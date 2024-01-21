<?php

namespace App\Http\Controllers\General;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function menuPermission($roleId) {

        $role = Role::findOrFail($roleId);

        $user = User::where('id', auth()->user()->id)->first();

        return response()->json([
            "name_role" => $role->rol_name,
            "permission" => $user->premission_user->map( function($var) {
                return $var->permission->cod_permission;
            })
        ], 200);
    }

    public function listaPermission() {
        $permission = Permission::all();

        return response()->json(
            $permission->map(function($per) {
                return [
                    'id' => $per->id,
                    'cod_permission' => $per->cod_permission,
                    'name_permission' => $per->name_permission
                ];
            })
        , 200);
    }
}
