<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    //
    protected $table = 'inventario';
    protected $fillable = [
        'id_sucursal', 'id_comic', 'nombre_comic', 'image', 'stock'
    ];
}
