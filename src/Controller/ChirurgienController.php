<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use App\Form\ChirurgienType;
use App\Repository\ChirurgienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chirurgien')]
final class ChirurgienController extends AbstractController {
    private const ROUTE_LIST = 'chirurgien_list';
    private const ROUTE_CREATE = 'chirurgien_create';
    private const ROUTE_UPDATE = 'chirurgien_update';
    private const ROUTE_DELETE = 'chirurgien_delete';
    private const ROUTE_SHOW = 'chirurgien_show';

    #[Route(name: self::ROUTE_LIST, methods: ['GET'])]
    public function index(ChirurgienRepository $chirurgienRepository): Response {
        return $this->render('chirurgien/index.html.twig', [
            'chirurgiens' => $chirurgienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $chirurgien = new Chirurgien();
        $form = $this->createForm(ChirurgienType::class, $chirurgien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chirurgien);
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chirurgien/new.html.twig', [
            'chirurgien' => $chirurgien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_SHOW, methods: ['GET'])]
    public function show(Chirurgien $chirurgien): Response {
        return $this->render('chirurgien/show.html.twig', [
            'chirurgien' => $chirurgien,
        ]);
    }

    #[Route('/{id}/edit', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function edit(Request $request, Chirurgien $chirurgien, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(ChirurgienType::class, $chirurgien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chirurgien/edit.html.twig', [
            'chirurgien' => $chirurgien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_DELETE, methods: ['POST'])]
    public function delete(Request $request, Chirurgien $chirurgien, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $chirurgien->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chirurgien);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
    }
}
