<?php
use \Jahmindache\Core\Controller\Language;
/**
 * C'est un module d'exemple pour visualiser comment fonctionne la gestion de module de l'application
 * Si on souhaite avant l'initialisation de l'application faire une manipulation particulère, on met la méthode onInitApp
 */
class ExempleModule{
    
    private $app;
    private $lang;
    private $moduleName;

    public function __construct(){
        $this->moduleName = get_class($this);
        $this->lang = new Language("en","fr",false,$this->moduleName);     
    }

    public function onInitApp(Object $app){
            $this->app = $app;
            
            $this->app->setOutput("success","loadSuccess","message","<p>".$this->lang->getTsl("EXAMPLE_HELLO_WORLD")."</p>",["lol" => "lol"]);
    }
    
}