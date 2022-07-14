<?php
    require_once('conn.php');

    // 設定 page
    if(!empty($_GET['page']))
        $page = intval($_GET['page']);
    else
        $page = 1;

    $per_page = 6;
    $offset = ($page - 1) * $per_page;

    // 讀取留言內容
    $sql_cmd = "SELECT 
    C.id as id, 
    C.article AS article, 
    C.created_at AS created_at,
    U.username AS username,
    U.nickname AS nickname
    FROM comments AS C LEFT JOIN users AS U ON C.author = U.username 
    WHERE C.is_deleted IS NULL
    ORDER BY C.id DESC
    LIMIT ? 
    OFFSET ?
    ;";

    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('ii', $per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();


    // 轉換成 JSON 格式
    $comments = array();

    while($row = $result->fetch_assoc()){
        array_push($comments, array(
            "id" => $row['id'],
            "username" => $row['username'],
            "nickname" => $row['nickname'],
            "article" => $row['article'],
            "created_at" => $row['created_at']
        ));
    }
    
    
    $json = array("comments" => $comments);
    $response = json_encode($json);


    // 設定此文件內容為 json 格式
    header('Content-Type: application/json; charset=utf-8');
    echo $response;
    

?>