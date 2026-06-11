<?php
class Destination {
    private $conn;
    private $table = 'destinations';

    public $id;
    public $name;
    public $country;
    public $description;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create() {
        $sql = "INSERT INTO {$this->table} (name, country, description, image)
                VALUES (:name, :country, :description, :image)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        return $stmt->execute();
    }
}
?>
