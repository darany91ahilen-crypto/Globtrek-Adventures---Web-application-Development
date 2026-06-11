<?php
class AdminController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requireAdmin();
    }

    private function requireAdmin() {
        if (!isset($_SESSION['user_id']) ||
            $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    public function dashboard() {
        $userModel    = new User($this->db);
        $bookingModel = new Booking($this->db);
        $packageModel = new Package($this->db);
        $queryModel   = new Query($this->db);
        $accModel     = new Accommodation($this->db);

        $data = [
            'total_customers'  => $userModel->countByRole('customer'),
            'total_staff'      => $userModel->countByRole('staff'),
            'total_bookings'   => $bookingModel->countByStatus('confirmed') +
                                  $bookingModel->countByStatus('pending'),
            'pending'          => $bookingModel->countByStatus('pending'),
            'revenue'          => $bookingModel->totalRevenue(),
            'packages'         => $packageModel->count(),
            'open_queries'     => $queryModel->countOpen(),
            'accommodations'   => $accModel->count(),
        ];

        // Get recent bookings for dashboard
        $recentBookings = $bookingModel->getAll();
        $recentBookings = array_slice($recentBookings, 0, 5);

        require_once BASE_PATH . '/views/admin/dashboard.php';
    }
    

public function packages() {
    $packageModel = new Package($this->db);
    $error        = '';
    $success      = '';
    $editPackage  = null;

    $sql  = "SELECT * FROM destinations ORDER BY name ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $destinations = $stmt->fetchAll();

    // HANDLE EDIT MODE
    if (isset($_GET['edit'])) {
        $editPackage = $packageModel->getById((int)$_GET['edit']);
        if (!$editPackage) {
            header('Location: ' . BASE_URL . '/index.php?url=admin/packages');
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // =====================
        // CREATE NEW PACKAGE
        // =====================
        if ($_POST['action'] === 'create') {

            $image_name = 'default.jpg';
            if (isset($_FILES['package_image']) &&
                $_FILES['package_image']['error'] === 0) {
                $result = $this->handleImageUpload($_FILES['package_image']);
                if ($result['success']) {
                    $image_name = $result['path'];
                } else {
                    $error = $result['error'];
                }
            }

            if (empty($error)) {
                $destination = $this->getSelectedDestination($destinations);
                if (!$destination) {
                    $error = 'Please select a valid destination.';
                }
            }

            if (empty($error)) {
                $packageModel->title         = htmlspecialchars($_POST['title']);
                $packageModel->destination_id = (int)$destination['id'];
                $packageModel->destination   = htmlspecialchars($destination['name']);
                $packageModel->description   = htmlspecialchars($_POST['description']);
                $packageModel->duration_days = (int)$_POST['duration_days'];
                $packageModel->price         = (float)$_POST['price'];
                $packageModel->max_persons   = (int)$_POST['max_persons'];
                $packageModel->includes      = htmlspecialchars($_POST['includes']);
                $packageModel->itinerary     = htmlspecialchars($_POST['itinerary']);
                $packageModel->image         = $image_name;

                $packageModel->create()
                    ? $success = 'Package created successfully!'
                    : $error   = 'Failed to create package.';
            }

        // =====================
        // UPDATE EXISTING PACKAGE
        // =====================
        } elseif ($_POST['action'] === 'update') {

            $pkg_id = (int)$_POST['package_id'];
            $destination = $this->getSelectedDestination($destinations);
            if (!$destination) {
                $error = 'Please select a valid destination.';
            }

            // Handle new image upload if provided
            if (empty($error) && isset($_FILES['package_image']) &&
                $_FILES['package_image']['error'] === 0) {
                $result = $this->handleImageUpload($_FILES['package_image']);
                if ($result['success']) {
                    $packageModel->updateImage($pkg_id, $result['path']);
                } else {
                    $error = $result['error'];
                }
            }

            if (empty($error)) {
                $packageModel->id             = $pkg_id;
                $packageModel->title          = htmlspecialchars($_POST['title']);
                $packageModel->destination_id = (int)$destination['id'];
                $packageModel->destination    = htmlspecialchars($destination['name']);
                $packageModel->description    = htmlspecialchars($_POST['description']);
                $packageModel->duration_days  = (int)$_POST['duration_days'];
                $packageModel->price          = (float)$_POST['price'];
                $packageModel->max_persons    = (int)$_POST['max_persons'];
                $packageModel->includes       = htmlspecialchars($_POST['includes']);
                $packageModel->itinerary      = htmlspecialchars($_POST['itinerary']);

                $packageModel->update()
                    ? $success = 'Package updated successfully!'
                    : $error   = 'Failed to update package.';
            }

        // =====================
        // DELETE PACKAGE
}  elseif ($_POST['action'] === 'delete') {
    $id = (int)$_POST['package_id'];
    try {
        // Step 1 - Delete accommodation_transport
        $sql  = "DELETE FROM accommodation_transport
                 WHERE booking_id IN
                 (SELECT id FROM bookings
                  WHERE package_id = :id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Step 2 - Delete payments
        $sql  = "DELETE FROM payments
                 WHERE booking_id IN
                 (SELECT id FROM bookings
                  WHERE package_id = :id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Step 3 - Delete bookings
        $sql  = "DELETE FROM bookings
                 WHERE package_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Step 4 - Delete package_accommodations
        $sql  = "DELETE FROM package_accommodations
                 WHERE package_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Step 5 - Delete package
        $sql  = "DELETE FROM packages WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute()
            ? $success = 'Package removed!'
            : $error   = 'Failed to remove package.';

    } catch (Exception $e) {
        $error = 'Cannot delete: ' . $e->getMessage();
    }




  

        // =====================
        // TOGGLE FEATURED
        // =====================
        } elseif ($_POST['action'] === 'toggle_featured') {
            $packageModel->toggleFeatured(
                $_POST['package_id'],
                $_POST['featured']
            );
            $success = 'Package updated successfully.';
        }
    }

    $packages = $packageModel->getAll();
    require_once BASE_PATH . '/views/admin/packages.php';
}

private function getSelectedDestination($destinations) {
    $destinationName = trim($_POST['destination'] ?? '');
    foreach ($destinations as $destination) {
        if (strcasecmp($destination['name'], $destinationName) === 0) {
            return $destination;
        }
    }
    return null;
}

// Image upload helper
private function handleImageUpload($file) {
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed  = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($file_ext, $allowed)) {
        return ['success' => false,
                'error'   => 'Only JPG, JPEG, PNG and WEBP allowed.'];
    }
    if ($file['size'] > 2097152) {
        return ['success' => false,
                'error'   => 'File size must be less than 2MB.'];
    }

    $upload_dir = BASE_PATH . '/assets/images/packages/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $new_name = 'pkg_' . time() . '_' . uniqid() . '.' . $file_ext;
    if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
        return ['success' => true, 'path' => 'packages/' . $new_name];
    }
    return ['success' => false, 'error' => 'Failed to upload image.'];
}
    
      

    public function staff() {
        $userModel = new User($this->db);
        $error     = '';
        $success   = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] === 'create') {
                $userModel->full_name = htmlspecialchars($_POST['full_name']);
                $userModel->email     = filter_input(INPUT_POST, 'email',
                                        FILTER_SANITIZE_EMAIL);
                $userModel->phone     = htmlspecialchars($_POST['phone']);
                $userModel->password  = password_hash($_POST['password'],
                                        PASSWORD_DEFAULT);
                $userModel->role      = 'staff';
                if (!$userModel->emailExists($userModel->email)) {
                    $userModel->register()
                        ? $success = 'Staff account created successfully.'
                        : $error   = 'Failed to create account.';
                } else {
                    $error = 'Email already exists.';
                }
            } elseif ($_POST['action'] === 'toggle') {
                $userModel->updateStatus($_POST['user_id'], $_POST['status']);
                $success = 'Staff status updated successfully.';
            }
        }

        $staffList = $userModel->getAllStaff();
        require_once BASE_PATH . '/views/admin/staff.php';
    }

    public function users() {
        $userModel = new User($this->db);
        $customers = $userModel->getAllCustomers();
        require_once BASE_PATH . '/views/admin/users.php';
    }

    public function reports() {
        $reportModel    = new Report($this->db);
        $salesByMonth   = $reportModel->getSalesByMonth();
        $customerReport = $reportModel->getCustomerReport();
        require_once BASE_PATH . '/views/admin/reports.php';
    }

    public function bookings() {
        $bookingModel = new Booking($this->db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
            $bookingId = (int)$_POST['booking_id'];

            if (isset($_POST['status'])) {
                $allowedStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                if (in_array($_POST['status'], $allowedStatuses, true)) {
                    $bookingModel->updateStatus($bookingId, $_POST['status']);
                }
            }

            if (isset($_POST['payment_status'])) {
                $allowedPaymentStatuses = ['unpaid', 'paid', 'refunded'];
                if (in_array($_POST['payment_status'], $allowedPaymentStatuses, true)) {
                    $bookingModel->updatePaymentStatus($bookingId, $_POST['payment_status']);
                }
            }

            header('Location: ' . BASE_URL . '/index.php?url=admin/bookings');
            exit;
        }

        $bookings     = $bookingModel->getAll();
        require_once BASE_PATH . '/views/admin/bookings.php';
    }
}
?>