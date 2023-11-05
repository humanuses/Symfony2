<?php

namespace App\Form;

use App\Entity\Magazyn;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('Przypisane_Magazyny', EntityType::class,
            ['label'=> 'Magazynows',
            'class'=> Magazyn::class,
        /* 'query_builder'=> function(EntityRepository $er){
                $query=$er->createQueryBuilder('r');
            
                return $query;
            },*/
            'choice_label'=>'nazwaMagazynu',
            'placeholder'=>'Zaznacz magazyny',
            'multiple'=>true,
            'expanded'=> true,
            'by_reference' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('surname')
            ->add('CRKP')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'USER' => 'ROLE_USER',
                 'ADMIN' => 'ROLE_ADMIN',
                    
                    
             ],
            ])
           /* -> add('roles', CheckboxType::class,[
                'label'    => 'ADMIN?',
                'required' => false,
                'data' => false,
            ]
            )*/
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
