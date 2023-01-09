<?php

namespace App\Form;

use App\Entity\Vaccine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class VaccineFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Exemple: Pfizer',
                ],
            ])
            ->add('dateNext', \DateTimeInterface::class, [
                    'label' => 'Date prochain vaccin',
                    'attr' => [
                        'placeholder' => 'Exemple: 01/01/2024',
                    ],
                ]
            )
            ->add('dateCurrent', \DateTimeInterface::class, [
                    'label' => 'Date actuelle vaccin',
                    'attr' => [
                        'placeholder' => 'Date à laquelle le vaccin a été fait',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccine::class,
        ]);
    }
}
