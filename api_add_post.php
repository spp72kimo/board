<?php 
	require_once('conn.php');
	header('Content-Type: application/json; charset=utf-8');
    
	// 驗證文章是否有內容，沒有就跳回
	if(empty($_POST['article'])) {
        $json = array(
            "status" => false,
            "message" => "Please insert some contents!"
        );
        $response = json_encode($json);
        echo $response;
		die();
	}

	// 新增文章
    $author = $_POST['username'];
    $content = $_POST['article'];

    $sql_cmd = "INSERT INTO comments(author, article) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('ss', $author, $content);
    $result = $stmt->execute();

    // 新增失敗
	if(!$result) {
        $json = array(
            "status" => false,
            "message" => $conn->error
        );
        $response = json_encode($json);
        echo $response;
        die();
    }


    // 新增成功
    $json = array(
        "status" => true,
        "message" => "Add post successfully."
    );
    $response = json_encode($json);
    echo $response;
 ?>