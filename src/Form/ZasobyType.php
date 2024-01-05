<?php

namespace App\Form;

use App\Entity\Artykul;
use App\Entity\Magazyn;
use App\Entity\Zasoby;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Choice;

class ZasobyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    
    {$tryb =$options['ses'];
     $choices=$options['mag'];
     $artid=$options['artid'];
    //    $choiceList =  ChoiceList:: $choices;
  //dd($artid[0]->getid());
       
        if ($tryb == "new" ) {

    
        

        $builder
        ->add('numer_artykulu', TextType::class,
        ['label'=>'Numer Artykułu',
        "data"=> $artid->getid(),
        "disabled" => true,

        'mapped'=> false,
       ])
            ->add('vat',ChoiceType::class,[
                'choices'  => [
                    '23 %' => 23,                    
                    '8 %' => 8, 
                    '5 %' => 5,             
                              ],'label'=> 'VAT',

                ])
                
            ->add('Cena_Jednostkowa')
            // ->add('Wartosc_Podatku')
            // ->add('Wartosc_Brutto',)
            ->add('nazwa_artykulu', TextType::class,
            ['label'=>'Nazwa Artykułu',
            "data"=> $artid->getNazwaArtykulu(),
            "disabled" => true,
 
            
        ])
        //     ->add('Jednostka_Miary', TextType::class,// pobrac  z id
        //     ['label'=>'Jednoskta rozliczenia',
        //     "data"=> $artid->getJednostkaRozliczenia()->getnazwajednostki(),
        //     "disabled" => true,
 
            
        //    ]);
    
    // }

    // if ($tryb !="out" && $tryb != null) {
      
    //         $builder
              ->add('magazyn', ChoiceType::class ,
          [
            'choices' =>$choices,
            'choice_value'=>'id',
          'choice_label'=>    function (?magazyn $magazyn): string {
            return $magazyn ? $magazyn->getNazwaMagazynu() : '';},
                ]
               )

          ;
        }
        if ($tryb != null) {
            $builder
            ->add('ilosc',null,['label'=>"Ilość"]);
        }

   }
        
   
      
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zasoby::class,
            'ses'=>'','mag'=>"","zasob"=>'','artid'=>''
        ]);
    }
}
