# Take'A'Vet (SAE 3.01)

![Banner](Banner.png)

Application de gestion d'emploi du temps, de rendez-vous, d'animaux pour vétérinaire et clients en Symfony.

## Les auteurs du projet

- Alexis Udycz
- Vincent Guillemot
- Clément Perrot
- Romain Leroy
- Benoit Soulière

## Les outils

- Symfony
- PhpCsFixer
- Codeception
- Zenstruck/foundry
- EasyAdmin
- Orm-fixtures

## Commandes

- "Getting Started"
```shell
git clone https://iut-info.univ-reims.fr/gitlab/udyc0001/sae3-01.git ./takeavet
cd ./takeavet/
composer install # to install all deps
```

- Lancer le projet sur une machine linux :
```shell
composer start
```
- Lancer le projet sur une machine windows :
```shell
symfony serve
```
- Vérifier le code avec l'outil Cs Fixer :
````shell
composer test:cs
````

- Corriger le code avec l'outil Cs Fixer :
````shell
composer fix:cs
````

- Générer des données factices :
````shell
composer db
````

- Générer tous les tests :
````shell
composer test
````

- Identifiants pour la fixture :
````shell
admin@take.vet
admin
````