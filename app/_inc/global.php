<?php

session_start();

//Definição das constantes de URL e ROOT
    if (!defined('__DIR__')) {
       define('__DIR__', dirname(__FILE__));
    }
    $scriptRoot = explode('/', str_replace('_inc', '', __DIR__));
    $scriptName = explode('/', $_SERVER['SCRIPT_NAME']);
    $arrayCaminho = array_intersect($scriptRoot, $scriptName);
    
    $complementoPasta = 'selecao-phpdev2017-2/app/';
    if (count($arrayCaminho) > 0) {
        foreach ($arrayCaminho as $pasta) {
            if (!empty($pasta)) {
                $complementoPasta .= $pasta . '/';
            }
        }
    }
    define('URL_SYS', 'http://' . $_SERVER['SERVER_NAME'] . '/' . $complementoPasta);
    define('ROOT_SYS', str_replace('_inc', '', dirname(__FILE__)));
// --


//Constantes do Sistema
define('SYS_TITLE', "Seleção SimplesVet");
define('SYS_SUBTITLE', '');
define('SYS_VERSION', '1.0');
define('SYS_THEME', 'metronic4');
define('SYS_LIB_DEFAULT', 'jquery,genesis,php.js');
define('SYS_CHARSET', 'utf-8');
define('SYS_COPYRIGHT', "2016 &copy; SimplesVet");

//Constantes URL
define('URL_STATIC', URL_SYS);
define('URL_GENESIS', URL_SYS . '_genesis/');
define('URL_SYS_THEME', URL_SYS . '_themes/' . SYS_THEME . '/');
define('URL_SYS_LOGO', URL_SYS_THEME . '_img/logo-interna.png');
define('URL_STATIC_GN', URL_STATIC . '_genesis/');
define('URL_SIGNIN', URL_SYS . 'login/login.php');
define('URL_UPLOAD', URL_SYS . '_upload/');
define('URL_API', str_replace('app', 'api', URL_SYS));

//Constantes caminho absoluto
define('ROOT_SYS_INC', ROOT_SYS . '_inc/');
define('ROOT_SYS_CLASS', ROOT_SYS . '_class/');
define('ROOT_GENESIS', ROOT_SYS . '_genesis/');
define('ROOT_SYS_THEME', ROOT_SYS . '_themes/' . SYS_THEME . '/');
define('ROOT_UPLOAD', ROOT_SYS . '_upload/');

define('SYS_PAGINACAO', 20);

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

require_once(ROOT_SYS_INC . 'config.php');
require_once(ROOT_SYS_INC . 'functions.php');
require_once(ROOT_GENESIS . 'genesis.php');

$genesis = new Genesis();

require_once(ROOT_SYS_THEME . 'theme.lib.php');
require_once(ROOT_SYS_THEME . 'header.class.php');
require_once(ROOT_SYS_THEME . 'footer.class.php');
require_once(ROOT_SYS_THEME . 'form.class.php');


//Tratamento do $_POST
    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $value = is_string($value) ? trim($value) : $value;
            if (empty($value)) {
                $_POST[$key] = null;
            } else {
                $_POST[$key] = is_string($value) ? stripslashes($value) : $value;
            }
        }
    }
// --