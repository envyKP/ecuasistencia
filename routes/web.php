<?php

use  Illuminate\Support\Facades\Route;
use  App\Http\Controllers\EausuarioController;
use  App\Http\Controllers\EaCancelacionMasivaController;
use  App\Http\Controllers\EaClienteController;
use  App\Http\Controllers\EaBaseActivaController;
use  App\Http\Controllers\EaProductoController;
use  App\Http\Controllers\EaImpuestosController;
use  App\Http\Controllers\EaSubproductoController;
use  App\Http\Controllers\EaBaseActivaBusquedaController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\EaCamposBaController;
use  App\Http\Controllers\EaControlCampania;
use  App\Http\Controllers\EaMigracionBaseActivaController;
use  App\Http\Controllers\EaMotivoDesactivacionController;
use  App\Http\Controllers\EaCabCargaInicialController;
use  App\Http\Controllers\EaProcesoController;
use  App\Http\Controllers\EaGenArchiProveTmkController;
use  App\Http\Controllers\EaRecepArchiProveTmkController;
use  App\Http\Controllers\EaGenArchiFinanController;
use  App\Http\Controllers\EaRecepArchiFinanController;
use  App\Http\Controllers\EaFactMasSeguviajeController;
use  Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use  App\Http\Controllers\EaUtilController;
use  App\Http\Controllers\EaCargaIndividualExport;
use  App\Http\Controllers\EaCargaIndividualImport;
use  App\Http\Controllers\EaDetalleDebitoController;

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

Route::get('encryptBase/', [EaUtilController::class, 'encryptBaseActiva']);
Route::get('clear_temp/{token}', [EaDetalleDebitoController::class, 'clear_temp']);

/*########################################################################################################################*/
//                                                      vistas
/*########################################################################################################################*/

Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'store']); //->middleware("throttle:10,2");
});


Route::middleware(['prevent-back-history'])->group(function () {
    Route::view('/register', 'register')->name('register');
    Route::view('/', 'auth.login');
    Route::get('facturacionMasiva/store/', [EaFactMasSeguviajeController::class, 'store'])->name('EaFactMasSeguviajeController.store');
});


Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::view('/home', 'home')->name('home');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::view('/dashboard/admin', 'dashboards.dashboardAdmin');
    Route::view('menu/procesos/carga/', 'dashboards.dashboardProcesosCarga');
});


/*########################################################################################################################*/
//                                                      rutas
/*########################################################################################################################*/

Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('usuarios/index', [UserController::class, 'index'])->name('UserController.index');
    Route::post('usuarios/update/', [UserController::class, 'update'])->name('UserController.update');
    Route::post('usuarios/show/', [UserController::class, 'show'])->name('UserController.show');
    Route::post('usuarios/store/', [UserController::class, 'store'])->name('UserController.store');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('cliente/show/', [EaClienteController::class, 'show'])->name('EaClienteController.show');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('cliente/index/', [EaClienteController::class, 'index'])->name('EaClienteController.index');
    Route::post('cliente/store/', [EaClienteController::class, 'store'])->name('EaClienteController.store');
    Route::post('cliente/edit/', [EaClienteController::class, 'edit'])->name('EaClienteController.edit');
    Route::post('cliente/destroy/', [EaClienteController::class, 'destroy'])->name('EaClienteController.destroy');
});

Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {

    Route::get('inicio/facturacionMasiva/segurviaje/', [EaFactMasSeguviajeController::class, 'index'])->name('EaFactMasSeguviajeController.index');
    Route::get('getSubproductosSapHtml/', [EaFactMasSeguviajeController::class, 'getSubproductoSap'])->name('EaFactMasSeguviajeController.getSubproductoSap');
    Route::post('inicio/facturacionMasiva/uploadArchivos/', [EaFactMasSeguviajeController::class, 'uploadArchivos'])->name('EaFactMasSeguviajeController.uploadArchivos');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::post('impuestos/store/', [EaImpuestosController::class, 'store'])->name('EaImpuestosController.store');
    Route::post('impuestos/destroy/', [EaImpuestosController::class, 'destroy'])->name('EaImpuestosController.destroy');
    Route::post('impuestos/edit/', [EaImpuestosController::class, 'edit'])->name('EaImpuestosController.edit');
    Route::get('getImpuestoHtml/', [EaImpuestosController::class, 'getImpuestoHtml'])->name('EaImpuestosController.getImpuestoHtml');
    Route::get('getImpuestoModel/', [EaImpuestosController::class, 'getImpuestoModel'])->name('EaImpuestosController.getImpuestoModel');
    Route::get('getClienteModel/', [EaClienteController::class, 'getClienteModel'])->name('EaClienteController.getClienteModel');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('productos/index/', [EaProductoController::class, 'index'])->name('EaProductoController.index');
    Route::patch('producto/delete/', [EaProductoController::class, 'destroy'])->name('EaProductoController.destroy');
    Route::patch('producto/store/', [EaProductoController::class, 'store'])->name('EaProductoController.store');
    Route::patch('producto/update/', [EaProductoController::class, 'update'])->name('EaProductoController.update');
    Route::patch('Subproducto/delete/', [EaSubproductoController::class, 'destroy'])->name('EaSubproductoController.destroy');
    Route::patch('Subproducto/store/', [EaSubproductoController::class, 'store'])->name('EaSubproductoController.store');
    Route::patch('Subproducto/update/', [EaSubproductoController::class, 'update'])->name('EaSubproductoController.update');
});




Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('cargarArchivo/baseActiva/index', [EaMigracionBaseActivaController::class, 'index'])->name('EaMigracionBaseActivaController.index');
    //Route::post('cargarArchivo/baseActiva/destroy/{cod_carga}', [EaMigracionBaseActivaController::class, 'destroy'])->name('EaMigracionBaseActivaController.destroy');
    Route::post('cargarArchivo/baseActiva/procesar/', [EaMigracionBaseActivaController::class, 'procesar'])->name('EaMigracionBaseActivaController.procesar');
    Route::get('cargarArchivo/baseActiva/home/', [EaMigracionBaseActivaController::class, 'home'])->name('EaMigracionBaseActivaController.home');
    Route::post('cargarArchivo/baseActiva/subirArchivos/', [EaMigracionBaseActivaController::class, 'uploadArchivos'])->name('EaMigracionBaseActivaController.uploadArchivos');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('cargar/inicial/index/', [EaCabCargaInicialController::class, 'index'])->name('EaCabCargaInicialController.index');
    Route::post('cargar/inicial/destroy/', [EaCabCargaInicialController::class, 'destroy'])->name('EaCabCargaInicialController.destroy');
    Route::post('cargar/inicial/procesar/', [EaCabCargaInicialController::class, 'procesar'])->name('EaCabCargaInicialController.procesar');
    Route::get('get/arhivos/genapt/', [EaCabCargaInicialController::class, 'get_archivos_html_genapt'])->name('EaCabCargaInicialController.get_archivos_html_genapt');
    Route::get('get/archivos/genaif/', [EaCabCargaInicialController::class, 'get_archivos_html_genaif'])->name('EaCabCargaInicialController.get_archivos_html_genaif');
    Route::get('get/procesos/carga/', [EaCabCargaInicialController::class, 'get_procesos_carga_html'])->name('EaCabCargaInicialController.get_procesos_carga_html');
    Route::post('cargar/inicial/subirArchivos/', [EaCabCargaInicialController::class, 'uploadArchivos'])->name('EaCabCargaInicialController.uploadArchivos');
    Route::post('cargar/inicial/mover/baseActiva/', [EaCabCargaInicialController::class, 'storeBaseActiva'])->name('EaCabCargaInicialController.storeBaseActiva');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('CancelacionMasiva/inicial/index/', [EaCancelacionMasivaController::class, 'index'])->name('EaCancelacionMasivaController.index');
    Route::post('CancelacionMasiva/inicial/destroy/', [EaCancelacionMasivaController::class, 'destroy'])->name('EaCancelacionMasivaController.destroy');
    Route::post('CancelacionMasiva/inicial/procesar/', [EaCancelacionMasivaController::class, 'procesar'])->name('EaCancelacionMasivaController.procesar');
    Route::post('CancelacionMasiva/inicial/subirArchivos/', [EaCancelacionMasivaController::class, 'uploadArchivos'])->name('EaCancelacionMasivaController.uploadArchivos');
    Route::post('reporte/CancelacionMasiva/', [EaCancelacionMasivaController::class, 'exportar_reporte'])->name('EaCancelacionMasivaController.exportar_reporte');
    Route::post('CancelacionMasiva/inicial/borrar/baseActiva/', [EaCancelacionMasivaController::class, 'borrarEnBaseActiva'])->name('EaCancelacionMasivaController.borrarEnBaseActiva');
});



Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('generacion/archivo/proveeTMK/index/', [EaGenArchiProveTmkController::class, 'index'])->name('EaGenArchiProveTmkController.index');
    Route::post('generacion/archivo/proveeTMK/destroy/', [EaGenArchiProveTmkController::class, 'destroy'])->name('EaGenArchiProveTmkController.destroy');

    Route::get('recepcion/archivo/proveeTMK/index/', [EaRecepArchiProveTmkController::class, 'index'])->name('EaRecepArchiProveTmkController.index');
    Route::post('recepcion/archivo/proveeTMK/subirArchivos/', [EaRecepArchiProveTmkController::class, 'uploadArchivos'])->name('EaRecepArchiProveTmkController.uploadArchivos');
    Route::post('recepcion/archivo/proveeTMK/destroy/', [EaRecepArchiProveTmkController::class, 'destroy'])->name('EaRecepArchiProveTmkController.destroy');
    Route::post('recepcion/archivo/proveeTMK/procesar/', [EaRecepArchiProveTmkController::class, 'procesar'])->name('EaRecepArchiProveTmkController.procesar');

    Route::get('generacion/archivo/financiero/index/', [EaGenArchiFinanController::class, 'index'])->name('EaGenArchiFinanController.index');
    Route::post('generacion/archivo/financiero/destroy/', [EaGenArchiFinanController::class, 'destroy'])->name('EaGenArchiFinanController.destroy');

    Route::get('recepcion/archivo/financiero/index/', [EaRecepArchiFinanController::class, 'index'])->name('EaRecepArchiFinanController.index');
    Route::post('recepcion/archivo/financiero/subirArchivo/', [EaRecepArchiFinanController::class, 'uploadArchivos'])->name('EaRecepArchiFinanController.uploadArchivos');
    Route::post('recepcion/archivo/financiero/destroy/', [EaRecepArchiFinanController::class, 'destroy'])->name('EaRecepArchiFinanController.destroy');
    Route::post('recepcion/archivo/financiero/procesar/', [EaRecepArchiFinanController::class, 'procesar'])->name('EaRecepArchiFinanController.procesar');
});


Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    ///////////////////////// cambio KPE Cargas
    //Route::get('generacion/archivo/cargaIndividual/index/', [EaCargaIndividualExport::class, 'index'])->name('EaCargaIndividualExport.index');
    //Route::post('generacion/archivo/cargaIndividual/destroy/', [EaCargaIndividualExport::class, 'destroy'])->name('EaCargaIndividualExport.destroy');
    Route::get('generacion/archivo/cargaIndividual/export/', [EaCargaIndividualExport::class, 'exporta'])->name('EaCargaIndividualExport.exporta');
    Route::get('generacion/archivo/cargaIndividual/generarFactura/', [EaCargaIndividualExport::class, 'generarFactura'])->name('EaCargaIndividualExport.generarFactura');

    Route::get('recepcion/archivo/cargaIndividual/index/', [EaCargaIndividualImport::class, 'index'])->name('EaCargaIndividualImport.index');
    Route::get('recepcion/archivo/cargaIndividual/detalleCarga/', [EaCargaIndividualImport::class, 'detalleCarga'])->name('EaCargaIndividualImport.detalleCarga');
    Route::post('recepcion/archivo/cargaIndividual/destroy/', [EaCargaIndividualImport::class, 'destroy'])->name('EaCargaIndividualImport.destroy');
    Route::post('recepcion/archivo/cargaIndividual/subirArchivo/', [EaCargaIndividualImport::class, 'uploadArchivos'])->name('EaCargaIndividualImport.uploadArchivos');
    //Route::post('recepcion/archivo/cargaIndividual/subirArchivo/', [EaCargaIndividualImport::class, 'uploadArchivos'])->name('EaCargaIndividualImport.uploadArchivos');
    Route::post('recepcion/archivo/cargaIndividual/destroy/', [EaCargaIndividualImport::class, 'destroy'])->name('EaCargaIndividualImport.destroy');
    Route::post('recepcion/archivo/cargaIndividual/procesar/', [EaCargaIndividualImport::class, 'procesar'])->name('EaCargaIndividualImport.procesar');
    //////////////////////////////////////////////////////
    Route::get('getDetalleDebitoOpciones/', [EaDetalleDebitoController::class, 'getDetalleDebitoOpciones'])->name('EaDetalleDebitoController.getDetalleDebitoOpciones');
    Route::get('getMenuSubproductoOpciones/', [EaDetalleDebitoController::class, 'getMenuSubproductoOpciones'])->name('EaDetalleDebitoController.getMenuSubproductoOpciones');
});


Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::post('baseActiva/editcli/', [EaBaseActivaController::class, 'editCli'])->name('EaBaseActivaController.editCli');
    Route::post('baseActiva/createCliente/', [EaBaseActivaController::class, 'store'])->name('EaBaseActivaController.store');
});


Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::patch('baseActiva/editAsistencia/', [EaBaseActivaController::class, 'editAsistencia'])->name('EaBaseActivaController.editAsistencia');
});


Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::post('change/password/', [UserController::class, 'change_pass'])->name('UserController.change_pass');
    Route::get('baseActiva/show/', [EaBaseActivaController::class, 'show'])->name('EaBaseActivaController.show');
    Route::post('baseActiva/buscar/seleccion/registro/', [EaBaseActivaController::class, 'buscarSeleccion'])->name('EaBaseActivaController.buscarSeleccion');
    Route::post('baseActiva/serch/', [EaBaseActivaController::class, 'serch'])->name('EaBaseActivaController.serch');
    Route::get('getProducto/', [EaProductoController::class, 'getProducto'])->name('EaProductoController.getProducto');
    Route::get('getProductoModel/', [EaProductoController::class, 'getProductoModel'])->name('EaProductoController.getProductoModel');
    Route::get('getSubproducto/', [EaSubproductoController::class, 'getSubproducto'])->name('EaSubproductoController.getSubproducto');
    Route::get('getSubproducto/cliente', [EaSubproductoController::class, 'getSubproductoCli'])->name('EaSubproductoController.getSubproductoCli');
    Route::get('getSubproductoModel/', [EaSubproductoController::class, 'getSubproductoModel'])->name('EaSubproductoController.getSubproductoModel');
    Route::get('busqueda/baseActiva/index', [EaBaseActivaBusquedaController::class, 'index'])->name('EaBaseActivaBusquedaController.index');
    Route::get('busqueda/baseActiva/search', [EaBaseActivaBusquedaController::class, 'search'])->name('EaBaseActivaBusquedaController.search');
    Route::get('get/motivos/desactivacion/html/', [EaMotivoDesactivacionController::class, 'getMotivosHtml'])->name('EaMotivoDesactivacionController.getMotivosHtml');
});


//Routes de generacion de archivos
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('generacion/archivo/proveeTMK/export/', [EaGenArchiProveTmkController::class, 'exportar_archivo'])->name('EaGenArchiProveTmkController.exportar_archivo');
    Route::get('generacion/archivo/financiero/export/', [EaGenArchiFinanController::class, 'exportar_archivo'])->name('EaGenArchiFinanController.exportar_archivo');
    Route::get('generacion/archivo/sinInformacionFinanciera/export/{cod_carga}', [EaRecepArchiFinanController::class, 'export_sin_infor_finan'])->name('EaGenArchiFinanController.export_sin_infor_finan');
    Route::post('reporte/cargaInicial/', [EaCabCargaInicialController::class, 'exportar_reporte'])->name('EaCabCargaInicialController.exportar_reporte');
});


//KPE Edicion Campanias
//opciones menu configuracion cargas
Route::middleware(['auth', 'prevent-back-history', 'isAdmin'])->group(function () {
    Route::get('configCampanias/index/', [EaControlCampania::class, 'index'])->name('EaControlCampania.index');
    Route::get('recepcion/archivo/cargaIndividual/indexJsonEntrada/', [EaControlCampania::class, 'indexJsonEntrada'])->name('EaControlCampania.indexJsonEntrada');
    Route::get('getOpcionesModelAllCliente/', [EaControlCampania::class, 'getOpcionesModelAllCliente'])->name('EaControlCampania.getOpcionesModelAllCliente');
    Route::get('getOpcionesModel/', [EaControlCampania::class, 'getOpcionesModel'])->name('EaControlCampania.getOpcionesModel');
    Route::post('import/cabecera/confop/', [EaControlCampania::class, 'post_import_guardar'])->name('EaControlCampania.post_import_guardar');
    Route::get('getOpcionesCampoC/', [EaControlCampania::class, 'getOpcionesCampoC'])->name('EaControlCampania.getOpcionesCampoC');
    Route::get('getOpcionesCampofijos/', [EaControlCampania::class, 'getOpcionesCampofijos'])->name('EaControlCampania.getOpcionesCampofijos');
    Route::get('getOpcionesCampoExport/', [EaControlCampania::class, 'getOpcionesCampoExport'])->name('EaControlCampania.getOpcionesCampoExport');
    Route::get('getOpcionesCampo0/', [EaControlCampania::class, 'getOpcionesCampo0'])->name('EaControlCampania.getOpcionesCampo0');
    Route::post('import/validacion/', [EaControlCampania::class, 'post_import_guardar_validacion'])->name('EaControlCampania.post_import_guardar_validacion');
    Route::post('import/guardar/datos', [EaControlCampania::class, 'post_import_guardar_datos'])->name('EaControlCampania.post_import_guardar_datos');
    
});
