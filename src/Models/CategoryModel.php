<?php

require_once BASE_PATH . '/src/Core/BaseModel.php';

class CategoryModel extends BaseModel {

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getBySlug(string $slug): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $cat = $stmt->fetch();
        return $cat ?: null;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $cat = $stmt->fetch();
        return $cat ?: null;
    }
	
	public function create(string $name, string $slug): int {
		$stmt = $this->db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
		$stmt->execute([$name, $slug]);
		return (int)$this->db->lastInsertId();
	}

	public function delete(int $id): void {
		$stmt = $this->db->prepare("DELETE FROM categories WHERE id=?");
		$stmt->execute([$id]);
	}
}