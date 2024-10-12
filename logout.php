<?php
require_once('root/config.php');
$phone = $_SESSION['phone'];
$userid = $_SESSION['userid'];
$dbh->query("UPDATE users SET token = '' WHERE userid = '$userid'  ");
unset($_SESSION['userid']);
session_destroy();
redirect_page(SITE_URL);
?>