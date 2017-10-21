<?php

namespace AppBundle\Common\Entity\Implementation;

use Doctrine\ORM\Mapping\{
    Column
};

trait Activated
{
    /**
     * @Column(type="boolean")
     */
    private $active = true;

    public function isActive()
    {
        return $this->active;
    }

    public function activate()
    {
        $this->active = true;

        return $this;
    }

    public function deactivate()
    {
        $this->active = false;

        return $this;
    }
}