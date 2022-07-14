<?php 
	require_once('utils.php');
	require_once('conn.php');
	session_start();

	// 儲存修改文章的 ID
	$id = $_POST['id'];
	
	// 驗證如果修改內容為空就跳回
	if(empty($_POST['article'])) {
		header("Location: edit_comment.php?errCode=1&id=".$id);
		die();	
	}

	// 是否有權限編輯他人文章
	if($_SESSION['is_modify_other']) {
		$sql_cmd = "UPDATE comments SET article = ? WHERE id = ? and author != ?";
		$stmt = $conn->prepare($sql_cmd);
		$stmt->bind_param('sis', $_POST['article'], $id, $_SESSION['username']);
		$result = $stmt->execute();
		if($result) {
			header("Location: index.php");
			exit();
		} else {
			header("Location: index.php?errCode=6");
			die();
		}
	} 

    // 是否有權限編輯自己文章
	if($_SESSION['is_modify_self']){
		$sql_cmd = "UPDATE comments SET article = ? WHERE id = ? AND author = ?";
		$stmt = $conn->prepare($sql_cmd);
		$stmt->bind_param('sis', $_POST['article'], $id, $_SESSION['username']);
		$result = $stmt->execute();
		

		if($result) {
			header("Location: index.php");
			exit();
		} else {
			header("Location: edit_comment.php?errCode=6");
			die();
		}
	} 
		

	header("Location: edit_comment.php?errCode=8");
	die();
 ?>