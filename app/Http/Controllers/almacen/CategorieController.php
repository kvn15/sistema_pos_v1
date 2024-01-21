<?php

namespace App\Http\Controllers\almacen;

use Illuminate\Http\Request;
use App\Models\almacen\Categorie;
use App\Http\Controllers\Controller;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Lista
    public function index() {

        $categorie = Categorie::all();

        return response()->json(
            $categorie->map( function($c) {
                return [
                    "id" => $c->id,
                    "name" => $c->name,
                    'state' => $c->state,
                    'state_name' => $c->state == 1 ? 'Activo' : 'Desactivado'
                ];
            })
        , 200);
    }

    // Store
    public function store(Request $request) {

        $categorie_exists = Categorie::where('name',$request->name)->first();

        if ($categorie_exists) {
            return response()->json(["message" => 'La categoría ya existe, por favor digitar otro.'], 403);
        }

        $request->validate([
            'name' => 'required'
        ]);

        $categorie = Categorie::create([
            'name' => $request->name,
            'state' => 1 // Activo
        ]);

        return response()->json([
            "message" => "Se creo correctamente la Categoría",
            "data" => [
                "id" => $categorie->id,
                "name" => $categorie->name,
                'state' => 1,
                'state_name' => 'Activo'
            ]
        ], 200);
    }

    // update
    public function update(Request $request, $id) {

        $categorie_exists = Categorie::where('id','<>',$id)->where('name',$request->name)->first();

        if ($categorie_exists) {
            return response()->json(["message" => 'La categoría ya existe, por favor digitar otro.'], 403);
        }

        $categorie = Categorie::findOrFail($id);

        $categorie->update($request->all());

        return response()->json([
            "message" => "Se actualizo correctamente la Categoría",
            "data" => [
                "id" => $categorie->id,
                "name" => $categorie->name,
                'state' => $categorie->state,
                'state_name' => $categorie->state == 1 ? 'Activo' : 'Desactivado'
            ]
        ], 200);
    }

    public function changeEstado(Request $request, $id) {

        $categorie = Categorie::findOrFail($id);

        $categorie->state = $request->state;

        $categorie->save();

        return response()->json(["message" => 'true'], 200);

    }

}
