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
    {$sesion=$request->get('searchvalue');
        
        //$u=$entityManager->getRepository(Artykul::class)->findOneBY(['Nazwa_artykulu' => $sesion]);
        $u=$entityManager->getRepository(Artykul::class)->findOneBySomeField($sesion);
        
        if($sesion){
            dd($u);
            if($u==null){
        $art=new Artykul();
        $form=$this->createForm(ArtykulType::class,$art,['tryb'=>'add']);
        $form->get('nazwa_artykulu')->setData($sesion);
        $tryb="add";
        }

        else
        {$art=$u ;
            $form = $this->createForm(ArtykulType::class, $art,['tryb'=>'edit']);
            $tryb="edit";
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($u==null)
            {
            $entityManager->persist($art);
            $entityManager->flush(); 
            }
            else {
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_zasoby');
        }//rediret after add to entity
        return $this->render('artykul/index.html.twig', [
            'controller_name' => 'ArtykulController',
            'tryb'=>$tryb,
            'ArtykulForm'=> $form->createView()
        ]);}
        return $this->render('artykul/index.html.twig' );
    }
}
