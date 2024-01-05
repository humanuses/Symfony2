<?php

namespace App\Controller;

use App\Entity\Artykul;
use App\Entity\Magazyn;
use App\Entity\User;
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
      $sesion1=$request->get('searchvalue');
      $artid= null;
        $userid=$this->getUser()->getUserIdentifier();   
        $magazynyusera=$entityManager->getRepository(Magazyn::class)->findByExampleField($userid);

        if($sesion1)
          { 
            $artid=$entityManager->getRepository(Artykul::class)->find($sesion1);
        $posiadanezasoby=$entityManager->getRepository(Zasoby::class)->findByExampleField($sesion1);
        if( $posiadanezasoby == null){$n="new";   
        } else {$n="edit";}
           }
        else {$posiadanezasoby=$entityManager->getRepository(Zasoby::class)->findAll(); $n="";}
            
        return $this->render('zasoby/zasoby.html.twig', [
            // 'zasobyForm' => $form->createView(),
            'tryb'=>$posiadanezasoby,
            'mag'=>$magazynyusera,
            'ses'=> $sesion1,'artid'=>$artid,
                    'controller_name' => 'ZasobyController',
        ]);
    
    }

    
    #[Route('admin/zasoby',name: 'app_adminzasoby')]
    public function index1(Request $request,EntityManagerInterface $entityManager): Response
    { $sesion1=$request->get('searchvalue');
      $magazynyusera=$entityManager->getRepository(Magazyn::class)->findAll();
      $posiadanezasoby=$entityManager->getRepository(Zasoby::class)->findAll();
      if($sesion1){
        $posiadanezasoby=$entityManager->getRepository(Zasoby::class)->findByExampleField($sesion1);
        }//dd($posiadanezasoby);
        return $this->render('zasoby/adminzasoby.html.twig', [
          // 'zasobyForm' => $form->createView(),
          'tryb'=>$posiadanezasoby,
          'mag'=>$magazynyusera,
         
                  'controller_name' => 'AdminZasobyController',
      ]);
    }

    
    #[Route('/zasoby/out',name: 'app_zasoby_out')]
    public function index2(Request $request,EntityManagerInterface $entityManager): Response
    {         $userid=$this->getUser()->getUserIdentifier();   
      $zasobid=$request->get('id');
      $magazynyusera=$entityManager->getRepository(Magazyn::class)->findByExampleField($userid);
      $zasob=$entityManager->getRepository(Zasoby::class)->find($zasobid);
             $form=$this->createForm(ZasobyType::class,null,['mag'=>$magazynyusera,'ses'=>'out',]);//,
        
             $form->handleRequest($request);
   
      if ($form->isSubmitted() && $form->isValid()) 
      {

        if(($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2)) > 0)
        {
          $zasob->setIlosc($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2));
          $ilosc=$form->get('ilosc')->getdata();
          $wartoscpodatku=round($ilosc*round($zasob->getvat()/100*$zasob->getCenaJednostkowa(),2),2);
          $zasob ->setWartoscPodatku($zasob->getWartoscPodatku()-$wartoscpodatku);
          $zasob-> setWartoscBrutto($zasob->getWartoscBrutto()-(round($zasob->getCenaJednostkowa()*$ilosc+$wartoscpodatku,2)));////dokończyć
         
          
          $entityManager->flush();

          return $this->redirectToRoute('app_zasoby');
        }
          elseif(($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2)) < 0)
          {
             $this->addFlash('error', 'NIE MASZ WYSTARCZAJĄCEJ ILOŚCI ATKYKUŁU DO WYDANIA');
          }
          elseif (($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2)) == 0)
          {
            $entityManager->getRepository(Zasoby::class)->remove($zasob,true);
            return $this->redirectToRoute('app_zasoby');
          }
        }
      return $this->render('zasoby/zasobyout.html.twig', [
               'zasobyForm' => $form->createView(),
        // 'tryb'=>$posiadanezasoby,
        // 'mag'=>$magazynyusera,
        "zasob"=>$zasob,
        'controller_name' => 'Zasoby OUT Controller',
      ]);
    }


    #[Route('/zasoby/in',name: 'app_zasoby_in')]
    public function index3(Request $request,EntityManagerInterface $entityManager): Response
    {         $userid=$this->getUser()->getUserIdentifier();   
      $zasobid=$request->get('id');
      $zasob=$entityManager->getRepository(Zasoby::class)->find($zasobid);
      $magazynyusera=$entityManager->getRepository(Magazyn::class)->findByExampleField($userid);
     // $zasob=new Zasoby();
             $form=$this->createForm(ZasobyType::class,null,['mag'=>$magazynyusera,'ses'=>'in']);//,
      $form->handleRequest($request);
    
      if ($form->isSubmitted() && $form->isValid()) {
      //  $zasob->setJednostkaMiary(1);//wczytać jednostke z artykułu po id
      $zasob->setIlosc($zasob->getIlosc() + round($form->get('ilosc')->getdata(),2));
      $ilosc=$form->get('ilosc')->getdata();
      $wartoscpodatku=round($ilosc*round($zasob->getvat()/100*$zasob->getCenaJednostkowa(),2),2);
      $zasob ->setWartoscPodatku($zasob->getWartoscPodatku()+$wartoscpodatku);
      $zasob-> setWartoscBrutto($zasob->getWartoscBrutto()+(round($zasob->getCenaJednostkowa()*$ilosc+$wartoscpodatku,2)));////dokończyć
     
          // $entityManager->persist($zasob);
          $entityManager->flush();
          return $this->redirectToRoute('app_zasoby');}
      return $this->render('zasoby/zasobyin.html.twig', [
               'zasobyForm' => $form->createView(),
        // 'tryb'=>$posiadanezasoby,
        // 'mag'=>$magazynyusera,
        'controller_name' => 'Zasoby IN Controller',
      ]);
    }


    #[Route('/zasoby/new',name: 'app_zasoby_new')]
    public function index4(Request $request,EntityManagerInterface $entityManager): Response
    {         $userid=$this->getUser()->getUserIdentifier(); 
      $sesion1=$request->get('searchvalue');   
     $zasobid=$request->get($sesion1);
      $magazynyusera=$entityManager->getRepository(Magazyn::class)->findByExampleField($userid);
      $zasob=$entityManager->getRepository(Zasoby::class)->find($sesion1);
      $artid=$entityManager->getRepository(Artykul::class)->find($sesion1);
      //dd($artid->getJednostkaRozliczenia()->getid());
      $zasobn=new Zasoby();
             $form=$this->createForm(ZasobyType::class,$zasobn,['mag'=>$magazynyusera,'ses'=>'new','artid'=> $artid,]);//,
      $form->handleRequest($request);
      $zasobn->setNazwaArtykulu($artid);
      $zasobn->setJednostkaMiary($artid->getJednostkaRozliczenia());
      $wartośćpodatku=round((($form->get('vat')->getData()/100)*$form->get('Cena_Jednostkowa')->getdata()),2)*$form->get('ilosc')->getdata();
      $zasobn->setWartoscPodatku($wartośćpodatku);
      $zasobn->setWartoscBrutto(round($form->get('Cena_Jednostkowa')->getdata(),2)*$form->get('ilosc')->getdata()+$wartośćpodatku);
      if ($form->isSubmitted() && $form->isValid()) {
       
        // if(($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2)) >= 0){
        //   $zasob->setIlosc($zasob->getIlosc() - round($form->get('ilosc')->getdata(),2));
          $entityManager->persist($zasobn);
          $entityManager->flush();
          return $this->redirectToRoute('app_zasoby');
        // }else{ $this->addFlash('error', 'SPRAWDZ WSZYSTKO JESZCZE RAZ');}
      }
      return $this->render('zasoby/zasobynew.html.twig', [
               'zasobyForm' => $form->createView(),
        // 'tryb'=>$posiadanezasoby,
        // 'mag'=>$magazynyusera,
        "zasob"=>$zasob,"artid"=>$artid,
        'controller_name' => 'Zasoby NEW Controller',
      ]);
    }
}

