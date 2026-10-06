<?php

declare(strict_types=1);

namespace App\Controller\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/app')]
class AppController extends AbstractController
{
    #[Route('/', 'app.index')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig');
    }
}
