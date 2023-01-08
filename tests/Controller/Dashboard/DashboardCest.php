<?php


namespace App\Tests\Controller\Dashboard;

use App\Factory\VetoFactory;
use App\Tests\ControllerTester;

class DashboardCest
{
    public function seeDashboard(ControllerTester $I)
    {
        $vetoProxy = VetoFactory::createOne();
        $veto = $vetoProxy->object();

        $I->amLoggedInAs($veto);
        $I->amOnPage('/dashboard');
        $I->see('Mon Dashboard');
        $I->see('Créer mon planning');
    }

    

}
