<?php

require_once 'Product.php';
require_once 'CartItem.php';

class Cart
{
    private float $subTotal = 0;
    private array $items = [];

    public function addItem(Product $product, int $qty): void
    {
        if ($qty <= 0) {
            throw new Exception("Số lượng phải lớn hơn 0.");
        }

        if ($product->getStockQuantity() < $qty) {
            throw new Exception("Sản phẩm không đủ tồn kho.");
        }

        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $item->increaseQuantity($qty);
                $this->updateSubTotal();
                return;
            }
        }

        $this->items[] = new CartItem($product, $qty);
        $this->updateSubTotal();
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    private function updateSubTotal(): void
    {
        $this->subTotal = 0;
        foreach ($this->items as $item) {
            $this->subTotal += $item->calculateTotal();
        }
    }

    public function checkout(): void
    {
        if (empty($this->items)) {
            throw new Exception("Giỏ hàng đang trống.");
        }

        foreach ($this->items as $item) {
            $item->getProduct()->updateStock(-$item->getQuantity());
        }

        echo "Thanh toán thành công. Tổng tiền: " . number_format($this->subTotal, 0, ',', '.') . " VNĐ";
    }
}
?>