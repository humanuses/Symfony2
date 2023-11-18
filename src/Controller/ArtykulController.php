<?php

namespace App\Controller;

use App\Entity\Artykul;
use App\Form\ArtykulType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
class ArtykulController extends AbstractController
{
    #[Route('admin/artykul', name: 'app_artykul')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {$art=new Artykul();
        $form=$this->createForm(ArtykulType::class,$art);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($art);
            $entityManager->flush();
            return $this->redirectToRoute('app_zasoby');}//rediret after add to entity
        return $this->render('artykul/index.html.twig', [
            'controller_name' => 'ArtykulController',
            'ArtykulForm'=> $form->createView()
        ]);
    }
}
