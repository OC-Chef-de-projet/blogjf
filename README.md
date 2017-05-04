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

## Installation
Il est préférable de créer un utilisateur pour accéder à cette base de données plutot que d'utiliser l'utilisateur **root**. Dans la procédure suivante le nom de l'utilisateur est **user**.

+ Cloner ou téléchargez le projet.
```
$ git clone https://github.com/PierreSylvain/blogjf.git
```

+ Positionnez vous dans le répertoire de l'application, qui est par défaut **blogjs**
```
$ cd blogjf
```

+ Le script **install/schema.sql** permet de créér la base de données et les tables nécessaires.
```
$ mysql -uuser -p blog < install/schema.sql
```
+ Le script **install/data.sql** permet de charger la base de données avec des données fictives.
```
$ mysql -uuser -p blog < install/data.sql
```

+ Par défaut un administrateur est créé avec comme login **admin** mais sans mot de passe (il n'est pas possible de se connecter un login sans mot de passe)

+ Pour créer un mot de passe de l'administrateur
```
$ php -f install/setpasswd.php admin | mysql -uuser blog -p
```
+ En fin d'installation il est recommandé d'effacer le répertoire **install**.
 
### Configuration
Dans le répertoire **App/Config** il y a deux fichiers de configuration **config.php.dist** et **database.php.dist** qui sont les modèles pour la configuration  de l'application.
Lors d'une première installation copier ces fichiers en **config.php** et **database.php**

#### config.php
	<?php
	/**
         * Configuration de l'application
         *
         * PHP Version 5.6
         *
         * @category App
         * @package  App\Config
         * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
         * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
         * @link     https://blogjs.lignedemire.eu
         */
         $config = [
            // Nombre de titre d'épisodes à afficher en une seule fois
            'episodeLimit' => 5,
            // Profondeur max des commentaires
            'maxDepth' => 3,
            // Serveur SMTP pour envoyer les mails
            'SMTPServer' => 'smtp.gmail.com',
            // Login du serveur SMTP
            'SMTPUsername' => 'me@gmail.com',
            // Mot de passe pour le serveur SMTP
            'SMTPPassword' => 'VerySuperSecret',
            // Adresse email pour recevoir les notifications de signalement d'abus
            'email' => 'j.forteroche@gmail.com'
         ];

#### database.php
    <?php
    /**
     * Accès à la base de données
     *
     * PHP Version 5.6
     *
     * @category App
     * @package  App\Config
     * @author   Pierre-Sylvain Augereau <ps.augereau@gmail.com>
     * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
     * @link     https://blogjs.lignedemire.eu
     */
     $database = [
		'host' 		=> '127.0.0.1',
		'login' 	=> 'user',
		'password' 	=> 'usersecretpassword',
		'database' 	=> 'blog',
		'port'		=> 3306
     ];

Le champ **port** est optionnel. Si vous utilisez ce champ, il est nécessaire de mettre une adresse IP dans le champ **host**, sinon le port ne sera pris en compte. (voir http://stackoverflow.com/questions/21046672/pdo-not-working-with-port)



