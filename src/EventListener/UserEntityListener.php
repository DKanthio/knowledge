<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Cursus;
use App\Entity\Certification;
use Symfony\Component\Security\Core\Security;

class UserEntityListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof User) {
            $currentUser = $this->security->getUser();
            if ($currentUser instanceof User) {
                $entity->setCreatedBy($currentUser);
                $entity->setUpdatedBy($currentUser);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof User) {
            $currentUser = $this->security->getUser();
            if ($currentUser instanceof User) {
                $entity->setUpdatedBy($currentUser);
            }
        }
    }
}
