<?php
// Include the database connection file
include '../database/db_connection.php';
    
// Start the session
session_start();

// Handle theme selection from POST request and store in session
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
// Set theme and corresponding CSS file
$theme = $_SESSION['theme'] ?? 'style';
$cssFile = match ($theme) {
    'night-mode' => 'night-mode.css',
    'pink' => 'pink.css',
    default => 'style.css',
};
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>title</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="privacy-content">
    
    <div class="privacy-header">
    <h1>Privacy Policy</h1>
    <p>At Finance First, we value your privacy and are committed to protecting your personal information. 
        This Privacy Policy outlines how we collect, use, and safeguard your data.</p>
    </div>

    <div class="privacy-intro">
    <h2>Information Collection</h2>
    <p>We collect information from you when you register on our site, subscribe to our newsletter, fill 
        out a form, or interact with our services. The types of information we may collect include your name, 
        email address, phone number, and financial information.</p>
    </div>

    <div class="privacy-use">
    <h2>Use of Information</h2>
    <p>We use the information we collect to provide you with a personalized experience, improve our website, 
        process transactions, send periodic emails, and respond to your inquiries. We may also use your 
        information to send you promotional materials about our services, which you can opt out of at any time.</p>
    </div>

    <div class="privacy-security">
    <h2>Data Protection</h2>
    <p>We implement a variety of security measures to maintain the safety of your personal information. 
        Your personal information is stored in secure networks and is only accessible by a limited number 
        of persons who have special access rights to such systems, and are required to keep the information 
        confidential.</p>
    </div>

    <div class="privacy-disclosure">
    <h2>Cookies</h2>
    <p>Our website may use "cookies" to enhance user experience. You can choose to set your web browser to 
        refuse cookies or to alert you when cookies are being sent. If you do so, note that some parts of the 
        site may not function properly.</p>
    </div>

    <div class="privacy-third-party">
    <h2>Third-Party Disclosure</h2>
    <p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information 
        unless we provide users with advance notice. This does not include website hosting partners and other 
        parties who assist us in operating our website, conducting our business, or servicing you, so long as 
        those parties agree to keep this information confidential. We may also release information when it's 
        release is appropriate to comply with the law, enforce our site policies, or protect ours or others' 
        rights, property or safety.</p>
    </div>

    <div class="privacy-links">
    <h2>Changes to This Privacy Policy</h2>
    <p>We may update this Privacy Policy from time to time. We will notify you about significant changes in 
        the way we treat personal information by sending a notice to the primary email address specified in 
        your account or by placing a prominent notice on our site.</p>

    </div>

    <div class="privacy-contact">
    <h2>Contact Us</h2>
    <p>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with 
        this site, please contact us at:</p>
    <p>Email: support@financefirst.com</p>
    <p>Phone: 1-800-555-0199</p>
    <p>Address: 123 Finance St, Money City, FC 12345</p>
    <p>Thank you for choosing Finance First!</p>
    </div>

    </div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-div">
    <ul class="socials">
        <span>Socials</span>
        <li><a href="https://www.linkedin.com/financefirst">LinkedIn</a></li>
        <li><a href="https://www.facebook.com/financefirst">Facebook</a></li>
        <li><a href="https://www.instagram.com/financefirst">Instagram</a></li>
        <li><a href="https://www.tiktok.com/financefirst">Tiktok</a></li>
    </ul>
    
    <ul class="wiki-pages">
        <span>Wiki Pages</span>
        <li><a href="../wiki/register_wiki.php" target="_blank">Login and Registration</a></li>
        <li><a href="../wiki/appointment_wiki.php" target="_blank">Appointments</a></li>
        <li><a href="../wiki/forum_wiki.php" target="_blank">Forums</a></li>
        <li><a href="../wiki/budget_wiki.php" target="_blank">Budget</a></li>
        <li><a href="../wiki/theme_wiki.php" target="_blank">Theme</a></li>
    </ul>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d184552.67410029974!2d-79.5428651034961!3d43.71812280463856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d4cb90d7c63ba5%3A0x323555502ab4c477!2sToronto%2C%20ON!5e0!3m2!1sen!2sca!4v1753924038204!5m2!1sen!2sca" 
            width="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p>&copy; 2025 Finance First. All rights reserved.</p>

        

    </footer>
</body>
</html>