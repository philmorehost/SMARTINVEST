<?php
/**
 * Admin FAQs Management
 */
include 'header.php';

$success = '';
$error = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $display_order = (int)($_POST['display_order'] ?? 0);

    if ($id) {
        $db->update('faqs', [
            'question' => $question,
            'answer' => $answer,
            'display_order' => $display_order
        ], 'id = ?', [$id]);
        $success = "FAQ updated successfully.";
    } else {
        $db->insert('faqs', [
            'question' => $question,
            'answer' => $answer,
            'display_order' => $display_order
        ]);
        $success = "FAQ added successfully.";
        $action = 'list';
    }
}

if ($action === 'delete' && $id) {
    $db->delete('faqs', 'id = ?', [$id]);
    header('Location: faqs.php?success=FAQ deleted');
    exit;
}

$faqs = $db->fetchAll("SELECT * FROM faqs ORDER BY display_order ASC");
$edit_faq = $id ? $db->fetch("SELECT * FROM faqs WHERE id = ?", [$id]) : null;
?>

<div class="content-header">
    <h1>FAQ Management</h1>
    <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn"><i class="fas fa-plus"></i> Add New FAQ</a>
    <?php else: ?>
        <a href="faqs.php" class="btn" style="background: var(--dark);"><i class="fas fa-arrow-left"></i> Back to List</a>
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
                    <th>Question</th>
                    <th>Answer Preview</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?php echo $faq['display_order']; ?></td>
                        <td><strong><?php echo htmlspecialchars($faq['question']); ?></strong></td>
                        <td style="color: var(--text-light);"><?php echo htmlspecialchars(substr($faq['answer'], 0, 100)) . '...'; ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $faq['id']; ?>" class="btn" style="padding: 6px 12px; font-size: 12px;"><i class="fas fa-edit"></i></a>
                            <a href="?action=delete&id=<?php echo $faq['id']; ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('Delete this FAQ?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($faqs)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: var(--text-light);">No FAQs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Question</label>
                <input type="text" name="question" value="<?php echo $edit_faq ? htmlspecialchars($edit_faq['question']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Answer</label>
                <textarea name="answer" rows="5" required><?php echo $edit_faq ? htmlspecialchars($edit_faq['answer']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label>Display Order (Lower numbers show first)</label>
                <input type="number" name="display_order" value="<?php echo $edit_faq ? $edit_faq['display_order'] : '0'; ?>">
            </div>
            <button type="submit" class="btn"><?php echo $edit_faq ? 'Update FAQ' : 'Add FAQ'; ?></button>
        </form>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
