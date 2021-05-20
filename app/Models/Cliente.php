<?php

namespace App\Models;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model 
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 

    public function venda() {
        return $this->hasMany(Venda::class);
    }
}

?>