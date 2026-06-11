<?php
session_start();
// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', 'http://localhost/globetrek');

// Config
require_once BASE_PATH . '/config/database.php';

// Models
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Package.php';
require_once BASE_PATH . '/models/Booking.php';
require_once BASE_PATH . '/models/Payment.php';
require_once BASE_PATH . '/models/Query.php';
require_once BASE_PATH . '/models/Destination.php';
require_once BASE_PATH . '/models/Report.php';
require_once BASE_PATH . '/models/HotelTransport.php';
require_once BASE_PATH . '/models/Accommodation.php';
require_once BASE_PATH . '/helpers/Email.php';
require_once BASE_PATH . '/models/TravelGuide.php';


// Controllers
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/HomeController.php';
require_once BASE_PATH . '/controllers/PackageController.php';
require_once BASE_PATH . '/controllers/BookingController.php';
require_once BASE_PATH . '/controllers/PaymentController.php';
require_once BASE_PATH . '/controllers/CustomerController.php';
require_once BASE_PATH . '/controllers/StaffController.php';
require_once BASE_PATH . '/controllers/AdminController.php';

// Currency helper function
function formatLKR($amount) {
    return 'Rs. ' . number_format($amount, 0, '.', ',');
}

// Router
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
$parts = explode('/', $url);

$controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
$action         = $parts[1] ?? 'index';
$param          = $parts[2] ?? null;

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        $controller->$action($param);
    } else {
        http_response_code(404);
        require_once BASE_PATH . '/views/errors/404.php';
    }
} else {
    http_response_code(404);
    require_once BASE_PATH . '/views/errors/404.php';
}
?>

