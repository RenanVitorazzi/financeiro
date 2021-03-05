<?php

namespace App;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model {

    protected $guarded = ['id'];
    protected $table = 'fornecedores';

    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function venda() {
        return $this->hasMany(Venda::class);
    }
}

?>