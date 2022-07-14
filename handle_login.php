<?php
    require_once('utils.php');
    require_once('conn.php');
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    // 表單驗證
    if(empty($username) || empty($password)) {
        header("Location: login.php?errCode=1");
        die();
    }
    
    // 取得會員資料
    $sql_cmd ="SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result = $stmt->get_result();


    if($result->num_rows === 0)
        // 查無 username
        header("Location: login.php?errCode=3");    
    else {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) {
            // 密碼驗證成功，紀錄 SSID，並導回 index
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_add'] = $row['is_add'];
            $_SESSION['is_modify_self'] = $row['is_modify_self'];
            $_SESSION['is_modify_other'] = $row['is_modify_other'];
            $_SESSION['is_del_self'] = $row['is_del_self'];
            $_SESSION['is_del_other'] = $row['is_del_other'];
            header("Location: index.php"); 
        } else {
            // 密碼驗證失敗
            header("Location: login.php?errCode=3");
        }
    }
       
?>