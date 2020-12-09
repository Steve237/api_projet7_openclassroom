Web service exposing an API

Téléchargez ce projet ou clonez-le (Git clone)*

##Prérequis
+ PHP 7.2
+ MySQL
+ Symfony 4
+PostMan

##Installation
Pour installer le projet, vous devez le cloner ou le télécharger, puis l'ouvrir via votre éditeur de texte. 
Pour le faire tourner sur votre machine en local, vous pouvez
installer MAMP (ou WAMP pour Windows, ou LAMP pour Linux).

1. Vous devez ensuite importer le fichier sql contenant les données du projet dans votre base de données. 
Il s'agit du fichier api7.sql que vous trouverez dans le dossier public à la racine du projet.

2. Ensuite, configurez la connexion du projet à votre base de données dans le fichier .env à la racine du projet, selon l'exemple suivant:
DATABASE_URL=mysql://username:password@127.0.0.1:3306/api7

username représente le nom d'utilisateur par lequel vous accéder à votre base de données, et password le mot de passe, et api7 le nom de la base.

3. Dès que vous aurez entrez les identifiants d'accès à la base de données, démarrez le serveur en exécutant la commande suivante dans la console : symfony server:start.

Vous pourrez alors vous rendre sur http://127.0.0.1:8000/apiPlatform pour accéder à la documentation technique de l'Api.

4. Pour obtenir le token d'authentification qui vous permettra d'exécuter les requêtes de l'Api(GET, POST, DELETE, PUT), vous devez exécuter, via Postman une requête POST 
vers le chemin http://127.0.0.1:8000/apiPlatform/login_check, et le body de cette requête doit contenir en guise de password le nom d'un client dans la table client de la base de données, 
et l'email de ce dernier. Par exemple : 
{
    "password":"Mark Tel",
    "email":"essonoadou@gmail.com"
}

##Construit avec
* [Symfony](https://symfony.com/): High performance PHP framework for web development
* [API Platform](https://api-platform.com/): REST and GraphQL framework to build modern API-driven projects
* JWT.
