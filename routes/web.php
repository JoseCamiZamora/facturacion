<?php

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/blogi', function () {
    
   return dd('nilton');
});


Route::post('/registro_usuario', 'AccesoController@registro_usuario');
Route::get('/form_reset_password', 'AccesoController@form_reset_password');
Route::post('/recuperar_password', 'AccesoController@recuperar_password');
Route::post('/login_externo', 'AccesoController@login_externo');
Route::get('/politicas', 'AccesoController@politicas');
 Route::get('/email_leido/{idemail}', 'AccesoController@email_revisado');



//Route::get('pasar_usuarios_viejos', 'UsuariosController@pasar_usuarios_viejos');
//Route::get('pasar_claves_viejas', 'UsuariosController@pasar_claves_viejas');

Auth::routes();



Route::group(['middleware' => ['auth' ]], function () {

   Route::get('/home', 'HomeController@index');
   Route::get('/logout', 'AccesoController@logout');
   Route::get('/perfil_usuario', 'AccesoController@perfil_usuario');


   /* recaudo */
   Route::get('recaudo/listado_facturas/{aniosel?}/{messel?}', 'RecaudoController@listado_facturas');
   Route::post('recaudo/buscar_factura', 'RecaudoController@buscar_factura');
   Route::get('recaudo/buscar_factura', 'RecaudoController@listado_facturas');
   
   Route::get('recaudo/detalle_factura/{id_factura}', 'RecaudoController@detalle_factura');
   Route::get('recaudo/info_pago_factura/{id_factura}/{valor}', 'RecaudoController@info_pago_factura');
   Route::get('recaudo/info_abono_factura/{id_factura}/{valor}', 'RecaudoController@info_abono_factura');

   Route::get('recaudo/listado_otros_recaudos/{fecha_actual?}', 'OtrosRecaudosController@listado_otros_recaudos');
   Route::post('recaudo/registrar_otros_recaudos', 'OtrosRecaudosController@registrar_otros_recaudos');
   Route::get('recaudo/registrar_otros_recaudos', 'OtrosRecaudosController@listado_otros_recaudos');
   Route::get('recaudo/borrar_otro_recaudo/{idrecaudo?}', 'OtrosRecaudosController@borrar_otro_recaudo');


    Route::get('recaudo/listado_otros_recaudos_excel/{fecha_actual?}', 'OtrosRecaudosController@listado_otros_recaudos_excel');


    /* facturas */
   
    Route::get('facturas/listado_facturas/{aniosel?}/{messel?}', 'FacturasController@listado_facturas');
    Route::get('facturas/listado_facturas_estado/{aniosel?}/{messel?}/{estadosel?}', 'FacturasController@listado_facturas_estado');

    Route::get('facturas/detalle_factura/{id_factura}/{seccion?}', 'FacturasController@detalle_factura');
    Route::get('facturas/buscar_factura', 'FacturasController@listado_facturas');
    Route::post('facturas/buscar_factura', 'FacturasController@buscar_factura');
    Route::get('facturas/generar_facturas/{aniosel}/{messel}', 'FacturasController@generar_facturas');
    Route::get('facturas/editar_factura/{id_factura}', 'FacturasController@editar_factura');
    Route::post('facturas/editar_factura_detalle', 'FacturasController@editar_factura_detalle');
    Route::get('facturas/form_cargos_factura/{id_factura}', 'FacturasController@form_cargos_factura');
    Route::post('facturas/agregar_cargos_factura', 'FacturasController@agregar_cargos_factura');


    Route::get('facturas/bucar_factura_abono/{id_factura}', 'FacturasController@bucar_factura_abono');
   
    Route::post('facturas/pagar_factura', 'FacturasController@pagar_factura');
    Route::post('facturas/abonar_factura', 'FacturasController@abonar_factura');
    Route::post('facturas/congelar_factura', 'FacturasController@congelar_factura');
    Route::post('facturas/descongelar_factura', 'FacturasController@descongelar_factura');
    
    

    
    Route::get('facturas/generate_image/{id_factura}', 'FacturasController@generate_image');
    
    Route::get('facturas/pdf_factura/{id_factura}', 'FacturasController@pdf_factura');
    Route::get('facturas/imprimir_factura/{id_factura}', 'FacturasController@impresion_factura');
    Route::get('facturas/pdf_facturas/{aniosel}/{messel}', 'FacturasController@pdf_facturas');
    Route::get('facturas/imprimir_facturas/{aniosel}/{messel}', 'FacturasController@impresion_facturas');
    Route::get('facturas/detalle_facturas_anteriores/{id_factura}', 'FacturasController@detalle_facturas_anteriores');

    Route::get('/mostrar_imagen/{id_usuario}/{filename}', 'UsuariosController@mostrar_imagen');
    Route::get('/form_editar_imagen/{id_usuario}', 'UsuariosController@form_editar_imagen');
    Route::post('/editar_imagen', 'UsuariosController@editar_imagen');



});



Route::group(['middleware' => ['auth','is_admin' ]], function () {
	
	
 
   /* usuarios */
   Route::get('/usuarios', 'UsuariosController@listado_usuarios');
   Route::get('/form_nuevo_usuario', 'UsuariosController@form_nuevo_usuario');
   Route::post('/crear_usuario', 'UsuariosController@crear_usuario');
   Route::get('/informacion_usuario/{id_usuario}', 'UsuariosController@informacion_usuario');
   Route::post('/editar_usuario', 'UsuariosController@editar_usuario');
   Route::post('/editar_acceso', 'UsuariosController@editar_acceso');

 

   
    


    /* configuracion  */
    Route::get('configuracion/listado_cargos_mora', 'ConfiguracionController@listado_cargos_mora');
    Route::get('configuracion/form_nuevo_cargo_mora', 'ConfiguracionController@form_nuevo_cargo_mora');
    Route::post('configuracion/nuevo_cargo_mora', 'ConfiguracionController@nuevo_cargo_mora');
    Route::get('configuracion/form_editar_cargo_mora/{id_valor}', 'ConfiguracionController@form_editar_cargo_mora');
    Route::post('configuracion/editar_cargo_mora', 'ConfiguracionController@editar_cargo_mora');



    Route::get('configuracion/listado_cargos', 'ConfiguracionController@listado_cargos');
    Route::get('configuracion/listado_valores', 'ConfiguracionController@listado_valores');
    Route::get('configuracion/form_nuevo_valor', 'ConfiguracionController@form_nuevo_valor');
    Route::post('configuracion/nuevo_valor', 'ConfiguracionController@nuevo_valor');
    Route::get('configuracion/form_editar_valor/{id_valor}', 'ConfiguracionController@form_editar_valor');
    Route::post('configuracion/editar_valor', 'ConfiguracionController@editar_valor');
    Route::get('configuracion/form_nuevo_cargo', 'ConfiguracionController@form_nuevo_cargo');
    Route::post('configuracion/nuevo_cargo', 'ConfiguracionController@nuevo_cargo');
    Route::get('configuracion/form_editar_cargo/{id_valor}', 'ConfiguracionController@form_editar_cargo');
    Route::post('configuracion/editar_cargo', 'ConfiguracionController@editar_cargo');
    Route::get('configuracion/listado_comunicados', 'ConfiguracionController@listado_comunicados');
    Route::get('configuracion/form_nuevo_comunicado', 'ConfiguracionController@form_nuevo_comunicado');
    Route::post('configuracion/nuevo_comunicado', 'ConfiguracionController@nuevo_comunicado');
    Route::get('configuracion/form_editar_comunicado/{id_valor}', 'ConfiguracionController@form_editar_comunicado');
    Route::post('configuracion/editar_comunicado', 'ConfiguracionController@editar_comunicado');
    Route::get('configuracion/form_borrar_valor/{id_valor}', 'ConfiguracionController@form_borrar_valor');
    
    
    
    
    
    


   /* cuentas */
   Route::get('cuentas/listado_cuentas', 'CuentasController@listado_cuentas');
   Route::get('cuentas/listado_cuentas_inactivas', 'CuentasController@listado_cuentas_inactivas');
   Route::get('cuentas/listado_cuentas_congeladas', 'CuentasController@listado_cuentas_congeladas');
   Route::get('cuentas/editar_cuenta/{id_cuenta}', 'CuentasController@editar_cuenta');
   Route::get('cuentas/form_nueva_cuenta', 'CuentasController@form_nueva_cuenta');
   Route::post('cuentas/editar_cuenta_acu', 'CuentasController@editar_cuenta_acu');
   Route::post('cuentas/crear_cuenta', 'CuentasController@crear_cuenta');
   Route::get('cuentas/inactivar_cuenta/{id_cuenta}', 'CuentasController@inactivar_cuenta');
   Route::get('cuentas/activar_cuenta/{id_cuenta}', 'CuentasController@activar_cuenta');
   Route::post('cuentas/buscar_cuenta', 'CuentasController@buscar_cuenta');
   Route::post('cuentas/buscar_cuenta_inactivas', 'CuentasController@buscar_cuenta_inactivas');
   Route::post('cuentas/buscar_cuenta_congeladas', 'CuentasController@buscar_cuenta_congeladas');
   Route::get('cuentas/lista_factura_cuenta/{id_cuenta}', 'CuentasController@lista_factura_cuenta');
   Route::get('cuentas/detalle_factura_cuenta/{id_factura}', 'CuentasController@detalle_factura_cuenta');
   Route::post('cuentas/buscar_factura', 'CuentasController@buscar_factura');
   Route::get('cuentas/congelar_cuenta/{id_cuenta}', 'CuentasController@congelar_cuenta');
   Route::get('cuentas/descongelar_cuenta/{id_cuenta}', 'CuentasController@descongelar_cuenta');
   Route::get('cuentas/form_listado_vehiculos/{id_cuenta}/{estado}', 'CuentasController@form_listado_vehiculos');

   


   
   

   
   /* informes  */
  Route::get('informes/listado_informes/{aniosel?}/{messel?}', 'InformesController@listado_informes');
  Route::get('informes/listado_facturas_no_pagadas/{id_factura?}', 'InformesController@listado_facturas_no_pagadas');
  
  Route::get('informes/listado_recaudos/{aniosel?}/{messel?}', 'InformesController@listado_recaudos');
    Route::get('informes/listado_recaudos_concepto/{aniosel?}/{messel?}', 'InformesController@listado_recaudos_concepto');


  Route::get('informes/listado_facturas_bancos/{aniosel?}/{messel?}', 'InformesController@listado_facturas_bancos');

  Route::get('configuracion/listado_cargos_a_generar', 'ConfiguracionController@listado_cargos_a_generar');

  
   Route::get('informes/excel_informe1/{aniosel?}/{messel?}', 'InformesController@excel_informe1');
   Route::get('informes/excel_informe2/{aniosel?}/{messel?}', 'InformesController@excel_informe2');
   Route::get('informes/excel_informe3/{aniosel?}/{messel?}', 'InformesController@excel_informe3');
   Route::get('informes/excel_informe5/{aniosel?}/{messel?}', 'InformesController@excel_informe5');
  
  /* indicadores  */

  Route::get('indicadores/listado_indicadores/{aniosel?}/{messel?}', 'IndicadoresController@listado_indicadores');
  Route::get('indicadores/valores_indicador/{estado}', 'IndicadoresController@valores_indicador');


});




