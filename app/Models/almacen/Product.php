<?php

namespace App\Models\almacen;

use Carbon\Carbon;
use App\Models\general\Marca;
use App\Models\almacen\Categorie;
use App\Models\almacen\Proveedor;
use App\Models\sunat\TributoSunat;
use App\Models\general\Laboratorio;
use App\Models\almacen\UnidadMedida;
use App\Models\general\TipoProducto;
use Illuminate\Database\Eloquent\Model;
use App\Models\almacen\ProductPriceDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_producto_id',
        'categoria_id',
        'codigo_barras',
        'nombre_producto',
        'detalle_producto',
        'principio_activo',
        'marca_id',
        'marca_otro',
        'provedor_id',
        'stock_inicial',
        'stock_limite',
        'imagen_producto',
        'fecha_vencimiento',
        'lote',
        'registro_sanitario',
        'presentacion',
        'tributo_sunat_id',
        'laboratorio_id',
        'state',
        'laboratorio_otro'
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

    // Relacion PRODUCTO CON DETALLE
    public function product_detail() {
        return $this->hasMany(ProductPriceDetail::class);
    }

    // Relacion categoria - Uno a Uno
    public function categorie() {
        return $this->belongsTo(Categorie::class, 'categoria_id');
    }

    // Relacion tipo producto - Uno a Uno
    public function tipo_producto() {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }

    // Relacion marca - Uno a Uno
    public function marca() {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    // Relacion proveedor - Uno a Uno
    public function proveedor() {
        return $this->belongsTo(Proveedor::class, 'provedor_id');
    }

    // Relacion laboratorio - Uno a Uno
    public function laboratorio() {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }

    // Relacion tributo - Uno a Uno
    public function tributo() {
        return $this->belongsTo(TributoSunat::class, 'tributo_sunat_id');
    }
}
