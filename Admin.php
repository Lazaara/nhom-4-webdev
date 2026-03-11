<?php

class Admin extends User
{
    public function __construct(int $id, string $email, string $password, string $fullName, string $phoneNumber)
    {
        parent::__construct($id, $email, $password, $fullName, $phoneNumber);
    }

    public function manageProducts(): void
    {
    }

    public function manageOrders(): void
    {
    }
}
?>