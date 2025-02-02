<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected ?int $id = null;
    protected ?int $customerId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }
}