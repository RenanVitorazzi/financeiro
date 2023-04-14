<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model 
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function cliente() {
        return $this->hasMany(Cliente::class);
    } 

    public function conta_corrente()
    {
        return $this->hasMany(ContaCorrenteRepresentante::class);
    }

    public function venda()
    {
        return $this->hasMany(Venda::class);
    }

    public function parcelas()
    {
        return $this->hasMany(Parcela::class);
    }

    public function scopeAdiamentos($query)
    {
        return $query->with(['parcelas' => function ($query) {
            $query->whereHas('adiamentos')->withSum('adiamentos', 'juros_totais');
        }]);
    }

    public function scopeEmpresa($query)
    {
        return $query->where('atacado', NULL);
    }

    protected static function booted()
    {
        if (auth()->user()->is_representante && !auth()->user()->is_admin) {
            static::addGlobalScope('user', function (Builder $builder) {
                $builder->where('id', auth()->user()->is_representante);
            });
        }
    }
}

?>