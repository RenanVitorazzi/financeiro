<?php

namespace App\Models;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model 
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $with = ['pessoa'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 

    public function venda() {
        return $this->hasMany(Venda::class);
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

?>