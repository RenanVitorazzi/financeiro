<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representante extends Model {
    // protected $fillable = [
    //     'id_pessoa'
    // ];
    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function cliente() {
        return $this->hasMany(Cliente::class);
    } 
}

?>