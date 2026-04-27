<?php

namespace SmartInvesting;

class Email
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function send($to, $subject, $message, $from = null)
    {
        $site_title = $this->db->getSetting('site_title', 'Smart Investing NG');
        $smtp_user = $this->db->getSetting('smtp_user');
        
        if (!$from) {
            $from = $smtp_user ? $smtp_user : "noreply@" . $_SERVER['HTTP_HOST'];
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: $site_title <$from>" . "\r\n";

        // Basic mail function. In a real production app, PHPMailer or SwiftMailer should be used for SMTP.
        // We will assume the server is configured to send mail or the admin provides SMTP settings later.
        return mail($to, $subject, $message, $headers);
    }

    public function sendEnrollmentNotification($data)
    {
        $admin_email = $this->db->fetch("SELECT email FROM admins LIMIT 1")['email'];
        $subject = "New Training Enrollment: " . $data['name'];
        $message = "
            <h2>New Enrollment Received</h2>
            <p><strong>Name:</strong> {$data['name']}</p>
            <p><strong>Email:</strong> {$data['email']}</p>
            <p><strong>Phone:</strong> {$data['phone']}</p>
            <p><strong>Course:</strong> {$data['course_id']}</p>
            <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
        ";
        
        return $this->send($admin_email, $subject, $message);
    }
}
