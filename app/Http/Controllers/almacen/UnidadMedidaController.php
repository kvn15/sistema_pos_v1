<?php

namespace App\Http\Controllers\almacen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\almacen\UnidadMedida;

class UnidadMedidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Lista
    public function index() {

        $unidad = UnidadMedida::all();

        return response()->json(
            $unidad->map( function($c) {
                return [
                    "id" => $c->id,
                    "name" => $c->name,
                    'abreviatura' => $c->abreviatura,
                    'equivalencia' => $c->equivalencia,
                    'state' => $c->state,
                    'state_name' => $c->state == 1 ? 'Activo' : 'Desactivado'
                ];
            })
        , 200);
    }

    // Store
    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'abreviatura' => 'required',
        ]);

        $unidad = UnidadMedida::create([
            'name' => $request->name,
            'abreviatura' => $request->abreviatura,
            'equivalencia' => $request->equivalencia,
            'state' => 1 // Activo
        ]);

        return response()->json([
            "message" => "Se creo correctamente la Unidad de Medida",
            "data" => [
                "id" => $unidad->id,
                "name" => $unidad->name,
                'abreviatura' => $unidad->abreviatura,
                'equivalencia' => $unidad->equivalencia,
                'state' => 1,
                'state_name' => 'Activo'
            ]
        ], 200);
    }

    // update
    public function update(Request $request, $id) {

        $unidad_exists = UnidadMedida::where('id','<>',$id)->where('name',$request->name)->first();

        if ($unidad_exists) {
            return response()->json(["message" => 'La Unidad de Medida ya existe, por favor digitar otro.'], 403);
        }

        $unidad = UnidadMedida::findOrFail($id);

        $unidad->update($request->all());

        return response()->json([
            "message" => "Se actualizo correctamente la Unidad de Medida",
            "data" => [
                "id" => $unidad->id,
                "name" => $unidad->name,
                'abreviatura' => $unidad->abreviatura,
                'equivalencia' => $unidad->equivalencia,
                'state' => $unidad->state,
                'state_name' => $unidad->state == 1 ? 'Activo' : 'Desactivado'
            ]
        ], 200);
    }

    public function changeEstado(Request $request, $id) {

        $unidad = UnidadMedida::findOrFail($id);

        $unidad->state = $request->state;

        $unidad->save();

        return response()->json(["message" => 'true'], 200);

    }

    //Eliminar
    public function delete($id) {

        $unidad = UnidadMedida::findOrFail($id);

        $unidad->delete();

        return response()->json(["message" => 'Se elimino correctamente la Unidad de Medida'], 200);

    }
}
