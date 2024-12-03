<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function productos(){
        return $this->belongsToMany(Producto::class)
                    ->withPivot(["cantidad"])
                    ->withTimestamps();
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
