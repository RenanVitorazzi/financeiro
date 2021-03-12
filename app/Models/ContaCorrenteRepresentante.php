<?php

namespace App\Models;

use App\Representante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContaCorrenteRepresentante extends Model
{
    use HasFactory;
    protected $table = 'conta_corrente_representante_controllers';
    protected $guarded = ['id'];

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 

    public function scopeBalancoFator($query) {
        return $query;
    }

    // public function totalReposicao ($query, $representante_id) {
    //     return $query::select(DB::raw('sum( peso ) as peso, sum( fator ) as fator'))
    //         ->where('representante_id', $representante_id)
    //         ->where('balanco', '=', 'Reposição')
    //         ->get();
    // }

    public function scopeTotalVenda ($query, $representante_id) {
        return $query::select(DB::raw('sum( peso ) as peso, sum( fator ) as fator'))
            ->where('representante_id', $representante_id)
            ->groupBy('balanco')
            ->get();
    }

    // public function total
}
