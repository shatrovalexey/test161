<?php
namespace Raketa\BackendTestTask\Infrastructure;

use Ramsey\Uuid\Uuid;

/**
* Кодек
*/
abstract class Codec
{
    /**
    * UUID
    *
    * @return string
    */
    public static function getUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
    * Закодирование в формат "serialize"
    *
    * @param mixed $data - данные
    *
    * @return ?string
    */
    public static function encodeSerialize($data): ?string
    {
        return serialize($data);
    }

    /**
    * Раскодирование из формата "serialize"
    *
    * @param mixed $data - данные
    *
    * @return ?mixed
    */
    public static function decodeSerialize($data): ?string
    {
        return unserialize($data);
    }

    /**
    * Раскодирование из формата JSON
    *
    * @param ?string $data - данные
    * @param bool $toArray - в массив, а не объект
    *
    * @return ?mixed
    */
    public static function decodeJson(?string $data, bool $toArray = true): ?string
    {
        return json_decode($data, $toArray);
    }

    /**
    * Закодирование в формат JSON
    *
    * @param mixed $data - данные
    *
    * @return ?string
    */
    public static function encodeJson($data): ?string
    {
        return json_encode($data);
    }

    /**
    * Заскодирование в формат JSON
    *
    * @param ?string $data - данные
    * @param bool $toArray - в массив, а не объект
    *
    * @return ?string
    */
    public static function decodeJson(?string $data, bool $toArray = true): ?string
    {
        return json_decode($data, $toArray);
    }

    /**
    * Универсальная сериализация данных
    *
    * @param mixed $data - данные
    * @param string $type - тип кодирования. Доступно: "Json", "Serialize"
    *
    * @return ?string
    */
    public static function serialize($data, string $type = 'Json'): ?string
    {
        return static::_callMethod('encode_' . ucfirst($type), $data);
    }

    /**
    * Универсальная разсериализация данных
    *
    * @param ?string $data - данные
    * @param string $type - тип кодирования. Доступно: "Json", "Serialize"
    *
    * @return ?string
    */
    public static function unserialize(?string $data, string $type = 'Json'): ?string
    {
        return static::_callMethod('decode_' . ucfirst($type), $data);
    }

    /**
    * Вызов локального метода по названию
    *
    * @param string $method - имя метода
    * @param ...array $args - тип кодирования. Доступно: "json"
    *
    * @return ?string
    */
    protected static function _callMethod(string $method, ... $args)
    {
        if (!method_exists(static::class, $method)) {
            return null;
        }

        return static::$method(... $args);
    }
}