<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipients = $_POST['recipients'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Split multiple recipients
    $recipientArray = array_map('trim', explode(',', $recipients));

    $mail = new PHPMailer();
    $mail->IsSMTP();

    // SMTP configuration
    $mail->SMTPDebug  = 0; // Set to 0 for production
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "xskaven6@gmail.com"; // Your Gmail
    $mail->Password   = "shidqrwdcpcjzyhq"; // Your Gmail App Password

    // Email content
    $mail->IsHTML(true);
    $mail->SetFrom("xskaven6@gmail.com", "Scholarship System");
    $mail->Subject = $subject;
    $mail->Body = "<div style='font-family: Arial, sans-serif;'>$message</div>";

    // Add all recipients
    foreach ($recipientArray as $email) {
        $mail->AddAddress($email);
    }

    // Send email and return response
    if(!$mail->Send()) {
        echo json_encode(['success' => false, 'message' => "Error sending email: " . $mail->ErrorInfo]);
    } else {
        echo json_encode(['success' => true, 'message' => "Email sent successfully!"]);
    }

    // Clear all recipients for next send
    $mail->ClearAddresses();
}
?>
