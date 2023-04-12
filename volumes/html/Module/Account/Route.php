<?php
//$this fait référence à $App

use Jahmindache\Module\Account\Account;
use Jahmindache\Module\Account\Controller\User;



\App::getInstance()->router->post('/account/login', function(){
        $_Account = new Account();
        $user = new User($_Account);
        $user->login($_POST);

});


\App::getInstance()->router->get('/account/setting', function(){
        
});


\App::getInstance()->router->get('/account/register', function(){
        
});


\App::getInstance()->router->get('/account/forgot_password', function(){
        
});


\App::getInstance()->router->post('/account/create', function(){
        $_Account = new Account();
        $user = new User($_Account);
        $user->create($_POST);
});


\App::getInstance()->router->post('/account/login_submit', function(){
        
});

