<?php
session_start();
include('./admin/inc/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $query  = $_POST['query'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@cosmicenergies.in'; // your Gmail
        $mail->Password   = 'lflkcvbhvwbhvrui';   // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        /* -------------------------
           1. Send Email to Admin
        --------------------------*/
        $mail->setFrom('info@cosmicenergies.in', 'Website Contact Form');
        $mail->addAddress('info@cosmicenergies.in', 'Website Admin'); 
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission";
        $mail->Body    = "
            <h2>New Contact Query</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Mobile:</strong> {$mobile}</p>
            <p><strong>Gender:</strong> {$gender}</p>
            <p><strong>Query:</strong><br>{$query}</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nMobile: $mobile\nGender: $gender\nQuery: $query";

        $mail->send();

        /* -------------------------
           2. Send Confirmation to User
        --------------------------*/
        $mail->clearAddresses(); // clear old recipient
        $mail->addAddress($email, $name); 

        $mail->Subject = "Thank You for Contacting Us";
        $mail->Body    = "
            <h2>Hello {$name},</h2>
            <p>Thank you for contacting us. We have received your query and our team will get back to you shortly.</p>
            <p><strong>Your Query:</strong><br>{$query}</p>
            <br>
            <p>Regards,<br>Website Team</p>
        ";
        $mail->AltBody = "Hello $name,\n\nThank you for contacting us. We received your query:\n$query\n\n- Website Team";

        $mail->send();

        // ✅ Redirect on success
        header("Location: index.php?msg=success");
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
