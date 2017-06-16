<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ConfigInterface
{
    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    public function get($path, $default = null);

    /**
     * @param string $path
     * @return bool
     */
    public function has($path);
}