<?php

namespace App\Models;

use App\Representante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrenteRepresentante extends Model
{
    use HasFactory;
    protected $table = 'conta_corrente_representante_controllers';

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 
}
