<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/usuarioDao.php';

$app->get('/usuarios/{usu_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $usu_int_codigo = $request->getAttribute('usu_int_codigo');
    
    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($usu_int_codigo);

    $data = UsuarioDao::selectByIdForm($usuario);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});

$app->post('/usuarios/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $usuario = new Usuario();
    $usuario->setUsu_var_nome($body['usu_var_nome']);
    $usuario->setUsu_var_email($body['usu_var_email']);
    $usuario->setUsu_cha_status($body['usu_cha_status']);

    $data = UsuarioDao::insert($usuario);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});

$app->put('/usuarios/{usu_int_codigo}/{apikey}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$usu_int_codigo = $request->getAttribute('usu_int_codigo');
    
    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($usu_int_codigo);
    $usuario->setUsu_var_nome($body['usu_var_nome']);
    $usuario->setUsu_var_email($body['usu_var_email']);
    $usuario->setUsu_cha_status($body['usu_cha_status']);

    $data = UsuarioDao::update($usuario);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});

$app->delete('/usuarios/{usu_int_codigo}/{apikey}', function (Request $request, Response $response) {
	$usu_int_codigo = $request->getAttribute('usu_int_codigo');
    
    $usuario = new Usuario();
    $usuario->setUsu_int_codigo($usu_int_codigo);

    $data = UsuarioDao::delete($usuario);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});
