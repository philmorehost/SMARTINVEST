<?php
/**
 * Stage 3: Admin Provisioning
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_user = $_POST['admin_user'] ?? '';
    $admin_email = $_POST['admin_email'] ?? '';
    $admin_pass = $_POST['admin_pass'] ?? '';

    require_once __DIR__ . '/../config/database.php';

    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$admin_user, $admin_email, $hashed_pass]);

        // Initialize default settings
        $settings = [
            ['site_title', 'Smart Investing NG'],
            ['site_description', 'Empowering Nigerians through smart stock market investing.'],
            ['sms_token', ''],
            ['sms_sender_id', 'PhilmoreSMS'],
            ['sms_enabled', '0'],
            ['smtp_host', ''],
            ['smtp_user', ''],
            ['smtp_pass', ''],
            ['smtp_port', '587'],
            ['whatsapp_number', '2348000000000']
        ];

        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        foreach ($settings as $setting) {
            $stmt->execute($setting);
        }

        // Pre-populate Pages with User Document Content
        $pages = [
            [
                'About Us', 
                'about', 
                '<h2>About Smart Investing NG</h2>
                <p>Smart Investing NG was created to help Nigerians understand how the stock market works and how to invest the right way.</p>
                <p>After working within the capital market space and seeing how many people struggle with confusion, misinformation, and losses, I decided to simplify investing.</p>
                <p>With hands-on experience in the Nigerian capital market, I help beginners start investing with confidence.</p>
                <p><strong>Mission:</strong> To empower everyday Nigerians with knowledge to grow wealth through smart investing.</p>
                <div style="margin-top: 30px;">
                    <a href="/training" class="cta-btn">Join Training</a>
                    <a href="/track-whatsapp" class="cta-btn" style="background: #25d366;">Chat on WhatsApp</a>
                </div>',
                'About Smart Investing NG',
                'Learn about our mission to empower Nigerians through smart investing.'
            ],
            [
                'Free Learning',
                'learning',
                '<h2>Free Stock Market Learning Resources</h2>
                <p>Start your journey with our free educational content.</p>
                <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 40px;">
                    <div class="card">
                        <h3>Videos (YouTube)</h3>
                        <p>Watch our step-by-step guides and market insights on YouTube.</p>
                    </div>
                    <div class="card">
                        <h3>Articles</h3>
                        <p>Read our beginner guides and investment articles.</p>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 50px;">
                    <a href="/training" class="cta-btn">Join Training Program</a>
                </div>',
                'Free Stock Market Learning Resources',
                'Access free educational videos and articles to start your investing journey.'
            ],
            [
                'Contact Us',
                'contact',
                '<h2>Contact Us</h2>
                <p>Have questions or ready to get started? Reach out directly.</p>
                <div class="contact-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px;">
                    <div>
                        <h3>Direct Reach</h3>
                        <p>WhatsApp: <a href="/track-whatsapp" style="color: #25d366; font-weight: 700;">Click to Chat</a></p>
                        <p>Email: info@smartinvesting.ng</p>
                    </div>
                    <div>
                        <h3>Send a Message</h3>
                        <form>
                            <div class="form-group"><input type="text" placeholder="Your Name" style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd;"></div>
                            <div class="form-group"><input type="email" placeholder="Your Email" style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd;"></div>
                            <div class="form-group"><textarea placeholder="Your Message" style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd;"></textarea></div>
                            <button type="button" class="cta-btn" style="width:100%; border:none;">Send Message</button>
                        </form>
                    </div>
                </div>',
                'Contact Us - Smart Investing NG',
                'Get in touch with us for inquiries about our training program.'
            ]
        ];

        $stmt = $pdo->prepare("INSERT INTO pages (title, slug, content, meta_title, meta_description) VALUES (?, ?, ?, ?, ?)");
        foreach ($pages as $page) {
            $stmt->execute($page);
        }

        // Pre-populate FAQs
        $faqs = [
            ['Do I need experience?', 'No, it\'s for beginners.', 1],
            ['How much do I need to start?', 'Start small.', 2],
            ['Can I join outside Nigeria?', 'Yes.', 3],
            ['Is this guaranteed profit?', 'No, but you will learn informed investing.', 4]
        ];

        $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, display_order) VALUES (?, ?, ?)");
        foreach ($faqs as $faq) {
            $stmt->execute($faq);
        }

        header('Location: ?stage=4');
        exit;
    } catch (PDOException $e) {
        $error = "Admin setup failed: " . $e->getMessage();
    }
}
?>

<h2>Step 3: Admin Provisioning</h2>
<p>Create your primary administrator account.</p>

<?php if (isset($error)): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="admin_user">Admin Username</label>
        <input type="text" name="admin_user" id="admin_user" placeholder="admin" required>
    </div>
    <div class="form-group">
        <label for="admin_email">Admin Email</label>
        <input type="email" name="admin_email" id="admin_email" placeholder="admin@example.com" required>
    </div>
    <div class="form-group">
        <label for="admin_pass">Admin Password</label>
        <input type="password" name="admin_pass" id="admin_pass" required>
    </div>
    <button type="submit" class="btn">Create Account & Finish</button>
</form>
