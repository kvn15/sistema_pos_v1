<?php

namespace App\Http\Controllers\almacen\carga;

use Illuminate\Http\Request;
use App\Models\almacen\Product;
use App\Http\Controllers\Controller;

class CargarProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Validar Producto x Codigo Barras
    public function validarCodigoBarra(Request $request) {

        $producto_error = array();

        $codigos = explode('|',$request->codigos_barra) ;

        for ($i=0; $i < count($codigos); $i++) {
            $product = Product::where('codigo_barras',$codigos[$i])->first();
            if ($product) {
                array_push($producto_error, $codigos[$i]);
            }
        }

        return response()->json($producto_error, 200);

    }

}
