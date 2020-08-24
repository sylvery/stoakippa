<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('datetime', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'attr' => ['class' => 'form-control'],
            // ])
            ->add('saleitem', EntityType::class, [
                'row_attr' => ['class' => 'col-sm-8'],
                'attr' => ['class' => 'form-control'],
                'label' => false,
                'choice_value' => function($choice) {
                    return $choice;
                },
                'choice_label' => function($choice) {
                    return $choice->getName() . ' ' . $choice->getMeasurement() . $choice->getMeasurementunit() . ' K' . number_format($choice->getPrice()/100, 2);
                },
                'class' => Item::class,
            ])
            ->add('quantity', NumberType::class, [
                'row_attr' => ['class' => 'col-sm-4'],
                'attr' => ['class' => 'form-control'],
            ])
            // ->add('cost', NumberType::class, [
            //     'attr' => ['class' => 'form-control'],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
