<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    #[Route('/admin/panel', name: 'app_admin_panel')]
    public function index(): Response
    {
        return $this->render('admin_panel/admin_panel.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }
}
