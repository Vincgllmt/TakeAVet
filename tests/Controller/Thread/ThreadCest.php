<?php


namespace App\Tests\Controller\Thread;

use App\Tests\ControllerTester;

class ThreadCest
{
    public function testIndexForNoUser(ControllerTester $I): void
    {
        $I->amOnPage('/threads');
        $I->seeResponseCodeIs(200);
        $I->click('Ajouter une question ici');
        $I->seeCurrentUrlEquals('/login');
    }





}
