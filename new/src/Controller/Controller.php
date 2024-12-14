<?php
namespace Raketa\BackendTestTask\Controller;

use Raketa\BackendTestTask\Infrastructure\Codec;

abstract class Controller
{
    protected function _getRequest(RequestInterface $request)
    {
        return Codec::unserialize($request->getBody()->getContents());
    }

    protected function _getResponse($data, int $status = 200)
    {
        $response = new JsonResponse();
        $response->getBody()->write(Codec::serialize($data));

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8')->withStatus($status);
    }
}