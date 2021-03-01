<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ContaCorrente extends Model {

    protected $guarded = ['id'];
    protected $table = 'contas_correntes';

    public function fornecedor() {
        return $this->hasMany(Fornecedor::class);
    } 

    // protected static function scopeCompra($query) {
    //     return $query->where('balanco', 'Crédito');

        // $debito = $this->where('balanco', 'Débito')
        //     ->where('fornecedor_id', $fornecedor_id)
        //     ->sum('peso')
        //     ->get();

        
    // }

    public function scopeTotalCredito($query, $fornecedor_id)
    {
        return $query->where('balanco', 'Crédito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
    }

    public function scopeTotalDebito($query, $fornecedor_id)
    {
        return $query->where('balanco', 'Débito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
    }

    public function scopeTotalGeral($query, $fornecedor_id)
    {
        $debito = $this->where('balanco', 'Débito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
        $credito = $this->where('balanco', 'Crédito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
        $total = $credito - $debito;
        return $total;
    }
}

?>