<?php
    require_once('e14.inc.php');
    
    session_start();
    session_destroy();
    header("Location: $SITE/e14-login.php");
    exit;
?>