<?php
class HotelTransport {
    private $conn;
    private $table = 'accommodation_transport';

    public $id;
    public $booking_id;
    public $hotel_name;
    public $hotel_contact;
    public $hotel_status;
    public $transport_type;
    public $transport_contact;
    public $transport_status;
    public $coordination_notes;
    public $coordinated_by;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO {$this->table}
                (booking_id, hotel_name, hotel_contact, hotel_status,
                 transport_type, transport_contact, transport_status,
                 coordination_notes, coordinated_by, created_at)
                VALUES
                (:booking_id, :hotel_name, :hotel_contact, :hotel_status,
                 :transport_type, :transport_contact, :transport_status,
                 :coordination_notes, :coordinated_by, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id',          $this->booking_id);
        $stmt->bindParam(':hotel_name',          $this->hotel_name);
        $stmt->bindParam(':hotel_contact',       $this->hotel_contact);
        $stmt->bindParam(':hotel_status',        $this->hotel_status);
        $stmt->bindParam(':transport_type',      $this->transport_type);
        $stmt->bindParam(':transport_contact',   $this->transport_contact);
        $stmt->bindParam(':transport_status',    $this->transport_status);
        $stmt->bindParam(':coordination_notes',  $this->coordination_notes);
        $stmt->bindParam(':coordinated_by',      $this->coordinated_by);
        return $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE {$this->table}
                SET hotel_name          = :hotel_name,
                    hotel_contact       = :hotel_contact,
                    hotel_status        = :hotel_status,
                    transport_type      = :transport_type,
                    transport_contact   = :transport_contact,
                    transport_status    = :transport_status,
                    coordination_notes  = :coordination_notes,
                    updated_at          = NOW()
                WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':hotel_name',         $this->hotel_name);
        $stmt->bindParam(':hotel_contact',      $this->hotel_contact);
        $stmt->bindParam(':hotel_status',       $this->hotel_status);
        $stmt->bindParam(':transport_type',     $this->transport_type);
        $stmt->bindParam(':transport_contact',  $this->transport_contact);
        $stmt->bindParam(':transport_status',   $this->transport_status);
        $stmt->bindParam(':coordination_notes', $this->coordination_notes);
        $stmt->bindParam(':booking_id',         $this->booking_id);
        return $stmt->execute();
    }

    public function getByBookingId($booking_id) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE booking_id = :booking_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $sql = "SELECT ht.*, b.travel_date, 
                       p.title as package_title,
                       p.destination,
                       u.full_name as customer_name
                FROM {$this->table} ht
                JOIN bookings b ON ht.booking_id = b.id
                JOIN packages p ON b.package_id = p.id
                JOIN users u ON b.user_id = u.id
                ORDER BY ht.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function existsForBooking($booking_id) {
        $sql = "SELECT id FROM {$this->table} 
                WHERE booking_id = :booking_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>