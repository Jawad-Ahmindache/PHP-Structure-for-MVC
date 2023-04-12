<?php
namespace Jahmindache\Module\Account\Model;
use Jahmindache\Core\Controller\Utility;
class UserModel {
 

        
    public static function createUser(array $data,$active = 0){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')->insert([
            'email'	        => $data['email'],
            'phone_number'  => $data['phone_number'],
            'password'      => Utility::pass_hash($data['password']),
            'active'        => $active,
            'active_token'  => Utility::generateSecureToken(128),
            'description'   => $data['description'],
            'type'	        => $data['type'],
            'zip'           => $data['zip'],
            'city'          => $data['city'],
            'address'       => $data['address']
        ]);
    }

    public function updateUser(){

    }

    public static function login($login=null,$password){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')
                                    ->where('email',$login)
                                    ->orWhere('phone_number',$login)
                                    ->where('password',Utility::pass_hash($password))
                                                                                     ->get('id');
    }

    public static function getAccountByID($id){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')
                                    ->where('id',$id)
                                    ->get()->first();
    }
    public static function isMailExist($email){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')->where('email', $email)->exists();
    }

    public static function isPhoneExist($phone){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')->where('phone_number', $phone)->exists();  
    }

    public static function isIdentificationProExist($identification_pro){
        $db = \App::getInstance()->model()->getDB();
        return $db::table('Account')->where('identification_pro', $identification_pro)->exists();  
    }

    public static function getAccountDetail($id,$type){
        $type = ($type == 1) ? 'Account_detail_candidate' : ($type == 2 ? 'Account_detail_company' : 'Account_detail_manager');
        $db = \App::getInstance()->model()->getDB();
        return $db::table($type)->where('idAccount',$id)->get()->first();
    }
}