<?php

namespace App\Manager;

use App\Entity\Vehicle;
use App\Enum\VehicleStatus;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class VehicleManager
{
    private UserInterface $user;
    public function __construct(
        private VehicleRepository $vehicleRepository,
        private Security $security,
        private EntityManagerInterface $entityManager,
    )
    {
        $this->user = $this->security->getUser();
    }

    public function getVehiclesSearch(string $search, $status): QueryBuilder
    {
        return $this->vehicleRepository->findAllBySearch($this->user->getCompany(), $search, $status);
    }

    public function getVehicle(int $id): Vehicle
    {
        $vehicle = $this->vehicleRepository->findOneBy([
            'id' => $id,
            'company' => $this->user->getCompany(),
        ]);

        return $vehicle ?? throw new NotFoundHttpException();
    }

    public function updateVehicle(Vehicle $vehicle): void
    {
        $this->entityManager->flush();
    }

    public function storeVehicle(Vehicle $vehicle): Vehicle
    {
        $vehicle->setCompany($this->user->getCompany());

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }

    public function deleteVehicle(Vehicle $vehicle): void
    {
        if($vehicle->getCompany() !== $this->user->getCompany()) throw new NotFoundHttpException();

        $this->entityManager->remove($vehicle);
        $this->entityManager->flush();
    }
}
