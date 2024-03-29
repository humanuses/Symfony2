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
    {$sesion=$request->get('searchvalue');
        
        $u=$entityManager->getRepository(Magazyn::class)->findOneBY(['Nazwa_Magazynu' => $sesion]);

        // dd($u);
        if($sesion){
            if($u==null){
        $magazyn=new Magazyn();
        $form=$this->createForm(MagazynType::class,$magazyn,['tryb'=>'add']);
        $form->get('Nazwa_Magazynu')->setData($sesion);
            }
            else
            {
                $magazyn=$u ;
            $form = $this->createForm(MagazynType::class, $magazyn,['tryb'=>'edit']);
            }
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($u==null)
            {
            $entityManager->persist($magazyn);
            $entityManager->flush();
            $this->addFlash('success', 'Magazyn dodany');
        }
            else{
                $entityManager->flush();
                $this->addFlash('success', 'Zmiany zapisano');
            }
           return $this->redirectToRoute('app_admin_panel');
        }
        return $this->render('magazyn/index.html.twig', [
            'controller_name' => 'MagazynController',
           'tryb'=>'edit',
            'magazynform'=>$form->createView()
        ]);}
        return $this->render('magazyn/index.html.twig');
    }
}
