<?php
namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\View\ProductsView;
use Raketa\BackendTestTask\Controller\Controller;

class GetProductsController extends Controller
{
    public function __construct(private ProductsView $productsVew) {}

    public function get(RequestInterface $request): ResponseInterface
    {
        return $this->_getResponse($this->productsVew->toArray($this->_getRequest($request)['category']));
    }
}