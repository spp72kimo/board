<?php
    require_once('conn.php');
    session_start();

    $id = $_POST['id'];
    $name = $_POST['username'];
    $is_add = $_POST['is_add'];
    $is_modify_self = $_POST['is_modify_self'];
    $is_modify_other = $_POST['is_modify_other'];
    $is_del_self = $_POST['is_del_self'];
    $is_del_other = $_POST['is_del_other'];

    $sql_cmd = "UPDATE users SET is_add=?, is_modify_self=?, is_modify_other=?, is_del_self=?, is_del_other=? WHERE id = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('iiiiii', $is_add, $is_modify_self, $is_modify_other, $is_del_self, $is_del_other, $id);
    $result = $stmt->execute();

    if($result) {
        header("Location: admin.php?msgCode=2");
        exit();
    } else {
        header("Location: admin.php?errCode=6");
        die();
    }

?>