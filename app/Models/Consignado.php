<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignado extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function representante() 
    {
        return $this->belongsTo(Representante::class)->with('pessoa');
    }

    public function venda() 
    {
        return $this->belongsTo(Venda::class);
    }

    public function cliente() 
    {
        return $this->belongsTo(Cliente::class)->with('pessoa');;
    }
}
