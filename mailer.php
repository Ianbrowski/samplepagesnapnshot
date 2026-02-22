<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Collect Personal Info
    $contactPerson   = strip_tags(trim($_POST["contact_person"]));
    $contactNumber   = strip_tags(trim($_POST["contact_number"]));
    $userEmail       = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $fbName          = strip_tags(trim($_POST["fb_name"]));

    // 2. Collect Event Details
    $celebration     = strip_tags(trim($_POST["celebration"]));
    $celebrantName   = strip_tags(trim($_POST["celebrant_name"]));
    $eventDate       = strip_tags(trim($_POST["event_date"]));
    $startTime       = strip_tags(trim($_POST["start_time"]));
    $theme           = strip_tags(trim($_POST["theme"]));
    $setting         = strip_tags(trim($_POST["setting"])); // Indoor/Outdoor

    // 3. Collect Location Info
    $venueAddress    = strip_tags(trim($_POST["venue_address"]));
    $landmark        = strip_tags(trim($_POST["landmark"]));

    // 4. Collect Message & Selected Bundle
    $userMessage     = strip_tags(trim($_POST["message"]));
    $selectedBundle  = strip_tags(trim($_POST["selected_bundle"]));

    // Prepare the professional Email Body
    $emailBody = "
        <div style='font-family: sans-serif; color: #333; line-height: 1.6;'>
            <h2 style='color: #D4AF37; border-bottom: 2px solid #D4AF37; padding-bottom: 10px;'>
                New Booking Inquiry: {$celebration}
            </h2>
            
            <p><strong>Selected Bundle:</strong> <span style='color: #D4AF37; font-size: 1.2em;'>{$selectedBundle}</span></p>

            <h3>Client Information</h3>
            <ul>
                <li><strong>Contact Person:</strong> {$contactPerson}</li>
                <li><strong>Contact Number:</strong> {$contactNumber}</li>
                <li><strong>Email:</strong> {$userEmail}</li>
                <li><strong>Facebook:</strong> {$fbName}</li>
            </ul>

            <h3>Event Logistics</h3>
            <ul>
                <li><strong>Celebration:</strong> {$celebration}</li>
                <li><strong>Celebrant:</strong> {$celebrantName}</li>
                <li><strong>Date:</strong> {$eventDate}</li>
                <li><strong>Start Time:</strong> {$startTime}</li>
                <li><strong>Theme:</strong> {$theme}</li>
                <li><strong>Setting:</strong> {$setting}</li>
            </ul>

            <h3>Location Details</h3>
            <p><strong>Venue Address:</strong> {$venueAddress}</p>
            <p><strong>Landmark:</strong> {$landmark}</p>

            <h3>Additional Message</h3>
            <p style='background: #f9f9f9; padding: 15px; border-left: 4px solid #D4AF37;'>
                " . nl2br($userMessage) . "
            </p>
        </div>
    ";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hydrogen2303@gmail.com'; 
        $mail->Password   = 'xibs ugrb fajj srzr'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('hydrogen2303@gmail.com', 'Crimson Lens Studio');
        $mail->addAddress('hydrogen2303@gmail.com'); 
        $mail->addReplyTo($userEmail, $contactPerson);

        $mail->isHTML(true);
        $mail->Subject = "New Booking Request | " . $celebration . " - " . $contactPerson;
        $mail->Body    = $emailBody;

        $mail->send();
        
        header("Location: index.php?status=success#contact");
    } catch (Exception $e) {
        header("Location: index.php?status=error#contact");
    }
}