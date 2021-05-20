<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model 
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function cliente() {
        return $this->hasMany(Cliente::class);
    } 

    public function conta_corrente()
    {
        return $this->hasMany(ContaCorrenteRepresentante::class);
    }

    public function venda()
    {
        return $this->hasMany(Venda::class);
    }
}

?>