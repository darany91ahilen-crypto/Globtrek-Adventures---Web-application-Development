<?php
class Booking {
    private $conn;
    private $table = 'bookings';

    public $id;
    public $user_id;
    public $package_id;
    public $travel_date;
    public $num_persons;
    public $total_price;
    public $special_requests;
    public $status; // pending, confirmed, cancelled, completed
    public $payment_status; // unpaid, paid, refunded

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO {$this->table}
                (user_id, package_id, travel_date, num_persons, total_price, special_requests, status, payment_status, created_at)
                VALUES (:user_id, :package_id, :travel_date, :num_persons, :total_price, :special_requests, 'pending', 'unpaid', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':package_id', $this->package_id);
        $stmt->bindParam(':travel_date', $this->travel_date);
        $stmt->bindParam(':num_persons', $this->num_persons);
        $stmt->bindParam(':total_price', $this->total_price);
        $stmt->bindParam(':special_requests', $this->special_requests);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    public function getByUserId($user_id) {
    $sql  = "SELECT b.*,
                    p.title as package_title,
                    p.image,
                    p.destination,
                    p.duration_days,
                    at.hotel_name,
                    at.hotel_contact,
                    at.hotel_status,
                    at.transport_type,
                    at.transport_contact,
                    at.transport_status
             FROM {$this->table} b
             JOIN packages p ON b.package_id = p.id
             LEFT JOIN accommodation_transport at
                    ON b.id = at.booking_id
             WHERE b.user_id = :user_id
             ORDER BY b.created_at DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll();
}
               

    public function getById($id) {
        $sql = "SELECT b.*, p.title as package_title, p.image, p.destination, p.duration_days,
                       u.full_name, u.email, u.phone
                FROM {$this->table} b
                JOIN packages p ON b.package_id = p.id
                JOIN users u ON b.user_id = u.id
                WHERE b.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $sql = "SELECT b.*, p.title as package_title, u.full_name, u.email
                FROM {$this->table} b
                JOIN packages p ON b.package_id = p.id
                JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updatePaymentStatus($id, $payment_status) {
        $sql = "UPDATE {$this->table} SET payment_status = :payment_status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function cancel($id, $user_id) {
        $sql = "UPDATE {$this->table} SET status = 'cancelled' 
                WHERE id = :id AND user_id = :user_id AND status = 'pending'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function countByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    public function totalRevenue() {
        $sql = "SELECT SUM(total_price) as revenue FROM {$this->table} 
                WHERE payment_status = 'paid'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['revenue'] ?? 0;
    }

    public function getMonthlySales() {
        $sql = "SELECT MONTH(created_at) as month, SUM(total_price) as revenue, COUNT(*) as bookings
                FROM {$this->table}
                WHERE payment_status = 'paid' AND YEAR(created_at) = YEAR(NOW())
                GROUP BY MONTH(created_at)
                ORDER BY month";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>