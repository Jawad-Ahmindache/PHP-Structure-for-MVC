<?php
namespace Jahmindache\Core\Controller;


class AbstractModule{
    
    protected $app;
    protected $lang;
    protected $moduleName = "";
        
    
    public function __construct(){
        $this->app = \App::getInstance();
    }
    
    
    /**
     * Action à faire avant l'initialisation
     *
     * @return void
     */
    public function onInitApp(){
            $this->app->setOutput("success","loadSuccess","message","<p>"."Hello world"."</p>",["hi" => "hi"]);
    }
    
    public function getLang(){
        return $this->lang;
    }
}