<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Web
{
    /**
     * @var ContainerRegisterInterface
     */
    private $containerRegister;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerRegisterInterface $register
     */
    public function __construct(ContainerRegisterInterface $register)
    {
        $this->containerRegister = $register;
    }

    public function run()
    {
        $this->container = new Container();

        $this->container->alias(ContainerInterface::class, $this->container);

        $this->container->alias(ServerRequestInterface::class, new Request(ServerRequestFactory::fromGlobals()));

        $this->container->instance(DispatcherInterface::class, Dispatcher::class);

        $this->containerRegister->register($this->container);

        $pipeline = new MiddlewarePipeline($this->container);

        if ($this->container->has(MiddlewareRegisterInterface::class)){

            /**
             * @var MiddlewareRegisterInterface $middlewareRegister
             */
            $middlewareRegister = $this->container->get(MiddlewareRegisterInterface::class);

            $middlewareRegister->register($pipeline);
        }

        $pipeline->add(DispatcherMiddleware::class);

        $response = $pipeline->handle($this->container->get(ServerRequestInterface::class));

        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }
}