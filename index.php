<?php 
  // 關閉警告訊息
  error_reporting(E_ERROR); 
  ini_set("display_errors","Off");

  require_once('errMsg.php');
  require_once("conn.php");
  require_once('utils.php');
  session_start();

  // 設定 page
  if(!empty($_GET['page']))
    $page = intval($_GET['page']);
  else
    $page = 1;

  $per_page = 6;
  $offset = ($page - 1) * $per_page;
 
    
  $sql_cmd = "SELECT 
    C.id as id, 
    C.article AS article, 
    C.created_at AS created_at,
    U.username AS username,
    U.nickname AS nickname
    FROM comments AS C LEFT JOIN users AS U ON C.author = U.username 
    WHERE C.is_deleted IS NULL
    ORDER BY C.id DESC
    LIMIT ? 
    OFFSET ?
    ;";

  $stmt = $conn->prepare($sql_cmd);
  $stmt->bind_param('ii', $per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  if(!$result)
    echo "ERROR: " . $result->error;

  $username = null;
  $nickname = null;
  $role = null;
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $nickname = getNickname($username);
    $role = $_SESSION['role'];
  };


  // 是否有權限新增留言
  $is_add = 1;   // 預設可新增留言
  if($_SESSION['is_add']===0)
    $is_add = $_SESSION['is_add'];
  
  // 是否有權限修改自己留言
  $is_modify_self = 1;  // 預設可以
  if($_SESSION['is_modify_self']===0)
    $is_modify_self = $_SESSION['is_modify_self']; 

    // 是否有權限修改別人留言
  $is_modify_other = 0;  // 預設不可修改別人留言 
  if($_SESSION['is_modify_other']===1)
    $is_modify_other = $_SESSION['is_modify_other'];

  // 是否有權限刪除自己留言
  $is_del_self = 1;  //預設可以
  if($_SESSION['is_del_self']===0)
    $is_del_self = $_SESSION['is_del_self'];
  
    // 是否有權限刪除別人留言
  $is_del_other = 0;  //預設不可刪除別人留言
  if($_SESSION['is_del_other']===1)
    $is_del_other = $_SESSION['is_del_other'];

  if(!$is_modify_self || !$is_del_self)
    $Msg = "您無權限修改或刪除留言！若有疑問請洽管理員";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="留言板" content="簡易留言板功能實做">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@1&amp;display=swap" rel="stylesheet">
    <title>簡易留言板</title>
    <link rel="stylesheet" href="./styles/style.css">
  </head>
  <body> 
    <div class="board"> 
      <nav> 
        <ul> 
          <?php if($role===1) { ?>
          <li><a href="admin.php">會員管理</a></li>  
          <?php } ?> 
          <?php if(!$username) { ?>
          <li><a href="register.php">註冊</a></li>
          <li><a href="login.php">登入</a></li>
          <?php } else { ?>
          <li><a href="logout.php">登出</a></li>
          <?php } ?>
        </ul>
      </nav>
      <div class="logo"> 
        <?php if($role===1) { ?>
          <div class="text">Administrator </div>
        <?php } else { ?>
          <div class="text">Comments </div>
        <?php } ?>
      </div>
      <?php
        if(!$is_add) {
      ?>
        <span class='permission_alert'>您目前停權中，若要新增留言，請聯絡管理員。</span>
      <?php } else { ?>
      <div class="post_area">
        <?php if($username) { ?>
        <div class='greeting'>Hello, <?php echo $nickname ?>
            <span class='modify_nickname'>| 修改暱稱</span>
        </div>
        <?php }?>
        <div class="post_author hide"> 
            <form action="handle_modify_nickname.php" method='post'>
              <label>暱稱：
                <input type="text" name="author" value="<?php echo $nickname ?>">
              </label>
              <button class='modify-nickname-button' type="submit">修改</button>
            </form>
        </div>
        <form action="handle_add_post.php" method="post">
          
          <div class="post_article">
            <textarea name="article" cols="30" rows="5"></textarea>
          </div>
          <div class="post_button"><span class="errMsg"><?php if(!empty($Msg)){echo $Msg;} ?></span>
            <?php if(!empty($username)) { ?>  
            <button type="submit">發送</button>
            <?php } else { ?>
            <span class='msg'><a href='login.php'>請登入留言</a></span>
            <?php } ?>
          </div>
        </form>
      </div>
      <?php } ?>
      <hr>
      <section> 
        <?php while($row = $result->fetch_assoc()){ 
          $id = escape($row['id']);
          $nickname = escape($row['nickname']); 
          $author = escape($row['username']);
          $time = escape($row['created_at']);
          $article = escape($row['article']); 
        ?>
        <div class="card">
          <div class="author_avater"> </div>
          <div class="content">
            <div class="author_name">
               <?php echo $nickname ?>
               <span>
                (@<?php echo $author ?>)  <?php echo $time ?>  
              </span>
              <?php if($is_modify_self) {  
                if($username === $author) { ?>
                  <span><a href='edit_comment.php?id=<?php echo $id ?>'>編輯</a></span>
               <?php }} ?>
              <?php if($is_modify_other) { 
                if($username !== $author){ ?>
                  <span><a href='edit_comment.php?id=<?php echo $id ?>'>編輯</a></span>
              <?php }} ?>
              <?php if($is_del_self) { 
                if($username === $author){ ?>
                  <span class='delete_comment'><a href='delete_comment.php?id=<?php echo $id ?>'>刪除</a></span>
              <?php }} ?>
              <?php if($is_del_other){ 
                if($username !== $author){ ?>
                    <span class='delete_comment'><a href='delete_comment.php?id=<?php echo $id ?>'>刪除</a></span>
              <?php }} ?>
            </div>
            <div class="article"><?php echo $article ?></div>
          </div>
        </div>
        <?php } ?>
      </section>
      <hr>
      <?php 
        $sql_cmd = "SELECT COUNT(id) AS count FROM comments WHERE is_deleted IS NULL";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $total_page = ceil($count / $per_page);
      ?>
      <div class="page_info">
        <span>目前有 <?php echo $count ?> 筆留言</span>
        <span>頁數：<?php echo $page ?> / <?php echo $total_page ?></span>
      </div>
      <div class="page_nav">
        <ul>
          <?php if($page !== 1){ ?>
          <a href="index.php?page=<?php echo $page-1 ?>"><li>上一頁</li></a>
          <?php } ?>
          <?php
            $page_dir = 1;

            if($total_page > 1){
              while($page_dir <= $total_page) {
          ?>
          <a href="index.php?page=<?php echo $page_dir ?>"><li><?php echo $page_dir ?></li></a>
          <?php
              $page_dir++;}
            }
          ?>
          <?php if($page != $total_page) { ?>
          <a href="index.php?page=<?php echo $page+1 ?>"><li>下一頁</li></a>
          <?php } ?>
        </ul>
      </div>
    </div>
  </body>
  <script>
    let modify_nickname_btn = document.querySelector('.modify_nickname');
    if(modify_nickname_btn){
      modify_nickname_btn.addEventListener('click', function() {
      document.querySelector('.post_author').classList.toggle('hide');
      })
    }
  </script>
</html>