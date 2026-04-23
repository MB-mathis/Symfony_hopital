<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
final class UserController extends AbstractController {
    
    public const ROUTE_LIST = 'user_list';
    public const ROUTE_CREATE = 'user_create';
    public const ROUTE_SHOW = 'user_show';
    public const ROUTE_UPDATE = 'user_update';
    public const ROUTE_DELETE = 'user_delete';

    #[Route(name: self::ROUTE_LIST, methods: ['GET'])]
    public function index(UserRepository $userRepository): Response {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserService $userService
        ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var string $plainPassword 
             * hash the password
            */
            $plainPassword = $form->get('plainPassword')->getData();
            $userService->hashPassword($user, $plainPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_SHOW, methods: ['GET'])]
    public function show(User $user): Response {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: self::ROUTE_DELETE, methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
    }
}
