<?php

namespace App\Controller;

use App\Entity\Donneur;
use App\Form\DonneurType;
use App\Repository\DonneurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\DonneurService;

#[Route('/donneur')]
final class DonneurController extends AbstractController {
    
    public const ROUTE_LIST = 'donneur_list';
    public const ROUTE_CREATE = 'donneur_create';
    public const ROUTE_UPDATE = 'donneur_update';
    public const ROUTE_DELETE = 'donneur_delete';
    public const ROUTE_SHOW = 'donneur_show';

    #[Route(name: self::ROUTE_LIST, methods: ['GET'])]
    public function index(DonneurRepository $donneurRepository): Response {
        return $this->render('donneur/index.html.twig', [
            'donneurs' => $donneurRepository->findAllDonneurs(),
        ]);
    }

    #[Route('/new', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function new(Request $request,
     DonneurService $donneurService
     ): Response {
        $donneur = new Donneur();
        $form = $this->createForm(DonneurType::class, $donneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            //  récupération des sous-forms
            $vivantData = $form->has('vivantData') ? $form->get('vivantData')->getData() : [];

            $decedeData = $form->has('decedeData') ? $form->get('decedeData')->getData() : [];

            //  payload commun (SANS JSON)
            $payload = [
                'groupeSanguin' => $data->getGroupeSanguin(),
                'sexe' => $data->getSexe(),
                'dateNaissance' => $data->getDateNaissance(),
                'taille' => $data->getTaille(),
                'poids' => $data->getPoids(),
                'numeroCrista' => $data->getNumeroCrista(),
            ];

            // délégation au service
            if ($data->getTypeDonneur()?->value === 'vivant') {

                $payload['data'] = [
                    'vivant' => $vivantData
                ];

                $donneurService->createDonneurVivant($payload);

            } elseif ($data->getTypeDonneur()?->value === 'decede') {

                $payload['data'] = [
                    'decede' => $decedeData
                ];

                $donneurService->createDonneurDecede($payload);
            }

            return $this->redirectToRoute(self::ROUTE_LIST);
        }

        return $this->render('donneur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: self::ROUTE_SHOW, methods: ['GET'])]
    public function show(Donneur $donneur): Response {
        return $this->render('donneur/show.html.twig', [
            'donneur' => $donneur,
        ]);
    }

    #[Route('/{id}/edit', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])] // mettre la securité du voter 
    public function edit(Request $request, Donneur $donneur, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(DonneurType::class, $donneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('donneur/edit.html.twig', [
            'donneur' => $donneur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_DELETE, methods: ['POST'])]
    public function delete(Request $request, Donneur $donneur, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $donneur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($donneur);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
    }
}
