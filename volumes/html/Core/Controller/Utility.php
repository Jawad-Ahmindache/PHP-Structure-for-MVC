<?php
namespace Jahmindache\Core\Controller;


class Utility {


    public static function generateSecureToken($length){
        return bin2hex(openssl_random_pseudo_bytes($length/2));
    }

    public static function pass_hash($password){
            return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function includeInVar($file){
        ob_start();
        include $file;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }


    
}