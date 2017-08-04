<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ResponseInterface;
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
     * @param ContainerRegisterInterface $register
     */
    public function __construct(ContainerRegisterInterface $register)
    {
        $this->containerRegister = $register;
    }

    public function run()
    {
        $response = $this->handle(new Request(ServerRequestFactory::fromGlobals()));
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $container = new Container();

        $origins = new Origins();

        $origins->setContainer($container);
        $origins->setRequest($request);

        $container->service(Origins::class, $origins);
        $container->service(ContainerInterface::class, $container);
        $container->service(ServerRequestInterface::class, $request);

        $container->instance(DispatcherInterface::class, Dispatcher::class);

        $this->containerRegister->register($container);

        $pipeline = new MiddlewarePipeline($container);

        if ($container->has(MiddlewareRegisterInterface::class)){

            /**
             * @var MiddlewareRegisterInterface $middlewareRegister
             */
            $middlewareRegister = $container->get(MiddlewareRegisterInterface::class);

            $middlewareRegister->register($pipeline);
        }

        $pipeline->add(DispatcherMiddleware::class);

        return $pipeline->handle($container->get(ServerRequestInterface::class));
    }
}