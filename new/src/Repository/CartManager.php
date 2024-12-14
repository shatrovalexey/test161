<?php
namespace Raketa\BackendTestTask\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Infrastructure\Connector;

class CartManager extends Connector
{
    protected LoggerInterface $logger;

    public function __construct(private string $host, private int $port, private ?string $password
        , private ?int $dbindex = 1, private ?int $timeout){}

    /**
    * @param LoggerInterface $logger
    *
    * @return LoggerInterface
    */
    public function setLogger(LoggerInterface $logger): LoggerInterface
    {
        return $this->logger = $logger;
    }

    /**
    * @param Cart $cart
    * @param string $id_session
    *
    * @return bool
    */
    public function saveCart(Cart $cart, string $id_session): bool
    {
        try {
            $this->getConnection()->set($cart, $id_session);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }

        return true;
    }

    /**
    * @param string $id_session
    *
    * @return Cart
    */
    public function getCart(string $id_session): Cart
    {
        try {
            return $this->getConnection()->get($id_session);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return new Cart($id_session, []);
    }
}
