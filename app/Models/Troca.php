<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use app\Parceiro;

class Troca extends Model
{
    use HasFactory;
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
