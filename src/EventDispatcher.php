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

use Psr\EventDispatcher\EventDispatcherInterface;
use Raylin666\EventDispatcher\Contracts\EventInterface;
use Raylin666\EventDispatcher\Contracts\ListenerInterface;
use Raylin666\EventDispatcher\Contracts\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use TypeError;

/**
 * Class EventDispatcher
 * @package Raylin666\EventDispatcher
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var ListenerProviderInterface
     */
    protected $listenerProvider;

    /**
     * EventDispatcher constructor.
     * @param ListenerProviderInterface $listenerProvider
     */
    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface
    {
        return $this->listenerProvider;
    }

    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event)
    {
        // TODO: Implement dispatch() method.

        if (!$event instanceof EventInterface) {
            throw new TypeError('The named event must implement \Raylin666\Event\Contracts\EventInterface.');
        }

        if ($this->isEventPropagationStopped($event)) {
            return $event;
        }

        foreach ($this->getListenerProvider()->getListenersForEvent($event) as $listener) {
            if (is_object($listener) || is_callable($listener)) {
                $listener($event);

                if ($this->isEventPropagationStopped($event)) {
                    break;
                }

                continue ;
            }

            if (is_string($listener) && class_exists($listener)) {
                $class = new $listener;
                if ($class instanceof ListenerInterface) {
                    $class->process($event);
                }
            }
        }

        return $event;
    }

    /**
     * @param object $event
     * @return bool
     */
    protected function isEventPropagationStopped(object $event): bool
    {
        return (
            $event instanceof StoppableEventInterface
            && $event->isPropagationStopped()
        );
    }
}