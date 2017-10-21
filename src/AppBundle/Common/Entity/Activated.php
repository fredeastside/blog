<?php

namespace AppBundle\Common\Entity;

interface Activated
{
    public function isActive();

    public function activate();

    public function deactivate();
}