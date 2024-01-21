<?php

namespace App\Models\Sunat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'serie',
        'numero',
        'state',
    ];

    //Mutators para cambiar la zona horaria del los timestamp
    public function setCreateAtAttribute($value) {
        date_default_timezone_set("America/Lima");//definimos sona horaria
        $this->attributes["created_at"] = Carbon::now(); //clase en laravel que nos permite manejar fechas
    }

    public function setUpdateAtAttribute($value) {
        date_default_timezone_set("America/Lima");//definimos sona horaria
        $this->attributes["updated_at"] = Carbon::now();
    }
}
