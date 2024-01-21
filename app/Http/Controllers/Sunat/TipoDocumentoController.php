<?php

namespace App\Http\Controllers\sunat;

use Illuminate\Http\Request;
use App\Models\sunat\TipoDocumento;
use App\Http\Controllers\Controller;

class TipoDocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // lista
    public function lista() {

        $tipoDoc = TipoDocumento::all();

        return response()->json($tipoDoc, 200);
    }

    // store
    public function store(Request $request) {

        $validTD = TipoDocumento::where('cod_tipo_doc',$request->cod_tipo_doc)->first();

        if ($validTD) {
            return response()->json(["message" => 'El código del tipo de documento ya existe en nuestra base de datos.'], 403);
        }

        $request->validate([
            'cod_tipo_doc' => 'required',
            'tipo_doc' => 'required',
            'abrev_tipo_doc' => 'required',
            'long_tipo_doc' => 'required',
        ]);

        $tipoDoc = TipoDocumento::create($request->all());

        return response()->json([
            "success" => true,
            "message" => 'Se creo correctamente el Tipo de Documento',
            "data" => $tipoDoc
        ], 200);
    }

    // update
    public function update(Request $request, $id) {

        $validTD = TipoDocumento::where('cod_tipo_doc',$request->cod_tipo_doc)->where('id','<>',$id)->first();

        if ($validTD) {
            return response()->json(["message" => 'El código del tipo de documento ya existe en nuestra base de datos.'], 403);
        }

        $tipoDoc = TipoDocumento::find($id);

        if (!$tipoDoc) {
            return response()->json(["message" => 'El tipo de documento no existe.'], 403);
        }

        $request->validate([
            'cod_tipo_doc' => 'required',
            'tipo_doc' => 'required',
            'abrev_tipo_doc' => 'required',
            'long_tipo_doc' => 'required',
        ]);

        $tipoDoc->update($request->all());

        return response()->json([
            "success" => true,
            "message" => 'Se actualizo correctamente el Tipo de Documento',
            "data" => $tipoDoc
        ], 200);
    }

    // eliminar
    public function delete($id) {
        $tipoDoc = TipoDocumento::find($id);

        $tipoDoc->delete();

        return response()->json([
            "success" => true,
            "message" => 'Se elimino correctamente el Tipo de Documento'
        ], 200);
    }
}
