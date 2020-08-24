<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('measurement', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'help_attr' => ['class' => 'text-muted small'],
                'help' => 'Speficy weight or volume in the simplest measurement standard'
                ])
            ->add('measurementunit', ChoiceType::class, [
                'choices' => [
                    'Gram' => 'g',
                    'Kilogram' => 'kg',
                    'MilliLitre' => 'ml',
                    'Litre' => 'l'
                ],
                'multiple' => false,
                'expanded' => true,
                'attr' => ['class' => 'form-control d-flex justify-content-between'],
                'help_attr' => ['class' => 'text-muted small'],
                'help' => 'Speficy the unit of measurement to measure the item with'
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'type' => 'number'
                ],
            ])
            // ->add('quantity', NumberType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'min' => 1,
            //         'type' => 'number'
            //     ],
            //     'required' => false,
            // ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\ItemCategory',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('manufacturer', EntityType::class, [
                'class' => 'App\Entity\ItemManufacturer',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
