<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([User::GROUP_ME])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de la société est obligatoire.')]
    #[Assert\Length(max: 255)]
    #[Groups([User::GROUP_ME])]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     *
     * ⚠️ Volontairement SANS groupe : User expose sa Company, si Company
     * exposait ses User on bouclerait (User → Company → Users → Company…),
     * et /api/me renverrait la liste de tous les collègues.
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company')]
    #[ORM\OrderBy(['email' => 'ASC'])]
    private Collection $users;

    /**
     * @var Collection<int, Activities>
     *
     * Sans groupe : l'historique d'activité n'a rien à faire dans /api/me.
     */
    #[ORM\OneToMany(targetEntity: Activities::class, mappedBy: 'company', orphanRemoval: true)]
    private Collection $activities;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

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
            $activity->setCompany($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getCompany() === $this) {
                $activity->setCompany(null);
            }
        }

        return $this;
    }
}