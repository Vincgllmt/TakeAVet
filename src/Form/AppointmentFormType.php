<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\TypeAppointment;
use App\Entity\Veto;
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
                'choice_label' => function (Veto $veto) {
                    return $veto->getDisplayName();
                },
                'query_builder' => function (VetoRepository $vetoRepository) {
                    return $vetoRepository->createQueryBuilder('v')
                        ->where('v.agenda IS NOT NULL')
                        ->orderBy('v.lastName', 'ASC');
                },
            ])
            ->add('type', EntityType::class, [
                'class' => TypeAppointment::class,
                'choice_label' => function (TypeAppointment $typeAppointment) {
                    $durationInMin = $typeAppointment->getDuration();
                    $timeStr = sprintf('%02dh%02d', floor($durationInMin / 60), $durationInMin % 60);

                    return "{$typeAppointment->getLibTypeApp()} ($timeStr)";
                },
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'choice_label' => function (Address $address) {
                    return $address->getDisplayName();
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
