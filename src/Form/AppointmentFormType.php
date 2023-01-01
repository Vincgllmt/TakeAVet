<?php

namespace App\Form;

use App\Entity\Veto;
use App\Repository\UserRepository;
use App\Repository\VetoRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('vet', EntityType::class, [
                'class' => Veto::class,
                'choice_label' => function (Veto $vetoRepository) {
                    return $vetoRepository->getDisplayName();
                },
                'query_builder' => function (VetoRepository $vetoRepository) {
                    return $vetoRepository->createQueryBuilder('v')
                        ->where('v.agenda IS NOT NULL')
                        ->orderBy('v.agenda', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
