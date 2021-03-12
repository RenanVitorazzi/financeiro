<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ContaCorrente extends Model {

    protected $guarded = ['id'];
    protected $table = 'contas_correntes';

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }

    public function scopeTotalCredito($query, $fornecedor_id)
    {
        return $query->where('balanco', 'Crédito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
    }

    public function scopeTotalDebito($query, $fornecedor_id)
    {
        return $query->where('balanco', 'Débito')->where('fornecedor_id', $fornecedor_id)->sum('peso');
    }

    public function scopeBalanco($query, $fornecedor_id)
    {
        $debito = $this->totalDebito($fornecedor_id);
        $credito = $this->totalCredito($fornecedor_id);

        return $credito - $debito;
    }
}

?>