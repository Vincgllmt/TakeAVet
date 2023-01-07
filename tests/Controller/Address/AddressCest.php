<?php


namespace App\Tests\Controller\Address;

use App\Factory\ClientFactory;
use App\Tests\ControllerTester;

class AddressCest
{

    public function testAddressList(ControllerTester $I)
    {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();
        $I->amLoggedInAs($client);
        $I->amOnPage('/address');
        $I->seeResponseCodeIs(200);
        $I->see('Mes adresses');
    }

}
