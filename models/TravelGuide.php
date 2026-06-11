<?php
class TravelGuide {
    private $conn;
    private $table = 'travel_guides';

    public $id;
    public $title;
    public $destination;
    public $content;
    public $tips;
    public $best_time;
    public $status;
    public $created_by;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllForStaff() {
    $sql  = "SELECT * FROM {$this->table}
             WHERE status = 'active'
             ORDER BY created_at DESC";
    $stmt = $this->conn->prepare($sql);
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

    public function getByDestination($destination) {
        $sql  = "SELECT * FROM {$this->table}
                 WHERE destination LIKE :destination
                 AND status = 'active'
                 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $dest = '%' . $destination . '%';
        $stmt->bindParam(':destination', $dest);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create() {
    $sql  = "INSERT INTO travel_guides
             (title, destination, content,
              tips, best_time, status,
              created_by, created_at)
             VALUES
             (:title, :destination, :content,
              :tips, :best_time, 'active',
              :created_by, NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':title',       $this->title);
    $stmt->bindParam(':destination', $this->destination);
    $stmt->bindParam(':content',     $this->content);
    $stmt->bindParam(':tips',        $this->tips);
    $stmt->bindParam(':best_time',   $this->best_time);
    $stmt->bindParam(':created_by',  $this->created_by);
    return $stmt->execute();
}

    public function update() {
        $sql  = "UPDATE {$this->table}
                 SET title       = :title,
                     destination = :destination,
                     content     = :content,
                     tips        = :tips,
                     best_time   = :best_time
                 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title',       $this->title);
        $stmt->bindParam(':destination', $this->destination);
        $stmt->bindParam(':content',     $this->content);
        $stmt->bindParam(':tips',        $this->tips);
        $stmt->bindParam(':best_time',   $this->best_time);
        $stmt->bindParam(':id',          $this->id);
        return $stmt->execute();
    }
    public function delete($id) {
    $sql  = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
}
?>