<?php


namespace App\Tests\Controller\Unavailability;

use App\Factory\ClientFactory;
use App\Tests\ControllerTester;

class UnavailabilityCest
{
    public function testDeleteUnavailabilityForClient(ControllerTester $I): void
    {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();

        $I->amLoggedInAs($client);
        $I->amOnPage('/unavailability/1/delete');
        $I->seeResponseCodeIs(403);
    }




}
