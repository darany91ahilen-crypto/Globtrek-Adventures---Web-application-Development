<?php
class Query {
    private $conn;
    private $table = 'queries';

    public $id;
    public $user_id;
    public $name;
    public $email;
    public $subject;
    public $message;
    public $reply;
    public $status; // open, replied, closed

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = "INSERT INTO {$this->table}
                (user_id, name, email, subject, message, status, created_at)
                VALUES (:user_id, :name, :email, :subject, :message, 'open', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':message', $this->message);
        return $stmt->execute();
    }

    public function getAll() {
        $sql = "SELECT q.*, u.full_name 
                FROM {$this->table} q
                LEFT JOIN users u ON q.user_id = u.id
                ORDER BY q.created_at DESC";
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

    public function getByUserId($user_id) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function reply($id, $reply) {
        $sql = "UPDATE {$this->table} SET reply = :reply, status = 'replied' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':reply', $reply);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countOpen() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'open'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }
}
?>