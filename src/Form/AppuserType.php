<?php

namespace App\Form;

use App\Entity\Appuser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AppuserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'help' => 'Username',
                'help_attr' => [
                    'class' => 'text-muted small'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone Number',
                'help' => 'Phone Number',
                'help_attr' => [
                    'class' => 'text-muted small'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'number'
                ]
            ])
            ->add('password', TextType::class, [
                'label' => 'Password',
                'help' => 'Password',
                'help_attr' => [
                    'class' => 'text-muted small'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'password'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'OWNER' => 'ROLE_OWNER',
                    'ACCOUNTANT' => 'ROLE_ACCOUNTANT',
                    'CASHIER' => 'ROLE_CASHIER',
                ],
                'choice_attr' => function(){
                    return ['class' => 'form-check-input col-1'];
                },
                'expanded' => true,
                'multiple' => true,
                'help' => 'User Roles & Previledges',
                'help_attr' => [
                    'class' => 'text-muted small'
                ],
                'label_attr' => [
                    'class' => 'sr-only',
                ],
                'attr' => [
                    'class' => 'form-group form-check form-control d-flex justify-content-around mb-0'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appuser::class,
        ]);
    }
}
