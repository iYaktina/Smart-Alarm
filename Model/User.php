<?php
require_once __DIR__ . '/../Include/db.inc.php';

class User {
    private mysqli $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register(string $name, string $email, string $password): bool {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed);
        return $stmt->execute();
    }

    public function login(string $email, string $password): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

       public function getAll(): array {
        $result = $this->conn->query("SELECT id, name, email, is_admin FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update(int $id, string $name, string $email, bool $isAdmin): bool {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $email, $isAdmin, $id);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function create(string $name, string $email, string $password, bool $isAdmin = false): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $hash, $isAdmin);
        return $stmt->execute();
    }

}
