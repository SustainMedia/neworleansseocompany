<?php

require '../vendor/PHP-Mailer/src/PHPMailer.php';
require '../vendor/PHP-Mailer/src/SMTP.php';
require '../vendor/PHP-Mailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $service = $_POST['service'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $website = $_POST['website'] ?? '';
    $pageUrl = $_POST['page_url'] ?? ''; // matches JS variable

    // Basic validation
    if (empty($name) || empty($service) || empty($email) || empty($phone) || empty($website)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'groundsmenwebsiteform@gmail.com';
        $mail->Password = 'iojb txzq rxmi owhj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('groundsmenwebsiteform@gmail.com', 'New Orleans SEO Company');
        $mail->addAddress('getgroundskeeping@icloud.com');
        // $mail->addAddress('muhammadumair25591@gmail.com');
        $mail->addAddress('access@sustain-media.com');

        $mail->isHTML(true);
        $mail->Subject = 'NEW LEAD - New Orleans SEO Company Form Submission';
        $mail->Body    = "<h3>Audit Request Details</h3>
                          <p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Phone:</strong> $phone</p>
                          <p><strong>Website URL:</strong> $website</p>
                          <p><strong>Selected Service:</strong> $service</p>
                          <p><strong>Submitted From Page:</strong> <a href='$pageUrl' target='_blank'>$pageUrl</a></p>";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo
        ]);
    }
}
