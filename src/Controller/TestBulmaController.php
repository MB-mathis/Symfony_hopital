<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestBulmaController extends AbstractController {
    #[Route('/test/bulma', name: 'app_test_bulma')]
    public function index(): Response {
        return $this->render('test_bulma/index.html.twig', [
            'controller_name' => 'TestBulmaController',
        ]);
    }
}
