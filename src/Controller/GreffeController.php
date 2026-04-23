<?php

namespace App\Controller;

use App\Entity\Greffe;
use App\Form\GreffeType;
use App\Repository\GreffeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\DossierMedical;
use App\Service\GreffeService;


#[Route('/greffe')]
final class GreffeController extends AbstractController {
    #[Route(name: 'app_greffe_index', methods: ['GET'])]
    public function index(GreffeRepository $greffeRepository): Response {
        return $this->render('greffe/index.html.twig', [
            'greffes' => $greffeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_greffe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $greffe = new Greffe();
        $form = $this->createForm(GreffeType::class, $greffe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($greffe);
            $entityManager->flush();

            return $this->redirectToRoute('app_greffe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('greffe/new.html.twig', [
            'greffe' => $greffe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_greffe_show', methods: ['GET'])]
    public function show(Greffe $greffe): Response {
        return $this->render('greffe/show.html.twig', [
            'greffe' => $greffe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_greffe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Greffe $greffe, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(GreffeType::class, $greffe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_greffe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('greffe/edit.html.twig', [
            'greffe' => $greffe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_greffe_delete', methods: ['POST'])]
    public function delete(Request $request, Greffe $greffe, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $greffe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($greffe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_greffe_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dossier/{id}/greffes', name: 'app_dossier_greffes', methods: ['GET'])]
    public function listGreffes(DossierMedical $dossier, GreffeService $greffeService): Response
    {
        $greffes = $greffeService->getGreffesByDossierWithFilters($dossier);

        return $this->render('greffe/by_dossier.html.twig', [
            'dossier' => $dossier,
            'greffes' => $greffes,
        ]);
    }
}
