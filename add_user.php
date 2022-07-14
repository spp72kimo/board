<?php 
  require_once('errMsg.php');
  require_once("conn.php");
  require_once('utils.php');
  session_start();

  // 設定 page
  if(!empty($_GET['page']))
    $page = intval($_GET['page']);
  else
    $page = 1;

  $per_page = 5;
  $offset = ($page - 1) * $per_page;
 
    
  $sql_cmd = "SELECT id, username, role FROM users";

  $stmt = $conn->prepare($sql_cmd);
  $stmt->execute();
  $result = $stmt->get_result();

  if(!$result)
    echo "ERROR: " . $result->error;

  $username = null;
  $role = null;
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
  };

  if($role !== 1) {
    header("Location: index.php");
    exit();
  }
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
          <li><a href="index.php">返回留言板</a></li>   
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
        <div class="text">Administrator </div>
      </div>
      <hr>
      <span class='errMsg'><?php if(!empty($Msg)) echo $Msg ?></span>
    <section class='add_user'>
      <h3>新增使用者</h3>
            <form action="handle_add_user.php" method='post'>
                <div>
                    <label for="username">帳號：</label>
                    <input type="text" name="username" id="username">
                </div>
                <div>
                    <label for="password1">輸入密碼：</label>
                    <input type="password" name="password" id="password1">
                </div>
                <div>
                    <label for="password2">確認密碼：</label>
                    <input type="password" name="password_check" id="password2">
                </div>
                <div>
                    <label for="add">新增文章：</label>
                    <select name="is_add" id="add">
                        <option value="0">否</option>
                        <option value="1" selected='selected'>是</option>
                    </select>
                </div>
                <div>
                    <label for="is_modify_self">修改自己文章：</label>
                    <select name="is_modify_self" id="is_modify_self">
                        <option value="0">否</option>
                        <option value="1" selected='selected'>是</option>
                    </select>
                </div>
                <div>
                    <label for="is_modify_other">修改別人文章：</label>
                    <select name="is_modify_other" id="is_modify_other">
                        <option value="0" selected='selected'>否</option>
                        <option value="1">是</option>
                    </select>
                </div>
                <div>
                    <label for="is_del_self">刪除自己文章：</label>
                    <select name="is_del_self" id="is_del_self">
                        <option value="0">否</option>
                        <option value="1" selected='selected'>是</option>
                    </select>
                </div>
                <div>
                    <label for="is_del_other">刪除別人文章：</label>
                    <select name="is_del_other" id="is_del_other">
                        <option value="0" selected='selected'>否</option>
                        <option value="1">是</option>
                    </select>
                </div>
                <div class="add_user_button">
                    <button type="submit">新增</button>
                </div>
            </form>
    </section>
  </body>
</html>