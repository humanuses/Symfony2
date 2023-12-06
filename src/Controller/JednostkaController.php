<?php

namespace App\Controller;

use App\Entity\Jednostka;
use App\Form\JednostkaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JednostkaController extends AbstractController
{
    #[Route('admin/jednostka', name: 'app_jednostka')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {$sesion=$request->get('searchvalue');
        
        $u=$entityManager->getRepository(Jednostka::class)->findOneBY(['Nazwa_Jednostki' => $sesion]);
        if($sesion){
            if($u==null){
        $jednostka=new Jednostka();
        $form=$this->createForm(JednostkaType::class,$jednostka);
        $form->get('Nazwa_Jednostki')->setData($sesion);//
        }

        else
        {$jednostka=$u ;
            $form = $this->createForm(JednostkaType::class, $jednostka,['tryb'=>'edit']);
        }
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if($u==null)
            {
            $entityManager->persist($jednostka);
            $entityManager->flush(); 
            }
            else {
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_jednostka');}//rediret after add to entity
        return $this->render('jednostka/index.html.twig', [
            'controller_name' => 'JednostkaController',
            'JednostkaForm'=> $form->createView()
        ]);}
      
        return $this->render('jednostka/index.html.twig');
    }
}
