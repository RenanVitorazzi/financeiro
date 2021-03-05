<?php

namespace App\Models;

use App\Cliente;
use App\Representante;
use App\Models\Parcela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['parcela'];

    public function parcela() {
        return $this->hasMany(Parcela::class);
    }

    public function representante() {
        return $this->belongsTo(Representante::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}
