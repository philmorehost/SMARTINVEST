<?php
/**
 * Admin Logout
 */
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../includes/Database.php';

session_start();

$db = \SmartInvesting\Database::getInstance();
$auth = new \SmartInvesting\Auth($db);
$auth->logout();

header('Location: login.php');
exit;
