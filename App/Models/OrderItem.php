<?php

namespace App\Models;

use App\Core\Model;

class OrderItem extends Model
{
    protected ?int $id = null;
    protected ?int $orderId;
    protected ?int $productSizeId;
    protected ?int $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getProductSizeId(): ?int
    {
        return $this->productSizeId;
    }

    public function setProductSizeId(int $productSizeId): void
    {
        $this->productSizeId = $productSizeId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}