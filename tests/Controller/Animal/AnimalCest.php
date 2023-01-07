<?php


namespace App\Tests\Controller\Animal;

use App\DataFixtures\AnimalFixtures;
use App\Factory\AnimalFactory;
use App\Factory\ClientFactory;
use App\Tests\ControllerTester;
use DateTimeZone;

class AnimalCest
{

    public function TestAnimalAdded(ControllerTester $I) {
        $clientProxy = ClientFactory::createOne();
        $client = $clientProxy->object();

        $I->amLoggedInAs($client);
        AnimalFactory::createMany(2);

        $I->amOnPage('/animal');
        $I->click('Ajouter un nouvel animal');
        $I->seeCurrentUrlEquals('/animal/create');
        $I->fillField('Nom', 'Alphonse');
        $I->selectOption('animal[birthday][day]', '12');
        $I->selectOption('animal[birthday][month]', 'août');
        $I->selectOption('animal[birthday][year]', '1989');
        $I->click('créer');
        $I->seeCurrentUrlEquals('/animal');
        $I->click('Supprimer cet animal');
        // $I->seeCurrentUrlEquals('/animal/'.$client->getId().'/delete');
        $I->see('Suppression de Alphonse');
        $I->click('Oui, supprimer cet animal');
        $I->seeCurrentUrlEquals('/animal');
        $I->dontSee('Alphonse');
    }

}
