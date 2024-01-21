<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ConsultaSunatController extends Controller
{
    // Consulta Ruc

    public function consultaRucSunat($ruc) {
        try {
            $response = Http::get('https://dniruc.apisperu.com/api/v1/ruc/'.$ruc.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFsbGluZXJwc29mdHdhcmVzYWNAZ21haWwuY29tIn0.CqzKsBSzn3-lV-AAnRjurJuGrR_ebBOIvnsEiuj7PMk');

            return response()->json($response->json(), 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => 'No se encontro Ruc, por favor registrarlo manualmente.'], 403);
        }
    }

    //Consulta DNI
    public function consultaDniSunat($dni) {
        try {
            $response = Http::get('https://dniruc.apisperu.com/api/v1/dni/'.$dni.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFsbGluZXJwc29mdHdhcmVzYWNAZ21haWwuY29tIn0.CqzKsBSzn3-lV-AAnRjurJuGrR_ebBOIvnsEiuj7PMk');

            return response()->json($response->json(), 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => 'No se encontro Dni, por favor registrarlo manualmente.'], 403);
        }
    }
}
