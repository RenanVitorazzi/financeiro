<?php

namespace App\Models;

use App\Models\Representante;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaCorrenteRepresentante extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'conta_corrente_representante';
    protected $guarded = ['id'];

    public function representante() {
        return $this->belongsTo(Representante::class);
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
