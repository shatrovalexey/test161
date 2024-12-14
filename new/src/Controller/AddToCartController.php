<?php

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\CartItem;
use Raketa\BackendTestTask\Repository\CartManager;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\CartView;
use Raketa\BackendTestTask\Controller\Controller;

class AddToCartController extends Controller
{
    public function __construct(private ProductRepository $productRepository,
        private CartView $cartView, private CartManager $cartManager){}

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = $this->_getRequest($request);
        $product = $this->productRepository->getByUuid($rawRequest['productUuid']);

        if (!$product) {
            return $this->_getResponse(['success' => false,]);
        }

        $cartItem = new CartItem($product->getUuid(), $product->getPrice(), $rawRequest['quantity']);
        $cart = $this->cartManager->getCart($request->id_session);
        $cart->addItem($cartItem);

        return $this->_getResponse(['success' => true, 'cart' => $this->cartView->toArray($cart),]);
    }
}