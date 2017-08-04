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
        $response = $this->handle(new Request(ServerRequestFactory::fromGlobals()));

        $emitter = new SapiEmitter();
        $emitter->emit($response);

        if (function_exists('fastcgi_finish_request')){
            fastcgi_finish_request();
        }

        $this->terminate();
    }

    public function terminate()
    {
        if (!$this->getContainer()->has(TaskRegisterInterface::class)){
            return ;
        }

        /**
         * @var TaskRegisterInterface $register
         */
        $register = $this->getContainer()->get(TaskRegisterInterface::class);

        /**
         * @var callable[] $tasks
         */
        $tasks = new TaskStorage();

        $register->register($tasks);

        foreach ($tasks as $task){
            $task();
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        if ($this->container === null){
            throw new \RuntimeException('The application is unhandled. You have to run the "handle" method.');
        }

        return $this->container;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $this->container = new Container();

        $origins = new Origins();

        $origins->setRequest($request);

        $this->container->service(Origins::class, $origins);
        $this->container->service(ContainerInterface::class, $this->container);
        $this->container->service(ServerRequestInterface::class, $request);

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

        return $pipeline->handle($this->container->get(ServerRequestInterface::class));
    }
}