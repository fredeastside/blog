<?php

namespace AppBundle\Common\Entity;

interface Timestampable
{
    public function created();
    public function updated();
}