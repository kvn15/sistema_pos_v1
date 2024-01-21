<?php

namespace App\Http\Controllers\Administracion;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PermissionUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        $users = User::all();
        return response()->json(
            $users->map(function($user) {

                $per = $user->premission_user->map(function($p){
                    return $p->permission_id;
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'user' => $user->user,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                    "role_name" => $user->role->rol_name,
                    "file_foto" => $user->file_foto ?? '',
                    'state' => $user->state,
                    'state_name' => $user->state == 1 ? 'Activo' : 'Desactivado',
                    "permissions" => implode('|',$per->toArray())
                ];
            })
        , 200);
    }

    // Registrar Usuario
    public function store(Request $request) {

        $user = User::where('user', $request->user)->first();

        // Si el usuario existe
        if ($user) {
            return response()->json(["message" => 'El usuario ya existe, por favor digitar otro.'], 403);
        }

        //Existe un archivo de nombre 'file_foto'
        if ($request->hasFile("file_foto")) {
            $path = Storage::putFile("usuarios", $request->file("file_foto")); //alamace la imagen en la clase storage
            $request->request->add(["imagen" => $path]); //agregamos la ruta al $request
        }

        // creamos el usuario
        $user_create = User::create([
            'name' => $request->name,
            'user' => $request->user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'file_foto' => $request->imagen,
            'role_id' => $request->role_id
        ]);

        $permisos = explode("|", $request->permission);

        foreach ($permisos as $value) {
            PermissionUser::create([
                "permission_id" => $value,
                "user_id" => $user_create->id
            ]);
        }

        return response()->json([
            "message" => "Se creo correctamente el Usuario",
            "data" => [
                'id' => $user_create->id,
                'name' => $user_create->name,
                'user' => $user_create->user,
                'email' => $user_create->email,
                'role_id' => $user_create->role_id,
                "role_name" => $user_create->role->rol_name,
                "file_foto" => $user_create->file_foto ?? '',
                'state' => 1,
                'state_name' => 'Activo',
                "permissions" => $request->permission
            ]
        ], 200);

    }

    // Registrar Usuario
    public function update(Request $request) {

        $user_exists = User::where('user', $request->user)->where('id', '<>',$request->id)->first();

        // Si el usuario existe
        if ($user_exists) {
            return response()->json(["message" => 'El usuario ya existe, por favor digitar otro.'], 403);
        }

        $user = User::findOrFail($request->id);

        //Existe un archivo de nombre 'file_foto'
        if ($request->hasFile("file_foto")) {
            if ($user->file_foto) {
                Storage::delete($user->file_foto); //Eliminar la imagen
            }
            $path = Storage::putFile("usuarios", $request->file("file_foto")); //alamace la imagen en la clase storage
            $request->request->add(["imagen" => $path]); //agregamos la ruta al $request
        }

        $password = $request->password || $request->password != null ? Hash::make($request->password) : $user->password;

        $imagen = $request->imagen ? $request->imagen : $user->file_foto;

        // creamos el usuario
        $user->update([
            'name' => $request->name,
            'user' => $request->user,
            'email' => $request->email,
            'password' => $password,
            'file_foto' => $imagen,
            'role_id' => $request->role_id
        ]);

        $permisos_user = PermissionUser::where('user_id',$request->id)->delete();

        $permisos = explode("|", $request->permission);

        foreach ($permisos as $value) {
            PermissionUser::create([
                "permission_id" => $value,
                "user_id" => $request->id
            ]);
        }

        $user = User::findOrFail($request->id);

        return response()->json([
            "message" => "Se actualizo correctamente el Usuario",
            "data" => [
                'id' => $user->id,
                'name' => $user->name,
                'user' => $user->user,
                'email' => $user->email,
                'role_id' => $user->role_id,
                "role_name" => $user->role->rol_name,
                "file_foto" => $user->file_foto ?? '',
                'state' => $user->state,
                'state_name' => $user->state == 1 ? 'Activo' : 'Desactivado',
                "permissions" => $request->permission
            ]
        ], 200);

    }

    public function changeEstado(Request $request) {

        $user = User::find($request->id);

        $user->state = $request->state;

        $user->save();

        return response()->json(["message" => 'true'], 200);

    }
}
