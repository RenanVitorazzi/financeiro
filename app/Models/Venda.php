<?php

namespace App\Models;

use App\Models\Cliente;
use App\Models\Representante;
use App\Models\Parcela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
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

    protected static function booted()
    {
        if (auth()->user()->is_representante && !auth()->user()->is_admin) {
            static::addGlobalScope('user', function (Builder $builder) {
                $builder->where('representante_id', auth()->user()->is_representante);
            });
        }
    }
}
