<?php
/**
 * Admin Pages Management (CMS)
 */
include 'header.php';

$success = '';
$error = '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $content = $_POST['content'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $status = $_POST['status'] ?? 'published';

    if ($id) {
        // Update
        $db->update('pages', [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'status' => $status
        ], 'id = ?', [$id]);
        $success = "Page updated successfully.";
    } else {
        // Create
        try {
            $db->insert('pages', [
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'status' => $status
            ]);
            $success = "Page created successfully.";
            $action = 'list';
        } catch (\Exception $e) {
            $error = "Failed to create page: " . $e->getMessage();
        }
    }
}

if ($action === 'delete' && $id) {
    $db->delete('pages', 'id = ?', [$id]);
    header('Location: pages.php?success=Page deleted');
    exit;
}

$pages = $db->fetchAll("SELECT * FROM pages ORDER BY created_at DESC");
$edit_page = $id ? $db->fetch("SELECT * FROM pages WHERE id = ?", [$id]) : null;
?>

<div class="content-header">
    <h1>Pages Management</h1>
    <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn"><i class="fas fa-plus"></i> Create New Page</a>
    <?php else: ?>
        <a href="pages.php" class="btn" style="background: var(--dark);"><i class="fas fa-arrow-left"></i> Back to List</a>
    <?php endif; ?>
</div>

<?php if ($success || isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $success ?: $_GET['success']; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($page['title']); ?></strong></td>
                        <td><code>/<?php echo htmlspecialchars($page['slug']); ?></code></td>
                        <td><span class="badge badge-<?php echo $page['status'] == 'published' ? 'completed' : 'pending'; ?>"><?php echo ucfirst($page['status']); ?></span></td>
                        <td><?php echo date('M j, Y', strtotime($page['updated_at'])); ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $page['id']; ?>" class="btn" style="padding: 6px 12px; font-size: 12px;"><i class="fas fa-edit"></i></a>
                            <a href="?action=delete&id=<?php echo $page['id']; ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($pages)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-light);">No pages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card">
        <form method="POST">
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="title" value="<?php echo $edit_page ? htmlspecialchars($edit_page['title']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Slug (URL segment)</label>
                <input type="text" name="slug" value="<?php echo $edit_page ? htmlspecialchars($edit_page['slug']) : ''; ?>" placeholder="e.g. about-us" required>
            </div>
            <div class="form-group">
                <label>Page Content (HTML allowed)</label>
                <textarea name="content" rows="15"><?php echo $edit_page ? htmlspecialchars($edit_page['content']) : ''; ?></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" name="meta_title" value="<?php echo $edit_page ? htmlspecialchars($edit_page['meta_title']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="published" <?php echo $edit_page && $edit_page['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo $edit_page && $edit_page['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3"><?php echo $edit_page ? htmlspecialchars($edit_page['meta_description']) : ''; ?></textarea>
            </div>
            <button type="submit" class="btn"><?php echo $edit_page ? 'Update Page' : 'Create Page'; ?></button>
        </form>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
