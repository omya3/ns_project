<?php

require_once 'logger.php';


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

logUserActivity($_SESSION['username'], basename(__FILE__));
// Destroy the session and redirect to index.php
session_destroy();
header('Location: index.php');
exit();
?>
