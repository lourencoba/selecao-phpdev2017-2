<?php

//Middleware de autenticação da apikey
$autenticacao = function ($request, $response, $next) {
    //Valida a apikey passada
    if ($request->getAttribute('route')->getArguments()['apikey'] != API_KEY) {
        return $response->withJson("Apikey denied", 403);
    }

    return $next($request, $response);
};

$app->add($autenticacao);