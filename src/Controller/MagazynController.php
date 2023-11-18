<?php

namespace App\Controller;

use App\Entity\Magazyn;
use App\Form\MagazynType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
class MagazynController extends AbstractController
{
    #[Route('admin/magazyn', name: 'app_magazyn')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {$magazyn=new Magazyn();
        $form=$this->createForm(MagazynType::class,$magazyn);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($magazyn);
            $entityManager->flush();
            return $this->redirectToRoute('app_zasoby');}
        return $this->render('magazyn/index.html.twig', [
            'controller_name' => 'MagazynController',
            'magazynform'=>$form->createView()
        ]);
    }
}
