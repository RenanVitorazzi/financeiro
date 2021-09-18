<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Troca extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function cheques() 
    {
        return $this->hasMany(TrocaParcela::class);
    }

    public function parceiro()
    {
        return $this->belongsTo(Parceiro::class);
    }

}
