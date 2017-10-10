<?php

namespace AppBundle\Common\Event;

interface EventDispatcher
{
    public function dispatch(array $events);
}