<?php
    require_once('conn.php');
    

    function generateToken() {
        $token = "";
        for( $i=1; $i<=8; $i++) {
            $token .= chr(rand(65, 90));        
            $token .= chr(rand(97, 122));        
        }
        return $token;
    }

    function saveToken($username, $token) {
        global $conn;
        $sql_cmd = sprintf(
            "INSERT INTO tokens(username, token) VALUES ('%s', '%s')",
            $username,
            $token
        );
        $result = $conn->query($sql_cmd);
        if(!$result)
            die("token save failed.");
        return true;
    }

    function removeToken($token) {
        global $conn;
        $sql_cmd = sprintf(
            "DELETE FROM tokens where token='%s'",
            $token
        );
        $result = $conn->query($sql_cmd);
        if($result->num_rows === 0)
            die("remove token failed.");
    }

    function getNickname($username) {
        global $conn;
        $sql_cmd = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        if(!empty($row))
            return $row['nickname'];
        else
            return null;
    }

    function escape($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }
?>