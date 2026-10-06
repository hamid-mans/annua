<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(name: 'app:user:create-admin', description: 'Crée un administrateur Annua (sans société).')]
final class CreateAdminCommand
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument(description: 'Adresse e-mail de l\'administrateur')] string $email,
    ): int {
        $plainPassword = $io->askHidden('Mot de passe (12 caractères minimum)');

        if (null === $plainPassword || mb_strlen($plainPassword) < 12) {
            $io->error('Le mot de passe doit contenir au moins 12 caractères.');

            return Command::FAILURE;
        }

        $user = (new User())
            ->setEmail($email)
            ->setRoles([User::ROLE_ADMIN])
            ->setCompany(null);

        $violations = $this->validator->validate($user);

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $io->error($violation->getMessage());
            }

            return Command::FAILURE;
        }

        $user->setPassword($this->hasher->hashPassword($user, $plainPassword));
        $this->em->persist($user);
        $this->em->flush();

        $io->success(sprintf('Administrateur « %s » créé.', $email));

        return Command::SUCCESS;
    }
}
