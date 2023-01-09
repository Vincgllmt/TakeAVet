# Take'A'Vet (SAE 3.01)

![Banner](Banner.png)

Application de gestion d'emploi du temps, de rendez-vous, d'animaux pour vétérinaire et clients en Symfony.

## Table des matières

<!-- TOC -->
* [Take'A'Vet (SAE 3.01)](#takea--vet--sae-301-)
    * [Table des matières](#table-des-matières)
    * [Les auteurs du projet](#les-auteurs-du-projet)
    * [Les outils](#les-outils)
    * [Pour commencer](#pour-commencer)
    * [Autres Commandes](#autres-commandes)
    * [Données](#données)
        * [Identifiants](#identifiants)
    * [Fonctionnalités](#fonctionnalités)
        * [Vétérinaire](#vétérinaire)
        * [Client](#client)
        * [Admin](#admin)
<!-- TOC -->
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
- EasyAdmin2
- Imagine
- FontAwesome

## Pour commencer

- Installation du projet
```shell
git clone https://iut-info.univ-reims.fr/gitlab/udyc0001/sae3-01.git ./takeavet
cd ./takeavet/
# Pour installer toutes les dépendances du projets
composer install 
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

## Fonctionnalités

- [X] Gestion automatisée de rendez-vous.
- [X] Gestion et affichage des plannings.
- [X] Foire aux questions pour utilisateur et vétérinaire
- [X] Gestion de vos animaux et de leurs vaccins.
- [ ] ...

### Vétérinaire
Si vous êtes connecté en tant que Vétérinaire vous pourrez créer des récapitulatifs des animaux, modifier votre planning etc...
### Client
En tant que client vous pouvez enregistrer vos animaux, voir leurs possible récapitulatifs, voir le planning des vétérinaires et prendre rendez vous.
### Admin
En tant qu'administrateur, vous avez accès au dashboard easyadmin, ce qui vous permet d'ajouter facilement des utilisateurs, des animaux et de supprimer des messages dans la foire aux questions, ainsi que de nombreuses autres possibilités.