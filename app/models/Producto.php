<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    /*
    public $id;
    public $producto;
    public $descripcion;
    public $precio;
    public $personalRequerido;
    */

    protected $table = 'productos';

    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'producto', 'descripcion', 'precio', 'personalRequerido'
    ];
}
?>