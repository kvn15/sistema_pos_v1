<?php

namespace App\Models\general;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoProducto extends Model
{
    use HasFactory;

    protected $table = "tipo_products";

    protected $fillable = [
        'tipo_producto',
        'state'
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
