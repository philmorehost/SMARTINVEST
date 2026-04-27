<?php

namespace SmartInvesting;

class Email
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function send($to, $subject, $content, $from = null)
    {
        $site_title = $this->db->getSetting('site_title', 'Smart Investing NG');
        $smtp_user = $this->db->getSetting('smtp_user');
        
        if (!$from) {
            $from = $smtp_user ? $smtp_user : "noreply@" . $_SERVER['HTTP_HOST'];
        }

        // Load modern template
        $template = $this->db->getSetting('email_template');
        if (!$template) {
            $template = $this->getDefaultTemplate();
        }

        // Replace placeholders in template
        $body = str_replace(
            ['{subject}', '{content}', '{site_title}', '{year}'],
            [$subject, $content, $site_title, date('Y')],
            $template
        );

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: $site_title <$from>" . "\r\n";

        return mail($to, $subject, $body, $headers);
    }

    public function sendEnrollmentNotification($data)
    {
        $admin_email = $this->db->fetch("SELECT email FROM admins LIMIT 1")['email'];
        $subject = "New Enrollment: " . $data['name'];
        $content = "
            <p>You have a new student enrollment for the <strong>{$data['course_id']}</strong>.</p>
            <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Name:</strong></td><td style='padding: 10px; border-bottom: 1px solid #eee;'>{$data['name']}</td></tr>
                <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Email:</strong></td><td style='padding: 10px; border-bottom: 1px solid #eee;'>{$data['email']}</td></tr>
                <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Phone:</strong></td><td style='padding: 10px; border-bottom: 1px solid #eee;'>{$data['phone']}</td></tr>
            </table>
            <p style='margin-top: 20px;'>Check your admin dashboard for more details.</p>
        ";
        
        return $this->send($admin_email, $subject, $content);
    }

    private function getDefaultTemplate()
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: "Inter", Arial, sans-serif; background-color: #f4f7f9; margin: 0; padding: 0; }
                .wrapper { width: 100%; padding: 40px 0; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
                .header { background-color: #1e3a8a; padding: 30px; text-align: center; }
                .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
                .content { padding: 40px; color: #334155; line-height: 1.6; }
                .footer { background-color: #f8fafc; padding: 20px; text-align: center; color: #64748b; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="wrapper">
                <div class="container">
                    <div class="header">
                        <h1>{site_title}</h1>
                    </div>
                    <div class="content">
                        <h2 style="color: #1e3a8a;">{subject}</h2>
                        {content}
                    </div>
                    <div class="footer">
                        <p>&copy; {year} {site_title}. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }
}
