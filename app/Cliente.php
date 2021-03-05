<?php

namespace App;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    // protected $fillable = [
    //     'id_pessoa'
    // ];
    protected $guarded = ['id'];
    
    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    } 

    public function representante() {
        return $this->belongsTo(Representante::class);
    } 

    public function venda() {
        return $this->hasMany(Venda::class);
    }
}

?>