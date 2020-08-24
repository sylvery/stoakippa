<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Transaction;
use App\Repository\ItemRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionSaleType extends AbstractType
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
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Item'
                ],
                'label' => false,
                'class' => Item::class,
                'required' => false,
                'choices' => $this->items,
                'choice_value' => function($choice) {
                    return $choice;
                },
                'choice_label' => function ($choice) {
                    return $choice->getName() . ' ' . $choice->getMeasurement() . $choice->getMeasurementunit() . ' K' . number_format($choice->getPrice()/100, 2);
                },
            ])
            ->add('quantity', NumberType::class, [
                'row_attr' => ['class' => 'col-sm-4'],
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '# of items'
                ],
            ])
            // ->add('cost', NumberType::class, [
            //     'attr' => ['class' => 'form-control'],
            // ])
        ;
    }
    // private items;
    public function __construct(ItemRepository $item)
    {
        $this->items = $item->findAll();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
