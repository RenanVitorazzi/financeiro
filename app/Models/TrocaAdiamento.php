<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrocaAdiamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'troca_adiamentos';

    public function cheque() 
    {
        return $this->hasMany(Parcela::class);
    }
    
    public function troca_parcela() 
    {
        return $this->belongsTo(TrocaParcela::class);
    }

}
