<?php
namespace ImmediateSolutions\Support\Framework\Tests;

use ImmediateSolutions\Support\Framework\RouteRegisterInterface;
use ImmediateSolutions\Support\Framework\RouterInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RouteRegister implements RouteRegisterInterface
{
    /**
     * @param RouterInterface $router
     */
    public function register(RouterInterface $router)
    {
        $router->get('/test', function(){
            return new HtmlResponse('<h1>Test</h1>');
        });
    }
}