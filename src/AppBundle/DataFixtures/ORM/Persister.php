<?php

declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class Persister
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function persist(array $objects)
    {
        $persistable = $this->getPersistableClasses();
        foreach ($objects as $object) {
            if (in_array(get_class($object), $persistable)) {
                $this->objectManager->persist($object);
            }
        }
        $this->objectManager->flush();
    }

    private function getPersistableClasses()
    {
        if (!isset($this->persistableClasses)) {
            $metadatas = $this->objectManager->getMetadataFactory()->getAllMetadata();
            foreach ($metadatas as $metadata) {
                if (isset($metadata->isEmbeddedClass) && $metadata->isEmbeddedClass) {
                    continue;
                }
                if (isset($metadata->isEmbeddedDocument) && $metadata->isEmbeddedDocument) {
                    continue;
                }
                $this->persistableClasses[] = $metadata->getName();
            }
        }

        return $this->persistableClasses;
    }
}
