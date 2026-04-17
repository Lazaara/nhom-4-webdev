<?php

require_once BASE_PATH . '/src/Core/BaseModel.php';

class ProductModel extends BaseModel {

    public function getNewProducts(int $limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT p.*, 
                   c.name as category_name,
                   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'active'
            ORDER BY p.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getBestSellers(int $limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT p.*,
                   c.name as category_name,
                   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image,
                   COALESCE(SUM(oi.quantity), 0) as total_sold
            FROM products p
            JOIN categories c ON p.category_id = c.id
            LEFT JOIN order_items oi ON p.id = oi.product_id
            WHERE p.status = 'active'
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

	public function getByCategory(int $categoryId, int $limit = 12, int $offset = 0): array {
		$stmt = $this->db->prepare("
			SELECT p.*,
				   c.name as category_name,
				   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
			FROM products p
			JOIN categories c ON p.category_id = c.id
			WHERE p.category_id = ? AND p.status = 'active'
			ORDER BY p.created_at DESC
			LIMIT ? OFFSET ?
		");
		$stmt->execute([$categoryId, $limit, $offset]);
		return $stmt->fetchAll();
	}

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = ? AND p.status = 'active'
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function getImages(int $productId): array {
        $stmt = $this->db->prepare("
            SELECT url FROM product_images 
            WHERE product_id = ? 
            ORDER BY sort_order
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function search(string $keyword, int $limit = 12, int $offset = 0): array {
        $keyword = '%' . $keyword . '%';
        $stmt = $this->db->prepare("
            SELECT p.*,
                   (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
            FROM products p
            WHERE p.status = 'active' AND p.name LIKE ?
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$keyword, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM products 
            WHERE category_id = ? AND status = 'active'
        ");
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }
	
	public function getAll(int $limit = 12, int $offset = 0): array {
    $stmt = $this->db->prepare("
        SELECT p.*,
               c.name as category_name,
               (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.status = 'active'
        ORDER BY p.created_at DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$limit, $offset]);
    return $stmt->fetchAll();
	}

	public function countAll(): int {
		$stmt = $this->db->query("SELECT COUNT(*) FROM products WHERE status = 'active'");
		return (int) $stmt->fetchColumn();
	}
	
	public function create(string $name, string $sku, float $price, int $stock, int $categoryId): int {
    $stmt = $this->db->prepare("
        INSERT INTO products (name, sku, price, stock, category_id, status)
        VALUES (?, ?, ?, ?, ?, 'active')
    ");
    $stmt->execute([$name, $sku, $price, $stock, $categoryId]);
    return (int)$this->db->lastInsertId();
	}

	public function update(int $id, string $name, string $sku, float $price, int $stock, int $categoryId): void {
		$stmt = $this->db->prepare("
			UPDATE products SET name=?, sku=?, price=?, stock=?, category_id=?
			WHERE id=?
		");
		$stmt->execute([$name, $sku, $price, $stock, $categoryId, $id]);
	}

	public function delete(int $id): void {
		$stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
		$stmt->execute([$id]);
	}

	public function addImage(int $productId, string $url): void {
		$stmt = $this->db->prepare("
			INSERT INTO product_images (product_id, url, sort_order) VALUES (?, ?, 0)
		");
		$stmt->execute([$productId, $url]);
	}

	public function updateImage(int $productId, string $url): void {
		$stmt = $this->db->prepare("
			UPDATE product_images SET url=? WHERE product_id=? LIMIT 1
		");
		$stmt->execute([$url, $productId]);
		if ($this->db->query("SELECT COUNT(*) FROM product_images WHERE product_id=$productId")->fetchColumn() == 0) {
			$this->addImage($productId, $url);
		}
	}
	
	public function countSearch(string $keyword): int {
		$keyword = '%' . $keyword . '%';
		$stmt = $this->db->prepare("
			SELECT COUNT(*) FROM products 
			WHERE status = 'active' AND name LIKE ?
		");
		$stmt->execute([$keyword]);
		return (int)$stmt->fetchColumn();
	}

    public function getFiltered(int $categoryId = 0, float $minPrice = 0, float $maxPrice = 0, string $brand = '', int $limit = 12, int $offset = 0): array {
    $where = ["p.status = 'active'"];
    $params = [];

        if ($categoryId) {
            $where[] = "p.category_id = ?";
            $params[] = $categoryId;
        }
        if ($minPrice > 0) {
            $where[] = "p.price >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice > 0) {
            $where[] = "p.price <= ?";
            $params[] = $maxPrice;
        }
        if ($brand) {
            $where[] = "p.name LIKE ?";
            $params[] = '%' . $brand . '%';
        }

        $whereStr = implode(' AND ', $where);
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->db->prepare("
            SELECT p.*,
                c.name as category_name,
                (SELECT url FROM product_images WHERE product_id = p.id ORDER BY sort_order LIMIT 1) as image
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE $whereStr
            ORDER BY p.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countFiltered(int $categoryId = 0, float $minPrice = 0, float $maxPrice = 0, string $brand = ''): int {
        $where = ["p.status = 'active'"];
        $params = [];

        if ($categoryId) {
            $where[] = "p.category_id = ?";
            $params[] = $categoryId;
        }
        if ($minPrice > 0) {
            $where[] = "p.price >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice > 0) {
            $where[] = "p.price <= ?";
            $params[] = $maxPrice;
        }
        if ($brand) {
            $where[] = "p.name LIKE ?";
            $params[] = '%' . $brand . '%';
        }

        $whereStr = implode(' AND ', $where);
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM products p
            WHERE $whereStr
        ");
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

}
