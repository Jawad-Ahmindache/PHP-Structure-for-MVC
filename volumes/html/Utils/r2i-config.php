<?php
define('__ROOT__',__DIR__."/..");
define('__R2ICORE__',__ROOT__."/Core");
define('__UTILS__',__ROOT__."/Utils");
define('__MODULE__',__ROOT__."/Module");
define('__THEME__',__ROOT__."/Theme");
define('__LANG__',__ROOT__."/lang");
define('__VOLUME__',__ROOT__."/volume");

/** Global DB config
 * Cette configuration concerne la base de donnée principale, c'est-à-dire qu'elle sert à orchestrer tout ce qui touche au fonctionnement de l'application
 * Par exemple : Les comptes utilisateurs, les logs, les indicateurs de performances de l'appli etc...
 * 
 * PS : Si on veut une appli mono DB il est possible de tout mettre dans le main aussi
 */

define('__DBHOST__',"mariadb-docker");
define('__DBUSER__',"root");
define('__DBPASS__',$_SERVER['MYSQL_ROOT_PASSWORD']);
define('__R2I_DB__',"r2i");

/**
 * Configuration Langue
 */

define('__DEFAULT_LANGUAGE__',"en");

