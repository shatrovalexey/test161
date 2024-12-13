DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products`(
    id BIGINT NOT null AUTO_INCREMENT COMMENT 'ID',
    uuid  varchar(255) not null comment 'UUID товара',
    category  varchar(255) not null comment 'Категория товара',
    is_active tinyint default 1  not null comment 'Флаг активности',
    name TEXT NOT null COMMENT 'Тип услуги',
    description text null comment 'Описание товара',
    thumbnail  varchar(255) null comment 'Ссылка на картинку',
    price float not null comment 'Цена' ,
	
	PRIMARY KEY(`id`)
) comment 'Товары';

create index is_active_idx on products (is_active);
