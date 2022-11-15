<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Producto as Producto;


class ProductoController implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $producto = $parametros['producto'];
    $descripcion = $parametros['descripcion'];
    $precio = $parametros['precio'];
    $personalRequerido = $parametros['personalRequerido'];
;
    // Creamos el producto
    $prd = new Producto();
    $prd->descripcion = $descripcion;
    $prd->precio = $precio;
    $prd->personalRequerido = $personalRequerido;

    $prd->save();

    $payload = json_encode(array("mensaje" => "Producto creado con exito"));

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
    // Buscamos producto por nombre
    $prd = $args['producto'];

    // Buscamos por primary key
    // $producto = Producto::find($usr);

    // Buscamos por attr producto
    $producto = Producto::where('producto', $prd)->first();

    $payload = json_encode($producto);

    $response->getBody()->write($payload);
    return $response
    ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Producto::all();
    $payload = json_encode(array("listaProductos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  
  public function ModificarUno($request, $response, $args)
{
  $parametros = $request->getParsedBody();

  $usrModificado = $parametros['producto'];
  $productoId = $args['id'];

  // Conseguimos el objeto
  $usr = Producto::where('id', '=', $productoId)->first();

  // Si existe
  if ($usr !== null) {
    // Seteamos un nuevo producto
    $usr->producto = $usrModificado;
    // Guardamos en base de datos
    $usr->save();
    $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
  } else {
    $payload = json_encode(array("mensaje" => "Producto no encontrado"));
  }

  $response->getBody()->write($payload);
  return $response
    ->withHeader('Content-Type', 'application/json');
}

  public function BorrarUno($request, $response, $args)
  {
    $productoId = $args['id'];
    // Buscamos el producto
    $producto = Producto::find($productoId);
    // Borramos
    $producto->delete();

    $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}