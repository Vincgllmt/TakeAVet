<?php

namespace App\Form;

use App\Entity\Agenda;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timeStart', TimeType::class, [
                'mapped' => false,
                'label' => 'Heure de début de votre journée',
            ])
            ->add('timeStop', TimeType::class, [
                'mapped' => false,
                'label' => 'Heure de fin de votre journée',
            ])
            ->add('weekend', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Prendre aussi le weekend ?',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agenda::class,
        ]);
    }
}
