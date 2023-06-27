<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productId', ChoiceType::class, [
                'label' => 'Please select a fund',
                'choices' => [
                    'Please choose' => null,
                    'Cushon Equities Fund' => 1,
                    'ISA Fund 2' => 2,
                ],
            ])
            ->add('amount', IntegerType::class, [
                'label' => 'Lump sum',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create your account',
            ]);
    }
}
