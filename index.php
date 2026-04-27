<?php
/**
 * Smart Investing NG - Entry Point
 */

// Check if database configuration exists
if (!file_exists(__DIR__ . '/config/database.php')) {
    header('Location: /install/');
    exit;
}

// Load core files
require_once __DIR__ . '/includes/Core.php';

// Initialize App
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/SMS.php';
require_once __DIR__ . '/includes/Email.php';

$db = \SmartInvesting\Database::getInstance();

// Simple Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

if (empty($uri)) {
    include __DIR__ . '/templates/home.php';
} elseif ($uri == 'training') {
    include __DIR__ . '/templates/training.php';
} elseif ($uri == 'faq') {
    include __DIR__ . '/templates/faq.php';
} elseif ($uri == 'track-whatsapp') {
    // Lead Tracker
    $db->insert('leads_whatsapp', [
        'page_url' => $_SERVER['HTTP_REFERER'] ?? 'direct',
        'user_ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    ]);
    $whatsapp_num = $db->getSetting('whatsapp_number', '2348000000000');
    header("Location: https://wa.me/$whatsapp_num?text=Hello,%20I'm%20interested%20in%20the%20Smart%20Investing%20training.");
    exit;
} elseif ($uri == 'enroll') {
    // Enrollment Manager
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        
        $db->insert('enrollments', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ]);

        // Send Notifications
        $email_manager = new \SmartInvesting\Email($db);
        $email_manager->sendEnrollmentNotification(['name' => $name, 'email' => $email, 'phone' => $phone, 'course_id' => 'Beginner Training']);

        // SMS Notification (PhilmoreSMS)
        if ($db->getSetting('sms_enabled') == '1') {
            $sms = new \SmartInvesting\SMS($db->getSetting('sms_token'), $db->getSetting('sms_sender_id'));
            $msg = "New Enrollment: $name ($phone). Check admin panel for details.";
            $admin_phone = $db->getSetting('whatsapp_number'); // Assume admin phone is same as whatsapp
            $sms->send($admin_phone, $msg);
        }

        header('Location: /track-whatsapp');
        exit;
    }
} else {
    // Custom Page Builder
    $page = $db->fetch("SELECT * FROM pages WHERE slug = ? AND status = 'published'", [$uri]);
    if ($page) {
        $page_title = $page['title'];
        $meta_description = $page['meta_description'];
        include __DIR__ . '/templates/header.php';
        echo '<section class="page-content"><div class="container">' . $page['content'] . '</div></section>';
        include __DIR__ . '/templates/footer.php';
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
    }
}

