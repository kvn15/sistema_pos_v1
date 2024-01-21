<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\General\RoleController;
use App\Http\Controllers\Sunat\VoucherController;
use App\Http\Controllers\almacen\ProductController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\almacen\CategorieController;
use App\Http\Controllers\almacen\ProveedorControlller;
use App\Http\Controllers\Administracion\UserController;
use App\Http\Controllers\sunat\TipoDocumentoController;
use App\Http\Controllers\almacen\UnidadMedidaController;
use App\Http\Controllers\Administracion\ClientController;
use App\Http\Controllers\General\ConsultaSunatController;
use App\Http\Controllers\General\PermissionRolesController;
use App\Http\Controllers\almacen\carga\CargarProductoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta de Login
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('general')->group(function () {
    Route::get('menuPermission/{roleId}', [PermissionRolesController::class, 'menuPermission']);
    Route::get('listaPermission', [PermissionRolesController::class, 'listaPermission']);
    Route::get('listaRole', [RoleController::class, 'listaRole']);
    //
    Route::get('listaGeneralProducto', [GeneralController::class, 'listaGeneralProducto']);
    Route::get('obtenerTipoDocumento', [GeneralController::class, 'obtenerTipoDocumento']);
    Route::get('productosVenta', [GeneralController::class, 'productosVenta']);
});

//ADMINISTRACION
Route::prefix('administracion')->group(function () {
    Route::get('user_list', [UserController::class, 'index']);
    Route::prefix('user')->group(function () {
        Route::post('store',[UserController::class,'store']);
        Route::post('update',[UserController::class,'update']);
        Route::post('changeEstado',[UserController::class,'changeEstado']);
    });

    Route::prefix('cliente')->group(function () {
        Route::get('lista', [ClientController::class,'lista']);
        Route::post('store', [ClientController::class,'store']);
        Route::put('update/{id}', [ClientController::class,'update']);
        Route::delete('delete/{id}', [ClientController::class,'delete']);
    });
});

//ALMACEN
Route::prefix('almacen')->group(function () {
    Route::prefix('categorie')->group(function () {
        Route::get('lista', [CategorieController::class, 'index']);
        Route::post('store', [CategorieController::class, 'store']);
        Route::put('update/{id}', [CategorieController::class, 'update']);
        Route::post('changeEstado/{id}', [CategorieController::class, 'changeEstado']);
    });
    Route::prefix('unidad_medida')->group(function () {
        Route::get('lista', [UnidadMedidaController::class, 'index']);
        Route::post('store', [UnidadMedidaController::class, 'store']);
        Route::put('update/{id}', [UnidadMedidaController::class, 'update']);
        Route::post('changeEstado/{id}', [UnidadMedidaController::class, 'changeEstado']);
        Route::delete('delete/{id}', [UnidadMedidaController::class, 'delete']);
    });
    Route::prefix('proveedor')->group(function () {
        Route::get('lista', [ProveedorControlller::class, 'index']);
        Route::post('store', [ProveedorControlller::class, 'store']);
        Route::put('update/{id}', [ProveedorControlller::class, 'update']);
        Route::post('changeEstado/{id}', [ProveedorControlller::class, 'changeEstado']);
    });

    Route::prefix('products')->group(function () {
        Route::get('lista', [ProductController::class, 'index']);
        Route::post('store', [ProductController::class, 'store']);
        Route::put('update/{id}', [ProductController::class, 'update']);
        Route::post('subirNuevaImagenStore', [ProductController::class, 'subirNuevaImagenStore']);
        Route::get('obtenerProducto/{id}', [ProductController::class, 'obtenerProducto']);
        Route::post('changeEstado/{id}', [ProductController::class, 'changeEstado']);
        Route::post('validarCodigoBarra', [CargarProductoController::class, 'validarCodigoBarra']);
    });
});

//SUNAT
Route::prefix('sunat')->group(function () {
    Route::get('consultaRuc/{ruc}', [ConsultaSunatController::class, 'consultaRucSunat']);
    Route::get('consultaDni/{dni}', [ConsultaSunatController::class, 'consultaDniSunat']);

    Route::prefix('documento')->group(function () {
        Route::get('lista', [VoucherController::class, 'lista']);
        Route::post('store', [VoucherController::class, 'store']);
        Route::put('update/{id}', [VoucherController::class, 'update']);
        Route::post('changeEstado', [VoucherController::class, 'changeEstado']);
    });

    Route::prefix('documento-identidad')->group(function () {
        Route::get('lista', [TipoDocumentoController::class, 'lista']);
        Route::post('store', [TipoDocumentoController::class, 'store']);
        Route::put('update/{id}', [TipoDocumentoController::class, 'update']);
        Route::delete('delete/{id}', [TipoDocumentoController::class, 'delete']);
    });
});
