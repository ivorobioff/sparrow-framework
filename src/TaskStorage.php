<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TaskStorage implements TaskStorageInterface, \IteratorAggregate
{
    /**
     * @var array
     */
    private $tasks = [];

    /**
     * @param callable $task
     */
    public function add(callable $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * @return callable[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->tasks);
    }
}