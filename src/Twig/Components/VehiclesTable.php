<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Enum\VehicleStatus;
use App\Manager\VehicleManager;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\Pagination\LiveComponent\ComponentWithPaginationTrait;
use Symfony\UX\Pagination\PaginationBuilder;
use Symfony\UX\Pagination\PaginatorInterface;

#[isGranted('ROLE_MANAGER')]
#[AsLiveComponent('VehiclesTable', 'components/Vehicle/VehiclesTable.html.twig')]
final class VehiclesTable
{
    use DefaultActionTrait;
    use ComponentWithPaginationTrait;

    #[LiveProp(writable: true, onUpdated: 'onQueryUpdated', url: true)]
    public ?string $query = '';

    /** @var list<string> */
    #[LiveProp(writable: true, onUpdated: 'onFiltersUpdated', url: true)]
    public array $statuses = self::DEFAULT_STATUSES;

    private const array DEFAULT_STATUSES = [
        VehicleStatus::Active->value,
        VehicleStatus::InMaintenance->value,
    ];

    public function __construct(
        private readonly VehicleManager $vehicleManager,
        private readonly PaginatorInterface $pagination,
    )
    {
    }

    protected function createPagination(): PaginationBuilder
    {
        return $this->pagination->query($this->vehicleManager->getVehiclesSearch($this->query, $this->getSelectedStatuses()))->perPage(25);
    }

    public function onQueryUpdated(string $previousQuery): void
    {
        $this->resetPage();
    }

    public function onFiltersUpdated(): void
    {
        $this->resetPage();
    }

    /** @return list<VehicleStatus> */
    private function getSelectedStatuses(): array
    {
        $values = array_filter($this->statuses, is_string(...));

        return array_values(array_filter(array_map(VehicleStatus::tryFrom(...), $values)));
    }
}
