<?php

namespace App\Form;

use App\Entity\Artykul;
use App\Entity\Jednostka;
use App\Entity\Magazyn;
use App\Entity\Zasoby;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ZasobyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    
    {$tryb =$options['ses'];
        
        if ($tryb != "edit") {

    
    
        $builder
            ->add('ilosc')
            ->add('vat')
            ->add('Cena_Jednostkowa')
            ->add('Wartosc_Podatku')
            ->add('Wartosc_Brutto')
           ->add('nazwa_artykulu', EntityType::class,
           ['label'=> 'Nazwa Artykulu',
           'class'=> Artykul::class,
            'choice_value'=>'id',
           'choice_label'=>'Nazwa_artykulu',
          
           'placeholder'=>'Wybierz Artykuł',
           
        ]);
    }
        $builder
        ->add('Jednostka_Miary',EntityType::class,
        ['label'=> 'Jednoskta rozliczenia',
        'class'=> Jednostka::class,
         'choice_value'=>'id',
        'choice_label'=>'Nazwa_Jednostki',
       
        'placeholder'=>'Wybierz Jednosktę',
        
        ])
          ->add('magazyn', EntityType::class,
           ['label'=> 'Nazwa magazynu',
           'class'=> Magazyn::class,
            'choice_value'=>'id',
           'choice_label'=>'Nazwa_magazynu',
          
           'placeholder'=>'Wybierz magazyn',
           
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zasoby::class,
            'ses'=>''
        ]);
    }
}
