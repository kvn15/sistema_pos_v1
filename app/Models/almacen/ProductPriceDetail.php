<?php

namespace App\Models\almacen;

use Carbon\Carbon;
use App\Models\almacen\Product;
use App\Models\almacen\UnidadMedida;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPriceDetail extends Model
{
    use HasFactory;

    protected $table = "product_price_details";

    protected $fillable = [
        'product_id',
        'unidad_medida_id',
        'cantidad_unidad',
        'precio_venta_cantidad',
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

    // Relacion con producto
    public function product()  {
        return $this->belongsTo(Product::class);
    }

    // Relacion categoria - Uno a Uno
    public function unidad_medida() {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }
}
