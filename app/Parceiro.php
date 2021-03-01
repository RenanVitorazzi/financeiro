<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parceiro extends Model {

    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

}

?>