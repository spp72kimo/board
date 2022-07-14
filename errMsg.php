<?php
    if(!empty($_GET['errCode'])) {
        $Msg = '錯誤：';

        switch($_GET['errCode']){
            case 1:
                $Msg .= "資料不齊全！";
                break;
            case 2:
                $Msg .= "帳號已有人使用！";
                break;
            case 3:
                $Msg .= "帳號密碼錯誤！";
                break;
            case 4:
                $Msg .= "您無此篇留言！";
                break;
            case 5:
                $Msg .= "您沒有權限修改！";
                break;
            case 6:
                $Msg .= "存取失敗！";
                break;
            case 7:
                $Msg .= "請確認密碼！";
                break;
            case 8:
                $Msg .= "您無權限！若有疑問請洽管理員";
                break;
            case 9:
                $Msg .= "您無權限修改或刪除留言！若有疑問請洽管理員";
                break;
        }
    }

    if(!empty($_GET['msgCode'])) {
        switch ($_GET['msgCode']) {
            case '1':
                $Msg = "刪除成功！";
                break;
            case '2':
                $Msg = "修改成功！";
                break;
            case '3':
                $Msg = "新增成功！";
                break;
        }
    }
?>