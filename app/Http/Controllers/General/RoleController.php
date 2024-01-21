<?php

namespace App\Http\Controllers\General;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function listaRole() {
        $roles = Role::all();

        return response()->json($roles, 200);
    }
}
