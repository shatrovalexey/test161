CREATE TABLE `category`(
    `id` BIGINT UNSIGNED NOT null AUTO_INCREMENT COMMENT 'ID'
    , `title` VARCHAR(255) NOT null COMMENT 'название'

    , UNIQUE(`title`)
    , PRIMARY KEY(`id`)
) COMMENT 'категория';

CREATE TABLE `products`(
    `uuid` CHAR(36) NOT null COMMENT 'UUID товара'
    , `id_category` BIGINT UNSIGNED NOT null COMMENT 'ID категории товара'
    , `is_active` TINYINT UNSIGNED NOT null DEFAULT true COMMENT 'Флаг активности'
    , `name` TEXT NOT null COMMENT 'Тип услуги'
    , `description` TEXT COMMENT 'Описание товара'
    , `thumbnail` VARCHAR(255) DEFAULT null COMMENT 'Ссылка на картинку'
    , `price` DECIMAL(10, 2) NOT null COMMENT 'Цена'

    , INDEX(`id_category`, `price`, `is_active`)
    , PRIMARY KEY(`uuid`)
    , CONSTRAINT FOREIGN KEY(`id_category`) REFERENCES `category`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) COMMENT 'Товары';