<?php

namespace AppBundle\Common\Entity\Implementation;

use Gedmo\Mapping\Annotation\Slug;
use Doctrine\ORM\Mapping\Column;

trait Sluggable
{
    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="string", unique=true)
     * @Slug(fields={"name"})
     */
    private $slug;

    public function slug()
    {
        return $this->slug;
    }

    public function name()
    {
        return $this->name;
    }
}