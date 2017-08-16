<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/animalVacinaDao.php';

$app->get('/animalvacinas/{anv_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $anv_int_codigo = $request->getAttribute('anv_int_codigo');
    $animalVacina = new AnimalVacina();
    $animalVacina->setAnv_int_codigo($anv_int_codigo);

    $data = AnimalVacinaDao::selectByIdForm($animalVacina);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});

$app->post('/animalvacinas/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $animalVacina = new AnimalVacina();

    // Objeto Animal
    $animal = new Animal();
    $animal->setAni_int_codigo($body['ani_int_codigo']);
    
    // Objeto Vacina
    $vacina = new Vacina();
    $vacina->setVac_int_codigo($body['vac_int_codigo']);
    
    // Objeto Usuário
    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($body['usu_int_codigo']);

    $animalVacina->setAnimal($animal);
    $animalVacina->setVacina($vacina);
    $animalVacina->setUsuario($usuario);
    $animalVacina->setAnv_dat_programacao(GF::convertDate($body['anv_dat_programacao']));

    $data = AnimalVacinaDao::insert($animalVacina);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});

$app->put('/animalvacinas/{anv_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$anv_int_codigo = $request->getAttribute('anv_int_codigo');

    $animalVacina = new AnimalVacina();

    // Objeto Animal
    $animal = new Animal();
    $animal->setAni_int_codigo($body['ani_int_codigo']);
    
    // Objeto Vacina
    $vacina = new Vacina();
    $vacina->setVac_int_codigo($body['vac_int_codigo']);

    // Objeto Usuário
    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($body['usu_int_codigo']); 

    $animalVacina->setAnv_int_codigo($anv_int_codigo);
    $animalVacina->setAnimal($animal);
    $animalVacina->setVacina($vacina);
    $animalVacina->setUsuario($usuario);
    $animalVacina->setAnv_dat_programacao(GF::convertDate($body['anv_dat_programacao']));
    
    $data = AnimalVacinaDao::update($animalVacina);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});

$app->put('/aplicacaovacina/{anv_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    
    $data = AnimalVacinaDao::aplicaVacina($request->getAttribute('anv_int_codigo'));
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});

$app->delete('/animalvacinas/{anv_int_codigo}/{apikey}', function (Request $request, Response $response) {
	$anv_int_codigo = $request->getAttribute('anv_int_codigo');

    $animalVacina = new AnimalVacina();
    $animalVacina->setAnv_int_codigo($anv_int_codigo);

    $data = AnimalVacinaDao::delete($animalVacina);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});
