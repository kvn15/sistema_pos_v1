<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\administracion\Client;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Listar
    public function lista() {

        $client = Client::all();

        return response()->json($client->map( function($c) {
            return [
                'id' => $c->id,
                'tipo_documento_id' => $c->tipo_documento_id ,
                'abrev_tipo_doc' => $c->tipo_documento->abrev_tipo_doc,
                'nro_documento' => $c->nro_documento,
                'nombres' => $c->nombres,
                'apellidos' => $c->apellidos,
                'razon_social' => $c->razon_social,
                'direccion' => $c->direccion,
                'telefono' => $c->telefono
            ];
        }), 200);
    }

    // Crear
    public function store(Request $request) {

        $client_exists = Client::where('tipo_documento_id',$request->tipo_documento_id)->where('nro_documento',$request->nro_documento)->first();

        if ($client_exists) {
            return response()->json(["message" => 'El Nro de Documento ya existe, por favor digitar otro.'], 403);
        }

        $request->validate([
            'tipo_documento_id' => 'required',
            'nro_documento' => 'required'
        ]);

        $client = Client::create($request->all());

        $client = Client::find($client->id);

        return response()->json([
            'id' => $client->id,
            'tipo_documento_id' => $client->tipo_documento_id ,
            'abrev_tipo_doc' => $client->tipo_documento->abrev_tipo_doc,
            'nro_documento' => $client->nro_documento,
            'nombres' => $client->nombres,
            'apellidos' => $client->apellidos,
            'razon_social' => $client->razon_social,
            'direccion' => $client->direccion,
            'telefono' => $client->telefono
        ], 200);
    }

     // Actualizar
     public function update(Request $request, $id) {

        $client_exists = Client::where('tipo_documento_id',$request->tipo_documento_id)->where('nro_documento',$request->nro_documento)->where('id','<>',$id)->first();

        if ($client_exists) {
            return response()->json(["message" => 'El Nro de Documento ya existe, por favor digitar otro.'], 403);
        }

        $client = Client::find($id);

        if (!$client) {
            return response()->json(["message" => 'El cliente no existe.'], 403);
        }

        $request->validate([
            'tipo_documento_id' => 'required',
            'nro_documento' => 'required'
        ]);

        $client->update($request->all());

        return response()->json([
            'id' => $client->id,
            'tipo_documento_id' => $client->tipo_documento_id ,
            'abrev_tipo_doc' => $client->tipo_documento->abrev_tipo_doc,
            'nro_documento' => $client->nro_documento,
            'nombres' => $client->nombres,
            'apellidos' => $client->apellidos,
            'razon_social' => $client->razon_social,
            'direccion' => $client->direccion,
            'telefono' => $client->telefono
        ], 200);
    }

    // Eliminar Cliente
    public function delete($id) {

        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                "success" => false,
                "message" => 'El cliente no existe.'],
            403);
        }

        $client->delete();

        return response()->json([
            "success" => true,
            "message" => 'El cliente se elimino correctamente.'
        ], 201);
    }
}
