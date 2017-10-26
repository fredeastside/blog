<?php

namespace AppBundle\Common\Doctrine\Filters;

use AppBundle\Common\Entity\Activated;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SelectOnlyActive extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->getReflectionClass()->implementsInterface(Activated::class)) {
            return '';
        }

        return sprintf('%s.active = 1', $targetTableAlias);
    }
}