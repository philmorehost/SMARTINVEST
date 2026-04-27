<?php
/**
 * Smart Investing NG - Web Installer
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$stage = isset($_GET['stage']) ? (int)$_GET['stage'] : 1;
$error = '';
$success = '';

// Check if already installed
if (file_exists(__DIR__ . '/../config/database.php') && $stage < 4) {
    header('Location: /');
    exit;
}

require_once __DIR__ . '/functions.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Investing NG - Installer</title>
    <link rel="stylesheet" href="../assets/css/installer.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="installer-container">
        <header>
            <div class="logo">Smart Investing <span>NG</span></div>
            <div class="progress-bar">
                <div class="step <?php echo $stage >= 1 ? 'active' : ''; ?>">1</div>
                <div class="step <?php echo $stage >= 2 ? 'active' : ''; ?>">2</div>
                <div class="step <?php echo $stage >= 3 ? 'active' : ''; ?>">3</div>
                <div class="step <?php echo $stage >= 4 ? 'active' : ''; ?>">4</div>
            </div>
        </header>

        <main>
            <?php
            switch ($stage) {
                case 1:
                    include 'stage1.php';
                    break;
                case 2:
                    include 'stage2.php';
                    break;
                case 3:
                    include 'stage3.php';
                    break;
                case 4:
                    include 'stage4.php';
                    break;
                default:
                    include 'stage1.php';
            }
            ?>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> Smart Investing NG. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
