<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Users attached to a company (administrators have no company and are excluded).
     *
     * @return list<User>
     */
    public function findClientUsers(?Company $company = null): array
    {
        $qb = $this->createQueryBuilder('u')
            ->addSelect('c')
            ->innerJoin('u.company', 'c')
            ->orderBy('c.name', 'ASC')
            ->addOrderBy('u.email', 'ASC');

        if (null !== $company) {
            $qb->andWhere('u.company = :company')->setParameter('company', $company);
        }

        return $qb->getQuery()->getResult();
    }
}
