<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Models\general\Marca;
use App\Models\almacen\Product;
use App\Models\almacen\Categorie;
use App\Models\almacen\Proveedor;
use App\Models\sunat\TributoSunat;
use App\Models\general\Laboratorio;
use App\Models\sunat\TipoDocumento;
use App\Http\Controllers\Controller;
use App\Models\almacen\UnidadMedida;
use App\Models\general\TipoProducto;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Obtener
    public function listaGeneralProducto() {

        $tipo_producto = TipoProducto::where('state',1)->get();
        $categoria = Categorie::where('state',1)->get();
        $proveedor = Proveedor::where('state',1)->get();
        $tributo_sunat = TributoSunat::where('state',1)->get();
        $unidad_medida = UnidadMedida::where('state',1)->get();
        $laboratorio = Laboratorio::where('state',1)->get();
        $marca = Marca::where('state',1)->get();

        return response()->json([
            compact('tipo_producto'),
            compact('categoria'),
            compact('proveedor'),
            compact('tributo_sunat'),
            compact('unidad_medida'),
            compact('laboratorio'),
            compact('marca')
        ], 200);

    }


    // Lista de tipos de documentos
    public function obtenerTipoDocumento() {

        $tipo_documento = TipoDocumento::all();

        return response()->json($tipo_documento, 200);

    }

    // Obtener Productos para venta
    public function productosVenta() {

        $products = Product::where('state',1)->get();

        return response()->json($products->map( function( $product ){
            return [
                'id' => $product->id,
                'codigo_barras' => $product->codigo_barras,
                'nombre_producto' => $product->nombre_producto,
                'categoria_id' => $product->categoria_id,
                'name_categoria' => $product->categorie->name,
                'stock_final' => $product->stock_final,
                'unidadMedida' => $product->product_detail->map( function( $detail ) {
                    return [
                        'unidad_medida_id' => $detail->unidad_medida_id,
                        'unidad_medida' => $detail->unidad_medida->name,
                        'cantidad_unidad' => $detail->cantidad_unidad,
                        'precio_venta_cantidad' => $detail->precio_venta_cantidad,
                    ];
                })
            ];
        }), 200);

    }

}
