<?php
class Accommodation {
    private $conn;
    private $table = 'accommodations';

    public $id;
    public $name;
    public $location;
    public $type;
    public $description;
    public $price_per_night;
    public $max_guests;
    public $image;
    public $amenities;
    public $contact_phone;
    public $contact_email;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($filters = []) {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active'";
        if (!empty($filters['location'])) {
            $sql .= " AND location LIKE :location";
        }
        if (!empty($filters['type'])) {
            $sql .= " AND type = :type";
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND price_per_night <= :max_price";
        }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        if (!empty($filters['location'])) {
            $loc = '%' . $filters['location'] . '%';
            $stmt->bindParam(':location', $loc);
        }
        if (!empty($filters['type'])) {
            $stmt->bindParam(':type', $filters['type']);
        }
        if (!empty($filters['max_price'])) {
            $stmt->bindParam(':max_price', $filters['max_price']);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql  = "SELECT * FROM {$this->table}
                 WHERE id = :id AND status = 'active' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByPackage($package_id) {
        $sql  = "SELECT a.*, pa.nights
                 FROM {$this->table} a
                 JOIN package_accommodations pa ON a.id = pa.accommodation_id
                 WHERE pa.package_id = :package_id
                 AND a.status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':package_id', $package_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create() {
        $sql  = "INSERT INTO {$this->table}
                 (name, location, type, description, price_per_night,
                  max_guests, image, amenities, contact_phone,
                  contact_email, status, created_at)
                 VALUES
                 (:name, :location, :type, :description, :price_per_night,
                  :max_guests, :image, :amenities, :contact_phone,
                  :contact_email, 'active', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name',           $this->name);
        $stmt->bindParam(':location',       $this->location);
        $stmt->bindParam(':type',           $this->type);
        $stmt->bindParam(':description',    $this->description);
        $stmt->bindParam(':price_per_night',$this->price_per_night);
        $stmt->bindParam(':max_guests',     $this->max_guests);
        $stmt->bindParam(':image',          $this->image);
        $stmt->bindParam(':amenities',      $this->amenities);
        $stmt->bindParam(':contact_phone',  $this->contact_phone);
        $stmt->bindParam(':contact_email',  $this->contact_email);
        return $stmt->execute();
    }
    public function update() {
    $sql  = "UPDATE {$this->table}
             SET name            = :name,
                 location        = :location,
                 type            = :type,
                 description     = :description,
                 price_per_night = :price_per_night,
                 max_guests      = :max_guests,
                 amenities       = :amenities,
                 contact_phone   = :contact_phone,
                 contact_email   = :contact_email
             WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name',            $this->name);
    $stmt->bindParam(':location',        $this->location);
    $stmt->bindParam(':type',            $this->type);
    $stmt->bindParam(':description',     $this->description);
    $stmt->bindParam(':price_per_night', $this->price_per_night);
    $stmt->bindParam(':max_guests',      $this->max_guests);
    $stmt->bindParam(':amenities',       $this->amenities);
    $stmt->bindParam(':contact_phone',   $this->contact_phone);
    $stmt->bindParam(':contact_email',   $this->contact_email);
    $stmt->bindParam(':id',              $this->id);
    return $stmt->execute();
}

    public function updateImage($id, $image) {
        $sql  = "UPDATE {$this->table} SET image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id',    $id);
        return $stmt->execute();
    }

    public function count() {
        $sql  = "SELECT COUNT(*) as total FROM {$this->table}
                 WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row  = $stmt->fetch();
        return $row['total'];
    }

public function delete($id) {
    try {
        // First delete from package_accommodations
        $sql  = "DELETE FROM package_accommodations
                 WHERE accommodation_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Then delete the accommodation
        $sql  = "DELETE FROM accommodations WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();

    } catch (Exception $e) {
        return false;
    }
}
}
?>