<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Repository\CartManager;
use Raketa\BackendTestTask\View\CartView;
use Raketa\BackendTestTask\Controller\Controller;

class GetCartController extends Controller
{
    public function __construct(public CartView $cartView, public CartManager $cartManager) {}

    public function get(RequestInterface $request): ResponseInterface
    {
        $cart = $this->cartManager->getCart();

        return $this->_getResponse($cart ? $this->cartView->toArray($cart)
            : ['message' => 'Cart not found',], $cart ? 200 : 404);
    }
}