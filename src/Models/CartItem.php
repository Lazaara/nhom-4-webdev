<?php

require_once 'Product.php';

class CartItem
{
    private Product $product;
    private int $quantity;
    private float $priceAtTime;

    public function __construct(Product $product, int $quantity)
    {
        if ($quantity <= 0) {
            throw new Exception("Số lượng phải lớn hơn 0.");
        }

        $this->product = $product;
        $this->quantity = $quantity;
        $this->priceAtTime = $product->getPrice();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPriceAtTime(): float
    {
        return $this->priceAtTime;
    }

    public function increaseQuantity(int $qty): void
    {
        if ($qty <= 0) {
            throw new Exception("Số lượng cộng thêm phải lớn hơn 0.");
        }

        $this->quantity += $qty;
    }

    public function calculateTotal(): float
    {
        return $this->quantity * $this->priceAtTime;
    }
}
?>