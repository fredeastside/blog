<?php

namespace App\Common\Entity;

interface Activated
{
    public function isActive();

    public function activate();

    public function deactivate();
}