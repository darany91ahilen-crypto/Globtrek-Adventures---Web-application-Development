<?php
class CustomerController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requireLogin();
    }

    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    public function dashboard() {
        $bookingModel = new Booking($this->db);
        $bookings     = $bookingModel->getByUserId($_SESSION['user_id']);
        $total        = count($bookings);
        $upcoming     = array_filter($bookings, fn($b) => $b['status'] === 'confirmed');
        require_once BASE_PATH . '/views/customer/dashboard.php';
    }

    public function mybookings() {
        $bookingModel = new Booking($this->db);
        $bookings     = $bookingModel->getByUserId($_SESSION['user_id']);
        require_once BASE_PATH . '/views/customer/mybookings.php';
    }

    public function profile() {
        $userModel = new User($this->db);
        $error     = '';
        $success   = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel->id        = $_SESSION['user_id'];
            $userModel->full_name = htmlspecialchars($_POST['full_name']);
            $userModel->phone     = htmlspecialchars($_POST['phone']);
            if ($userModel->updateProfile()) {
                $_SESSION['user_name'] = $userModel->full_name;
                $success = 'Profile updated successfully.';
            } else {
                $error = 'Update failed.';
            }
        }
        $user = $userModel->findById($_SESSION['user_id']);
        require_once BASE_PATH . '/views/customer/profile.php';
    }

    public function query() {
        $error   = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $queryModel          = new Query($this->db);
            $queryModel->user_id = $_SESSION['user_id'];
            $queryModel->name    = $_SESSION['user_name'];
            $queryModel->email   = $_SESSION['user_email'];
            $queryModel->subject = htmlspecialchars($_POST['subject']);
            $queryModel->message = htmlspecialchars($_POST['message']);
            if ($queryModel->create()) {
                $success = 'Query submitted successfully!';
            } else {
                $error = 'Failed to submit query.';
            }
        }
        $queryModel  = new Query($this->db);
        $myQueries   = $queryModel->getByUserId($_SESSION['user_id']);
        require_once BASE_PATH . '/views/customer/query.php';
    }
}
?>