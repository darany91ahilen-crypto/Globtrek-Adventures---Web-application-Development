<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $full_name;
    public $email;
    public $phone;
    public $password;
    public $role; // customer, staff, admin
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $sql = "INSERT INTO {$this->table} 
                (full_name, email, phone, password, role, status, created_at)
                VALUES (:full_name, :email, :phone, :password, :role, 'active', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':role', $this->role);
        return $stmt->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND status = 'active' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function emailExists($email) {
        $sql = "SELECT id FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getAllCustomers() {
        $sql = "SELECT id, full_name, email, phone, created_at, status 
                FROM {$this->table} WHERE role = 'customer' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllStaff() {
        $sql = "SELECT id, full_name, email, phone, created_at, status 
                FROM {$this->table} WHERE role = 'staff' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
public function saveResetToken($id, $token, $expires) {
    $sql  = "UPDATE {$this->table}
             SET reset_token = :token,
                 reset_expires = :expires
             WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':token',   $token);
    $stmt->bindParam(':expires', $expires);
    $stmt->bindParam(':id',      $id);
    return $stmt->execute();
}

public function findByResetToken($token) {
    $sql  = "SELECT * FROM {$this->table}
             WHERE reset_token = :token
             AND reset_expires > NOW()
             LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    return $stmt->fetch();
}

public function clearResetToken($id) {
    $sql  = "UPDATE {$this->table}
             SET reset_token = NULL,
                 reset_expires = NULL
             WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

    public function updateProfile() {
        $sql = "UPDATE {$this->table} 
                SET full_name = :full_name, phone = :phone 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function updatePassword($id, $hashed_password) {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countByRole($role) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }
}
?>