<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

// Check if the form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data from your HTML
    $userName    = strip_tags(trim($_POST["name"]));
    $userEmail   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $eventType   = strip_tags(trim($_POST["event_type"]));
    $userMessage = strip_tags(trim($_POST["message"]));

    // Prepare the email body
    $emailBody = "
        <h2>New Inquiry from Crimson Lens Website</h2>
        <p><strong>Name:</strong> {$userName}</p>
        <p><strong>Email:</strong> {$userEmail}</p>
        <p><strong>Event:</strong> {$eventType}</p>
        <p><strong>Message:</strong><br>{$userMessage}</p>
    ";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hydrogen2303@gmail.com'; 
        $mail->Password   = 'xibs ugrb fajj srzr'; // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('hydrogen2303@gmail.com', 'Crimson Lens Studio');
        $mail->addAddress('hydrogen2303@gmail.com'); // Where you want to RECEIVE the mail
        $mail->addReplyTo($userEmail, $userName);     // So you can click 'Reply' directly

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Studio Booking: " . $eventType;
        $mail->Body    = $emailBody;

        $mail->send();
        
        // Redirect back to your site with a success message
        header("Location: index.php?status=success#contact");
    } catch (Exception $e) {
        header("Location: index.php?status=error#contact");
    }
}