<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/animalDao.php';

$app->get('/animais/{ani_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::selectByIdForm($animal);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});


$app->post('/animais/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $animal = new Animal();

    // Objeto proprietário
    $proprietario = new Proprietario();
    $proprietario->setPro_int_codigo($body['pro_int_codigo']);
    
    // Objeto raça
    $raca = new Raca();
    $raca->setRac_int_codigo($body['rac_int_codigo']);

    $animal->setAni_var_nome($body['ani_var_nome']);
    $animal->setProprietario($proprietario);
    $animal->setRaca($raca);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso(GF::changeDotToComma($body['ani_dec_peso'], 'C')); 	

    $data = AnimalDao::insert($animal);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});


$app->put('/animais/{ani_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();

    // Objeto proprietário
    $proprietario = new Proprietario();
    $proprietario->setPro_int_codigo($body['pro_int_codigo']);
    
    // Objeto raça
    $raca = new Raca();
    $raca->setRac_int_codigo($body['rac_int_codigo']);

    $animal->setAni_int_codigo($ani_int_codigo);
    $animal->setProprietario($proprietario);
    $animal->setRaca($raca);
    $animal->setAni_var_nome($body['ani_var_nome']);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso(GF::changeDotToComma($body['ani_dec_peso'], 'C')); 	

    $data = AnimalDao::update($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});


$app->delete('/animais/{ani_int_codigo}/{apikey}', function (Request $request, Response $response) {
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::delete($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});