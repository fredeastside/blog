<?php

namespace AppBundle\Common\Repository;

interface Repository
{
    public function getEntityClass();

    public function getManager();
}