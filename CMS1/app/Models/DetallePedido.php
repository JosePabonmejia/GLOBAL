<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id';
    // protected $foreignKey = ['pedido_id', 'producto_id'];

    protected $fillable = ['cantidad', 'costo_unitario', 'subtotal'];
}
