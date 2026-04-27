<?php 
$page_title = 'Contact Us';
include 'header.php'; 

$whatsapp_number = $db->getSetting('whatsapp_number', '2348000000000');
?>

<section class="page-hero" style="background: var(--primary); color: var(--white); padding: 100px 0; text-align: center;">
    <div class="container">
        <h1 style="color: white; font-size: 48px;">Contact Us</h1>
        <p style="color: #94a3b8; font-size: 20px; margin-top: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">Have questions or ready to get started? Reach out directly via WhatsApp for instant support.</p>
    </div>
</section>

<section class="contact-section" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="container">
        <div class="hero-grid" style="align-items: start; gap: 40px;">
            <div class="contact-info" style="padding: 40px;">
                <h2 style="font-size: 32px; margin-bottom: 20px;">Get in Touch</h2>
                <p style="color: var(--text-muted); font-size: 16px; line-height: 1.8;">Our team is dedicated to empowering you with the best investment knowledge. Whether you're a beginner or looking to scale, we're here to help.</p>
                
                <div style="margin-top: 50px;">
                    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px; background: var(--white); padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                        <div style="width: 60px; height: 60px; background: #dcfce7; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #16a34a;">
                            <i class="fab fa-whatsapp" style="font-size: 30px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 18px;">Official WhatsApp</div>
                            <div style="color: var(--text-muted);">Instant response & support</div>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 20px; background: var(--white); padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                        <div style="width: 60px; height: 60px; background: #eff6ff; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: var(--primary-accent);">
                            <i class="fas fa-envelope" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 18px;">Email Address</div>
                            <div style="color: var(--text-muted);">info@smartinvesting.ng</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <div class="card">
                    <h3 style="margin-bottom: 25px; font-size: 24px;">Message Us Directly</h3>
                    <p style="color: var(--text-muted); margin-bottom: 30px;">Fill the details below and you'll be redirected to chat with our investment advisors.</p>
                    <form id="whatsappForm">
                        <div class="form-group">
                            <label>Your Full Name</label>
                            <input type="text" id="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label>How can we help you?</label>
                            <textarea id="message" rows="5" placeholder="I'm interested in the beginner training program..." required></textarea>
                        </div>
                        <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; background: #25d366; font-size: 18px; padding: 18px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fab fa-whatsapp" style="font-size: 22px;"></i> Open WhatsApp Chat
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
    
    const text = `Hello Smart Investing NG,\nMy name is ${name}.\n\nMessage: ${msg}`;
    const encodedText = encodeURIComponent(text);
    
    // Track lead
    fetch('/track-whatsapp-api').finally(() => {
        window.location.href = `https://wa.me/${phone}?text=${encodedText}`;
    });
});
</script>

<?php include 'footer.php'; ?>
