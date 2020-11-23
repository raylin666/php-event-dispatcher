<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2020 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\EventDispatcher;

use Psr\EventDispatcher\StoppableEventInterface;
use Raylin666\EventDispatcher\Contracts\EventInterface;
use Serializable;

/**
 * Class Event
 * @package Raylin666\EventDispatcher
 */
abstract class Event implements EventInterface, StoppableEventInterface, Serializable
{
    /**
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.

        return static::class;
    }

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        // TODO: Implement isPropagationStopped() method.

        return false;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.

        return serialize($this);
    }

    /**
     * @param string $serialized
     * @return mixed|void
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.

        return unserialize($serialized);
    }
}