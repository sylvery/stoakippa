<?php

namespace App\Form;

use App\Entity\Sale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('datetime', DateTimeType::class, [
            //     'widget' => 'single_text',
            //     'attr' => ['class' => 'form-control'],
            // ])
            ->add('transactions', CollectionType::class, [
                'entry_type' => TransactionSaleType::class,
                'entry_options' => [
                    'label'=> false,
                    'label_attr' => ['class' => 'd-none'],
                    'attr' => ['class' => 'row'],
                ],
                'allow_add' => true,
            ])
            // ->add('items', EntityType::class, [
            //     'class' => 'App\Entity\Item',
            //     'attr' => ['class' => 'form-control'],
            // ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $sale = $event->getData();
            $form = $event->getForm();
            $form->add('payment', NumberType::class, [
                'row_attr' => ['class' => 'col-8 input-group'],
                'label_attr' => ['class' => 'input-group-prepend input-group-text'],
                'label' => 'Tendered',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
