<?php
/**
 * Stage 2: Database Provisioning
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? 'localhost';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    $db_name = $_POST['db_name'] ?? '';

    try {
        $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $pdo->exec("USE `$db_name`");

        // Execute schema
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        $pdo->exec($schema);

        // Save config
        $config_content = "<?php
define('DB_HOST', '$db_host');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');
define('DB_NAME', '$db_name');
";
        file_put_contents(__DIR__ . '/../config/database.php', $config_content);

        $_SESSION['db_host'] = $db_host;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
        $_SESSION['db_name'] = $db_name;

        header('Location: ?stage=3');
        exit;
    } catch (PDOException $e) {
        $error = "Connection failed: " . $e->getMessage();
    }
}
?>

<h2>Step 2: Database Provisioning</h2>
<p>Configure your MySQL database connection details.</p>

<?php if (isset($error)): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="db_host">Database Host</label>
        <input type="text" name="db_host" id="db_host" value="localhost" required>
    </div>
    <div class="form-group">
        <label for="db_user">Database Username</label>
        <input type="text" name="db_user" id="db_user" placeholder="root" required>
    </div>
    <div class="form-group">
        <label for="db_pass">Database Password</label>
        <input type="password" name="db_pass" id="db_pass" placeholder="Leave empty if none">
    </div>
    <div class="form-group">
        <label for="db_name">Database Name</label>
        <input type="text" name="db_name" id="db_name" value="smart_investing" required>
    </div>
    <button type="submit" class="btn">Test Connection & Install Schema</button>
</form>
