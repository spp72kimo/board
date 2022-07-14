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
    <header>注意！本站為練習用網站，註冊時請勿使用任何真實的帳號或密碼。</header>
    <div class="board"> 
      <nav> 
        <ul> 
          <li><a href="index.php">首頁</a></li>
          <li><a href="login.php">登入</a></li>
        </ul>
      </nav>
      <div class="logo"> 
        <div class="text">Register </div>
      </div>
      <div class="register_area">
        <form action="handle_register.php" method="post">
          <div class="post_author"> 
            <div class="input_content">
              <label for="username">名稱：</label>
              <input type="text" name="username" id="username">
            </div>
            <div class="input_content"> 
              <label for="password1">輸入密碼： </label>
              <input type="password" name="password" id="password1">
            </div>
            <div class="input_content"> 
              <label for="password2">確認密碼： </label>
              <input type="password" name="password_check" id="password2">
            </div>
            <div class="input_content"> 
              <label for="email">信箱： </label>
              <input type="email" name="email" id="email">
            </div>
          </div>
          <div class="post_button"> <span class="errMsg"><?php if(!empty($Msg)){echo $Msg;} ?></span>
            <button type="submit">提交</button>
          </div>
        </form>
      </div>
      <hr>
    </div>
  </body>
</html>