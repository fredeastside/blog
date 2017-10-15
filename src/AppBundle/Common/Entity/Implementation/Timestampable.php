<?php

namespace AppBundle\Common\Entity\Implementation;

use Doctrine\ORM\Mapping\{
    Column
};
use Gedmo\Mapping\Annotation\Timestampable as TimestampableAnnotation;

trait Timestampable
{
    /**
     * @TimestampableAnnotation(on="create")
     * @Column(type="datetime")
     */
    private $created;

    /**
     * @TimestampableAnnotation(on="update")
     * @Column(type="datetime")
     */
    private $updated;

    public function created()
    {
        return $this->created;
    }

    public function updated()
    {
        return $this->updated;
    }
}