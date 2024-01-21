<?php

namespace App\Http\Controllers\almacen;

use Illuminate\Http\Request;
use App\Models\almacen\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\almacen\ProductPriceDetail;
use App\Http\Resources\almacen\product\ProductCollection;
use App\Http\Resources\almacen\product\ProductOneResource;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Lista
    public function index() {

        $products = Product::all();

        return response()->json(ProductCollection::make($products), 200);
    }

    // Store
    public function store(Request $request) {

        $request->validate([
            'tipo_producto_id' => 'required',
            'categoria_id' => 'required',
            'codigo_barras' => 'required',
            'nombre_producto' => 'required',
            'detalle_producto' => 'required',
            'stock_inicial' => 'required',
        ]);

        $detalle = explode(",", $request->detail_unidad);

        if (count($detalle) == 0) {

            return response()->json([
                "success" => false,
                "message" => 'Debe completar el detalle de Unidad del producto.'
            ], 403);
        }

        $codigo_barra = Product::where('codigo_barras',$request->codigo_barras)->first();

        // Si el usuario existe
        if ($codigo_barra) {
            return response()->json([
                "success" => false,
                "message" => 'El codígo de barras ya existe.'
            ], 403);
        }

        $request->request->add(["stock_final" => $request->stock_inicial]);

        $prduct_create = Product::create($request->all());

        // registramos detalle

        foreach ($detalle as $value) {
            $unidad = explode("|", $value);
            ProductPriceDetail::create([
                'product_id' => $prduct_create->id,
                'unidad_medida_id' => $unidad[0],
                'cantidad_unidad' => $unidad[1],
                'precio_venta_cantidad' => $unidad[2],
            ]);
        }

        $product = Product::find($prduct_create->id);

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => 'No se pudo registrar el producto.'
            ], 403);
        }


        return response()->json([
            "success" => true,
            "message" => 'Se registro correctamente el producto.',
            'data' => $prduct_create->id
        ], 201);

    }

    //subir imagen
    public function subirNuevaImagenStore(Request $request) {

        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => 'El producto no existe'
            ], 403);
        }

        //Existe un archivo de nombre 'imagen_producto'
        if ($request->hasFile("imagen_producto")) {
            if ($product->imagen_producto) {
                Storage::delete($product->imagen_producto); //Eliminar la imagen
            }
            $path = Storage::putFile("productos", $request->file("imagen_producto")); //alamace la imagen en la clase storage
            $request->request->add(["imagen_productos" => $path]); //agregamos la ruta al $request
        }

        $product->update([
            'imagen_producto' => $request->imagen_productos == 'null' ? null : $request->imagen_productos,
        ]);

        return response()->json([
            "success" => true
        ], 201);

    }


    // Obtener Producto
    public function obtenerProducto($id) {

        $producto = Product::find($id);

        if (!$producto) {
            return response()->json([
                "success" => false,
                "message" => 'El producto no existe'
            ], 403);
        }

        return response()->json(ProductOneResource::make($producto), 200);

    }

    // Editar
    public function update(Request $request, $id) {

        $request->validate([
            'tipo_producto_id' => 'required',
            'categoria_id' => 'required',
            'codigo_barras' => 'required',
            'nombre_producto' => 'required',
            'detalle_producto' => 'required',
            'stock_inicial' => 'required',
        ]);

        $detalle = explode(",", $request->detail_unidad);

        if (count($detalle) == 0) {

            return response()->json([
                "success" => false,
                "message" => 'Debe completar el detalle de Unidad del producto.'
            ], 403);
        }

        $codigo_barra = Product::where('codigo_barras',$request->codigo_barras)->where('id','<>',$id)->first();

        // Si el usuario existe
        if ($codigo_barra) {
            return response()->json([
                "success" => false,
                "message" => 'El codígo de barras ya existe.'
            ], 403);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => 'El Producto no existe.'
            ], 403);
        }

        if ($product->stock_final > $request->stock_inicial) {
            $request->request->add(["stock_final" => $request->stock_inicial]);
        }

        $product->update($request->all());

        // Eliminamos Detalle

        $details = ProductPriceDetail::where('product_id',$id)->delete();

        // registramos detalle

        foreach ($detalle as $value) {
            $unidad = explode("|", $value);
            ProductPriceDetail::create([
                'product_id' => $id,
                'unidad_medida_id' => $unidad[0],
                'cantidad_unidad' => $unidad[1],
                'precio_venta_cantidad' => $unidad[2],
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => 'Se actualizo correctamente el producto.',
            'data' => $product->id
        ], 201);

    }

    // Desactivar
    public function changeEstado(Request $request) {

        $product = Product::find($request->id);

        $product->state = $request->state;

        $product->save();

        return response()->json(["message" => 'true'], 200);

    }

}
