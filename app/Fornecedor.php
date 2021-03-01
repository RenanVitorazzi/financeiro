<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model {

    protected $guarded = ['id'];
    protected $table = 'fornecedores';

    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

}

?>