<?php

namespace App\Http\Controllers\Sunat;

use Illuminate\Http\Request;
use App\Models\Sunat\Voucher;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // lista
    public function lista() {

        $vouchers = Voucher::all();

        return response()->json(
            $vouchers->map( function($voucher) {
                return [
                    'id' => $voucher->id,
                    'documento' => $voucher->documento,
                    'serie' => $voucher->serie,
                    'numero' => $voucher->numero,
                    'state' => $voucher->state,
                    'state_name' => $voucher->state == 1 ? 'Activo' : 'Desactivado',
                ];
            })
        , 200);
    }

    // store
    public function store(Request $request) {

        $voucher_exist = Voucher::where('serie',$request->serie)->first();

        if ($voucher_exist) {
            return response()->json(["message" => 'La serie ya existe en nuestra base de datos.'], 403);
        }

        $request->validate([
            'documento' => 'required',
            'serie' => 'required',
        ]);

        $voucher = Voucher::create($request->all());

        $voucher = Voucher::find($voucher->id);

        return response()->json([
            "message" => 'Se registro correctamente el tipo de comprobante',
            "data" => [
                'id' => $voucher->id,
                'documento' => $voucher->documento,
                'serie' => $voucher->serie,
                'numero' => $voucher->numero,
                'state' => $voucher->state,
                'state_name' => $voucher->state == 1 ? 'Activo' : 'Desactivado',
            ]
        ], 200);
    }

    // Actualizar
    public function update(Request $request, $id) {

        $voucher_exist = Voucher::where('serie',$request->serie)->where('id','<>',$id)->first();

        if ($voucher_exist) {
            return response()->json(["message" => 'La serie ya existe en nuestra base de datos.'], 403);
        }

        $voucher = Voucher::find($id);

        if (!$voucher) {
            return response()->json(["message" => 'El documento no existe.'], 403);
        }

        $request->validate([
            'documento' => 'required',
            'serie' => 'required',
            'numero' => 'required'
        ]);

        $voucher->update($request->all());

        return response()->json([
            "message" => 'Se actualizo correctamente el tipo de comprobante',
            "data" => [
                'id' => $voucher->id,
                'documento' => $voucher->documento,
                'serie' => $voucher->serie,
                'numero' => $voucher->numero,
                'state' => $voucher->state,
                'state_name' => $voucher->state == 1 ? 'Activo' : 'Desactivado',
            ]
        ], 200);
    }

    // Actualizar Estado
    public function changeEstado(Request $request) {

        $voucher = Voucher::find($request->id);

        $voucher->state = $request->state;

        $voucher->save();

        return response()->json(["message" => 'true'], 200);

    }
}
