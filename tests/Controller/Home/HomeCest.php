<?php

namespace App\Tests\Controller\Home;

use App\Factory\ClientFactory;
use App\Tests\ControllerTester;

class HomeCest
{

    public function indexHome(ControllerTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->see("Bienvenue sur Take'A'Vet");
        $I->seeElement('header');
        $I->seeElement('footer');
        $I->seeElement('.main-content');
    }

}
