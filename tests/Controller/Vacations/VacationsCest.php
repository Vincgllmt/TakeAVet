<?php


namespace App\Tests\Controller\Vacations;

use App\Factory\ClientFactory;
use App\Tests\ControllerTester;

class VacationsCest
{
    public function normalUserCannotAccessToVacations(ControllerTester $I) {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();
        $I->amLoggedInAs($client);
        $I->amOnPage('vacation/2/delete');
        $I->seeResponseCodeIs(403);
    }

}
