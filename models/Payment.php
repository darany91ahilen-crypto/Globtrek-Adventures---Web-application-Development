<?php
class Payment {
    private $conn;
    private $table = 'payments';

    public $id;
    public $booking_id;
    public $user_id;
    public $amount;
    public $payment_method;
    public $transaction_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
    $sql  = "INSERT INTO payments
             (booking_id, user_id, amount,
              payment_method, transaction_id,
              status, created_at)
             VALUES
             (:booking_id, :user_id, :amount,
              :payment_method, :transaction_id,
              :status, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':booking_id',     $this->booking_id);
    $stmt->bindParam(':user_id',        $this->user_id);
    $stmt->bindParam(':amount',         $this->amount);
    $stmt->bindParam(':payment_method', $this->payment_method);
    $stmt->bindParam(':transaction_id', $this->transaction_id);
    $stmt->bindParam(':status',         $this->status);
    return $stmt->execute();
}

    public function getByBookingId($booking_id) {
        $sql = "SELECT * FROM {$this->table} WHERE booking_id = :booking_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $sql = "SELECT pay.*, b.travel_date, u.full_name, p.title as package_title
                FROM {$this->table} pay
                JOIN bookings b ON pay.booking_id = b.id
                JOIN users u ON pay.user_id = u.id
                JOIN packages p ON b.package_id = p.id
                ORDER BY pay.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>