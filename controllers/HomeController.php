<?php
class HomeController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $page_title='Home';
        $packageModel     = new Package($this->db);
        $destinationModel = new Destination($this->db);
        $featured         = $packageModel->getFeatured(6);
        $destinations     = $destinationModel->getAll();
        require_once BASE_PATH . '/views/home/index.php';
    }

    public function about() {
        require_once BASE_PATH . '/views/home/about.php';
    }
    public function accommodation() {
            $accommodationModel = new Accommodation($this->db);
            $filters = [];
            if (!empty($_GET['location'])) $filters['location'] = $_GET['location'];
            if (!empty($_GET['type']))     $filters['type']     = $_GET['type'];
            if (!empty($_GET['max_price']))$filters['max_price'] = (float)$_GET['max_price'];
            $accommodations = $accommodationModel->getAll($filters);
            require_once BASE_PATH . '/views/home/accommodation.php';
        }

        public function accommodationDetail($id) {
            if (!$id) {
                header('Location: ' . BASE_URL . '/index.php?url=home/accommodation');
                exit;
            }
            $accommodationModel = new Accommodation($this->db);
            $accommodation = $accommodationModel->getById($id);
            if (!$accommodation) {
                echo "<h2 style='padding:2rem;'>Accommodation not found.</h2>";
                return;
            }
            require_once BASE_PATH . '/views/home/accommodation_detail.php';
        }

    public function contact() {
        $success = '';
        $error   = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $queryModel          = new Query($this->db);
            $queryModel->name    = htmlspecialchars($_POST['name']);
            $queryModel->email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $queryModel->subject = htmlspecialchars($_POST['subject']);
            $queryModel->message = htmlspecialchars($_POST['message']);
            $queryModel->user_id = $_SESSION['user_id'] ?? null;
            if ($queryModel->create()) {
                $success = 'Query submitted successfully!';
            } else {
                $error = 'Failed to submit query.';
            }
        }
        require_once BASE_PATH . '/views/home/contact.php';
    }

public function guides() {
    $guideModel = new TravelGuide($this->db);
    $guides     = $guideModel->getAllForStaff();
    require_once BASE_PATH . '/views/home/guides.php';
}

public function guide_detail($id) {
    if (!$id) {
        header('Location: ' . BASE_URL .
               '/index.php?url=home/guides');
        exit;
    }
    $guideModel = new TravelGuide($this->db);
    $guide      = $guideModel->getById($id);
 
    
    require_once BASE_PATH . '/views/home/guide_detail.php';
}
}
?>