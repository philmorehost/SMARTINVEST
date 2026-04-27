<?php 
$page_title = 'Smart Investing NG Beginner Training Program';
include 'header.php'; 
?>

<section class="page-hero" style="background: var(--primary); color: var(--white); padding: 80px 0; text-align: center;">
    <div class="container">
        <h1>Smart Investing NG Beginner Training Program</h1>
        <p style="color: #94a3b8; font-size: 18px; margin-top: 15px;">This training helps complete beginners understand how to invest in the Nigerian stock market step-by-step.</p>
    </div>
</section>

<section class="training-details">
    <div class="container">
        <div class="hero-grid">
            <div class="details-content">
                <h2>Curriculum Overview</h2>
                <ul class="training-list" style="margin-top: 30px; font-size: 18px; color: var(--text);">
                    <li><i class="fas fa-check-circle" style="color: var(--secondary);"></i> How the stock market works</li>
                    <li><i class="fas fa-check-circle" style="color: var(--secondary);"></i> How to open and fund a brokerage account</li>
                    <li><i class="fas fa-check-circle" style="color: var(--secondary);"></i> How to buy and sell shares</li>
                    <li><i class="fas fa-check-circle" style="color: var(--secondary);"></i> How to identify good stocks</li>
                    <li><i class="fas fa-check-circle" style="color: var(--secondary);"></i> How to manage risk</li>
                </ul>

                <h2 style="margin-top: 40px;">How It Works:</h2>
                <p style="margin-top: 10px;">Live sessions / recorded classes, practical examples, step-by-step guidance, support group access</p>

                <h2 style="margin-top: 40px;">Who Should Join:</h2>
                <p style="margin-top: 10px;">Beginners, workers, diaspora Nigerians, anyone interested in investing</p>

                <h2 style="margin-top: 40px;">Bonuses:</h2>
                <p style="margin-top: 10px;">WhatsApp group, free resources, updates</p>
            </div>
            
            <div class="enrollment-form-container">
                <div class="card" style="padding: 40px; border: 2px solid var(--primary-accent);">
                    <h3 style="margin-bottom: 25px; text-align: center;">Enroll Now</h3>
                    <p style="text-align: center; color: var(--text-muted); margin-bottom: 30px;">Fill the form below to secure your spot. You will be redirected to WhatsApp for payment details.</p>
                    <form action="/enroll" method="POST">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Full Name</label>
                            <input type="text" name="name" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Email Address</label>
                            <input type="email" name="email" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
                        </div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            <label>Phone Number</label>
                            <input type="text" name="phone" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border);" placeholder="080...">
                        </div>
                        <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer; font-size: 18px;">Enroll Now - ₦15,000</button>
                    </form>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="/track-whatsapp" style="color: #25d366; font-weight: 600;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
