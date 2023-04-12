<?php

namespace Jahmindache\Core\Controller;
use Jahmindache\Core\Controller\{
    Log
};
use Jahmindache\Core\Model\{
    LogModel
};

/**
 * Cette classe gère l'internationalisation de l'application grâce à des fichiers ini
 * Toujours avoir au minimum le fichier en.ini dans ses langues pour permettre à l'utilisateur d'avoir au moins une langue
 */
class Language{
    
        

    /**
     * Language par défaut si le language préféré n'est pas trouvé
     *
     * @var string
     */
    private $defaultLanguage = "";
    
    /**
     * Language préféré du naviguateur
     *
     * @var string
     */
    private $preferedLanguage = "";
    
    /**
     * Fichier du langage par défaut
     *
     * @var mixed : Array si valide et false si invalide
     */
    public $defaultLanguageINI = false;    
    
    /**
     * Fichier du language de préférences 
     *
     * @var mixed : Array si valide et false si invalide
     */
    public $preferedLanguageINI = false;
    
    /**
     * Dossier ou se trouvent les fichiers .ini de langue
     *
     * @var string
     */
    private $dirLang = "";
    
    /**
     * Nom du module à traduire
     *
     * @var string
     */
    private $module = "";
    
    /**
     * Nom du thème à traduire
     * Laisser false si ce n'est pas un thème
     * @var mixed
     */
    private $theme = false;




    
    public function __construct(string $defaultLanguage,string $preferedLanguage,$theme = false,string $module){
        $this->defaultLanguage = preg_replace('/_[a-zA-Z]*/','',$defaultLanguage);
        $this->preferedLanguage = preg_replace('/_[a-zA-Z]*/','',$preferedLanguage);
        $this->theme = $theme === false ? false : ucfirst(strtolower($theme));
        $this->module = $theme === false ? false : ucfirst(strtolower($module));
        $this->dirLang = $theme !== false ? __THEME__."/".$theme."/lang/".$module : __LANG__."/".$module."/";
        $this->module = $module;
        $this->defaultLanguageINI = $this->setIniFile($this->defaultLanguage);
        $this->preferedLanguageINI = $this->setIniFile($this->preferedLanguage);

        if($this->preferedLanguageINI === false){
            $this->preferedLanguage = $this->defaultLanguage;
            $this->preferedLanguageINI = $this->defaultLanguageINI;
        }

        


    }
    
    
    /**
     * Récupérer le dossier pointant vers les langues passé en constructeur
     *
     * @return string
     */
    public function getDirLang(): string{
        return $this->dirLang;
    }
    
        
    /**
     * Initialiser le thème à traduire
     *
     * @param  mixed $theme
     * @return void
     */
    public function setTheme($theme): void {
        $this->theme = $theme;
    }
    /**
     * 
     * Avoir la traduction grâce à la langue determinée automatiquement
     *
     * @param  string $keyword : variable dans le .ini
     * @return string
     */
    public function getTsl(string $keyword): string{
            $translate = $this->isTranslateExist($keyword);
            if($translate !== false)
                return $translate;
            else    
                return "Lang not defined";
            
    }

    
    /**
     * Avoir la traduction en choisissant soi même une langue
     *
     * @param  string $keyword
     * @param  string $lang
     * @return mixed
     */
    public function getTslManual(string $keyword,string $lang): string{
        $translate = parse_ini_file($this->getDirLang().$lang.".ini");
        if($translate[$keyword])
            return $translate[$keyword];
        else
            return "Lang not defined";
    }

    public function isTranslateExist(string $keyword): mixed{
        
        if(isset($this->preferedLanguageINI[$keyword])){
            return $this->preferedLanguageINI[$keyword];
        }
        else if(isset($this->defaultLanguageINI[$keyword])){
            
            LogModel::logLang("error",
                              $this->theme == false ? null : $this->theme,$this->module,
                              $this->preferedLanguage,"Translation not exist for : " . $keyword);

            return $this->defaultLanguageINI[$keyword];
        }
        else{
            LogModel::logLang("error",
                              $this->theme == false ? null : $this->theme,$this->module,
                              $this->defaultLanguage,"Translation not exist for : " . $keyword);
            return false;
        }
    }


    private function setIniFile(string $lang) : mixed{
        $lang = strtolower($lang);
        if(is_file($this->getDirLang().$lang.".ini"))
            return parse_ini_file($this->getDirLang().$lang.".ini");
        else{
            
             LogModel::logLang("error",
                                $this->theme == false ? null : $this->theme,$this->module,
                                $this->defaultLanguage,"INI file don't exist for this language");

            return false;
        }
    }    
    

}