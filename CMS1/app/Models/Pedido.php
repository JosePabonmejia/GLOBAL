<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';
    protected $primarykey = 'id';
    protected $foreingkey = ['users_id'];

    protected $fillable = ['provincia', 'localidad', 'direccion', 'costo_total', 'fecha', 'estado'];

    public function user(){
        return $this->hasOne(User::class , 'id', 'users_id');
    }

    public function productos(){
        return $this->belongsToMany(Product::class, 'detalle_pedido')->withPivot('cantidad', 'costo_unitario', 'subtotal');
    }
}
