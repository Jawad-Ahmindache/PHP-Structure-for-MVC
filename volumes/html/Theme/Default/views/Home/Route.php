<?php
use Jahmindache\Core\Controller\Utility;


\App::getInstance()->router->get('/home', function(){
    $app = \App::getInstance();
    $app->setOutput('success', 'loadHome', '', Utility::includeInVar(__DIR__ . "/home.php"));      
});



\App::getInstance()->router->get('/navbar', function(){
    $app = \App::getInstance();
    $app->setOutput('success', 'loadNavbar', '', Utility::includeInVar(__DIR__ . "/navbar.php")); 
    
});


