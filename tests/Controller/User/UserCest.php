<?php


namespace App\Tests\Controller\User;

use App\Factory\ClientFactory;
use App\Tests\ControllerTester;

class UserCest
{
    public function notUserRedirectionOnLogin(ControllerTester $I) {
        $I->amOnPage('/me');
        $I->seeCurrentUrlEquals('/login');
    }

    public function userCanAccessToMe(ControllerTester $I) {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();

        $I->amLoggedInAs($client);
        $I->amOnPage('/me');
        $I->seeCurrentUrlEquals('/me');
        $I->seeResponseCodeIs(200);
    }
}
