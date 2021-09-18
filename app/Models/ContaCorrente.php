<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaCorrente extends Model {

    protected $guarded = ['id'];
    protected $table = 'conta_corrente';
    use SoftDeletes;

    public function fornecedor() 
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function anexos()
    {
        return $this->hasMany(ContaCorrenteAnexos::class);
    }

}

?>