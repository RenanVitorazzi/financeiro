<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrocaParcela extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'trocas_parcelas';

    public function parcelas() 
    {
        return $this->hasOne(Parcela::class, 'id', 'parcela_id');
    }

    public function trocas()
    {
        return $this->belongsTo(Troca::class, 'troca_id');
    }

    public function adiamento()
    {
        return $this->hasMany(TrocaAdiamento::class, 'troca_parcela_id');
    }
}
