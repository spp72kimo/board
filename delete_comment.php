<?php 
    require_once('errMsg.php');
    require_once("conn.php");
    require_once('utils.php');
    session_start();
    
    $id = $_GET['id'];
    if(empty($_SESSION['username'])){
        header("Location: index.php?errCode=5");
        die();
    }

    // 是否有權限刪除他人留言
    if($_SESSION['is_del_other']) {
        $sql_cmd = "UPDATE comments SET is_deleted = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        if(!$result) {
            header("Location: index.php?errCode=6");
            die();
        }
        else {
            header("Location: index.php?msgCode=1");
            exit();
        }
    } else {
        header("Location: index.php?errCode=8");
		die();
    }


    

    // 是否有權限刪除自己的留言
    if($_SESSION['is_del_self']) {
        $sql_cmd = "UPDATE comments SET is_deleted = 1 WHERE id = ? AND author = ?";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('is', $id, $_SESSION['username']);
        $result = $stmt->execute();
        if(!$result){
            header("Location: index.php?errCode=4");
            die();
        }
        else {
            header("Location: index.php?msgCode=1");
            exit();
        }
    } else {
        header("Location: index.php?errCode=8");
		die();
    }

?>
