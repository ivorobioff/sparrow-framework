<?php
namespace ImmediateSolutions\Support\Framework\Tests;

use ImmediateSolutions\Support\Framework\Web;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequestFactory;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class WebTest extends TestCase
{
    public function testHandle()
    {
        $web = new Web(new ContainerRegister());

        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/test'
        ];

        $request = ServerRequestFactory::fromGlobals($server);

        $response = $web->handle($request);

        Assert::assertEquals('<h1>Test</h1>', (string) $response->getBody());
    }
}