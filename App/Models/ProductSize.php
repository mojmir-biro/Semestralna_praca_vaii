<?php

namespace App\Models;

use App\Core\Model;

class ProductSize extends Model
{
    protected ?int $id = null;
    protected ?int $productId;
    protected ?float $priceFactor;
    protected ?string $size;
    protected ?int $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getPriceFactor(): ?float
    {
        return $this->priceFactor;
    }

    public function setPriceFactor(float $priceFactor): void
    {
        $this->priceFactor = $priceFactor;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
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