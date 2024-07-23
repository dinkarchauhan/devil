<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$receiving_email_address = 'dinkarchauhan720@gmail.com';

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'beelabsofficial@gmail.com'; // SMTP username
        $mail->Password   = 'your_app_password'; // Use an app password, not your actual Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addAddress($receiving_email_address);
        $mail->addReplyTo($_POST['email'], $_POST['name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body    = "From: {$_POST['name']}<br>Email: {$_POST['email']}<br><br>Message:<br>{$_POST['message']}";

        $mail->send();
        echo json_encode(['success' => 'Message has been sent']);
    } catch (Exception $e) {
        echo json_encode(['error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
