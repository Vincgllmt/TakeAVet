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


    public function testAddressEdit(ControllerTester $I)
    {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();

        $I->amLoggedInAs($client);
        $I->amOnPage('/address');
        $I->fillField('Nom', 'Maison');
        $I->fillField('Adresse', '1 rue de la paix');
        $I->fillField('Code Postal', '75000');
        $I->fillField('Ville', 'Paris');
        $I->click('Ajouter');
        $I->see('Maison');

        $I->click('Changer');
        $I->fillField('Nom', 'Voisin');
        $I->click('Modifier');
        $I->see("Edition de 'Voisin'");
    }

}
