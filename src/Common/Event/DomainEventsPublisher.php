<?php

namespace App\Common\Event;

interface DomainEventsPublisher
{
    public function releaseEvents(): array;
}
