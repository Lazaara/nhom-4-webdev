<?php

class Customer extends User
{
    private ?Cart $cart = null;
    private array $orders = [];
    private array $reviews = [];

    public function __construct(int $id, string $email, string $password, string $fullName, string $phoneNumber)
    {
        parent::__construct($id, $email, $password, $fullName, $phoneNumber);
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }

    public function setOrders(array $orders): void
    {
        $this->orders = $orders;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function setReviews(array $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function viewOrderHistory(): void
    {
    }

    public function addToWishlist(Product $p): void
    {
    }
}
?>