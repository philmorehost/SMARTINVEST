<?php
/**
 * Admin Dashboard - Home
 */
include 'header.php';

$enrollment_count = $db->fetch("SELECT COUNT(*) as count FROM enrollments")['count'];
$page_count = $db->fetch("SELECT COUNT(*) as count FROM pages")['count'];
$lead_count = $db->fetch("SELECT COUNT(*) as count FROM leads_whatsapp")['count'];

$recent_enrollments = $db->fetchAll("SELECT * FROM enrollments ORDER BY created_at DESC LIMIT 5");
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Enrollments</div>
        <div class="value"><?php echo $enrollment_count; ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Custom Pages</div>
        <div class="value"><?php echo $page_count; ?></div>
    </div>
    <div class="stat-card">
        <div class="label">WhatsApp Leads</div>
        <div class="value"><?php echo $lead_count; ?></div>
    </div>
</div>

<div class="card">
    <div class="card-title">
        Recent Enrollments
        <a href="enrollments.php" class="btn" style="padding: 8px 16px; font-size: 12px;">View All</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_enrollments as $enrollment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($enrollment['name']); ?></td>
                    <td><?php echo htmlspecialchars($enrollment['email']); ?></td>
                    <td><?php echo htmlspecialchars($enrollment['phone']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($enrollment['created_at'])); ?></td>
                    <td><span class="badge badge-<?php echo $enrollment['status']; ?>"><?php echo ucfirst($enrollment['status']); ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($recent_enrollments)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-light);">No enrollments yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
