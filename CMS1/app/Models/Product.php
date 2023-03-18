<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primarykey = 'id';
    protected $foreingkey = ['category_id', 'brand_id'];

    protected $fillable = ['name', 'slug', 'details', 'price', 'shipping_cost', 'description', 'image_path', 'estado'];

    public function categoria(){
        return $this->hasOne(Categoria::class, 'id', 'category_id');
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class, 'detalle_pedido');
    }


    public function dashboard(){
        //Medicamento Evolucion
        $pedido_productos = DB::select("SELECT sum(dt.cantidad) AS cantidad, p.name FROM detalle_pedido dt 
        INNER JOIN products p ON dt.product_id = p.id 
        GROUP BY p.id LIMIT 3");

        // //Medicamento Indicación
        // $medicamento_ind = DB::select("SELECT sum(dt.cantidad) AS cantidad, m.nombre FROM detalle_tratamiento_indicacion dt 
        // INNER JOIN medicamento m ON dt.medicamento_id = m.id 
        // GROUP BY m.id LIMIT 3");
        return $pedido_productos;

    }
}
