<?php

namespace App\Common\Event;

interface EventDispatcher
{
    public function dispatch(array $events);
}