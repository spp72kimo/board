<?php 
  require_once('errMsg.php');
  require_once("conn.php");
  require_once('utils.php');
  session_start();
  
  $id = $_GET['id'];

  $sql_cmd = "SELECT * FROM comments WHERE id = ?";
  $stmt = $conn->prepare($sql_cmd);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if(!$result)
    header("Location: index.php?errCode=4");

  $row = $result->fetch_assoc();


  $username = null;
  $nickname = null;
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $nickname = getNickname($username);
  };

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
            <?php if(!$username) { ?>
            <li><a href="register.php">註冊</a></li>
            <li><a href="login.php">登入</a></li>
            <?php } else { ?>
            <li><a href="index.php">返回留言板</a></li>
            <li><a href="logout.php">登出</a></li>
            <?php } ?>
        </ul>
      </nav>
      <div class="logo"> 
        <div class="text">Edit </div>
      </div>
      <div class="post_area">
        <form action="handle_edit_comment.php" method="post">
          <div class="post_article">
            <textarea name="article" cols="30" rows="5"><?php echo $row['article'] ?></textarea>
          </div>
          <div class="post_button"><span class="errMsg"><?php if(!empty($Msg)){echo $Msg;} ?></span>
            <input type="hidden" name="id" value='<?php echo $id ?>'>
            <button type="submit">修改</button>
          </div>
        </form>
      </div>
      <hr>
      
    </div>
  </body>
</html>