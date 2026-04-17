<?php

require_once BASE_PATH . '/src/Core/BaseModel.php';

class UserModel extends BaseModel {

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function getRoleByUserId(int $userId): string {
        $stmt = $this->db->prepare("
            SELECT r.name FROM roles r
            JOIN user_roles ur ON r.id = ur.role_id
            WHERE ur.user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        $role = $stmt->fetchColumn();
        return $role ?: 'customer';
    }

    public function create(string $fullName, string $email, string $passwordHash): int {
        $stmt = $this->db->prepare("
            INSERT INTO users (full_name, email, password_hash) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$fullName, $email, $passwordHash]);
        return (int) $this->db->lastInsertId();
    }

    public function assignRole(int $userId, int $roleId): void {
        $stmt = $this->db->prepare("
            INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)
        ");
        $stmt->execute([$userId, $roleId]);
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}