<?php

require_once BASE_PATH . '/src/Core/BaseModel.php';

class OrderModel extends BaseModel {

    public function createAddress(int $userId, string $name, string $phone, string $address): int {
        $stmt = $this->db->prepare("
            INSERT INTO addresses (user_id, recipient_name, phone, line1, city)
            VALUES (?, ?, ?, ?, 'Việt Nam')
        ");
        $stmt->execute([$userId, $name, $phone, $address]);
        return (int)$this->db->lastInsertId();
    }

    public function createOrder(int $userId, int $addressId, float $total): int {
        $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, address_id, subtotal, shipping_fee, total, status)
            VALUES (?, ?, ?, 0, ?, 'pending')
        ");
        $stmt->execute([$userId, $addressId, $total, $total]);
        return (int)$this->db->lastInsertId();
    }

    public function createOrderItem(int $orderId, int $productId, int $qty, float $price): void {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, unit_price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$orderId, $productId, $qty, $price]);
    }

    public function createPayment(int $orderId, float $amount): void {
        $stmt = $this->db->prepare("
            INSERT INTO payments (order_id, method, provider_txn_id, status, amount, paid_at)
            VALUES (?, 'COD', ?, 'pending', ?, NULL)
        ");
        $txnId = 'COD-' . $orderId . '-' . time();
        $stmt->execute([$orderId, $txnId, $amount]);
    }

    public function getOrdersByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT o.*, a.recipient_name, a.phone, a.line1
            FROM orders o
            JOIN addresses a ON o.address_id = a.id
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getOrderById(int $orderId, int $userId): ?array {
        $stmt = $this->db->prepare("
            SELECT o.*, a.recipient_name, a.phone, a.line1
            FROM orders o
            JOIN addresses a ON o.address_id = a.id
            WHERE o.id = ? AND o.user_id = ?
            LIMIT 1
        ");
        $stmt->execute([$orderId, $userId]);
        $order = $stmt->fetch();
        return $order ?: null;
    }

    public function getOrderItems(int $orderId): array {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name,
                   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $orderId, string $status): void {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    public function getAllOrders(): array {
        $stmt = $this->db->query("
            SELECT o.*, u.full_name, u.email, a.recipient_name, a.line1
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN addresses a ON o.address_id = a.id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }
}