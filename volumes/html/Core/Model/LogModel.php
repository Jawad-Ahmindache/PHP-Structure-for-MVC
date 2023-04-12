<?php
namespace Jahmindache\Core\Model;

/**
 * Cette classe permet d'envoyer ou de recevoir des logs de la base de donnée.
 */
class LogModel {
    
    
    private static $errorList = array(
        'success' => 0,
        'warning' => 1,
        'info' => 2,
        'error' => 3        
    );
    /**
     * Envoyer un log pour les langues
     * @param  Capsule : connexion à la DB
     * @param  string $type : 0 = success,1 = warning,2 = info,3 = error
     * @param  mixed $theme : mettre null si c'est seulement pour un module, ou nom du répertoire du thème si c'est pour un thème 
     * @param  string $module : mettre nom du module 
     * @param  string $lang : la langue qui pose probleme exemple : fr
     * @param  string $message : Le message d'indication du problème
     * @return void
     */
    public static function logLang(string $type,$theme,string $module,string $lang,string $message){
        
            \App::getInstance()->model()->getDB()::table('log_lang')->updateOrInsert([
                'type' => self::getType($type),
                'theme' => $theme,
                'module' => $module,
                'lang' => $lang,
                'message' => $message
            ]);
    } 
    /**
     * Avoir le type d'erreur à partir de $errorList
     *
     * @param  string $type
     * @return void
     */
    public static function getType(string $type){
            return self::$errorList[$type];
    }

    

   

}
