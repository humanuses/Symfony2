<?php

namespace App\Form;

use App\Entity\Magazyn;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MagazynType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {$tryb =$options['tryb'];
        $builder
            ->add('Nazwa_Magazynu')
            ->add('users', EntityType::class,
            ['label'=> 'Użytkownicy',
            'class'=> User::class,

            'choice_label'=>'username',
            'placeholder'=>'Zaznacz magazyny',
            'multiple'=>true,
            'expanded'=> true,
            'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Magazyn::class,
            'tryb'=>''
        ]);
    }
}
