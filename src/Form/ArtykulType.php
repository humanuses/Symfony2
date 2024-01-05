<?php

namespace App\Form;

use App\Entity\Artykul;
use App\Entity\Jednostka;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArtykulType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {$tryb =$options['tryb'];
      //  dd($tryb);
        if ($tryb == "add") {
        $builder
            ->add('nazwa_artykulu', null,['label'=> 'Nazwa artykułu',])
            ->add('Jednostka_Rozliczenia', EntityType::class,
            ['label'=> 'Jednoskta rozliczenia',
            'class'=> Jednostka::class,
             'choice_value'=>'id',
            'choice_label'=>'Nazwa_Jednostki',
           
            'placeholder'=>'Wybierz Jednosktę',
            
        ]);}
            else{
        $builder
        ->add('nazwa_artykulu', null,['label'=> 'Nazwa artykułu',])        ;}
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artykul::class,
            'tryb'=>'',
        ]);
    }
}
