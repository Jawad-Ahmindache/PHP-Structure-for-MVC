<?php

namespace Jahmindache\Core\Controller;

/**
 * Cette classe contient les informations liée à la requête on peut avoir :
 * - L'ip
 * - Savoir si une requête est en ajax
 * - Avoir la langue utilisé par l'utilisateur
 */
class UserDetection {

    
    /**
     * Check si le client a émis une requête Ajax
     *
     * @return bool
     */
    public static function isAjax(): bool {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;
        else
            return false;
    }
    
    /**
     * Avoir l'ip de l'utilisateur
     *
     * @return string
     */
    public static function getIp(): string{
        return $_SERVER['REMOTE_ADDR'];
    }

    
    /**
     * Extraire la langue préférée de l'utilisateur grâce à l'entête "Accept-Language"
     *
     * @return string
     */
    public static function getClientLang(): string{

        $formatedLang = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        
        
        return $formatedLang !== false ? preg_replace('/-/','_',$formatedLang) : "en";
    }
    


    
}