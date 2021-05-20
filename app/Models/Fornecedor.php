<?php

namespace App\Models;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model 
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'fornecedores';

    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function venda() {
        return $this->hasMany(Venda::class);
    }

    public function contaCorrente() {
        return $this->hasMany(ContaCorrente::class)->latest();
    }
}

?>