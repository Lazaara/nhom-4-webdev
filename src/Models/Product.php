<?php

class Product
{
    private int $id;
    private string $name;
    private float $price;
    private int $stockQuantity;
    private string $description;
    private array $images;

    public function __construct(
        int $id,
        string $name,
        float $price,
        int $stockQuantity,
        string $description = '',
        array $images = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->description = $description;
        $this->images = $images;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function updateStock(int $qty): void
    {
        $newStock = $this->stockQuantity + $qty;

        if ($newStock < 0) {
            throw new Exception("Số lượng tồn kho không đủ.");
        }

        $this->stockQuantity = $newStock;
    }
}
?>