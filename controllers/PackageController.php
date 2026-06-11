<?php
class PackageController {
    private $db;
    private $packageModel;

    public function __construct() {
        $database           = new Database();
        $this->db           = $database->getConnection();
        $this->packageModel = new Package($this->db);
    }

    public function index() {
        $page_title='Tour Packages';
        $filters = [];
        if (!empty($_GET['destination'])) $filters['destination'] = $_GET['destination'];
        if (!empty($_GET['min_price']))   $filters['min_price']   = (float)$_GET['min_price'];
        if (!empty($_GET['max_price']))   $filters['max_price']   = (float)$_GET['max_price'];
        if (!empty($_GET['duration']))    $filters['duration']    = (int)$_GET['duration'];

        $packages     = $this->packageModel->getAll($filters);
        $destinations = (new Destination($this->db))->getAll();
        require_once BASE_PATH . '/views/packages/index.php';
    }
    public function detail($id) {
    if (!$id) {
        header('Location: ' . BASE_URL . '/index.php?url=package/index');
        exit;
    }

    $package = $this->packageModel->getById($id);
    if (!$package) {
        http_response_code(404);
        require_once BASE_PATH . '/views/errors/404.php';
        return;
    }

    // GET LINKED ACCOMMODATIONS
    $accModel      = new Accommodation($this->db);
    $accommodations = $accModel->getByPackage($id);

    require_once BASE_PATH . '/views/packages/detail.php';
}
}
?>