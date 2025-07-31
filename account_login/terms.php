<?php
include '../database/db_connection.php';
    
session_start();
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = $_POST['theme'];
}
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

    <div class="terms-content">
        <div class="terms-header">
    <h1>Terms of Service</h1>
    <p>Welcome to Finance First! By using our services, you agree to comply with and be bound by the following 
    terms and conditions:</p>
    </div>

    <div class="terms-acceptance">
    <h2>1. Acceptance of Terms</h2>
    <p>By accessing or using our website, you agree to these terms. If you do not agree, please do not use our 
    services.</p>
    </div>

    <div class="terms-changes">
    <h2>2. Changes to Terms</h2>
    <p>We may modify these terms at any time. Changes will be effective immediately upon posting on this page.
    Your continued use of the site after changes are posted constitutes your acceptance of the new terms.</p>
    </div>

    <div class="terms-user-responsibilities">
    <h2>3. User Responsibilities</h2>
    <p>You are responsible for maintaining the confidentiality of your account information and for all activities 
    that occur under your account. You agree to notify us immediately of any unauthorized use of your account or 
    any other breach of security.</p>
    </div>

    <div class="terms-use-of-services">
    <h2>4. Use of Services</h2>
    <p>You agree to use our services only for lawful purposes and in accordance with these terms. You must not 
    use our services in any way that violates any applicable local, national, or international law or regulation.</p>
    </div>

    <div class="terms-intellectual-property">
    <h2>5. Intellectual Property</h2>
    <p>All content on this site, including text, graphics, logos, and software, is the property of Finance First 
    or its licensors and is protected by copyright, trademark, and other intellectual property laws. You may not 
    reproduce, distribute, or create derivative works from any content without our express written permission.</p>
    </div>

    <div class="terms-limitation-of-liability">
    <h2>6. Limitation of Liability</h2>
    <p>In no event shall Finance First, its directors, employees, or agents be liable for any direct, indirect, 
    incidental, special, consequential, or punitive damages arising out of or in connection with your use of our 
    services or this site. This includes, but is not limited to, damages for loss of profits, goodwill, use, data, 
    or other intangible losses.</p>
    </div>

    <div class="terms-indemnification">
    <h2>7. Indemnification</h2>
    <p>You agree to indemnify, defend, and hold harmless Finance First, its affiliates, and their respective officers, 
    directors, employees, and agents from any claim, liability, loss, damage, or expense (including reasonable 
    attorneys' fees) arising out of or related to your use of our services, your violation of these terms, or your 
    violation of any rights of another party.</p>
    </div>

    <div class="terms-governing-law">
    <h2>8. Governing Law</h2>
    <p>These terms shall be governed by and construed in accordance with the laws of the jurisdiction in which 
    Finance First operates, without regard to its conflict of law principles. You agree to submit to the personal 
    jurisdiction of the courts located within that jurisdiction for the resolution of any disputes.</p> 
    </div>

    <div class="terms-contact">
    <h2>9. Contact Information</h2> 
    <p>If you have any questions about these terms, please contact us at:</p>
    <p>Email: support@financefirst.com</p>
    <p>Phone: 1-800-555-0199</p>
    <p>Address: 123 Finance St, Money City, FC 12345</p>
    <p>Thank you for choosing Finance First!</p>
    </div>

    </div>
</body>
</html>