<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('admin/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {$sesion=$request->get('searchvalue');
        $u=$entityManager->getRepository(User::class)->findOneBY(['crkp' => $sesion]);
       //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
       if($sesion){
        if($u==null){
         $user = new User();
         $form = $this->createForm(RegistrationFormType::class, $user,['tryb'=>'add']);
         $form->get('CRKP')->setData($sesion);
        } else
        {$user=$u ;
        $form = $this->createForm(RegistrationFormType::class, $user,['tryb'=>'edit']);}
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
           // dd($u);
            if($u==null)
                {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
               # $user->setRoles(['ROLE_ADMIN']);
               $user->setCrkp($form->get('CRKP')->getData());
                $entityManager->persist($user);
                $entityManager->flush();
                }
            else{
                    $entityManager->flush();
                }
           
           
            // encode the plain password
         //   $u = $entityManager->getRepository(User::class)->findOneBy(['crkp' => $form->get('CRKP')->getData()]);
       
           
}
          //  return $this->redirectToRoute('app_login');
      

        return $this->render('registration/register.html.twig', [
           'registrationForm' => $form->createView(),
        ]);}
        return $this->render('registration/register.html.twig'); 
        
    }
    // #[Route('admin/useredit' ,name: 'app_useredit') ]
    // public function index2(Request $request, EntityManagerInterface $entityManager):Response
    // { $sesion=$request->get('user');
    //     $user =  $entityManager->getRepository(User::class)->findOneBY(['crkp' => $sesion]);
    //     $form = $this->createForm(RegistrationFormType::class, $user,['tryb'=>'edit']);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
           
           
    //       //  $entityManager->persist($user);
    //         $entityManager->flush();
           

    //         return $this->redirectToRoute('app_admin_panel');
    //     }

    //     return $this->render('registration/useredit.html.twig',[
    //         'u'=>$sesion,
    //        'registrationForm' => $form->createView(),
           
    //     ]);
    // }
}
