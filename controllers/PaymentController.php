<?php
class PaymentController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requireLogin();
    }

    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=auth/login');
            exit;
        }
    }

    public function pay($booking_id = null) {

        if ($_SESSION['user_role'] !== 'customer') {
            header('Location: ' . BASE_URL . '/index.php?url=home/index');
            exit;
        }

        if (!$booking_id) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        $bookingModel = new Booking($this->db);
        $booking      = $bookingModel->getById($booking_id);

        if (!$booking ||
            $booking['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        if ($booking['payment_status'] === 'paid') {
            header('Location: ' . BASE_URL .
                   '/index.php?url=customer/mybookings');
            exit;
        }

        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $card_type   = $_POST['card_type']   ?? '';
            $card_name   = trim(htmlspecialchars(
                               $_POST['card_name']   ?? ''));
            $card_number = trim($_POST['card_number'] ?? '');
            $expiry      = trim($_POST['expiry']      ?? '');
            $cvv         = trim($_POST['cvv']         ?? '');

            $allowed_cards = ['visa'];

            if (empty($card_type) ||
                !in_array($card_type, $allowed_cards)) {
                $error = 'select(Visa).';

            } elseif (empty($card_name)) {
                $error = 'Please enter the cardholder name.';

            } elseif (strlen(preg_replace('/\s/', '',
                       $card_number)) < 16) {
                $error = 'Please enter a valid 16 digit card number.';

            } elseif (empty($expiry) ||
                      !preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
                                  $expiry)) {
                $error = 'Please enter a valid expiry date (MM/YY).';

            } elseif (strlen($cvv) < 3) {
                $error = 'Please enter a valid CVV.';

            } else {
                // CHECK EXPIRY DATE
                $parts         = explode('/', $expiry);
                $exp_month     = (int)$parts[0];
                $exp_year      = (int)('20' . $parts[1]);
                $current_year  = (int)date('Y');
                $current_month = (int)date('m');

                if ($exp_year < $current_year ||
                   ($exp_year === $current_year &&
                    $exp_month < $current_month)) {
                    $error = 'Your card has expired.';

                } else {
                    // GENERATE TRANSACTION ID
                    $prefix         = strtoupper(substr($card_type, 0, 2));
                    $transaction_id = 'GT-' . $prefix . '-' .
                                      date('YmdHis') . '-' .
                                      strtoupper(substr(
                                          md5(uniqid()), 0, 6));

                    // SAVE PAYMENT
                    $paymentModel                 = new Payment($this->db);
                    $paymentModel->booking_id     = $booking_id;
                    $paymentModel->user_id        = $_SESSION['user_id'];
                    $paymentModel->amount         = $booking['total_price'];
                    $paymentModel->payment_method = $card_type;
                    $paymentModel->transaction_id = $transaction_id;
                    $paymentModel->status         = 'completed';

                    if ($paymentModel->create()) {

                        // UPDATE BOOKING
                        $bookingModel->updatePaymentStatus(
                            $booking_id, 'paid');
                        $bookingModel->updateStatus(
                            $booking_id, 'confirmed');

                        // SEND EMAIL
                        $userModel = new User($this->db);
                        $user      = $userModel->findById(
                                         $_SESSION['user_id']);

                        if ($user && !empty($user['email'])) {
                            Email::sendPaymentSuccess(
                                $user['email'],
                                $user['full_name'],
                                $transaction_id,
                                $booking['package_title'],
                                number_format(
                                    $booking['total_price'], 0)
                            );
                        }

                        $success = 'Payment successful! ' .
                                   'Transaction ID: ' .
                                   $transaction_id;
                    } else {
                        $error = 'Payment failed. Please try again.';
                    }
                }
            }
        }

        require_once BASE_PATH . '/views/booking/payment.php';
    }
}
?>