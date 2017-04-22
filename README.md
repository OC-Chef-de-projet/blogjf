# blogjf
Blog pour Jean Forteroche (P3)

---
Ce projet est un début de framework MVC dans le cadre de ma formation "Chef de projet multimédia" avec Openclassrooms.

## Architecture
+ **Core** - Classes pour la gestion du MVC
+ **App** - Répertoire de l'application
    + **Config** - Fichiers de configuration
    + **Controller** - Classes des controleurs
    + **Model** - Classes des modèles
    + **View** - Fichier de rendu
    + **www** - Fichiers et répertoires web
+ **tests** - Tests unitaires

## Configuration
Dans le répertoire **App/Config** il y a deux fichiers de configuration **config.php.dist** et **database.php.dist** qui sont les modèles pour la configuration  de l'application.
Lors d'une première installation copier ces fichiers en **config.php** et **database.php**


### config.php
	<?php
	/*
	 * Configuration de l'application
	 */
	$config = [
		'episodeLimit' => 5, 			// Nombre de titre d'épisodes à afficher en une seule fois
		'maxDepth' => 3,			// Profondeur max des commentaires
		'salt' => '12345679ABCDeesc'	// Chaine de caratères pour la hachage des mots de passe
	];

### database.php
	<?php

	/*
	 * Accès à la base de données
	 */
	$database = [
			'host' => 'localhost', 				// URL du serveur Mysql
			'login' => 'user',					// Login
			'password' => 'usersecretpassword',	// Mot de passe
			'database' => 'blog'				// Nom de la base de données
	];






