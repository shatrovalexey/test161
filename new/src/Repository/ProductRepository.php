<?php
namespace Raketa\BackendTestTask\Repository;

use Doctrine\DBAL\Connection;
use Raketa\BackendTestTask\Repository\Entity\Product;

class ProductRepository
{
    public function __construct(private Connection $connection){}

    public function getByUuid(string $uuid): Product
    {
        $row = $this->connection->fetchOne('
SELECT
    `p1`.*
FROM
    `products` AS `p1`
WHERE
    (`p1`.`uuid` = ?);
        '
        , [$uuid,]);

        if (empty($row)) {
            throw new \Exception('Product not found');
        }

        return $this->make($row);
    }

    public function getByCategory(int $id_category): array
    {
        return array_map(
            fn (array $row): Product => $this->make($row)
            , $this->connection->fetchAllAssociative('
SELECT
    `p1`.`id`
FROM
    `products` AS `p1`

    INNER JOIN `category` AS `c1` ON
    (`p1`.`id_category`  = `c1`.`id`)
WHERE
    (`p1`.`is_active` = ?)
    AND (`c1`.`title` = ?);
            '
            , [1, $id_category,])
        );
    }

    public function make(array $row): Product
    {
        return new Product(... array_map(fn ($key) => $row[$key]
            , ['is_active', 'id_category', 'name', 'description', 'thumbnail', 'price',]));
    }
}
