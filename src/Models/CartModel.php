<?php

require_once BASE_PATH . '/src/Core/BaseModel.php';

class CartModel extends BaseModel {

    public function getOrCreateCart(int $userId): int {
        $stmt = $this->db->prepare("
            SELECT id FROM carts 
            WHERE user_id = ? AND status = 'active' 
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        $cart = $stmt->fetchColumn();

        if ($cart) return (int)$cart;

        $stmt = $this->db->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->execute([$userId]);
        return (int)$this->db->lastInsertId();
    }

    public function getItems(int $cartId): array {
        $stmt = $this->db->prepare("
            SELECT ci.*, p.name, p.stock, p.sku,
                   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?
        ");
        $stmt->execute([$cartId]);
        return $stmt->fetchAll();
    }

    public function addItem(int $cartId, int $productId, int $qty, float $price): void {
        // Nếu đã có thì tăng số lượng
        $stmt = $this->db->prepare("
            SELECT quantity FROM cart_items 
            WHERE cart_id = ? AND product_id = ?
        ");
        $stmt->execute([$cartId, $productId]);
        $existing = $stmt->fetchColumn();

        if ($existing !== false) {
            $stmt = $this->db->prepare("
                UPDATE cart_items SET quantity = quantity + ?
                WHERE cart_id = ? AND product_id = ?
            ");
            $stmt->execute([$qty, $cartId, $productId]);
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO cart_items (cart_id, product_id, quantity, unit_price)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$cartId, $productId, $qty, $price]);
        }
    }

    public function updateItem(int $cartId, int $productId, int $qty): void {
        $stmt = $this->db->prepare("
            UPDATE cart_items SET quantity = ?
            WHERE cart_id = ? AND product_id = ?
        ");
        $stmt->execute([$qty, $cartId, $productId]);
    }

    public function removeItem(int $cartId, int $productId): void {
        $stmt = $this->db->prepare("
            DELETE FROM cart_items 
            WHERE cart_id = ? AND product_id = ?
        ");
        $stmt->execute([$cartId, $productId]);
    }

    public function clearCart(int $cartId): void {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cartId]);
    }

    public function countItems(int $userId): int {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(ci.quantity), 0)
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            WHERE c.user_id = ? AND c.status = 'active'
        ");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}