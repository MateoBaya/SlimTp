<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    /*
    public $id;
    public $productos;
    public $precioTotal;
    public $tiempoTotalEstimado;
    public $isFinished;
    */
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $table = 'productos';

    protected $fillable = [
        'productos', 'precioTotal', 'tiempoTotalEstimado', 'isFinished'
    ];
}
?>