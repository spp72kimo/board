<?php 
	// $user_name = "steven";
	// $password = "steven";
	// $db_name="steven";
	// $server_name = "localhost";
	// $conn = new mysqli($server_name, $user_name, $password, $db_name);


	$user_name = "root";
	$password = "STEven_10821385";
	$db_name="board";
	$server_name = "localhost:3306";
	$conn = new mysqli($server_name, $user_name, $password, $db_name);


	if($conn->connect_error) {
		die("連線錯誤" . $conn->connect_error);
	}

	// 設定資料庫編碼
	$conn->query('SET NAMES UTF8');
	// 設定資料庫時區
	$conn->query('SET time_zone = "+8:00"');
	// echo "連線成功！ <br>";
 ?>