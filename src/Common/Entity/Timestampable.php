<?php

namespace App\Common\Entity;

interface Timestampable
{
    public function created();
    public function updated();
}