<?php


namespace App\Tests\Controller\Security;

use App\Factory\ClientFactory;
use App\Factory\VetoFactory;
use App\Tests\ControllerTester;
use http\Client;

class LoginCest
{

    public function loginForAdmin(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->click('Se connecter');
        $I->fillField('Email', 'admin@take.vet');
        $I->fillField('Mot de passe', 'admin');
        $I->click('Sign in');
        $I->see('Menu admin');
        $I->see('Déconnexion');
    }
}