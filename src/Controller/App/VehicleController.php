<?php

namespace App\Controller\App;

use App\Entity\Vehicle;
use App\Form\Vehicle\CreateVehicleType;
use App\Form\Vehicle\VehicleType;
use App\Manager\VehicleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MANAGER')]
#[Route('/app/vehicules', name: 'app.vehicle.')]
final class VehicleController extends AbstractController
{

    public function __construct(
        private readonly VehicleManager $vehicleManager,
    )
    {
    }

    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
    ): Response
    {
        $vehicle = new Vehicle();
        $createVehicleForm = $this->createForm(CreateVehicleType::class, $vehicle);
        $createVehicleForm->handleRequest($request);

        if ($createVehicleForm->isSubmitted() && $createVehicleForm->isValid()) {
            $vehicle = $this->vehicleManager->storeVehicle($vehicle);

            $this->addFlash('success', 'Véhicule ajouté');

            return $this->redirectToRoute('app.vehicle.update', ['id' => $vehicle->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicle/index.html.twig', [
            'form' => $createVehicleForm,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'update', methods: ['GET', 'POST'])]
    public function update(
        int $id,
        Request $request
    ): Response
    {
        $vehicle = $this->vehicleManager->getVehicle($id);

        $vehicleForm = $this->createForm(VehicleType::class, $vehicle);
        $vehicleForm->handleRequest($request);

        if ($vehicleForm->isSubmitted() && $vehicleForm->isValid()) {
            $this->vehicleManager->updateVehicle($vehicle);

            $this->addFlash('success', 'Véhicule mis à jour');

            return $this->redirectToRoute('app.vehicle.update', ['id' => $vehicle->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicle/update.html.twig', [
            'vehicle' => $vehicle,
            'form' => $vehicleForm,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    #[IsCsrfTokenValid(new Expression('"delete-vehicle-" ~ args["id"]'))]
    public function delete(
        int $id
    ): RedirectResponse
    {
        $this->vehicleManager->deleteVehicle($this->vehicleManager->getVehicle($id));
        $this->addFlash('success', 'Véhicule supprimé');

        return $this->redirectToRoute('app.vehicle.index', [], Response::HTTP_SEE_OTHER);
    }
}
