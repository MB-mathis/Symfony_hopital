<?php

namespace App\Controller;

use App\Entity\DossierMedical;
use App\Form\DossierMedicalType;
use App\Repository\DossierMedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/dossier/medical')]
final class DossierMedicalController extends AbstractController {
    public const ROUTE_LIST = 'dossier_medical_list';
    public const ROUTE_CREATE = 'dossier_medical_create';
    public const ROUTE_UPDATE = 'dossier_medical_update';
    public const ROUTE_DELETE = 'dossier_medical_delete';
    public const ROUTE_SHOW = 'dossier_medical_show';

    #[Route(name: self::ROUTE_LIST, methods: ['GET'])]
    public function index(DossierMedicalRepository $dossierMedicalRepository): Response {
        return $this->render('dossier_medical/index.html.twig', [
            'dossier_medicals' => $dossierMedicalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $dossierMedical = new DossierMedical();
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossierMedical);
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier_medical/new.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_SHOW, methods: ['GET'])]
    public function show(DossierMedical $dossierMedical): Response {
        return $this->render('dossier_medical/show.html.twig', [
            'dossier_medical' => $dossierMedical,
        ]);
    }

    #[Route('/{id}/edit', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierMedical $dossierMedical, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(DossierMedicalType::class, $dossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dossier_medical/edit.html.twig', [
            'dossier_medical' => $dossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_DELETE, methods: ['POST'])]
    public function delete(Request $request, DossierMedical $dossierMedical, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $dossierMedical->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dossierMedical);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
    }
}
