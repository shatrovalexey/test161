<?php
namespace Raketa\BackendTestTask\Domain;

use Raketa\BackendTestTask\Infrastructure\Codec;

class CartItem
{
    public ?string $uuid;

    public function __construct(public string $productUuid, public float $price, public int $quantity) {
        $this->uuid = Codec::Uuid();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
