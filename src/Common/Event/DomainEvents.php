<?php

namespace App\Common\Event;

use Symfony\Component\EventDispatcher\Event;

trait DomainEvents
{
    private $events = [];

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    private function addEvent(Event $event)
    {
        if ($this->hasEvent(get_class($event))) {
            return;
        }
        $this->events[get_class($event)] = $event;
    }

    private function hasEvent(string $key)
    {
        return isset($this->events[$key]);
    }
}
