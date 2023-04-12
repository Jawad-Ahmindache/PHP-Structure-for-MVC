<?php



/**
 * Permet de récuperer le répertoire contenant les dossiers de modules ou se trouvent nos routes
 */
define('__THEME_ROOTER_LOAD_DIR__', __DIR__ . '/views');



/**
 * Constante qui donne le fichier accessibles aux users
 */
define('__THEME_PUBLIC__', '/Theme/Default/public');


/**
 * Constante qui donne le répertoire des ressources de nos librairies
 */
define('__THEME_LIB__', __THEME_PUBLIC__.'/node_modules');

/**
 * Constante qui donne le répertoire des ressources de nos modules
 */
define('__THEME_MODULE__', __THEME_PUBLIC__.'/modules');






require __DIR__."/functions.php";