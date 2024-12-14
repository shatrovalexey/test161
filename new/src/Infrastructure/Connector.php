<?php
namespace Raketa\BackendTestTask\Infrastructure;

use Raketa\BackendTestTask\Domain\Cart;
use Redis;
use RedisException;
use Raketa\BackendTestTask\Infrastructure\Codec;

/**
* Обёртка подключения к хранилищу
*/
abstract class Connector
{
    /**
    * @var ?static $obj - синглтон
    */
    protected ?static $_obj;
    protected ?Redis $_connection;

    /**
    * Конструктор
    */
    protected function __construct(private string $host, private int $port, private ?string $password
        , private ?int $dbindex, private ?int $timeout) {}

    public function getConnection()
    {
        if ($this->_connection) {
            try {
                if ($this->_connection->ping('OK')) {
                    return $this;
                }
            } catch (\Exception $exception) {}
        }

        $this->_callMethod(function ($self) {
            $self->_connection = new Redis();
            $self->_connection->connect($self->host, $self->port);
            $self->_connection->auth($self->password);
            $self->_connection->select($self->dbindex);
        }, $this);

        return $this;
    }

    /**
    * Создание синглтона
    *
    * @param Redis $redis
    * @param int $timeout
    *
    * @return static
    */
    public function getInstance(string $host, int $port, ?string $password
        , ?int $dbindex, int $timeout = 24 * 60 * 60): static
    {
        return static::$_obj = static::$_obj ?? new static($host, $port, $password, $dbindex, $timeout);
    }

    /**
    * Получить значение по ключу
    *
    * @param string $key
    *
    * @return ?Cart
    *
    * @throws ConnectorException
    */
    public function get(string $key): ?Cart
    {
        return $this->_callMethod(fn () => Codec::unserialize($this->redis->get($key), 'serialize'));
    }

    /**
    * Создать ключ-значение
    *
    * @param string $key
    * @param Cart $value
    *
    * @return int
    *
    * @throws ConnectorException
    */
    public function set(string $key, Cart $value): int
    {
        return $this->_callMethod(fn () => $this->redis->setex($key
            , $this->timeout, Codec::serialize($value, 'serialize')));
    }

    /**
    * Проверить ключ
    *
    * @param string $key
    *
    * @return bool
    */
    public function has(string $key): bool
    {
        return $this->_callMethod(fn () => $this->redis->exists($key));
    }

    /**
    * Вызов с преобразованием исключения в ConnectorException
    *
    * @param \Closure $sub
    * @param ...array $args
    *
    * @return mixed
    */
    protected function _callMethod(\Closure $sub, ... $args)
    {
        try {
            return $sub(... $args);
        } catch(RedisException $e)  {
            throw new ConnectorException('Connector error', $e->getCode(), $e);
        }
    }
}
