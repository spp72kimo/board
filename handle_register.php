<?php
    require_once('conn.php');
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
    $email = $_POST['email'];

    // 確認表單是否填寫完整
    if(empty($username) || empty($password) || empty($email)) {
        header("Location: register.php?errCode=1");
        die();
    }

    // 確認密碼是否正確
    if($password !== $password_check){
        header("Location: register.php?errCode=7");
        die();
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql_cmd = "INSERT INTO users(username, nickname,  password, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('ssss', $username, $username, $password, $email);
    $result = $stmt->execute();
    
    if(!$result) {
        $errorMsg = $conn->error;
        if(str_contains($errorMsg, 'Duplicate entry')){
            header("Location: register.php?errCode=2");
        }
        die("register failed.");
    }

    $_SESSION['username'] = $username;
    $_SESSION['role'] = 2;
    header("Location: index.php");
    
?>