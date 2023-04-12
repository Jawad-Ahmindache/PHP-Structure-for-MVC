<?php
namespace Jahmindache\Module\Account\Controller;
use Jahmindache\Module\Account\Account;
use Rakit\Validation\Validator;
use Jahmindache\Module\Account\Model\UserModel;
class User{

    protected $userData;
    
    protected $module;
    
    /**
     * Liste non exhaustive de validation, certaines peuvent se faire directement avec des méthodes
     * Par exemple : Les vérification SQL, les fichiers ou encore l'existence d'une clé dans un tableau
     *
     * @var array
     */
    protected $listValidator = array(
        'email' => 'required|email|min:5|max:255',
        'phone_number' => 'required|regex:/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/|',
        'password' => 'required|min:4|max:128',
        'description' => 'required|min:4|max:280',
        'zip' => 'required|min:2|max:10|regex:/(?i)^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/',
        'city' => 'required|min:2|max:50|regex:/^[\wÀ-ÿ \-_]+$/i',
        'address' => 'required|min:2|max:50|regex:/^[\wÀ-ÿ \-_]+$/i',
        'identification_pro' => 'max:14|regex:/[0-9 -]*/',
        'type' => 'required'
   );

   protected $listValidatorAlias;

   protected $validationMsg = array();

   protected $lang;

   
   protected $data = array(
        'id'                 => null,
        'email'              => null,
        'phone_number'       => null,
        'type'               => null,
        'zip'                => null,
        'city'               => null,
        'address'            => null,
        'description'        => null,
        'date_register'      => null, 
        'identification_pro' => null,
        'profile_picture'    => null
   );
   
   protected $dataDetail = array();
   protected $allowedAccountType = array(
        1 => "candidate",
        2 => "company",
        3 => "manager"
   );


    
        
    /**
     * __construct
     *
     * @param  Account $account
     * @return void
     */
    public function __construct($account){
        $this->module = $account;
        $this->setValidationMsg();
    }

    
    public function updateAccountSession($id){
        $userInfo = UserModel::getAccountByID($id);
        
        if($userInfo == NULL)
            return false;
        else
        {
            foreach($userInfo as $key => $value){
                if(array_key_exists($key,$this->data))
                    $_SESSION['account'][$key] = $value;
                
            }
        }
        
        $_SESSION['account']['detail'] = null;
        $userInfoDetail = UserModel::getAccountDetail($id,$userInfo->type);

        
        if($userInfoDetail){
            foreach($userInfoDetail as $key => $value){
                if(array_key_exists($key,$this->dataDetail))
                    $_SESSION['account']['detail'][$key] = $value;
            }
        }

        return true;
    }
   
    public function login(array $data){
         $lang = $this->module->getLang();

         $login = isset($data['login']) ? $data['login'] : null;
         $password = isset($data['password']) ? $data['password'] : null;
         
         $result = UserModel::login($login,$password)->first();
         if($result == NULL){
            \App::getInstance()->setOutput("error","accountLoginError",
                                           $lang->getTsl("LOGIN_ERROR"),null,[]);
         }
         else{

            \App::getInstance()->setOutput("success","accountLoginSuccess",
                                            $lang->getTsl("LOGIN_SUCCESS"),null,[]);

            if(!$this->updateAccountSession($result->id)){
                 \App::getInstance()->setOutput("error","accountLoginSessionError",
                                                $lang->getTsl("LOGIN_SESSION_ERROR"),null,[]);
            }


         }
    }

    private function setValidationMsg(){
        $lang = $this->module->getLang();
        
        $this->validationMsg = array(
            'required' => ":attribute ". $lang->getTsl('REQUIRED_FORM'),
            'email' => ":attribute ". $lang->getTsl('EMAIL_FORM'),
            'min' => ':attribute '. $lang->getTsl('MIN_FORM'),
            'max' => ':attribute '. $lang->getTsl('MAX_FORM'),
            'regex' => ':attribute '. $lang->getTsl('REGEX_FORM'),
        );

        $this->listValidatorAlias = array(
            'email' => $lang->getTsl('EMAIL_ATTRIBUTE_ALIAS'),
            'phone_number' => $lang->getTsl('PHONE_ATTRIBUTE_ALIAS'),
            'password' => $lang->getTsl('PASSWORD_ATTRIBUTE_ALIAS'),
            'description' => $lang->getTsl('DESCRIPTION_ATTRIBUTE_ALIAS'),
            'zip' => $lang->getTsl('ZIP_ATTRIBUTE_ALIAS'),
            'city' => $lang->getTsl('CITY_ATTRIBUTE_ALIAS'),
            'address' => $lang->getTsl('ADDRESS_ATTRIBUTE_ALIAS'),
            'identification_pro' => $lang->getTsl('SIRET_ATTRIBUTE_ALIAS'),
            'type' => $lang->getTsl('TYPE_ATTRIBUTE_ALIAS')
        );
    }



    protected function mailOrPhoneError($email,$phone){
        $phoneExist = UserModel::isMailExist($email);
        $emailExist = UserModel::isPhoneExist(trim($phone));
        $errorList = array();
        if($phoneExist || $emailExist){
            
            if($phoneExist === true){
                $errorList['email'] = $this->module->getLang()->getTsl('EMAIL_EXIST_FORM');
            }
                
            if($emailExist === true){
                $errorList['phone_number'] = $this->module->getLang()->getTsl('PHONE_EXIST_FORM');
                \App::getInstance()->setOutput("error","accountError",
                                 $this->module->getLang()->getTsl("ACCOUNT_CREATE_ERROR"),null,
                                 array("errorList" => $errorList));
            }

            return $errorList;
        }
        else {
            return false;
        }
    }

    private function isCorrectType($type){
        if(array_key_exists($type,$this->allowedAccountType)){
            return true;
        }
        else{
            \App::getInstance()->setOutput("error","accountError",
                            $this->module->getLang()->getTsl("ACCOUNT_CREATE_ERROR"),null,
                            array("errorList" => array("type" => $this->lang->module->getTsl('INCORRECT_TYPE_FORM'))));

            return false;
        }
    }
    public function create(array $data){
        $validator = new Validator();
        $crit = $this->listValidator;

        $app = \App::getInstance();
        $validator->setMessages($this->validationMsg);


        $validation = $validator->make($data, [
            'email' => $crit['email'],
            'phone_number' => $crit['phone_number'],
            'password' => $crit['password'],
            'zip' => $crit['zip'],
            'city' => $crit['city'],
            'address' => $crit['address'],
            'type' => $crit['type']
        ]);
        $validation->setAliases($this->listValidatorAlias);

            $validation->validate();
            if ($validation->fails()){
                    $app->setOutput("error","accountError",
                                     $this->module->getLang()->getTsl("ACCOUNT_CREATE_ERROR"),null,
                                     array("errorList" => $validation->errors()->firstOfAll()));
            }
            else
            {   
                if(!$this->mailOrPhoneError($data['email'],$data['phone_number'])){
                    if($this->isCorrectType($data['type'])){
                        if(UserModel::createUser($data)){
                            $app->setOutput("success","accountSuccess",
                            $this->module->getLang()->getTsl("ACCOUNT_CREATE_SUCCESS"),null,[]);

                        }
                        else{
                            $app->setOutput("error","accountError",
                            $this->module->getLang()->getTsl("ACCOUNT_CREATE_ERROR"),null,[]);
                        }
                    }
                                        
                }

            }   
    }


    
    
}