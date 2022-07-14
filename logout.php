<?php
    require_once('utils.php');
    session_start();
    session_destroy();

    header("Location: index.php");
?>