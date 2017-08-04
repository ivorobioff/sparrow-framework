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
}