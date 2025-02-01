<?php

namespace App\Models;

use App\Core\Model;

class BasketItem extends Model
{
    protected ?int $id = null;
    protected ?int $basketId;
    protected ?int $productSizeId;
    protected ?int $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasketId(): ?int
    {
        return $this->basketId;
    }

    public function setBasketId(int $basketId): void
    {
        $this->basketId = $basketId;
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