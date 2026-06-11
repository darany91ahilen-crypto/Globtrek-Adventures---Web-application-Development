<?php
class StaffController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requireStaff();
    }

    private function requireStaff() {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['staff','admin'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    public function dashboard() {
        $bookingModel    = new Booking($this->db);
        $queryModel      = new Query($this->db);
        $packageModel    = new Package($this->db);
        $total_bookings  = $bookingModel->countByStatus('confirmed') + $bookingModel->countByStatus('pending');
        $pending_bookings = $bookingModel->countByStatus('pending');
        $open_queries    = $queryModel->countOpen();
        $total_packages  = $packageModel->count();
        require_once BASE_PATH . '/views/staff/dashboard.php';
    }

    public function bookings() {
        $bookingModel = new Booking($this->db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
            $bookingModel->updateStatus($_POST['booking_id'], $_POST['status']);
            header('Location: ' . BASE_URL . '/index.php?url=staff/bookings');
            exit;
        }
        $bookings = $bookingModel->getAll();
        require_once BASE_PATH . '/views/staff/bookings.php';
    }

    public function packages() {
    $packageModel = new Package($this->db);
    $error        = '';
    $success      = '';
    $editPackage  = null;

    // GET DESTINATIONS FOR DROPDOWN
    $sql  = "SELECT * FROM destinations ORDER BY name ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $destinations = $stmt->fetchAll();

    if (isset($_GET['edit'])) {
        $editPackage = $packageModel->getById((int)$_GET['edit']);
        if (!$editPackage) {
            header('Location: ' . BASE_URL .
                   '/index.php?url=staff/packages');
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_POST['action'] === 'create') {

            $image_name = 'default.jpg';
            if (isset($_FILES['package_image']) &&
                $_FILES['package_image']['error'] === 0) {
                $file     = $_FILES['package_image'];
                $file_ext = strtolower(pathinfo($file['name'],
                            PATHINFO_EXTENSION));
                $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($file_ext, $allowed)) {
                    $error = 'Only JPG, PNG and WEBP allowed.';
                } elseif ($file['size'] > 2097152) {
                    $error = 'File must be less than 2MB.';
                } else {
                    $upload_dir = BASE_PATH . '/assets/images/packages/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $new_name = 'pkg_' . time() . '_' .
                                uniqid() . '.' . $file_ext;
                    if (move_uploaded_file($file['tmp_name'],
                        $upload_dir . $new_name)) {
                        $image_name = 'packages/' . $new_name;
                    } else {
                        $error = 'Failed to upload image.';
                    }
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

        } elseif ($_POST['action'] === 'update') {

            $pkg_id = (int)$_POST['package_id'];
            $destination = $this->getSelectedDestination($destinations);
            if (!$destination) {
                $error = 'Please select a valid destination.';
            }

            if (empty($error) && isset($_FILES['package_image']) &&
                $_FILES['package_image']['error'] === 0) {
                $file     = $_FILES['package_image'];
                $file_ext = strtolower(pathinfo($file['name'],
                            PATHINFO_EXTENSION));
                $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($file_ext, $allowed) &&
                    $file['size'] <= 2097152) {
                    $upload_dir = BASE_PATH . '/assets/images/packages/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $new_name = 'pkg_' . time() . '_' .
                                uniqid() . '.' . $file_ext;
                    if (move_uploaded_file($file['tmp_name'],
                        $upload_dir . $new_name)) {
                        $packageModel->updateImage($pkg_id,
                            'packages/' . $new_name);
                    } else {
                        $error = 'Failed to upload image.';
                    }
                } else {
                    $error = 'Only JPG, PNG and WEBP files under 2MB are allowed.';
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

        } elseif ($_POST['action'] === 'delete') {

            $id = (int)$_POST['package_id'];
            try {
                $sql  = "DELETE FROM accommodation_transport
                         WHERE booking_id IN
                         (SELECT id FROM bookings
                          WHERE package_id = :id)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $sql  = "DELETE FROM payments
                         WHERE booking_id IN
                         (SELECT id FROM bookings
                          WHERE package_id = :id)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $sql  = "DELETE FROM bookings
                         WHERE package_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $sql  = "DELETE FROM package_accommodations
                         WHERE package_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $sql  = "DELETE FROM packages WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute()
                    ? $success = 'Package removed!'
                    : $error   = 'Failed to remove.';

            } catch (Exception $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        }
    }

    $packages = $packageModel->getAll();
    require_once BASE_PATH . '/views/staff/packages.php';
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

   public function accommodations() {
    $accModel          = new Accommodation($this->db);
    $error             = '';
    $success           = '';
    $editAccommodation = null;

    if (isset($_GET['edit'])) {
        $editAccommodation = $accModel->getById((int)$_GET['edit']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_POST['action'] === 'create') {
            $image_name = 'default.jpg';
            if (isset($_FILES['accommodation_image']) &&
                $_FILES['accommodation_image']['error'] === 0) {
                $file     = $_FILES['accommodation_image'];
                $file_ext = strtolower(pathinfo($file['name'],
                            PATHINFO_EXTENSION));
                $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($file_ext, $allowed)) {
                    $error = 'Only JPG, PNG and WEBP allowed.';
                } elseif ($file['size'] > 2097152) {
                    $error = 'File must be less than 2MB.';
                } else {
                    $upload_dir = BASE_PATH . '/assets/images/accommodations/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $new_name = 'acc_' . time() . '_' .
                                uniqid() . '.' . $file_ext;
                    if (move_uploaded_file($file['tmp_name'],
                        $upload_dir . $new_name)) {
                        $image_name = 'accommodations/' . $new_name;
                    } else {
                        $error = 'Failed to upload image.';
                    }
                }
            }

            if (empty($error)) {
            $accModel->name            = htmlspecialchars($_POST['name']);
            $accModel->location        = htmlspecialchars($_POST['location']);
            $accModel->type            = $_POST['type'];
            $accModel->description     = htmlspecialchars($_POST['description']);
            $accModel->price_per_night = (float)$_POST['price_per_night'];
            $accModel->max_guests      = (int)$_POST['max_guests'];
            $accModel->amenities       = htmlspecialchars($_POST['amenities']);
            $accModel->contact_phone   = htmlspecialchars($_POST['contact_phone']);
            $accModel->contact_email   = htmlspecialchars($_POST['contact_email']);
            $accModel->image           = $image_name;
            $accModel->create()
                ? $success = 'Accommodation added successfully!'
                : $error   = 'Failed to add accommodation.';
            }

        } elseif ($_POST['action'] === 'update') {
            $acc_id = (int)$_POST['acc_id'];
            if (isset($_FILES['accommodation_image']) &&
                $_FILES['accommodation_image']['error'] === 0) {
                $file     = $_FILES['accommodation_image'];
                $file_ext = strtolower(pathinfo($file['name'],
                            PATHINFO_EXTENSION));
                $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($file_ext, $allowed)) {
                    $error = 'Only JPG, PNG and WEBP allowed.';
                } elseif ($file['size'] > 2097152) {
                    $error = 'File must be less than 2MB.';
                } else {
                    $upload_dir = BASE_PATH . '/assets/images/accommodations/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $new_name = 'acc_' . time() . '_' .
                                uniqid() . '.' . $file_ext;
                    if (move_uploaded_file($file['tmp_name'],
                        $upload_dir . $new_name)) {
                        $accModel->updateImage($acc_id,
                            'accommodations/' . $new_name);
                    } else {
                        $error = 'Failed to upload image.';
                    }
                }
            }

            if (empty($error)) {
            $accModel->id              = $acc_id;
            $accModel->name            = htmlspecialchars($_POST['name']);
            $accModel->location        = htmlspecialchars($_POST['location']);
            $accModel->type            = $_POST['type'];
            $accModel->description     = htmlspecialchars($_POST['description']);
            $accModel->price_per_night = (float)$_POST['price_per_night'];
            $accModel->max_guests      = (int)$_POST['max_guests'];
            $accModel->amenities       = htmlspecialchars($_POST['amenities']);
            $accModel->contact_phone   = htmlspecialchars($_POST['contact_phone']);
            $accModel->contact_email   = htmlspecialchars($_POST['contact_email']);
            $accModel->update()
                ? $success = 'Accommodation updated successfully!'
                : $error   = 'Failed to update accommodation.';
            }

        } elseif ($_POST['action'] === 'delete') {
            $accModel->delete($_POST['acc_id']);
            $success = 'Accommodation removed.';
        }
    }

    $accommodations = $accModel->getAll();
    require_once BASE_PATH . '/views/staff/accommodations.php';
}

    public function queries() {
        $queryModel = new Query($this->db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query_id'])) {
            $queryModel->reply($_POST['query_id'], htmlspecialchars($_POST['reply']));
            header('Location: ' . BASE_URL . '/index.php?url=staff/queries');
            exit;
        }
        $queries = $queryModel->getAll();
        require_once BASE_PATH . '/views/staff/queries.php';
    }

    public function guides() {
    $guideModel  = new TravelGuide($this->db);
    $error       = '';
    $success     = '';
    $editGuide   = null;

    if (isset($_GET['edit'])) {
        $editGuide = $guideModel->getById((int)$_GET['edit']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_POST['action'] === 'create') {
            $guideModel->title       = htmlspecialchars($_POST['title']);
            $guideModel->destination = htmlspecialchars($_POST['destination']);
            $guideModel->content     = htmlspecialchars($_POST['content']);
            $guideModel->tips        = htmlspecialchars($_POST['tips']);
            $guideModel->best_time   = htmlspecialchars($_POST['best_time']);
            $guideModel->created_by  = $_SESSION['user_id'];
            $guideModel->create()
                ? $success = 'Travel guide added!'
                : $error   = 'Failed to add guide.';

        } elseif ($_POST['action'] === 'update') {
            $guideModel->id          = (int)$_POST['guide_id'];
            $guideModel->title       = htmlspecialchars($_POST['title']);
            $guideModel->destination = htmlspecialchars($_POST['destination']);
            $guideModel->content     = htmlspecialchars($_POST['content']);
            $guideModel->tips        = htmlspecialchars($_POST['tips']);
            $guideModel->best_time   = htmlspecialchars($_POST['best_time']);
            $guideModel->update()
                ? $success = 'Travel guide updated!'
                : $error   = 'Failed to update guide.';

        } elseif ($_POST['action'] === 'delete') {
            $guideModel->delete($_POST['guide_id']);
            $success = 'Guide removed.';
        }
    }

    $guides = $guideModel->getAllForStaff();
    require_once BASE_PATH . '/views/staff/guides.php';
}
public function coordination() {
    $error   = '';
    $success = '';

    // Get database connection
    $db = $this->db;

    // HANDLE FORM SUBMISSION
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'create') {

            $sql  = "INSERT INTO accommodation_transport
                     (booking_id, hotel_name, hotel_contact,
                      hotel_status, transport_type,
                      transport_contact, transport_status,
                      coordinated_by, created_at)
                     VALUES
                     (:booking_id, :hotel_name, :hotel_contact,
                      :hotel_status, :transport_type,
                      :transport_contact, :transport_status,
                      :coordinated_by, NOW())";
            $stmt = $db->prepare($sql);
          $booking_id        = (int)$_POST['booking_id'];
            $hotel_name        = htmlspecialchars($_POST['hotel_name']);
            $hotel_contact     = htmlspecialchars($_POST['hotel_contact']);
            $hotel_status      = $_POST['hotel_status'];
            $transport_type    = htmlspecialchars($_POST['transport_type']);
            $transport_contact = htmlspecialchars($_POST['transport_contact']);
            $transport_status  = $_POST['transport_status'];
            $coordinated_by    = $_SESSION['user_id'];

            $stmt->bindParam(':booking_id',        $booking_id);
            $stmt->bindParam(':hotel_name',        $hotel_name);
            $stmt->bindParam(':hotel_contact',     $hotel_contact);
            $stmt->bindParam(':hotel_status',      $hotel_status);
            $stmt->bindParam(':transport_type',    $transport_type);
            $stmt->bindParam(':transport_contact', $transport_contact);
            $stmt->bindParam(':transport_status',  $transport_status);
            $stmt->bindParam(':coordinated_by',    $coordinated_by);

            $stmt->execute()
                ? $success = 'Coordination details saved successfully!'
                : $error   = 'Failed to save details.';

        } elseif ($_POST['action'] === 'delete') {
            $sql  = "DELETE FROM accommodation_transport
                     WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_POST['coord_id']);
            $stmt->execute();
            $success = 'Record removed.';
        }
    }

    // GET ALL CONFIRMED BOOKINGS FOR DROPDOWN
    $sql      = "SELECT b.id, b.travel_date,
                        p.title as package_title,
                        u.full_name
                 FROM bookings b
                 JOIN packages p ON b.package_id = p.id
                 JOIN users u ON b.user_id = u.id
                 WHERE b.status IN ('pending','confirmed')
                 ORDER BY b.travel_date ASC";
    $stmt     = $db->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll();

    // GET ALL COORDINATION RECORDS
    $sql      = "SELECT at.*, b.travel_date,
                        p.title as package_title,
                        u.full_name as customer_name
                 FROM accommodation_transport at
                 JOIN bookings b ON at.booking_id = b.id
                 JOIN packages p ON b.package_id = p.id
                 JOIN users u ON b.user_id = u.id
                 ORDER BY at.created_at DESC";
    $stmt     = $db->prepare($sql);
    $stmt->execute();
    $coordinations = $stmt->fetchAll();

    require_once BASE_PATH . '/views/staff/coordination.php';
}
}
?>