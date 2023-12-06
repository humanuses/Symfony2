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
    
    {$sesion=$request->get('tryb');
       $posiadanezasoby=$entityManager->getRepository(Zasoby::class)->findByExampleField(2,3);
      // dd($posiadanezasoby);
        $zasob=new Zasoby();
        $form=$this->createForm(ZasobyType::class,$zasob,['ses'=>$sesion]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zasob);
            $entityManager->flush();
            return $this->redirectToRoute('app_zasoby');}//rediret after add to entity
        return $this->render('zasoby/zasoby.html.twig', [
            'zasobyForm' => $form->createView(),
            'tryb'=>$sesion,
            'controller_name' => 'ZasobyController',
        ]);
    
    }
}
