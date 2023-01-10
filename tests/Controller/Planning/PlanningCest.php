<?php


namespace App\Tests\Controller\Planning;

use App\Factory\ClientFactory;
use App\Factory\VetoFactory;
use App\Tests\ControllerTester;

class PlanningCest
{

    public function planningIndex(ControllerTester $I) {
        $I->amOnPage('/planning');
        $I->seeResponseCodeIs(200);
        $I->see('Liste des Plannings');
        $I->seeElement('header');
        $I->seeElement('footer');
        $I->seeElement('.main-content');
        $vetoProxy = VetoFactory::createOne();
        $veto = $vetoProxy->object();

        $I->amLoggedInAs($veto);
        $I->amOnPage('/planning/' . $vetoProxy->getId());
    }

}