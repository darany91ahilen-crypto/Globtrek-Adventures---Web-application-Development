<?php
class Report {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSalesByMonth() {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
                       COUNT(*) as total_bookings,
                       SUM(total_price) as total_revenue
                FROM bookings
                WHERE payment_status = 'paid'
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month DESC LIMIT 12";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

   public function getCustomerReport() {
        $sql = "SELECT u.full_name, u.email, COUNT(b.id) as total_bookings,
                       SUM(b.total_price) as total_spent
                FROM users u
                LEFT JOIN bookings b ON u.id = b.user_id
                WHERE u.role = 'customer'
                GROUP BY u.id
                ORDER BY total_bookings DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>