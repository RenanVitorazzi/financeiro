<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estoque extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'estoque';

    public function cc_fornecedor() {
        return $this->belongsTo(ContaCorrente::class);
    } 

    public function cc_representante() {
        return $this->belongsTo(ContaCorrenteRepresentante::class);
    } 
} 
