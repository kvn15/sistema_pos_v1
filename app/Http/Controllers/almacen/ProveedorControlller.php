<?php

namespace App\Http\Controllers\almacen;

use Illuminate\Http\Request;
use App\Models\almacen\Proveedor;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ProveedorControlller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Lista
    public function index() {

        $proveedor = Proveedor::all();

        return response()->json(
            $proveedor->map( function($pro) {
                return [
                    "id" => $pro->id,
                    "ruc" => $pro->ruc,
                    "razon_social" => $pro->razon_social,
                    "ubigeo" => $pro->ubigeo,
                    "sIdUbigeo" => $pro->sIdUbigeo,
                    "direccion" => $pro->direccion,
                    "celular" => $pro->celular,
                    "email" => $pro->email,
                    'state' => $pro->state,
                    'state_name' => $pro->state == 1 ? 'Activo' : 'Desactivado'
                ];
            })
        , 200);
    }

    // store
    public function store(Request $request) {

        $request->validate([
            'ruc' => 'required|max:15',
            'razon_social' => 'required'
        ]);

        $proveedor_exists = Proveedor::where('ruc',$request->ruc)->first();

        if ($proveedor_exists) {
            return response()->json(["message" => 'El proveedor ya existe.'], 403);
        }

        $proveedor = Proveedor::create($request->all());

        return response()->json([
            "message" => "Se creo correctamente el Proveedor",
            "data" => [
                "id" => $proveedor->id,
                "ruc" => $proveedor->ruc,
                "razon_social" => $proveedor->razon_social,
                "ubigeo" => $proveedor->ubigeo,
                "sIdUbigeo" => $proveedor->sIdUbigeo,
                "direccion" => $proveedor->direccion,
                "celular" => $proveedor->celular,
                "email" => $proveedor->email,
                'state' => 1,
                'state_name' => 'Activo'
            ]
        ], 200);
    }

    // update
    public function update(Request $request, $id) {

        $request->validate([
            'ruc' => 'required|max:15',
            'razon_social' => 'required'
        ]);

        $proveedor_exists = Proveedor::where('id','<>',$id)->where('ruc',$request->ruc)->first();

        if ($proveedor_exists) {
            return response()->json(["message" => 'El proveedor ya existe.'], 403);
        }

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update($request->all());

        return response()->json([
            "message" => "Se actualizo correctamente el Proveedor",
            "data" => [
                "id" => $proveedor->id,
                "ruc" => $proveedor->ruc,
                "razon_social" => $proveedor->razon_social,
                "ubigeo" => $proveedor->ubigeo,
                "sIdUbigeo" => $proveedor->sIdUbigeo,
                "direccion" => $proveedor->direccion,
                "celular" => $proveedor->celular,
                "email" => $proveedor->email,
                'state' => $proveedor->state,
                'state_name' => $proveedor->state == 1 ? 'Activo' : 'Desactivado'
            ]
        ], 200);
    }

    public function changeEstado(Request $request, $id) {

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->state = $request->state;

        $proveedor->save();

        return response()->json(["message" => 'true'], 200);

    }

}
