<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class SecurityController extends AbstractController
{
    /**
     * json_login vérifie les identifiants AVANT d'arriver ici.
     * On n'y entre donc qu'en cas de succès (ou si la requête n'est pas du JSON).
     */
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json(['message' => 'Requête invalide : JSON attendu.'], Response::HTTP_BAD_REQUEST);
        }

        // La preuve de connexion, c'est le cookie de session : rien à renvoyer
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Seule source de vérité sur l'utilisateur connecté.
     * Vue l'appelle après le login et à chaque chargement de l'appli.
     */
    #[Route('/api/me', name: 'app_api_me', methods: ['GET'])]
    public function me(#[CurrentUser] User $user): JsonResponse
    {
        return $this->json($user, context: ['groups' => ['user:me']]);
    }

    /**
     * Jamais exécutée : le firewall intercepte la route avant.
     */
    #[Route('/api/logout', name: 'app_api_logout', methods: ['POST'])]
    public function logout(): never
    {
        throw new \LogicException('Intercepté par le firewall.');
    }
}