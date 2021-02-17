<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model {
    // protected $fillable = [
    //     'nome',
    //     'email',
    //     'cep',

    // ];

    protected $guarded = ['id'];
    
    public function representante() {
        return $this->hasOne(Representante::class);
    }

    public function cliente() {
        return $this->hasOne(Cliente::class);
    }
}

?>