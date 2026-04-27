<?php
/**
 * Frontend Footer
 */
$footer_code = $db->getSetting('footer_code');
?>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <div class="footer-logo">Smart Investing <span>NG</span></div>
                    <p>Empowering Nigerians with the knowledge and tools to achieve financial freedom through the Nigerian stock market.</p>
                </div>
                <div class="footer-links">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/training">Training</a></li>
                        <li><a href="/learning">Free Learning</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/faq">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Contact</h4>
                    <p style="color: #94a3b8; margin-bottom: 15px;">Questions? Reach out to us via WhatsApp for instant support.</p>
                    <a href="https://wa.me/<?php echo $db->getSetting('whatsapp_number'); ?>" class="cta-btn" style="background: #25d366;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Smart Investing NG. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script src="assets/js/main.js"></script>
    <?php echo $footer_code; ?>
</body>
</html>
