<?php

namespace App\Manager;

use App\Entity\Activities;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Enum\ActivitiesType;
use App\Repository\ActivitiesRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

use function Symfony\Component\Clock\now;

final readonly class ActivitiesManager {

    private User $user;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private ActivitiesRepository $activitiesRepository
    )
    {
        $this->user = $this->security->getUser();
    }

    public function storeActivities(ActivitiesType $type, Vehicle $vehicle, Activities $activies): Activities
    {
        $activies->setType($type);
        $activies->setCompany($this->user->getCompany());
        $activies->setOperator($this->user);
        $activies->setCreatedAt(new DateTimeImmutable());
        $activies->setVehicle($vehicle);

        $this->entityManager->persist($activies);
        $this->entityManager->flush();

        return $activies;
    }

}