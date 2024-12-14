<?php
namespace Raketa\BackendTestTask\Domain;

use Raketa\BackendTestTask\Infrastructure\Codec;

class Cart
{
    protected ?string $uuid;

    public function __construct(private Customer $customer, private string $paymentMethod, private array $items) {
        $this->uuid = Codec::Uuid();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }
}
