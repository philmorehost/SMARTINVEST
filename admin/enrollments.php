<?php
/**
 * Admin Enrollments Management
 */
include 'header.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($action === 'status' && $id) {
    $status = $_GET['status'];
    $db->update('enrollments', ['status' => $status], 'id = ?', [$id]);
    header('Location: enrollments.php?success=Status updated');
    exit;
}

if ($action === 'delete' && $id) {
    $db->delete('enrollments', 'id = ?', [$id]);
    header('Location: enrollments.php?success=Enrollment deleted');
    exit;
}

$enrollments = $db->fetchAll("SELECT * FROM enrollments ORDER BY created_at DESC");
?>

<div class="content-header">
    <h1>Training Enrollments</h1>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
<?php endif; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($enrollments as $enrollment): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($enrollment['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($enrollment['email']); ?></td>
                    <td><?php echo htmlspecialchars($enrollment['phone']); ?></td>
                    <td><?php echo htmlspecialchars($enrollment['course_id']); ?></td>
                    <td><?php echo date('M j, Y H:i', strtotime($enrollment['created_at'])); ?></td>
                    <td><span class="badge badge-<?php echo $enrollment['status']; ?>"><?php echo ucfirst($enrollment['status']); ?></span></td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="?action=status&id=<?php echo $enrollment['id']; ?>&status=contacted" class="btn btn-secondary" style="padding: 6px 12px; font-size: 10px;">Mark Contacted</a>
                            <a href="?action=status&id=<?php echo $enrollment['id']; ?>&status=completed" class="btn" style="padding: 6px 12px; font-size: 10px; background: #059669;">Complete</a>
                            <a href="?action=delete&id=<?php echo $enrollment['id']; ?>&status=completed" class="btn btn-danger" style="padding: 6px 12px; font-size: 10px;" onclick="return confirm('Delete this record?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($enrollments)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-light);">No enrollments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
