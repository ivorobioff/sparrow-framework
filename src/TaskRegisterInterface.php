<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface TaskRegisterInterface
{
    /**
     * @param TaskStorageInterface $storage
     */
    public function register(TaskStorageInterface $storage);
}