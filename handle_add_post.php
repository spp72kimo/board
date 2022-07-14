<?php 
	require_once('utils.php');
	require_once('conn.php');
	session_start();
	$author = $_SESSION['username'];
	
	// 驗證文章是否有內容，沒有就跳回
	if(empty($_POST['article'])) {
		header("Location: index.php?errCode=1");
		die("沒有資料");
	}

	// 驗證是否有權限新增文章
	if($_SESSION['is_add']) {
		$sql_cmd = "INSERT INTO comments(author, article) VALUES (?, ?)";
		$stmt = $conn->prepare($sql_cmd);
		$stmt->bind_param('ss', $author, $_POST['article']);
		$result = $stmt->execute();
	} else {
		header("Location: index.php?errCode=8");
		die();
	}
		
	if(!$result)
		die($conn->error);
	header("Location: index.php");
 ?>