<?php

namespace AppBundle\Common\Event;

interface DomainEventsPublisher
{
    public function releaseEvents(): array;
}
