<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adiamento extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function parcelas() 
    {
        return $this->belongsTo(Parcela::class, 'parcela_id');
    }

    // public function scopePagos($query)
    // {
    //     return $query->where('pago', 1);
    // }

    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->whereNull('pago');
        });
    }
}
