<?php
class BookingController {
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

    // CREATE BOOKING
    
    public function create($package_id = null) {

        // Only customers can book
        if ($_SESSION['user_role'] !== 'customer') {
            header('Location: ' . BASE_URL . '/index.php?url=home/index');
            exit;
        }

        // Get package ID from URL or GET param
        if (!$package_id) {
            $package_id = $_GET['package_id'] ?? null;
        }

        if (!$package_id) {
            header('Location: ' . BASE_URL . '/index.php?url=package/index');
            exit;
        }

        $packageModel = new Package($this->db);
        $package      = $packageModel->getById($package_id);

        if (!$package) {
            http_response_code(404);
            require_once BASE_PATH . '/views/errors/404.php';
            return;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $travel_date      = trim($_POST['travel_date']      ?? '');
            $num_persons      = (int)($_POST['num_persons']      ?? 1);
            $special_requests = htmlspecialchars(
                                    $_POST['special_requests'] ?? '');

            // VALIDATION
            if (empty($travel_date)) {
                $error = 'Please select a travel date.';
            } elseif (strtotime($travel_date) <= time()) {
                $error = 'Travel date must be in the future.';
            } elseif ($num_persons < 1) {
                $error = 'Number of persons must be at least 1.';
            } elseif ($num_persons > $package['max_persons']) {
                $error = 'Maximum ' . $package['max_persons'] .
                         ' persons allowed for this package.';
            } else {

                // CREATE BOOKING
                $bookingModel                   = new Booking($this->db);
                $bookingModel->user_id          = $_SESSION['user_id'];
                $bookingModel->package_id       = $package_id;
                $bookingModel->travel_date      = $travel_date;
                $bookingModel->num_persons      = $num_persons;
                $bookingModel->total_price      = $package['price'] *
                                                  $num_persons;
                $bookingModel->special_requests = $special_requests;

                $booking_id = $bookingModel->create();

                if ($booking_id) {

                    $userModel = new User($this->db);
                    $user      = $userModel->findById($_SESSION['user_id']);

                    // SEND BOOKING CONFIRMATION TO CUSTOMER
                    if ($user && !empty($user['email'])) {
                        Email::sendBookingConfirmation(
                            $user['email'],
                            $user['full_name'],
                            $booking_id,
                            $package['title'],
                            $package['destination'],
                            date('d M Y', strtotime($travel_date)),
                            $num_persons,
                            number_format(
                                $package['price'] * $num_persons, 0
                            )
                        );
                    }

                    // REDIRECT TO CONFIRM PAGE
                    header('Location: ' . BASE_URL .
                           '/index.php?url=booking/confirm/' .
                           $booking_id);
                    exit;

                } else {
                    $error = 'Booking failed. Please try again.';
                }
            }
        }

        require_once BASE_PATH . '/views/booking/create.php';
    }

    // =============================================
    // CONFIRM BOOKING PAGE
    // =============================================
    public function confirm($booking_id = null) {

        if (!$booking_id) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        $bookingModel = new Booking($this->db);
        $booking      = $bookingModel->getById($booking_id);

        // Security check — must be owner
        if (!$booking ||
            $booking['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        require_once BASE_PATH . '/views/booking/confirm.php';
    }

    // =============================================
    // CANCEL BOOKING
    // =============================================
    public function cancel($booking_id = null) {

        if (!$booking_id) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        $bookingModel = new Booking($this->db);
        $bookingModel->cancel($booking_id, $_SESSION['user_id']);

        header('Location: ' . BASE_URL .
               '/index.php?url=customer/mybookings');
        exit;
    }
}
?>