<?php

namespace App\Models\administracion;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\administracion\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'nombres',
        'apellidos',
        'razon_social',
        'direccion',
        'telefono'
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

    // Relación de Uno a Uno
    public function tipo_documento() {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

}
