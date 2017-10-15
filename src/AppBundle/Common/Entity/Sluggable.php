<?php

namespace AppBundle\Common\Entity;

interface Sluggable
{
    public function slug();
    public function name();
}