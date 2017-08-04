<?php
namespace ImmediateSolutions\Support\Framework\Tests;

use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\ContainerRegisterInterface;
use ImmediateSolutions\Support\Framework\RouteRegisterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ContainerRegister implements ContainerRegisterInterface
{
    /**
     * @param ContainerPopulatorInterface $populator
     */
    public function register(ContainerPopulatorInterface $populator)
    {
        $populator->instance(RouteRegisterInterface::class, RouteRegister::class);
    }
}