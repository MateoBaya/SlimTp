<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Pedido as Pedido;


class PedidoController implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $productos = $parametros['productos'];
    $precioTotal = $parametros['precioTotal'];
    $tiempoTotalEstimado = $parametros['tiempoTotalEstimado'];
    $isFinished = $parametros['isFinished'];

    // Creamos el Pedido
    $pdd = new Pedido();
    $pdd->productos = $productos;
    $pdd->precioTotal = $precioTotal;
    $pdd->tiempoTotalEstimado = $tiempoTotalEstimado;
    $pdd->isFinished = $isFinished;
  
    $pdd->save();

    $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

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
    // Buscamos Pedido por nombre
    $pdd = $args['id'];

    // Buscamos por primary key
     $pedido = Pedido::find($pdd);

    // Buscamos por attr Pedido
    //$Pedido = Pedido::where('Pedido', $usr)->first();

    $payload = json_encode($pedido);

    $response->getBody()->write($payload);
    return $response
    ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Pedido::all();
    $payload = json_encode(array("listaPedidos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  
  public function ModificarUno($request, $response, $args)
{
  $parametros = $request->getParsedBody();

  $pddModificado = $parametros['productos'];
  $pedidoId = $args['id'];

  // Conseguimos el objeto
  $pdd = Pedido::where('id', '=', $pedidoId)->first();

  // Si existe
  if ($pdd !== null) {
    // Seteamos un nuevo Pedido
    $pdd->productos = $pddModificado;
    // Guardamos en base de datos
    $pdd->save();
    $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
  } else {
    $payload = json_encode(array("mensaje" => "Pedido no encontrado"));
  }

  $response->getBody()->write($payload);
  return $response
    ->withHeader('Content-Type', 'application/json');
}

  public function BorrarUno($request, $response, $args)
  {
    $pedidoId = $args['id'];
    // Buscamos el Pedido
    $pedido = Pedido::find($pedidoId);
    // Borramos
    $pedido->delete();

    $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
