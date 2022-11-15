<?php
use Slim\Psr7\Response;

class Logger
{

    public static function VerificadorCredenciales($request, $handler)
    {
        $requestType=$request->getMethod();
        if($requestType === "GET")
        {
            $response = $handler->handle($request);
            $response->getBody()->write("{API->GET}");
        }
        else if($requestType === "POST")
        {
            $dataParseada = $request->getParsedBody();
            $nombre = $dataParseada['usuario'];
            $perfil = $dataParseada['perfil'];
            if($perfil === 'admin')
            {
                $response = $handler->handle($request);
                $response->getBody()->write("Metodo ".$requestType." verificar");
                $response->getBody()->write("Bienvenido {$nombre}!");
                $response = $response->withStatus(200);
            }
            else
            {
                $response = new Response();
                $response->getBody()->write("Usuario no administrador");
                $response = $response->withStatus(401);
            }

        }
        return $response;
    }
}