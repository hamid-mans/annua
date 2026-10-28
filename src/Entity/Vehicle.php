<?php

namespace App\Entity;

use App\Enum\VehicleCategory;
use App\Enum\VehicleEnergy;
use App\Enum\VehicleStatus;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle //implements CompanyOwnedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    private ?string $registrationNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $firstRegistrationDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $currentRegistrationDate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $variantType = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $cnit = null;

    #[ORM\Column(length: 17, nullable: true)]
    private ?string $vin = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxLadenMass = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxCombinedMass = null;

    #[ORM\Column(nullable: true)]
    private ?int $unladenMass = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $euCategory = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $nationalGenre = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $bodyType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $typeApprovalNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $engineDisplacement = null;

    #[ORM\Column(nullable: true)]
    private ?float $netPowerKw = null;

    #[ORM\Column(nullable: true, enumType: VehicleEnergy::class)]
    private ?VehicleEnergy $energy = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $fiscalPower = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $seatCount = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $co2Emissions = null;

    #[ORM\Column(enumType: VehicleCategory::class)]
    private ?VehicleCategory $category = null;

    #[ORM\Column(enumType: Vehicle::class)]
    private ?VehicleStatus $status = VehicleStatus::Active;

    /**
     * @var Collection<int, Activities>
     */
    #[ORM\OneToMany(targetEntity: Activities::class, mappedBy: 'vehicle', orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): static
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getFirstRegistrationDate(): ?\DateTimeImmutable
    {
        return $this->firstRegistrationDate;
    }

    public function setFirstRegistrationDate(?\DateTimeImmutable $firstRegistrationDate): static
    {
        $this->firstRegistrationDate = $firstRegistrationDate;

        return $this;
    }

    public function getCurrentRegistrationDate(): ?\DateTimeImmutable
    {
        return $this->currentRegistrationDate;
    }

    public function setCurrentRegistrationDate(?\DateTimeImmutable $currentRegistrationDate): static
    {
        $this->currentRegistrationDate = $currentRegistrationDate;

        return $this;
    }

    public function getVariantType(): ?string
    {
        return $this->variantType;
    }

    public function setVariantType(?string $variantType): static
    {
        $this->variantType = $variantType;

        return $this;
    }

    public function getCnit(): ?string
    {
        return $this->cnit;
    }

    public function setCnit(?string $cnit): static
    {
        $this->cnit = $cnit;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): static
    {
        $this->vin = $vin;

        return $this;
    }

    public function getMaxLadenMass(): ?int
    {
        return $this->maxLadenMass;
    }

    public function setMaxLadenMass(?int $maxLadenMass): static
    {
        $this->maxLadenMass = $maxLadenMass;

        return $this;
    }

    public function getMaxCombinedMass(): ?int
    {
        return $this->maxCombinedMass;
    }

    public function setMaxCombinedMass(?int $maxCombinedMass): static
    {
        $this->maxCombinedMass = $maxCombinedMass;

        return $this;
    }

    public function getUnladenMass(): ?int
    {
        return $this->unladenMass;
    }

    public function setUnladenMass(?int $unladenMass): static
    {
        $this->unladenMass = $unladenMass;

        return $this;
    }

    public function getEuCategory(): ?string
    {
        return $this->euCategory;
    }

    public function setEuCategory(?string $euCategory): static
    {
        $this->euCategory = $euCategory;

        return $this;
    }

    public function getNationalGenre(): ?string
    {
        return $this->nationalGenre;
    }

    public function setNationalGenre(?string $nationalGenre): static
    {
        $this->nationalGenre = $nationalGenre;

        return $this;
    }

    public function getBodyType(): ?string
    {
        return $this->bodyType;
    }

    public function setBodyType(?string $bodyType): static
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    public function getTypeApprovalNumber(): ?string
    {
        return $this->typeApprovalNumber;
    }

    public function setTypeApprovalNumber(?string $typeApprovalNumber): static
    {
        $this->typeApprovalNumber = $typeApprovalNumber;

        return $this;
    }

    public function getEngineDisplacement(): ?int
    {
        return $this->engineDisplacement;
    }

    public function setEngineDisplacement(?int $engineDisplacement): static
    {
        $this->engineDisplacement = $engineDisplacement;

        return $this;
    }

    public function getNetPowerKw(): ?float
    {
        return $this->netPowerKw;
    }

    public function setNetPowerKw(?float $netPowerKw): static
    {
        $this->netPowerKw = $netPowerKw;

        return $this;
    }

    public function getEnergy(): ?VehicleEnergy
    {
        return $this->energy;
    }

    public function setEnergy(?VehicleEnergy $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getFiscalPower(): ?int
    {
        return $this->fiscalPower;
    }

    public function setFiscalPower(?int $fiscalPower): static
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    public function getSeatCount(): ?int
    {
        return $this->seatCount;
    }

    public function setSeatCount(?int $seatCount): static
    {
        $this->seatCount = $seatCount;

        return $this;
    }

    public function getCo2Emissions(): ?int
    {
        return $this->co2Emissions;
    }

    public function setCo2Emissions(?int $co2Emissions): static
    {
        $this->co2Emissions = $co2Emissions;

        return $this;
    }

    public function getCategory(): ?VehicleCategory
    {
        return $this->category;
    }

    public function setCategory(VehicleCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?VehicleStatus
    {
        return $this->status;
    }

    public function setStatus(VehicleStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Activities>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activities $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setVehicle($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getVehicle() === $this) {
                $activity->setVehicle(null);
            }
        }

        return $this;
    }
}
