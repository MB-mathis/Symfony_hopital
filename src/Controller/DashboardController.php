<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\DashboardService;

final class DashboardController extends AbstractController {
    
    public const ROUTE_INDEX = 'dashboard_index';

    #[Route('/dashboard', name: self::ROUTE_INDEX)]
   public function index(DashboardService $dashboardService): Response
    {
        $data = $dashboardService->getDashboardData();

        return $this->render('dashboard/index.html.twig', [
            'data' => $data,
        ]);
    }
}
