<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Entity\Vehicle;
use App\Manager\VehicleManager;
use App\Repository\VehicleRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\Pagination\LiveComponent\ComponentWithPaginationTrait;
use Symfony\UX\Pagination\PaginationBuilder;
use Symfony\UX\Pagination\PaginationInterface;
use Symfony\UX\Pagination\PaginatorInterface;

#[isGranted('ROLE_MANAGER')]
#[AsLiveComponent('VehiclesTable', 'components/Vehicle/VehiclesTable.html.twig')]
final class VehiclesTable
{
    use DefaultActionTrait;
    use ComponentWithPaginationTrait;

    #[LiveProp(writable: true, onUpdated: 'onQueryUpdated', url: true)]
    public ?string $query = '';

    public function __construct(
        private readonly VehicleManager $vehicleManager,
        private readonly PaginatorInterface $pagination,
    )
    {
    }

    protected function createPagination(): PaginationBuilder
    {
        return $this->pagination->query($this->vehicleManager->getVehiclesSearch($this->query))->perPage(25);
    }

    public function onQueryUpdated(string $previousQuery): void
    {
        $this->resetPage();
    }
}
