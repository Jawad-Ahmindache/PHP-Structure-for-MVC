<?php
use Jahmindache\Core\Model\AppModel;
use MiladRahimi\PhpRouter\Router;

use Jahmindache\Core\Controller\{
    UserDetection,
    Language
};


class App {
            
    
    /**
     * Valeur de sortie de l'application
     *
     * @var array
     */
    protected $appOutput;
    
    /**
     * Contient un objet langue utilisé dans le coeur de l'App
     *
     * @var Language
     */
    protected $lang;
    /**
     * Contient le theme de l'application par défaut (default)
     *
     * @var string
     */
    protected $theme;

    protected $htmlMode = false;
    private static $instance = null; // L'attribut qui stockera l'instance unique

    private $session;
        
    /**
     * Contient le model
     *
     * @var AppModel
     */
    protected $mainDB;

    
    protected $router;
    
    /**
     * Contient un tableau ou un false (si erreur) des modules initiateurs de l'APP
     *
     * @var mixed
     */
    protected $moduleIniter;

    

    /**
     * Comme le constructeur à la différence qu'il construit l'objet que si on appelle cette méthode
     *
     * @return void
     */
    public function start(){
        
        //Redirection si ce n'est pas la route d'entrée en ajax
        if($_SERVER['REQUEST_URI'] != "/" && !UserDetection::isAjax()){
            header('Location: /');
            die();
        }
        $this->theme = "Default";
        $this->setMainDB();
        $this->lang = new Language(__DEFAULT_LANGUAGE__,UserDetection::getClientLang(),false,"Core");
        $this->setOutput("error","voidError",$this->lang->getTsl("PAGE_NOT_LOADED_ERROR"),null,[]);
        
         $this->moduleIniter = parse_ini_file(__UTILS__."/moduleIniter.ini")["module"];
         
         if(is_array($this->moduleIniter))
             $this->initModule();
 
          $this->loadRoute();
    }
     
    /**
     * Permet d'avoir les informations de sortie de l'application sous forme de tableau
     *
     * @return array
     */
    public function getOutputArray(): array {
       return $this->appOutput;
    }
    
     
    public function setMainDB(){
        $this->mainDB = new AppModel(__DBHOST__,__R2I_DB__,__DBUSER__,__DBPASS__);
    }

     /**
     * Méthode permettant de passer au début d'un tableau un élément
     * (Elle sera déplacée dans une autre classe en tant que méthode statique)
     *
     * @param  array $array : Tableau à manipuler 
     * @param  array $element : Element à placer dans notre tableau
     * @return void
     */
    public static function array_push_start(array $array,string $element): array{
        $firstLine = $array[0];
        $array[0] = $element;
        array_push($array,$firstLine);
        return $array; 
    }

    public function class_basename($class){
        return (substr($class, strrpos($class, '\\') + 1));

    }

    public function session(){
        return $this->session;
    }

    public function enableHtmlMode(){
        $this->htmlMode = true;
    }

    
    public function disableHtmlMode(){
        $this->htmlMode = false;
    }

    private function loadRoute(){
   
            $this->router = Router::create();
            $listModule = $this->getListModule();


            //Inclure les config du thème (valable pour tous les thèmes quelle que soit sa techno)
            include __THEME__ . "/" . $this->theme . "/config.php";            
            // Route d'initialisation de l'app
            
            $this->router->get('/', function(){
                $this->enableHtmlMode();
            
                require __THEME__ . "/" . $this->theme . "/index.php";
                                
            });
            
            foreach($listModule as $value){
                 if (is_file(__MODULE__ . '/' . $value . '/' . 'Route.php')) 
                    include __MODULE__ . '/' . $value . '/Route.php';
            }

            foreach(scandir(__THEME_ROOTER_LOAD_DIR__) as $value){
                if (is_file(__THEME_ROOTER_LOAD_DIR__ . '/' . $value . '/' . 'Route.php')) 
                    include __THEME_ROOTER_LOAD_DIR__ . '/' . $value . '/Route.php'; 
            }

            $this->router->dispatch();    


        
    }

    public static function getInstance(){
      if (self::$instance == null)
        self::$instance = new App();

      return self::$instance;
    }

  
    public function getListModule(){
        return scandir(__MODULE__);
    }


    
    /**
     * Permet d'avoir les informations de sortie de l'application sous forme de chaine de caractère
     *
     * @return string
     */
    public function getOuputArrayJSON(): string{
        return json_encode($this->getOutputArray()); 
    }
            
    /**
     * Permet de modifier la sortie de l'app
     *
     * @param  string $type : Type de renvoie exemple ("error" ou "success")
     * @param  string $typeName : Sous catégorie d'erreur exemple ("voidError" ou "appSuccessInit")
     * @param  string $message : Message de renvoi
     * @param  string $html : Html renvoyé
     * @param  array $data : Tableau 
     * @return void
     */

    public function setOutput(string $type,string $typeName,string $message,string $html = null,array $data = array()){
        $this->appOutput = array(
            "type" => $type,
            "typeName" => $typeName,
            "message" => $message,
            "html" => $html,
            "data" => $data
        );
    }
            
    /**
     * Initialise les modules d'entrée avant le chargement de l'application puis le détruit
     *
     * @return void
     */
    private function initModule(){

        foreach($this->moduleIniter as $value){
            $moduleTxt = "\Jahmindache\Module\\".$value."\\".$value;
            
            $module = new $moduleTxt($this);

            $module->onInitApp();
            unset($module);
        }
    }
    
    /**
     * Avoir le model de l'app
     *
     * @return AppModel
     */
    public function model(){
        return $this->mainDB;
    }
    
    public function view($html){
        $this->appOutput['html'] = $html; 
    }

    /**
     * Retourne soi une réponse JSON soi une redirection
     *
     * @param  mixed $redirect url de redirection, laisser false si output
     * @return void
     */
    public function render(){
        
        if($this->htmlMode == true)
            echo $this->getOutputArray()['html'];
        else
            echo $this->getOuputArrayJSON();
    }   

    
}
  
