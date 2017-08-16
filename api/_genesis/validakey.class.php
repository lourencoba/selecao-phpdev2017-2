<?php

/**
 * Middleware para validação da APIKEY
 */

class ValidaKey {

    public function __invoke($request, $response, $next) {

        if ($request->getAttribute('apikey') != API_KEY) {
            return "APIKEY negada";
        }

        return $next($request, $response);

    }
}

?>