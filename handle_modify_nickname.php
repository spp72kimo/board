<?php
    require_once('conn.php');
    session_start();

    $sql_cmd = "UPDATE users SET nickname = ? WHERE username = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('ss', $_POST['author'], $_SESSION['username']);
    $result = $stmt->execute();
    if($result)
        header("Location: index.php");
    else
        echo $conn->error;
        die();
?>