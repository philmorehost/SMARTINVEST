<?php
/**
 * Stage 1: System Audit
 */

$requirements = [
    'PHP Version (8.1+)' => version_compare(PHP_VERSION, '8.1.0', '>='),
    'PDO Extension' => extension_loaded('pdo'),
    'PDO MySQL Extension' => extension_loaded('pdo_mysql'),
    'cURL Extension' => extension_loaded('curl'),
    'OpenSSL Extension' => extension_loaded('openssl'),
    'MBString Extension' => extension_loaded('mbstring'),
    'Config Directory Writable' => is_writable(__DIR__ . '/../config'),
];

$all_ok = !in_array(false, $requirements, true);

?>
<h2>Step 1: System Audit</h2>
<p>We need to make sure your server meets the minimum requirements to run Smart Investing NG.</p>

<ul class="audit-list">
    <?php foreach ($requirements as $label => $passed): ?>
        <li class="audit-item">
            <span><?php echo $label; ?></span>
            <span class="<?php echo $passed ? 'status-ok' : 'status-fail'; ?>">
                <?php echo $passed ? '✔ Passed' : '✖ Failed'; ?>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<?php if ($all_ok): ?>
    <div class="alert alert-success">All system requirements met. You're ready to proceed!</div>
    <a href="?stage=2" class="btn">Continue to Database Setup</a>
<?php else: ?>
    <div class="alert alert-error">Some requirements were not met. Please fix them to continue.</div>
    <button onclick="window.location.reload()" class="btn">Re-check System</button>
<?php endif; ?>
