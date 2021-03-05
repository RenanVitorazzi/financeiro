<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcela extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    use HasFactory, SoftDeletes;

    public function venda() {
        return $this->belongsTo(Venda::class);
    } 
}
