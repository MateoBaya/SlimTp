<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;

    /*
    public $id;
    public $usuario;
    public $clave;
    public $nombre;
    public $apellido;
    public $tipoUsuario;
    public $idProducto;
    public $estatus;
    public $tiempoEstimado;
    public $perfil;
    */
    /*
    function __construct()
    {
        
    }
    */
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $incrementing = true;
    const UPDATED_AT = null;
    const CREATED_AT = 'fechaAlta';
    const DELETED_AT = 'fechaBaja';

    protected $fillable = [
        'usuario', 'clave', 'nombre', 'apellido', 'tipoUsuario', 'idProducto', 'estatus', 'tiempoEstimado', 'perfil', 'fechaAlta','fechaBaja'
    ];
}
