<?php 
$page_title = 'Contact Us';
include 'header.php'; 

$whatsapp_number = $db->getSetting('whatsapp_number', '2348000000000');
?>

<section class="page-hero" style="background: var(--primary); color: var(--white); padding: 80px 0; text-align: center;">
    <div class="container">
        <h1>Contact Us</h1>
        <p style="color: #94a3b8; font-size: 18px; margin-top: 15px;">Have questions? We are just a message away.</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="hero-grid" style="align-items: start; gap: 60px;">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p style="margin-top: 20px; color: var(--text-muted);">For faster responses, we recommend reaching out via WhatsApp. Our team is available to help you with your investment journey.</p>
                
                <div style="margin-top: 40px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="width: 50px; height: 50px; background: var(--primary-light); border-radius: 50%; display: flex; justify-content: center; align-items: center; color: var(--primary-accent);">
                            <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary);">WhatsApp</div>
                            <div style="color: var(--text-muted);">Chat with us instantly</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: var(--primary-light); border-radius: 50%; display: flex; justify-content: center; align-items: center; color: var(--primary-accent);">
                            <i class="fas fa-envelope" style="font-size: 20px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary);">Email</div>
                            <div style="color: var(--text-muted);">info@smartinvesting.ng</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <div class="card" style="padding: 40px; border: 1px solid var(--border);">
                    <h3 style="margin-bottom: 25px;">Send a WhatsApp Message</h3>
                    <form id="whatsappForm">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label>Your Message</label>
                            <textarea id="message" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; background: #25d366; font-size: 16px;">
                            <i class="fab fa-whatsapp"></i> Send via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('whatsappForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const msg = document.getElementById('message').value;
    const phone = "<?php echo $whatsapp_number; ?>";
    
    const text = `Hello, my name is ${name}. ${msg}`;
    const encodedText = encodeURIComponent(text);
    
    // Track as a lead before redirecting
    fetch('/track-whatsapp-api').then(() => {
        window.location.href = `https://wa.me/${phone}?text=${encodedText}`;
    });
});
</script>

<?php include 'footer.php'; ?>
