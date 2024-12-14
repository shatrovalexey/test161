<?php
namespace Raketa\BackendTestTask\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Domain\Cart;
use Raketa\BackendTestTask\Infrastructure\Connector;

class CartManager extends Connector
{
    public $logger;

    public function __construct($host, $port, $password)
    {
        parent::__construct($host, $port, $password, 1);
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function saveCart(Cart $cart)
    {
        try {
            $this->getConnection()->set($cart, session_id());
        } catch (Exception $e) {
            $this->logger->error('Error');
        }
    }

    /**
     * @return ?Cart
     */
    public function getCart()
    {
        try {
            return $this->getConnection()->get(session_id());
        } catch (Exception $e) {
            $this->logger->error('Error');
        }

        return new Cart(session_id(), []);
    }
}
