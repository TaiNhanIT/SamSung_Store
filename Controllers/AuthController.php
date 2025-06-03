<?php
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../helpers/send_Email.php';

class AuthController {
    public function login() {
        session_start();
        $login_error = '';
        $register_success = '';
        if (isset($_SESSION['customer_id']) && isset($_SESSION['customer_email'])) {
            $email = $_SESSION['customer_email'];
            $password = $_SESSION['last_login_password'] ?? '';
        }
        // Nếu vừa chuyển từ đăng ký sang (chưa POST), lấy từ session
        else if ($_SERVER['REQUEST_METHOD'] !== 'POST' && (isset($_SESSION['login_email']) || isset($_SESSION['login_password']))) {
            $email = $_SESSION['login_email'] ?? '';
            $password = $_SESSION['login_password'] ?? '';
            unset($_SESSION['login_email'], $_SESSION['login_password']);
        } else {
            // Nếu vừa submit form, lấy từ POST
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
        }

        if (isset($_SESSION['register_success'])) {
            $register_success = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($email);
            $password = trim($password);

            $customerModel = new Customer();
            $customer = $customerModel->getCustomerByEmail($email);

            // Sử dụng password_verify để kiểm tra mật khẩu đã mã hóa
            if ($customer && password_verify($password, $customer['password'])) {
                $_SESSION['customer_id'] = $customer['id'];
                $_SESSION['customer_email'] = $customer['email'];
                $_SESSION['last_login_password'] = $password;
                header('Location: /SamSung/');
                exit;
            } else {
                $login_error = 'Email hoặc mật khẩu không đúng!';
            }
        }
        require __DIR__ . '/../views/loginAndRegister/login.php';
    }

    public function register() {
        session_start();
        $register_error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $street = trim($_POST['street'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $country_code = trim($_POST['country_code'] ?? '');

            if (!$first_name || !$last_name || !$email || !$phone || !$password) {
                $register_error = "Vui lòng nhập đầy đủ thông tin!";
            } else {
                $customerModel = new Customer();
                if ($customerModel->emailExists($email)) {
                    $register_error = "Email đã tồn tại!";
                } else {
                    $customer_id = $customerModel->addCustomer([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'phone_number' => $phone,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ]);
                    if ($customer_id) {
                        $customerModel->addAddress($customer_id, $street, $city, $country_code);
                        $_SESSION['register_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                        $_SESSION['login_email'] = $email;
                        $_SESSION['login_password'] = $password;
                        header('Location: /SamSung/?controller=auth&action=login');
                        exit;
                    } else {
                        $register_error = "Đăng ký thất bại!";
                    }
                }
            }
        }
        require __DIR__ . '/../views/loginAndRegister/register.php';
    }

    public function resetPassword() {
        $error = '';
        $success = '';
        $token = $_GET['token'] ?? '';
        $customerModel = new Customer();
        $customer = $customerModel->getCustomerByToken($token);
        if (!$customer) {
            $error = "Link không hợp lệ hoặc đã hết hạn!";
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $customer) {
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';
    if (!$password || !$repassword) {
        $error = "Vui lòng nhập đầy đủ mật khẩu!";
    } elseif ($password !== $repassword) {
        $error = "Mật khẩu nhập lại không khớp!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($customerModel->updatePassword($customer['email'], $hashedPassword)) {
            $customerModel->clearResetToken($customer['email']);
            $success = "Đổi mật khẩu thành công! <a href='?controller=auth&action=login'>Đăng nhập</a>";
        } else {
            $error = "Không thể cập nhật mật khẩu. Vui lòng thử lại!";
        }
    }
        }
        require __DIR__ . '/../views/loginAndRegister/resetPassword.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /SamSung/?controller=auth&action=login');
        exit();
    }

    public function forgotPassword() {
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $customerModel = new Customer();
            $customer = $customerModel->getCustomerByEmail($email);
            if ($customer) {
                $token = bin2hex(random_bytes(32));
                $customerModel->saveResetToken($email, $token);
                $resetLink = "http://localhost:8080/SamSung/?controller=auth&action=resetPassword&token=$token";
                $subject = "Yêu cầu đặt lại mật khẩu";
                $body = "Nhấn vào link sau để đặt lại mật khẩu: <a href='$resetLink'>$resetLink</a>";
                if (sendMail($email, $customer['first_name'] ?? '', $subject, $body)) {
                    $success = "Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư!";
                } else {
                    $error = "Không gửi được email. Vui lòng thử lại sau!";
                }
            } else {
                $error = "Email không tồn tại trong hệ thống!";
            }
        }
        require __DIR__ . '/../views/loginAndRegister/forgotPassword.php';
    }
}