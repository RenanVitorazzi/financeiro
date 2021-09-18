<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adiamento extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function cheques() 
    {
        return $this->belongsTo(Parcela::class);
    }

}
