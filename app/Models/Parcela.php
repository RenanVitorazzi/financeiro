<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcela extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    use HasFactory, SoftDeletes;

    public function venda() 
    {
        return $this->belongsTo(Venda::class);
    } 

    public function representante()
    {
        return $this->belongsTo(Representante::class);
    }

    public function parceiro()
    {
        return $this->belongsTo(Parceiro::class);
    }

    public function adiamentos()
    {
        return $this->hasMany(Adiamento::class);
    }

    public function troca()
    {
        return $this->belongsTo(TrocaParcela::class);
    }

    protected static function booted()
    {
        // if (auth()->user()->is_representante && !auth()->user()->is_admin) {
        //     static::addGlobalScope('user', function (Builder $builder) {
        //         $builder->where('representante_id', auth()->user()->is_representante);
        //     });
        // }
    }

}
