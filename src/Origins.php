<?php
namespace ImmediateSolutions\Support\Framework;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Origins
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }
}