<?php

namespace App\Form;

use App\Entity\Veto;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormVetoType extends RegistrationFormUserType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veto::class,
        ]);
    }
}
