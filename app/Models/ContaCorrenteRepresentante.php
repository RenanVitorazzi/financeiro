<?php

namespace App\Models;

use App\Models\Representante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaCorrenteRepresentante extends Model
{
    use HasFactory;
    protected $table = 'conta_corrente_representante';
    protected $guarded = ['id'];

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 
}
