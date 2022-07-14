<?php
    require_once('errMsg.php');
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
          <li><a href="index.php">首頁</a></li>
          <li><a href="register.php">註冊</a></li>
        </ul>
      </nav>
      <div class="logo"> 
        <div class="text">Login </div>
      </div>
      <div class="post_area">
        <form action="handle_login.php" method="post">
          <div class="post_author"> 
            <div class="input_content">
              <label for="username">名稱：</label>
              <input type="text" name="username" id="username">
            </div>
            <div class="input_content"> 
              <label for="password">密碼： </label>
              <input type="password" name="password" id="password">
            </div>
          </div>
          <div class="post_button"> <span class="errMsg"><?php if(!empty($Msg)){echo $Msg;} ?></span>
            <button type="submit">登入</button>
          </div>
        </form>
      </div>
      <hr>
    </div>
  </body>
</html>