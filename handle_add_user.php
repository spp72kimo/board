<?php 
	require_once('utils.php');
	require_once('conn.php');
	session_start();
	
	$username = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
    $is_add = $_POST['is_add'];
    $is_modify_self = $_POST['is_modify_self'];
    $is_modify_other = $_POST['is_modify_other'];
    $is_del_self = $_POST['is_del_self'];
    $is_del_other = $_POST['is_del_other'];

    if($password !== $password_check){
        header("Location: add_user.php?errCode=7");
        die();
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

	if($_SESSION['role']===1) {
		$sql_cmd = "INSERT INTO 
        users(username, nickname, password, is_add, is_modify_self, is_modify_other, is_del_self, is_del_other)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
         ";
		$stmt = $conn->prepare($sql_cmd);
		$stmt->bind_param('ssiiiii', $username, $username,  $password, $is_add, $is_modify_self, $is_modify_other, $is_del_self, $is_del_other);
		$result = $stmt->execute();

		if($result) {
			header("Location: admin.php?magCode=3");
			exit();
		} else {
			header("Location: index.php?errCode=6");
			die();
		}
	}

 ?>