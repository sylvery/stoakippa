<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('datetime', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'attr' => ['class' => 'form-control'],
            // ])
            ->add('item', EntityType::class, [
                 'class' => 'App\Entity\Item',
                // 'choices' => function(?Item $item) {
                //     return $item;
                // },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('quantity', NumberType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('cost', NumberType::class, [
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
