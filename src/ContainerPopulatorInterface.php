<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContainerPopulatorInterface
{
    /**
     * @param string $target
     * @param callable|string|object $source
     * @return $this
     */
    public function service($target, $source);

    /**
     * @param string $target
     * @param string|callable $source
     * @return $this
     */
    public function instance($target, $source);

    /**
     * @param string $target
     * @param string $source
     * @return $this
     */
    public function alias($target, $source);

    /**
     * @param string $target
     * @param callable $initializer
     * @return $this
     */
    public function initialize($target, callable $initializer);
}