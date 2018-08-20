# Emove


## Prérequis
L'application est installée avec docker et docker compose, ces outils sont nécessaires pour utiliser l'application. 

Assurez-vous que vous n'avez aucun service qui est sur les ports 81 et 8080 avant de poursuivre l'installation.

## Installation
Clonez le repository

~~~
https://github.com/so-mouga/emove.git --dev
~~~

L'installation est très simple. 

1. Placez vous sur le projet 
~~~
- cd emove
~~~
2. Exécutez le ficher docker compose
~~~
- docker-compose up -d --build
~~~

3. Exécutez composer
~~~
- docker-compose exec php composer install
~~~

4. Installation des fixtures 
~~~
-  php bin/console doctrine:fixtures:load
~~~


## Base de donnée
Pour accéder à la base donnée ouvrez l'url http://localhost:8081

~~~
Server = db
Username = admin
Password = admin
database = emove	
~~~

## Utilisation du site

### Utilisation des API
Les donnée du site sont accessible via api sur la  http://localhost:8080/api/....

Un login et mot de passe est requie pour toutes connection http bia les routes /api
- login : ipssi
- mdp : ipssi

Un token est requie pour acceder au route user, on peut le récupérer en se connectant via /api/auth-tokens
- login : kevin@gmail.com
- password : admin

Chaque route user devra avoir comme header en paramétre X-Auth-Token et en valeur le token récupéré plus haut
