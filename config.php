<?php
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    $autoload = function($class){
        if($class == 'Email'){
            include("classes/vendor/autoload.php");//phpmailer
        }
        include('classes/'.$class.".php");
    };
    spl_autoload_register($autoload);


    define("INCLUDE_PATH","http://localhost/site%20dinamico01/");
    define("BASE_DIR_PAINEL",__DIR__.'/painel');

    //conenctar banco de dados.
    define("HOST",'localhost'); //tipo de host
    define("USER","root"); //usuaruo
    define("PASSWORD",''); //senha
    define("DATABASE",'site_dinamico'); //meu dbname = banco de dados

?>