<?php
/**
 * Frontend Header
 */
$db = \SmartInvesting\Database::getInstance();
$site_title = $db->getSetting('site_title', 'Smart Investing NG');
$header_code = $db->getSetting('header_code');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . $site_title : $site_title; ?></title>
    <meta name="description" content="<?php echo $meta_description ?? $db->getSetting('site_description'); ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <?php echo $header_code; ?>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="nav-container">
                <a href="/" class="logo">Smart Investing <span>NG</span></a>
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/training">Training</a></li>
                        <li><a href="/learning">Free Learning</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </nav>
                <a href="/training" class="cta-btn">Enroll Now</a>
            </div>
        </div>
    </header>
