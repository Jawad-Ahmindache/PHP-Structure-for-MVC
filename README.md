
## I. Outils serveurs

Serveurs web : Nginx  
Base de donnée : MariaDB  
Back end : PHP-8  
Gestion des données : Phpmyadmin  (apache)  
Conteneurs : Dockers  
Cluster : + tard (surement docker swarm)  
Schéma : Draw.IO

## II. Fichiers

#### Racine 

**Docker-compose.yml** : Contient nos conteneurs Docker  
**Variable.env** : Contient nos variables d'environnement pour nos conteneurs Docker  
**Docker/** : Dossier contenant nos images docker personalisées  
**Schéma/** : Dossier contenant tous les croquis & schéma de nos projets
**Volumes** : Contient tous les fichiers d'une appli (code source,db,config,stockage)

#### Volumes

**Config/** : Contient tous les fichiers de config serveur (ssl,php.ini,MariaDB.cnf,nginx.conf,...)  
**Database/** : Toutes nos base de donnée  
**files/** : Les fichiers de stockage de ressource de l'appli  
- files/<IDVOL>/upload/<MODULE>/ : fichier upload par l'utilisateur
- files/<IDVOL>/generated/<MODULE>/ : fichier générés par l'appli 
**html/** : Code source du projet  
**cron/** : Toutes les task Cron
**log/** : Les logs des services (nginx,php,sql,...)

## III. Ports machine hôte utilisés
443 : HTTPS nginx  
80 : HTTP(redirection https) nginx  
8080 : HTTP Phpmyadmin (redirection 8443 https)  
8443 : Https Phpmyadmin  
3306 : sql mariadb  
9000 : Php  


## IV. Installer le projet
1) 
        cd Projet_RBSII
    
2) 
        Installer key.pem et cert.pem dans volumes/config/ssl/
3)
        Installer les  DKIM dans volumes/config/dkim/
4)
        (optionnel) Glisser les database dans volumes/database/

5)
        docker compose --env-file ./variable.env up

## V. Architecture du code

Globalement l'architecture du code est du PHP MVC. C'est assez simple,
Il y a un dossier **module** qui regroupe toutes les fonctionnalités du site par leur nom sans les **views**  

Un dossier **theme** qui regroupe les thèmes du site et chaques views est regroupés dans un dossier avec le nom des modules   
- Il contient <NOM_THEME>/views (accessible uniquement via back end)  
exemple : defaultTheme/views/account/
- Assets (accessible via front & back) <NOM_THEME>/assets
    - script/<module>/
    - lib/
    - css/<module>/
    - img/<module>/

- public_lang/ les langues accessibles par le front end regroupés par modules
exemple : public_lang/account/fr_FR.ini



Un dossier **vendor** contenant nos dépendences composer

Un dossier **utils** contenant toutes nos constantes requises pour toutes l'appli (par exemple la liste des modules disponible)

Un dossier **lang** les langues uniquement accessibles depuis le back end et regroupés par modules
exemple : lang/account/fr_FR.ini


## VI. Précision sur les modules & Thème

Un fichier **about.yml** se trouve toujours à la racine d'un thème ou d'un module sont but est de donner des informations.
De la même manière, un fichier **icon.png** s'y trouve pour donner un icone au module 
Cela permet un suivi plus efficace du module    

        name: Exemple theme
        version: 1.2
        author : nom prenom
        date_create: 2022-12-01 14:54:00
        last_modif : 2022-12-02 09:54:00
        contributor :
        	- Nom prenom
        description : Ce theme sert d'exemple
        changelog : 
                1.2 : 
                    - Ajout X
                    - Modification de X
                1.1 : 
                    - Ajout X
                1.0 : 
                    - Creation du theme
    
# PHP-Structure-for-MVC
