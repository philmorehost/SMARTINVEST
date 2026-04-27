<?php
/**
 * Admin Header Template
 */
require_once __DIR__ . '/../includes/Core.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../includes/Security.php';

session_start();

$db = \SmartInvesting\Database::getInstance();
$auth = new \SmartInvesting\Auth($db);
$auth->requireLogin();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Investing NG</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                Smart Investing <span>NG</span>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home" style="margin-right: 12px;"></i> Dashboard
                </a>
                <a href="pages.php" class="<?php echo $current_page == 'pages.php' ? 'active' : ''; ?>">
                    <i class="fas fa-file-alt" style="margin-right: 12px;"></i> Pages
                </a>
                <a href="enrollments.php" class="<?php echo $current_page == 'enrollments.php' ? 'active' : ''; ?>">
                    <i class="fas fa-user-graduate" style="margin-right: 12px;"></i> Enrollments
                </a>
                <a href="faqs.php" class="<?php echo $current_page == 'faqs.php' ? 'active' : ''; ?>">
                    <i class="fas fa-question-circle" style="margin-right: 12px;"></i> FAQs
                </a>
                <a href="testimonials.php" class="<?php echo $current_page == 'testimonials.php' ? 'active' : ''; ?>">
                    <i class="fas fa-quote-left" style="margin-right: 12px;"></i> Testimonials
                </a>
                <a href="settings.php" class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                    <i class="fas fa-cog" style="margin-right: 12px;"></i> Settings
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="logout.php" style="color: #ef4444; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <h1>Admin Panel</h1>
                <div class="user-info">
                    <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_user']); ?></strong></span>
                </div>
            </header>
