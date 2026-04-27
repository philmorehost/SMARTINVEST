<?php
/**
 * Admin Settings
 */
include 'header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'general') {
        $db->updateSetting('site_title', $_POST['site_title']);
        $db->updateSetting('site_description', $_POST['site_description']);
        $db->updateSetting('whatsapp_number', $_POST['whatsapp_number']);
        $db->updateSetting('header_code', $_POST['header_code']);
        $db->updateSetting('footer_code', $_POST['footer_code']);
        $success = "General settings updated successfully.";
    } elseif ($action === 'sms') {
        $db->updateSetting('sms_token', $_POST['sms_token']);
        $db->updateSetting('sms_sender_id', $_POST['sms_sender_id']);
        $db->updateSetting('sms_enabled', isset($_POST['sms_enabled']) ? '1' : '0');
        $success = "SMS settings updated successfully.";
    } elseif ($action === 'smtp') {
        $db->updateSetting('smtp_host', $_POST['smtp_host']);
        $db->updateSetting('smtp_user', $_POST['smtp_user']);
        $db->updateSetting('smtp_pass', $_POST['smtp_pass']);
        $db->updateSetting('smtp_port', $_POST['smtp_port']);
        $success = "SMTP settings updated successfully.";
    } elseif ($action === 'alerts') {
        $db->updateSetting('email_template', $_POST['email_template']);
        $db->updateSetting('sms_template', $_POST['sms_template']);
        $success = "Alert templates updated successfully.";
    }
}

$settings = [
    'site_title' => $db->getSetting('site_title'),
    'site_description' => $db->getSetting('site_description'),
    'whatsapp_number' => $db->getSetting('whatsapp_number'),
    'header_code' => $db->getSetting('header_code'),
    'footer_code' => $db->getSetting('footer_code'),
    'sms_token' => $db->getSetting('sms_token'),
    'sms_sender_id' => $db->getSetting('sms_sender_id'),
    'sms_enabled' => $db->getSetting('sms_enabled'),
    'smtp_host' => $db->getSetting('smtp_host'),
    'smtp_user' => $db->getSetting('smtp_user'),
    'smtp_pass' => $db->getSetting('smtp_pass'),
    'smtp_port' => $db->getSetting('smtp_port'),
    'email_template' => $db->getSetting('email_template', '
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
        </html>'),
    'sms_template' => $db->getSetting('sms_template', 'New Lead: {name} ({phone}) enrolled for {course}. Check admin dashboard.'),
];

$tab = $_GET['tab'] ?? 'general';
?>

<div class="tabs">
    <a href="?tab=general" class="tab <?php echo $tab == 'general' ? 'active' : ''; ?>">General</a>
    <a href="?tab=sms" class="tab <?php echo $tab == 'sms' ? 'active' : ''; ?>">SMS API</a>
    <a href="?tab=smtp" class="tab <?php echo $tab == 'smtp' ? 'active' : ''; ?>">SMTP Email</a>
    <a href="?tab=alerts" class="tab <?php echo $tab == 'alerts' ? 'active' : ''; ?>">Alert Templates</a>
</div>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($tab == 'general'): ?>
    <div class="card">
        <form method="POST">
            <input type="hidden" name="action" value="general">
            <div class="form-group">
                <label>Site Title</label>
                <input type="text" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Site Description</label>
                <textarea name="site_description" rows="3"><?php echo htmlspecialchars($settings['site_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>WhatsApp Number (with country code, e.g., 234...)</label>
                <input type="text" name="whatsapp_number" value="<?php echo htmlspecialchars($settings['whatsapp_number']); ?>">
            </div>
            <div class="form-group">
                <label>Header Injection Code (Analytics, Pixel, etc.)</label>
                <textarea name="header_code" rows="5" placeholder="<script>...</script>"><?php echo htmlspecialchars($settings['header_code']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Footer Injection Code</label>
                <textarea name="footer_code" rows="5" placeholder="<script>...</script>"><?php echo htmlspecialchars($settings['footer_code']); ?></textarea>
            </div>
            <button type="submit" class="btn">Save General Settings</button>
        </form>
    </div>
<?php endif; ?>

<?php if ($tab == 'sms'): ?>
    <div class="card">
        <div class="card-title">PhilmoreSMS API Configuration</div>
        <form method="POST">
            <input type="hidden" name="action" value="sms">
            <div class="form-group">
                <label>API Token</label>
                <input type="password" name="sms_token" value="<?php echo htmlspecialchars($settings['sms_token']); ?>" placeholder="Enter your PhilmoreSMS API Token">
            </div>
            <div class="form-group">
                <label>Sender ID</label>
                <input type="text" name="sms_sender_id" value="<?php echo htmlspecialchars($settings['sms_sender_id']); ?>" maxlength="11">
                <small style="color: var(--text-light);">Maximum 11 characters. Must be approved in your PhilmoreSMS account.</small>
            </div>
            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="sms_enabled" id="sms_enabled" style="width: auto;" <?php echo $settings['sms_enabled'] == '1' ? 'checked' : ''; ?>>
                <label for="sms_enabled" style="margin-bottom: 0;">Enable SMS Notifications for Enrollments</label>
            </div>
            <button type="submit" class="btn">Save SMS Settings</button>
        </form>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border);">
            <h3>Check Wallet Balance</h3>
            <?php
            if ($settings['sms_token']) {
                require_once __DIR__ . '/../includes/SMS.php';
                $sms = new \SmartInvesting\SMS($settings['sms_token']);
                $balance = $sms->getBalance();
                if ($balance && $balance['status'] == 'success') {
                    echo "<p style='margin-top:10px; color: var(--secondary); font-weight: 600;'>Current Balance: ₦" . $balance['balance'] . "</p>";
                } else {
                    echo "<p style='margin-top:10px; color: #ef4444;'>Error: " . ($balance['message'] ?? 'Could not fetch balance. Check your token.') . "</p>";
                }
            } else {
                echo "<p style='margin-top:10px; color: var(--text-light);'>Enter API Token to see balance.</p>";
            }
            ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($tab == 'smtp'): ?>
    <div class="card">
        <form method="POST">
            <input type="hidden" name="action" value="smtp">
            <div class="form-group">
                <label>SMTP Host</label>
                <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($settings['smtp_host']); ?>" placeholder="smtp.gmail.com">
            </div>
            <div class="form-group">
                <label>SMTP Username (Email)</label>
                <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($settings['smtp_user']); ?>" placeholder="your-email@gmail.com">
            </div>
            <div class="form-group">
                <label>SMTP Password</label>
                <input type="password" name="smtp_pass" value="<?php echo htmlspecialchars($settings['smtp_pass']); ?>">
            </div>
            <div class="form-group">
                <label>SMTP Port</label>
                <input type="text" name="smtp_port" value="<?php echo htmlspecialchars($settings['smtp_port']); ?>" placeholder="587">
            </div>
            <button type="submit" class="btn">Save SMTP Settings</button>
        </form>
    </div>
<?php endif; ?>

<?php if ($tab == 'alerts'): ?>
    <div class="card">
        <form method="POST">
            <input type="hidden" name="action" value="alerts">
            <div class="form-group">
                <label>Email HTML Template</label>
                <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">
                    Use placeholders: <code>{subject}</code>, <code>{content}</code>, <code>{site_title}</code>, <code>{year}</code>
                </p>
                <textarea name="email_template" rows="15" style="font-family: monospace; font-size: 12px;"><?php echo htmlspecialchars($settings['email_template']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>SMS Template (Max 160 chars recommended)</label>
                <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">
                    Use placeholders: <code>{name}</code>, <code>{phone}</code>, <code>{course}</code>
                </p>
                <textarea name="sms_template" id="sms_template" rows="3" maxlength="160"><?php echo htmlspecialchars($settings['sms_template']); ?></textarea>
                <div id="sms_counter" style="font-size: 12px; text-align: right; margin-top: 5px; color: var(--text-light);">
                    0 / 160 characters (1 unit)
                </div>
            </div>
            
            <button type="submit" class="btn">Save Templates</button>
        </form>
    </div>
    
    <script>
    const smsInput = document.getElementById('sms_template');
    const smsCounter = document.getElementById('sms_counter');
    
    function updateCounter() {
        const len = smsInput.value.length;
        smsCounter.textContent = `${len} / 160 characters (${Math.ceil(len/160)} unit${len > 160 ? 's' : ''})`;
        if (len > 160) {
            smsCounter.style.color = '#ef4444';
        } else {
            smsCounter.style.color = 'var(--text-light)';
        }
    }
    
    smsInput.addEventListener('input', updateCounter);
    updateCounter();
    </script>
<?php endif; ?>

<?php include 'footer.php'; ?>
