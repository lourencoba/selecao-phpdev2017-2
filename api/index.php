<?php

require 'vendor/autoload.php';

$settings['displayErrorDetails'] = true;
$settings['determineRouteBeforeAppMiddleware'] = true;

$app = new \Slim\App(["settings" => $settings]);

require 'config.php';

//Middleware de autenticação
require '_genesis/autenticacao.php';

require '_genesis/genesis.php';
require 'endpoints/usuarios.php';
require 'endpoints/animais.php';
require 'endpoints/proprietarios.php';
require 'endpoints/animalvacinas.php';

$app->run();