<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Mesa as Mesa;


class MesaController implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $estado = $parametros['estado'];
    $idPedido = $parametros['idPedido'];

    // Creamos la mesa
    $mesa = new Mesa();
    $mesa->estado = $estado;
    $mesa->idPedido = $idPedido;

    $mesa->save();

    $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function VerificarUsuario($request, $response, $args)
  {
      $payload = json_encode(array("mensaje" => "Pase por POST"));
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
      ;
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos mesa por id 
    $ms= $args['id'];

    // Buscamos por primary key
     $mesa = Mesa::find($ms);

    // Buscamos por attr Mesa
    //$mesa = Mesa::where('mesa', $usr)->first();

    $payload = json_encode($mesa);

    $response->getBody()->write($payload);
    return $response
    ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Mesa::all();
    $payload = json_encode(array("listaMesas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  
  public function ModificarUno($request, $response, $args)
{
  $parametros = $request->getParsedBody();

  $msModificado = $parametros['estado'];
  $mesaId = $args['id'];

  // Conseguimos el objeto
  $ms = Mesa::where('id', '=', $mesaId)->first();

  // Si existe
  if ($ms !== null) {
    // Seteamos un nuevo estado
    $ms->estado = $msModificado;
    // Guardamos en base de datos
    $ms->save();
    $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));
  } else {
    $payload = json_encode(array("mensaje" => "Mesa no encontrada"));
  }

  $response->getBody()->write($payload);
  return $response
    ->withHeader('Content-Type', 'application/json');
}

  public function BorrarUno($request, $response, $args)
  {
    $mesaId = $args['id'];
    // Buscamos la mesa
    $mesa = Mesa::find($mesaId);
    // Borramos
    $mesa->delete();

    $payload = json_encode(array("mensaje" => "Mesa borrado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}