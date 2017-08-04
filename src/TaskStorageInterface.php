<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface TaskStorageInterface
{
    /**
     * @param callable $task
     */
    public function add(callable $task);
}