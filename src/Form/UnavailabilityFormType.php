<?php

namespace App\Form;

use App\Entity\Unavailability;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnavailabilityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $curYear = (int) date('Y');

        $builder
            ->add('lib', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('dateDeb', DateTimeType::class, [
                'required' => true,
                'label' => 'Date',
                'years' => range($curYear, $curYear + 10),
            ])
            ->add('dateEnd', DateTimeType::class, [
                'label' => 'Date de fin',
                'years' => range($curYear, $curYear + 10),
            ])
            ->add('isRepeated', CheckboxType::class, [
                'required' => false,
                'label' => 'Répétition de l\'absence, (dans ce cas c\'est le jour dans la semaine est pris en compte)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unavailability::class,
        ]);
    }
}
