<?php
class Package {
    private $conn;
    private $table = 'packages';

    public $id;
    public $title;
    public $destination_id;
    public $destination;
    public $description;
    public $duration_days;
    public $price;
    public $max_persons;
    public $image;
    public $includes;  
    public $itinerary;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($filters = []) {
        $sql = "SELECT p.*, d.name as destination_name 
                FROM {$this->table} p
                LEFT JOIN destinations d ON p.destination_id = d.id
                WHERE p.status = 'active'";

        if (!empty($filters['destination'])) {
            $sql .= " AND p.destination LIKE :destination";
        }
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= :min_price";
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= :max_price";
        }
        if (!empty($filters['duration'])) {
            $sql .= " AND p.duration_days = :duration";
        }
        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($filters['destination'])) {
            $dest = '%' . $filters['destination'] . '%';
            $stmt->bindParam(':destination', $dest);
        }
        if (!empty($filters['min_price'])) {
            $stmt->bindParam(':min_price', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $stmt->bindParam(':max_price', $filters['max_price']);
        }
        if (!empty($filters['duration'])) {
            $stmt->bindParam(':duration', $filters['duration']);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFeatured($limit = 6) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' AND featured = 1 
                ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function toggleFeatured($id, $featured) {
    $sql  = "UPDATE {$this->table}
             SET featured = :featured WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':featured', $featured);
    $stmt->bindParam(':id',       $id);
    return $stmt->execute();
}

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND status = 'active' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create() {
        $sql = "INSERT INTO {$this->table} 
                (title, destination_id, destination, description, duration_days, price, max_persons, image, includes, itinerary, status, featured, created_at)
                VALUES (:title, :destination_id, :destination, :description, :duration_days, :price, :max_persons, :image, :includes, :itinerary, 'active', 0, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':destination_id', $this->destination_id);
        $stmt->bindParam(':destination', $this->destination);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':duration_days', $this->duration_days);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':max_persons', $this->max_persons);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':includes', $this->includes);
        $stmt->bindParam(':itinerary', $this->itinerary);
        return $stmt->execute();
    }


public function update() {
    $sql  = "UPDATE {$this->table}
             SET title         = :title,
                 destination_id = :destination_id,
                 destination   = :destination,
                 description   = :description,
                 duration_days = :duration_days,
                 price         = :price,
                 max_persons   = :max_persons,
                 includes      = :includes,
                 itinerary     = :itinerary
             WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':title',         $this->title);
    $stmt->bindParam(':destination_id',$this->destination_id);
    $stmt->bindParam(':destination',   $this->destination);
    $stmt->bindParam(':description',   $this->description);
    $stmt->bindParam(':duration_days', $this->duration_days);
    $stmt->bindParam(':price',         $this->price);
    $stmt->bindParam(':max_persons',   $this->max_persons);
    $stmt->bindParam(':includes',      $this->includes);
    $stmt->bindParam(':itinerary',     $this->itinerary);
    $stmt->bindParam(':id',            $this->id);
    return $stmt->execute();
}

public function updateImage($id, $image) {
    $sql  = "UPDATE {$this->table} SET image = :image WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id',    $id);
    return $stmt->execute();
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

    public function count() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }
}
?>