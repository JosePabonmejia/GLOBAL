<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';
    protected $primaryKey = 'id';

    protected $fillable = ['nombre', 'estado'];
    
    //Relación de muchos a uno
    public function productos(){

        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
