<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\User;
use App\Form\CompanyType;
use App\Form\UserType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/companies', name: 'admin.company.')]
final class CompanyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CompanyRepository $companies): Response
    {
        return $this->render('admin/company/index.html.twig', [
            'rows' => $companies->findAllWithUserCount(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($company);
            $this->em->flush();

            $this->addFlash('success', sprintf('La société « %s » a été créée.', $company->getName()));

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId()]);
        }

        return $this->render('admin/company/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function show(Request $request, Company $company, #[MapQueryParameter] string $tab = 'info'): Response
    {
        $originalName = (string) $company->getName();

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', sprintf('La société « %s » a été modifiée.', $company->getName()));

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId()]);
        }

        return $this->renderCompany(
            $company,
            $form,
            null,
            null,
            $form->isSubmitted() ? 'info' : ('users' === $tab ? 'users' : 'info'),
            $originalName,
        );
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Company $company): Response
    {
        if (!$this->isCsrfTokenValid('delete-company-' . $company->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Jeton de sécurité invalide, veuillez réessayer.');

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId()]);
        }

        $userCount = $company->getUsers()->count();

        if ($userCount > 0) {
            $this->addFlash('error', sprintf(
                'La société « %s » ne peut pas être supprimée : elle compte encore %d utilisateur%s.',
                $company->getName(),
                $userCount,
                $userCount > 1 ? 's' : '',
            ));

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId()]);
        }

        $name = $company->getName();
        $this->em->remove($company);
        $this->em->flush();

        $this->addFlash('success', sprintf('La société « %s » a été supprimée.', $name));

        return $this->redirectToRoute('admin.company.index');
    }

    #[Route('/{id}/users/new', name: 'user.new', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function userNew(Request $request, Company $company): Response
    {
        $user = (new User())->setCompany($company);

        $form = $this->createForm(UserType::class, $user, ['password_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->hasher->hashPassword($user, (string) $form->get('plainPassword')->getData()));
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', sprintf('L\'utilisateur « %s » a été créé.', $user->getEmail()));

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId(), 'tab' => 'users']);
        }

        return $this->renderCompany($company, $this->createForm(CompanyType::class, $company), $form, null, 'users');
    }

    #[Route('/{id}/users/{userId}/edit', name: 'user.edit', requirements: ['id' => '\d+', 'userId' => '\d+'], methods: ['GET', 'POST'])]
    public function userEdit(
        Request $request,
        Company $company,
        #[MapEntity(id: 'userId')] User $user,
    ): Response {
        $this->denyUnlessMember($company, $user);

        $form = $this->createForm(UserType::class, $user, ['password_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = (string) $form->get('plainPassword')->getData();

            if ('' !== $plainPassword) {
                $user->setPassword($this->hasher->hashPassword($user, $plainPassword));
            }

            $this->em->flush();

            $this->addFlash('success', sprintf('L\'utilisateur « %s » a été modifié.', $user->getEmail()));

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId(), 'tab' => 'users']);
        }

        return $this->renderCompany($company, $this->createForm(CompanyType::class, $company), $form, $user, 'users');
    }

    #[Route('/{id}/users/{userId}/delete', name: 'user.delete', requirements: ['id' => '\d+', 'userId' => '\d+'], methods: ['POST'])]
    public function userDelete(
        Request $request,
        Company $company,
        #[MapEntity(id: 'userId')] User $user,
    ): Response {
        $this->denyUnlessMember($company, $user);

        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Jeton de sécurité invalide, veuillez réessayer.');

            return $this->redirectToRoute('admin.company.show', ['id' => $company->getId(), 'tab' => 'users']);
        }

        $email = $user->getEmail();
        $this->em->remove($user);
        $this->em->flush();

        $this->addFlash('success', sprintf('L\'utilisateur « %s » a été supprimé.', $email));

        return $this->redirectToRoute('admin.company.show', ['id' => $company->getId(), 'tab' => 'users']);
    }

    private function denyUnlessMember(Company $company, User $user): void
    {
        if ($user->isAdmin() || $user->getCompany()?->getId() !== $company->getId()) {
            throw $this->createNotFoundException();
        }
    }

    private function renderCompany(
        Company $company,
        FormInterface $companyForm,
        ?FormInterface $userForm,
        ?User $editedUser,
        string $tab,
        ?string $companyName = null,
    ): Response {
        return $this->render('admin/company/update.html.twig', [
            'company' => $company,
            'company_name' => $companyName ?? $company->getName(),
            'company_form' => $companyForm,
            'user_form' => $userForm,
            'edited_user' => $editedUser,
            'active_tab' => $tab,
        ]);
    }
}
