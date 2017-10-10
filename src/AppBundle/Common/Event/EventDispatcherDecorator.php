<?php

namespace AppBundle\Common\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcherDecorator implements EventDispatcher
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function dispatch(array $events)
    {
        foreach ($events as $eventName => $event) {
            $this->eventDispatcher->dispatch($eventName, $event);
        }
    }
}