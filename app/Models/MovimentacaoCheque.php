<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoCheque extends Model
{ 
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'movimentacoes_cheques';
    public $timestamps = false;
}
