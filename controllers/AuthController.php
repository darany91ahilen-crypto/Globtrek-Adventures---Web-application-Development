<?php
class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database   = new Database();
        $this->db   = $database->getConnection();
        $this->user = new User($this->db);
    }

    // =====================
    // LOGIN
    // =====================
    public function login() {
        $error = '';

        if (isset($_SESSION['user_id'])) {
            $this->redirectByRole($_SESSION['user_role']);
        }

        // Generate CSRF token if not already set
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['csrf_token']) ||
                !isset($_SESSION['csrf_token']) ||
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $error = 'Invalid request. Please try again.';
                require_once BASE_PATH . '/views/auth/login.php';
                return;
            }

            $email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $userData = $this->user->findByEmail($email);
                if ($userData && password_verify($password, $userData['password'])) {
                    session_regenerate_id(true);

                    $_SESSION['user_id']       = $userData['id'];
                    $_SESSION['user_name']     = $userData['full_name'];
                    $_SESSION['user_role']     = $userData['role'];
                    $_SESSION['user_email']    = $userData['email'];
                    $_SESSION['last_activity'] = time();

                    // Regenerate CSRF after login
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    $this->redirectByRole($userData['role']);
                } else {
                    $error = 'Invalid email or password. Please try again.';
                }
            }
        }
        require_once BASE_PATH . '/views/auth/login.php';
    }

    // =====================
    // REGISTER
    // =====================
    public function register() {
        $error   = '';
        $success = '';

        if (isset($_SESSION['user_id'])) {
            $this->redirectByRole($_SESSION['user_role']);
        }

        // Generate CSRF token if not already set
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST['csrf_token']) ||
                !isset($_SESSION['csrf_token']) ||
                $_POST['csrf_token'] !== $_SESSION['csrf_token']) {                                                         
                $error = 'Invalid request. Please try again.';
                require_once BASE_PATH . '/views/auth/register.php';
                return;
                }
                $full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email']     ?? '');
$phone     = trim($_POST['phone']     ?? '');
$password  = $_POST['password']        ?? '';
$confirm   = $_POST['confirm_password'] ?? '';
            if (empty($full_name)) {
                $error = 'Full name is required.';
            } elseif (strlen($full_name) < 3) {
                $error = 'Full name must be at least 3 characters.';
            } elseif (empty($email)) {
                $error = 'Email address is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
                $error = 'Phone number must be exactly 10 digits.';
            } elseif (empty($password)) {
                $error = 'Password is required.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters.';
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $error = 'Password must contain at least one uppercase letter.';
            } elseif (!preg_match('/[0-9]/', $password)) {
                $error = 'Password must contain at least one number.';
            } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
                $error = 'Password must contain at least one special character (!@#$%).';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } elseif ($this->user->emailExists($email)) {
                $error = 'This email is already registered. Please login.';
            } else {
                $this->user->full_name = $full_name;
                $this->user->email     = $email;
                $this->user->phone     = $phone;
                $this->user->password  = password_hash($password, PASSWORD_DEFAULT);
                $this->user->role      = 'customer';

                if ($this->user->register()) {
                    // Regenerate CSRF token after successful registration
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    $success = 'Registration successful! You can now login.';
                } else {
                    $error = 'Registration failed. Please try again.';
                }
            }
        }
        require_once BASE_PATH . '/views/auth/register.php';
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }

    // =====================
    // FORGOT PASSWORD
    // =====================
    public function forgot() {
        $error   = '';
        $success = '';

        // Generate CSRF token if not already set
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

            if (empty($email)) {
                $error = 'Please enter your email address.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (!$this->user->emailExists($email)) {
                $error = 'No account found with this email address.';
            } else {
                $token    = (string)random_int(100000, 999999);
                $expires  = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                $userData = $this->user->findByEmail($email);
                $this->user->saveResetToken($userData['id'], $token, $expires);

                $reset_link = BASE_URL . '/index.php?url=auth/reset/' . $token;
                if (Email::sendPasswordResetOtp(
                    $userData['email'],
                    $userData['full_name'],
                    $token,
                    $reset_link
                )) {
                    $success = 'A password reset OTP has been sent to your email. It expires in 15 minutes.';
                } else {
                    $error = 'We could not send the reset email. Please try again later.';
                }
            }
        }
        require_once BASE_PATH . '/views/auth/forgot.php';
    }

    // =====================
    // RESET PASSWORD
    // =====================
    public function reset($token) {
        $error   = '';
        $success = '';

        if (empty($token)) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        $userData = $this->user->findByResetToken($token);
        if (!$userData) {
            $error = 'This reset link is invalid or has expired. Please request a new one.';
            require_once BASE_PATH . '/views/auth/forgot.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password']         ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters.';
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $error = 'Password must contain at least one uppercase letter.';
            } elseif (!preg_match('/[0-9]/', $password)) {
                $error = 'Password must contain at least one number.';
            } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
                $error = 'Password must contain at least one special character.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $this->user->updatePassword($userData['id'], $hashed);
                $this->user->clearResetToken($userData['id']);
                $success = 'Your password has been reset successfully!';
            }
        }
        require_once BASE_PATH . '/views/auth/reset.php';
    }

    // =====================
    // HELPER
    // =====================
    private function redirectByRole($role) {
        if ($role === 'admin') {
            header('Location: ' . BASE_URL . '/index.php?url=admin/dashboard');
        } elseif ($role === 'staff') {
            header('Location: ' . BASE_URL . '/index.php?url=staff/dashboard');
        } else {
            header('Location: ' . BASE_URL . '/index.php?url=customer/dashboard');
        }
        exit;
    }
}
?>