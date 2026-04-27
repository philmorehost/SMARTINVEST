<?php
/**
 * Admin Testimonials Management
 */
include 'header.php';

$success = '';
$error = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $content = $_POST['content'] ?? '';
    $display_order = (int)($_POST['display_order'] ?? 0);
    $photo = $_POST['photo_url'] ?? '';

    if ($id) {
        $db->update('testimonials', [
            'name' => $name,
            'content' => $content,
            'photo' => $photo,
            'display_order' => $display_order
        ], 'id = ?', [$id]);
        $success = "Testimonial updated successfully.";
    } else {
        $db->insert('testimonials', [
            'name' => $name,
            'content' => $content,
            'photo' => $photo,
            'display_order' => $display_order
        ]);
        $success = "Testimonial added successfully.";
        $action = 'list';
    }
}

if ($action === 'delete' && $id) {
    $db->delete('testimonials', 'id = ?', [$id]);
    header('Location: testimonials.php?success=Testimonial deleted');
    exit;
}

$testimonials = $db->fetchAll("SELECT * FROM testimonials ORDER BY display_order ASC");
$edit_t = $id ? $db->fetch("SELECT * FROM testimonials WHERE id = ?", [$id]) : null;
?>

<div class="content-header">
    <h1>Testimonials Management</h1>
    <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn"><i class="fas fa-plus"></i> Add New Testimonial</a>
    <?php else: ?>
        <a href="testimonials.php" class="btn" style="background: var(--dark);"><i class="fas fa-arrow-left"></i> Back to List</a>
    <?php endif; ?>
</div>

<?php if ($success || isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $success ?: $_GET['success']; ?></div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Name</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td><?php echo $t['display_order']; ?></td>
                        <td><strong><?php echo htmlspecialchars($t['name']); ?></strong></td>
                        <td style="color: var(--text-light);"><?php echo htmlspecialchars(substr($t['content'], 0, 100)) . '...'; ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $t['id']; ?>" class="btn" style="padding: 6px 12px; font-size: 12px;"><i class="fas fa-edit"></i></a>
                            <a href="?action=delete&id=<?php echo $t['id']; ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('Delete this testimonial?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($testimonials)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: var(--text-light);">No testimonials found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Person's Name</label>
                <input type="text" name="name" value="<?php echo $edit_t ? htmlspecialchars($edit_t['name']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Testimonial Content</label>
                <textarea name="content" rows="5" required><?php echo $edit_t ? htmlspecialchars($edit_t['content']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label>Photo URL (Optional)</label>
                <input type="text" name="photo_url" value="<?php echo $edit_t ? htmlspecialchars($edit_t['photo']) : ''; ?>" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>Display Order</label>
                <input type="number" name="display_order" value="<?php echo $edit_t ? $edit_t['display_order'] : '0'; ?>">
            </div>
            <button type="submit" class="btn"><?php echo $edit_t ? 'Update Testimonial' : 'Add Testimonial'; ?></button>
        </form>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
