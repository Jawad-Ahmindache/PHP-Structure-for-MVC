<?php
namespace Jahmindache\Module\Account;
use \Jahmindache\Core\Controller\{
    AbstractModule,
    Language,
    UserDetection
    
};


/**
 * Gestion des comptes de l'application
 */
class Account extends AbstractModule{
    
    public function __construct(){
        parent::__construct();
        $this->moduleName = $this->app->class_basename(__CLASS__);
        $this->lang = new Language(__DEFAULT_LANGUAGE__,UserDetection::getClientLang(),false,$this->moduleName);
    }

    
    /**
     * Action à faire avant l'initialisation
     *
     * @return void
     */
    public function onInitApp(){
        
    }

    

    
    
}