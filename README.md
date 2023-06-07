# Code-source---TPI
Projet TPI, Site de gestion de prêt entre voisins 
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Auteur : Anthony Pfister 
Date : 07.06.2023
Description : Fichier d'instruction pour l'installation du site "Gestion de prêt entre voisins" sur un serveur local

Prérequis : 

Serveur UwAmp: 3.1.0 
Version php : 8.2.6
MySQL : 5.7.11
PHPMyAdmin : 5.2.1
Selenium IDE pour chrome: 3.17.2
Liens pour téléchargement : 
- https://www.uwamp.com/fr/
- https://windows.php.net/download#php-8.2
- https://dev.mysql.com/downloads/mysql/5.7.html
- https://www.phpmyadmin.net/downloads/
- https://chrome.google.com/webstore/detail/selenium-ide/mooikfkahbdckldjjndioackbalphokd

importation des utilisateurs pour la base de données :

- Copier la requête SQL qui se trouve dans le fichier "User.txt" dans le dossier DB.
- Coller et executer la requête dans le localhost dans PHPMyAdmin.

Importation de la base de données :

- Aller dans "nouvelle base de données" dans PHPMyAdmin et cliqué sur l'onglet importation.
- Selectionné le fichier "db_gestionpretvoisins.sql", puis executer l'importation.

Importation du code source du site Web :

- Copier l'entièreté des fichier du code source du site dans le dossier "www" du serveur local Uwamp

Importation des tests automatisé avec Selenium IDE :

- Choisir le projet de "Tests de fonctionnalitées" dans l'extension.
- Activer l'autorisation du téléchargement des fichier dans les paramètres de l'extension.
- Modifier le chemin absolue du téléchargement des images des tests automatiques "ajout article" et "modifier article" par le nouveau chemin absolue de votre pc pour le fichier "Dépot image"  .

