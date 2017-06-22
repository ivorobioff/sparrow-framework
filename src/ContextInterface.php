<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContextInterface
{
    /**
     * @return bool
     */
    public function isDebug();

    /**
     * @return string
     */
    public function getRootPath();
}