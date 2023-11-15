<?php

namespace App\Controller;

use App\Entity\Zasoby;
use App\Form\ZasobyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ZasobyController extends AbstractController
{
    #[Route('/zasoby', name: 'app_zasoby')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    
    {$zasob=new Zasoby();
        $form=$this->createForm(ZasobyType::class,$zasob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zasob);
            $entityManager->flush();
            return $this->redirectToRoute('app_zasoby');}//rediret after add to entity
        return $this->render('zasoby/zasoby.html.twig', [
            'zasobyForm' => $form->createView(),
            'controller_name' => 'ZasobyController',
        ]);
    
    }
}
