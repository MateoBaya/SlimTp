<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Usuario as Usuario;


class UsuarioController implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $usuario = $parametros['usuario'];
    $clave = $parametros['clave'];
    $nombre = $parametros['nombre'];
    $apellido = $parametros['apellido'];
    $tipoUsuario = $parametros['tipoUsuario'];
    $idProducto = $parametros['idProducto'];
    $estatus = $parametros['estatus'];
    $tiempoEstimado = $parametros['tiempoEstimado'];
    $perfil = $parametros['perfil'];
    // Creamos el usuario
    $usr = new Usuario();
    $usr->usuario = $usuario;
    $usr->clave = $clave;
    $usr->nombre = $nombre;
    $usr->apellido = $apellido;
    $usr->tipoUsuario = $tipoUsuario;
    $usr->idProducto = $idProducto;
    $usr->estatus = $estatus;
    $usr->tiempoEstimado = $tiempoEstimado;
    $usr->perfil = $perfil;
    $usr->save();

    $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

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
    // Buscamos usuario por nombre
    $usr = $args['usuario'];

    // Buscamos por primary key
    // $usuario = Usuario::find($usr);

    // Buscamos por attr usuario
    $usuario = Usuario::where('usuario', $usr)->first();

    $payload = json_encode($usuario);

    $response->getBody()->write($payload);
    return $response
    ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Usuario::all();
    $payload = json_encode(array("listaUsuario" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  
  public function ModificarUno($request, $response, $args)
{
  $parametros = $request->getParsedBody();

  $usrModificado = $parametros['usuario'];
  $usuarioId = $args['id'];

  // Conseguimos el objeto
  $usr = Usuario::where('id', '=', $usuarioId)->first();

  // Si existe
  if ($usr !== null) {
    // Seteamos un nuevo usuario
    $usr->usuario = $usrModificado;
    // Guardamos en base de datos
    $usr->save();
    $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));
  } else {
    $payload = json_encode(array("mensaje" => "Usuario no encontrado"));
  }

  $response->getBody()->write($payload);
  return $response
    ->withHeader('Content-Type', 'application/json');
}

  public function BorrarUno($request, $response, $args)
  {
    $usuarioId = $args['id'];
    // Buscamos el usuario
    $usuario = Usuario::find($usuarioId);
    // Borramos
    $usuario->delete();

    $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
