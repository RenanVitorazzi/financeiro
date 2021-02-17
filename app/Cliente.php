<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    // protected $fillable = [
    //     'id_pessoa'
    // ];
    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 
}

?>