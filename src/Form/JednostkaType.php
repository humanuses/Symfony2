<?php

namespace App\Form;

use App\Entity\Jednostka;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JednostkaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nazwa_Jednostki',null,["label"=> 'Nazwa jednostki'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jednostka::class,
            'tryb'=>'',
        ]);
    }
}
