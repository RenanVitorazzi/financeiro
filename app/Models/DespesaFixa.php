<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespesaFixa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'despesas_fixas';
    public $timestamps = false;
    
    public function local() {
        return $this->belongsTo(Local::class);
    } 

    public function despesas() {
        return $this->belongsTo(Despesa::class);
    } 
}
