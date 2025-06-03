<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nếu dùng Composer autoload thì dùng dòng này:
// require_once __DIR__ . '/../vendor/autoload.php';
// Nếu không dùng Composer, sửa lại đường dẫn cho đúng:
require_once __DIR__ . '/../Vendor/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../Vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../Vendor/PHPMailer-master/src/SMTP.php';

/**
 * Gửi email với PHPMailer qua SMTP Gmail
 * @param string $toEmail Email người nhận
 * @param string $toName  Tên người nhận
 * @param string $subject Tiêu đề email
 * @param string $body    Nội dung email (HTML)
 * @return bool           true nếu gửi thành công, false nếu lỗi
 */
function sendMail($toEmail, $toName, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nguyenhuutainhanit@gmail.com';      // Thay bằng Gmail của bạn
        $mail->Password   = 'hciowgvepesglnby';                  // Thay bằng App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        //Recipients
        $mail->setFrom('nguyenhuutainhanit@gmail.com', 'sibi');
        $mail->addAddress($toEmail, $toName ?: $toEmail);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Hiển thị lỗi chi tiết để debug
        echo "Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}