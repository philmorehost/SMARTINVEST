<?php 
$page_title = 'Frequently Asked Questions';
include 'header.php'; 
$faqs = $db->fetchAll("SELECT * FROM faqs ORDER BY display_order ASC");
?>

<section class="page-hero" style="background: var(--primary); color: var(--white); padding: 80px 0; text-align: center;">
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <p style="color: #94a3b8; font-size: 18px; margin-top: 15px;">Everything you need to know about starting your investment journey.</p>
    </div>
</section>

<section class="faq-section">
    <div class="container">
        <div class="accordion">
            <?php foreach ($faqs as $faq): ?>
                <div class="accordion-item">
                    <button class="accordion-header">
                        <?php echo htmlspecialchars($faq['question']); ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content">
                        <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('.accordion-header').forEach(button => {
    button.addEventListener('click', () => {
        const accordionItem = button.parentElement;
        accordionItem.classList.toggle('active');
    });
});
</script>

<?php include 'footer.php'; ?>
