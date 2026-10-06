<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/users', name: 'admin.user.')]
final class UserController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(
        UserRepository $users,
        CompanyRepository $companies,
        #[MapQueryParameter] ?int $company = null,
    ): Response {
        $filter = null !== $company ? $companies->find($company) : null;

        return $this->render('admin/user/index.html.twig', [
            'users' => $users->findClientUsers($filter),
            'companies' => $companies->findBy([], ['name' => 'ASC']),
            'filter' => $filter,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        CompanyRepository $companies,
        UserPasswordHasherInterface $hasher,
        #[MapQueryParameter] ?int $company = null,
    ): Response {
        $user = new User();

        if (null !== $company) {
            $user->setCompany($companies->find($company));
        }

        $form = $this->createForm(UserType::class, $user, ['password_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, (string) $form->get('plainPassword')->getData()));
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', sprintf('L\'utilisateur « %s » a été créé.', $user->getEmail()));

            return $this->redirectToRoute('admin.user.index', ['company' => $user->getCompany()?->getId()]);
        }

        return $this->render('admin/user/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $this->denyUnlessClientUser($user);

        $form = $this->createForm(UserType::class, $user, ['password_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = (string) $form->get('plainPassword')->getData();

            if ('' !== $plainPassword) {
                $user->setPassword($hasher->hashPassword($user, $plainPassword));
            }

            $em->flush();

            $this->addFlash('success', sprintf('L\'utilisateur « %s » a été modifié.', $user->getEmail()));

            return $this->redirectToRoute('admin.user.index', ['company' => $user->getCompany()?->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $this->denyUnlessClientUser($user);

        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Jeton de sécurité invalide, veuillez réessayer.');

            return $this->redirectToRoute('admin.user.index');
        }

        $companyId = $user->getCompany()?->getId();
        $email = $user->getEmail();

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', sprintf('L\'utilisateur « %s » a été supprimé.', $email));

        return $this->redirectToRoute('admin.user.index', ['company' => $companyId]);
    }

    private function denyUnlessClientUser(User $user): void
    {
        if ($user->isAdmin() || null === $user->getCompany()) {
            throw $this->createNotFoundException();
        }
    }
}
