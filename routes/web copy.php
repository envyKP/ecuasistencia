<?php

use  Illuminate\Support\Facades\Route;
use  App\Http\Controllers\EausuarioController;
use  App\Http\Controllers\EaClienteController;
use  App\Http\Controllers\EaBaseActivaController;
use  App\Http\Controllers\EaProductoController;
use  App\Http\Controllers\EaImpuestosController;
use  App\Http\Controllers\EaSubproductoController;
use  App\Http\Controllers\EaBaseActivaBusquedaController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\EaCamposBaController;
use  App\Http\Controllers\EaMigracionBaseActivaController;
use  App\Http\Controllers\EaMotivoDesactivacionController;
use  App\Http\Controllers\EaCabCargaInicialController;
use  App\Http\Controllers\EaProcesoController;
use  App\Http\Controllers\EaGenArchiProveTmkController;
use  App\Http\Controllers\EaRecepArchiProveTmkController;
use  App\Http\Controllers\EaGenArchiFinanController;
use  App\Http\Controllers\EaRecepArchiFinanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();
//Auth::logout();


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*########################################################################################################################*/
//                                                      testing
/*########################################################################################################################*/

//Route::view('/', 'admin.admin');
//Route::get('/getdata', [EausuarioController::class, 'getDataSGA']);
//route::get('getEstadoCliente', [EaCamposBaController::class, 'get_data_estado_Cliente']);


/*########################################################################################################################*/
//                                                      vistas
/*########################################################################################################################*/
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::view('/home', 'home');
    Route::view('/', 'home');
    Route::view('/dashboard/admin', 'dashboards.dashboardAdmin');
    Route::view('menu/procesos/carga/', 'dashboards.dashboardProcesosCarga');
    Route::view('migrar/base/activa', 'migrarBaseAct.home ')->name('migrar.baseActiva');
});


/*########################################################################################################################*/
//                                                      rutas
/*########################################################################################################################*/
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('usuarios/index', [UserController::class, 'index'])->name('UserController.index');
    Route::post('usuarios/update/', [UserController::class, 'update'])->name('UserController.update');
    Route::post('usuarios/show/', [UserController::class, 'show'])->name('UserController.show');
    Route::post('usuarios/store/', [UserController::class, 'store'])->name('UserController.store');

    Route::get('getImpuestoHtml/', [EaImpuestosController::class, 'getImpuestoHtml'])->name('EaImpuestosController.getImpuestoHtml');
    Route::get('getImpuestoModel/', [EaImpuestosController::class, 'getImpuestoModel'])->name('EaImpuestosController.getImpuestoModel');
    Route::post('impuestos/store/', [EaImpuestosController::class, 'store'])->name('EaImpuestosController.store');
    Route::post('impuestos/destroy/', [EaImpuestosController::class, 'destroy'])->name('EaImpuestosController.destroy');
    Route::post('impuestos/edit/', [EaImpuestosController::class, 'edit'])->name('EaImpuestosController.edit');

    Route::get('cliente/show/', [EaClienteController::class, 'show'])->name('EaClienteController.show');
    Route::get('cliente/index/', [EaClienteController::class, 'index'])->name('EaClienteController.index');
    Route::get('getClienteModel/', [EaClienteController::class, 'getClienteModel'])->name('EaClienteController.getClienteModel');
    Route::post('cliente/store/', [EaClienteController::class, 'store'])->name('EaClienteController.store');
    Route::post('cliente/edit/', [EaClienteController::class, 'edit'])->name('EaClienteController.edit');
    Route::post('cliente/destroy/', [EaClienteController::class, 'destroy'])->name('EaClienteController.destroy');


    Route::get('baseActiva/show/', [EaBaseActivaController::class, 'show'])->name('EaBaseActivaController.show');
    Route::post('baseActiva/buscar/seleccion/registro/', [EaBaseActivaController::class, 'buscarSeleccion'])->name('EaBaseActivaController.buscarSeleccion');
    Route::post('baseActiva/serch/', [EaBaseActivaController::class, 'serch'])->name('EaBaseActivaController.serch');
    Route::post('baseActiva/editcli/', [EaBaseActivaController::class, 'editCli'])->name('EaBaseActivaController.editCli');
    Route::post('baseActiva/createCliente/', [EaBaseActivaController::class, 'store'])->name('EaBaseActivaController.store');
    Route::patch('baseActiva/editAsistencia/', [EaBaseActivaController::class, 'editAsistencia'])->name('EaBaseActivaController.editAsistencia');


    Route::get('productos/index/', [EaProductoController::class, 'index'])->name('EaProductoController.index');
    Route::get('getProducto/', [EaProductoController::class, 'getProducto'])->name('EaProductoController.getProducto');
    Route::get('getProductoModel/', [EaProductoController::class, 'getProductoModel'])->name('EaProductoController.getProductoModel');
    Route::patch('producto/delete/', [EaProductoController::class, 'destroy'])->name('EaProductoController.destroy');
    Route::patch('producto/store/', [EaProductoController::class, 'store'])->name('EaProductoController.store');
    Route::patch('producto/update/', [EaProductoController::class, 'update'])->name('EaProductoController.update');


    Route::get('getSubproducto/', [EaSubproductoController::class, 'getSubproducto'])->name('EaSubproductoController.getSubproducto');
    Route::get('getSubproducto/cliente', [EaSubproductoController::class, 'getSubproductoCli'])->name('EaSubproductoController.getSubproductoCli');
    Route::get('getSubproductoModel/', [EaSubproductoController::class, 'getSubproductoModel'])->name('EaSubproductoController.getSubproductoModel');
    Route::patch('Subproducto/delete/', [EaSubproductoController::class, 'destroy'])->name('EaSubproductoController.destroy');
    Route::patch('Subproducto/store/', [EaSubproductoController::class, 'store'])->name('EaSubproductoController.store');
    Route::patch('Subproducto/update/', [EaSubproductoController::class, 'update'])->name('EaSubproductoController.update');

    Route::get('busqueda/baseActiva/index', [EaBaseActivaBusquedaController::class, 'index'])->name('EaBaseActivaBusquedaController.index');
    Route::get('busqueda/baseActiva/search', [EaBaseActivaBusquedaController::class, 'search'])->name('EaBaseActivaBusquedaController.search');

    Route::get('cargarArchivo/baseActiva/home', [EaMigracionBaseActivaController::class, 'home'])->name('EaMigracionBaseActivaController.home');
    Route::get('cargarArchivo/baseActiva/index', [EaMigracionBaseActivaController::class, 'index'])->name('EaMigracionBaseActivaController.index');
    Route::post('cargarArchivo/baseActiva/destroy/{cod_carga}', [EaMigracionBaseActivaController::class, 'destroy'])->name('EaMigracionBaseActivaController.destroy');
    Route::post('cargarArchivo/baseActiva/procesar/{cod_carga}', [EaMigracionBaseActivaController::class, 'procesar'])->name('EaMigracionBaseActivaController.procesar');
    Route::post('cargarArchivo/baseActiva/subirArchivos', [EaMigracionBaseActivaController::class, 'uploadArchivos'])->name('EaMigracionBaseActivaController.uploadArchivos');

    Route::get('get/motivos/desactivacion/html/', [EaMotivoDesactivacionController::class, 'getMotivosHtml'])->name('EaMotivoDesactivacionController.getMotivosHtml');

    Route::get('cargar/inicial/index/', [EaCabCargaInicialController::class, 'index'])->name('EaCabCargaInicialController.index');
    Route::get('get/arhivos/genapt/', [EaCabCargaInicialController::class, 'get_archivos_html_genapt'])->name('EaCabCargaInicialController.get_archivos_html_genapt');
    Route::get('get/archivos/genaif/', [EaCabCargaInicialController::class, 'get_archivos_html_genaif'])->name('EaCabCargaInicialController.get_archivos_html_genaif');
    Route::get('get/procesos/carga/', [EaCabCargaInicialController::class, 'get_procesos_carga_html'])->name('EaCabCargaInicialController.get_procesos_carga_html');
    Route::post('cargar/inicial/destroy/{cod_carga}', [EaCabCargaInicialController::class, 'destroy'])->name('EaCabCargaInicialController.destroy');
    Route::post('cargar/inicial/subirArchivos/', [EaCabCargaInicialController::class, 'uploadArchivos'])->name('EaCabCargaInicialController.uploadArchivos');
    Route::post('cargar/inicial/procesar/{cod_carga}', [EaCabCargaInicialController::class, 'procesar'])->name('EaCabCargaInicialController.procesar');
    Route::post('cargar/inicial/mover/baseActiva/{cod_carga}', [EaCabCargaInicialController::class, 'storeBaseActiva'])->name('EaCabCargaInicialController.storeBaseActiva');

    Route::get('generacion/archivo/proveeTMK/index/', [EaGenArchiProveTmkController::class, 'index'])->name('EaGenArchiProveTmkController.index');
    Route::post('generacion/archivo/proveeTMK/destroy/{cod_carga}', [EaGenArchiProveTmkController::class, 'destroy'])->name('EaGenArchiProveTmkController.destroy');
    Route::post('generacion/archivo/proveeTMK/editar/registro/{cod_carga}', [EaGenArchiProveTmkController::class, 'edit_registro_genapt'])->name('EaGenArchiProveTmkController.edit_registro_genapt');

    Route::get('recepcion/archivo/proveeTMK/index/', [EaRecepArchiProveTmkController::class, 'index'])->name('EaRecepArchiProveTmkController.index');
    Route::post('recepcion/archivo/proveeTMK/subirArchivos/', [EaRecepArchiProveTmkController::class, 'uploadArchivos'])->name('EaRecepArchiProveTmkController.uploadArchivos');
    Route::post('recepcion/archivo/proveeTMK/destroy/{cod_carga}', [EaRecepArchiProveTmkController::class, 'destroy'])->name('EaRecepArchiProveTmkController.destroy');
    Route::post('recepcion/archivo/proveeTMK/procesar/{cod_carga}', [EaRecepArchiProveTmkController::class, 'procesar'])->name('EaRecepArchiProveTmkController.procesar');


    Route::get('generacion/archivo/financiero/index/', [EaGenArchiFinanController::class, 'index'])->name('EaGenArchiFinanController.index');
    Route::post('generacion/archivo/financiero/destroy/{cod_carga}', [EaGenArchiFinanController::class, 'destroy'])->name('EaGenArchiFinanController.destroy');
    Route::post('generacion/archivo/financiero/editar/registro/{cod_carga}', [EaGenArchiFinanController::class, 'edit_registro_genaif'])->name('EaGenArchiFinanController.edit_registro_genaif');

    Route::get('recepcion/archivo/financiero/index/', [EaRecepArchiFinanController::class, 'index'])->name('EaRecepArchiFinanController.index');
    Route::post('recepcion/archivo/financiero/subirArchivo/', [EaRecepArchiFinanController::class, 'uploadArchivos'])->name('EaRecepArchiFinanController.uploadArchivos');
    Route::post('recepcion/archivo/financiero/destroy/{cod_carga}', [EaRecepArchiFinanController::class, 'destroy'])->name('EaRecepArchiFinanController.destroy');
    Route::post('recepcion/archivo/financiero/procesar/{cod_carga}', [EaRecepArchiFinanController::class, 'procesar'])->name('EaRecepArchiFinanController.procesar');

});

//Routes de generacion de archivos
Route::middleware(['auth'])->group(function () {
    Route::get('generacion/archivo/proveeTMK/export/', [EaGenArchiProveTmkController::class, 'exportar_archivo'])->name('EaGenArchiProveTmkController.exportar_archivo');
    Route::get('generacion/archivo/financiero/export/', [EaGenArchiFinanController::class, 'exportar_archivo'])->name('EaGenArchiFinanController.exportar_archivo');
    Route::get('generacion/archivo/sinInformacionFinanciera/export/{cod_carga}', [EaRecepArchiFinanController::class, 'export_sin_infor_finan'])->name('EaGenArchiFinanController.export_sin_infor_finan');
});


