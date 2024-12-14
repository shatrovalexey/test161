<?php
namespace Raketa\BackendTestTask\Repository\Entity;

use Raketa\BackendTestTask\Infrastructure\Codec;

readonly class Product
{
    private string $uuid;

    public function __construct(private bool $isActive = true, private int $id_category
        , private string $name, private string $description, private string $thumbnail, private float $price)
    {
        $this->uuid = Codec::Uuid();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getIdCategory(): string
    {
        return $this->id_category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
