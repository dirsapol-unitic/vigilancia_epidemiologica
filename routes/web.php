<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
  
    //Ruta del Home de Administración
    Route::get('/home', 'HomeController@index')->name('home.index');

    //Rutas del Usuario
    Route::resource('users', 'Admin\UserController');
    Route::get('user/perfil/editar_clave/{id}', 'Admin\UserController@editar_clave')->name('users.editar_clave');
    Route::patch('user/perfil/editar_clave/{id}', 'Admin\UserController@update_clave')->name('users.update_clave');
    Route::patch('user/perfil/subir_foto/{id}', 'Admin\UserController@subir_foto')->name('users.subir_foto');    
    
    ///Rutas para establecimiento
    Route::resource('establecimientos', 'Admin\EstablecimientoController');
    Route::resource('establecimientosaluds', 'Admin\EstablecimientoSaludController');

    ///Rutas para mantenimiento
    Route::resource('dosis', 'Admin\DosiController');
    Route::resource('fabricantes', 'Admin\FabricanteController');
    Route::resource('resultados', 'Admin\ResultadoController');
    Route::resource('muestras', 'Admin\MuestraController');
    Route::resource('pruebas', 'Admin\PruebaController');
    Route::resource('sitios', 'Admin\SitioController');
    Route::resource('vacunas', 'Admin\VacunaController');
    Route::resource('vias', 'Admin\ViaController');
    Route::resource('pnpcategorias', 'Admin\PnpCategoriaController');
    Route::resource('sintomas', 'Admin\SintomaController');
    Route::resource('signos', 'Admin\SignoController');
    Route::resource('factorriesgos', 'Admin\FactorRiesgoController');
    Route::resource('cuadropatologicos', 'Admin\CuadroPatologicoController');
    Route::resource('enfermedadregiones', 'Admin\EnfermedadRegioneController');
    Route::resource('ocupaciones', 'Admin\OcupacioneController');
    Route::resource('lugares', 'Admin\LugareController');
    Route::resource('informeriesgos', 'Admin\InformeRiesgoController');
    Route::resource('preguntas', 'Admin\PreguntaController');
    Route::get('preguntas/rpta_new/{id}', 'Admin\PreguntaController@create_rpta')->name('preguntas.create_rpta');
    Route::patch('preguntas/rpta_new/{id}', 'Admin\PreguntaController@store_rpta')->name('preguntas.store_rpta');
    Route::resource('respuestas', 'Admin\RespuestaController');
    Route::resource('clasificaciones', 'Admin\ClasificacionController');
    Route::resource('seguimientos', 'Admin\SeguimientoController');

    //reporte
    Route::get('reportes/{id?}', 'Admin\AislamientoController@reporte_general')->name('aislamientos.reporte_general');
    Route::post('/reportes', 'Admin\AislamientoController@busca_reporte_general')->name('aislamientos.busca_reporte_general');
    Route::get('reporte_departamentos/{id?}', 'Admin\AislamientoController@reporte_departamentos')->name('aislamientos.reporte_departamentos');
    Route::post('reporte_departamentos/{id?}', 'Admin\AislamientoController@reporte_departamentos_fecha')->name('aislamientos.reporte_departamentos_fecha');
    Route::get('reporte_pruebas_covid/{id?}', 'Admin\AislamientoController@reporte_pruebas_covid')->name('aislamientos.reporte_pruebas_covid');
    Route::post('reporte_pruebas_covid/{id?}', 'Admin\AislamientoController@reporte_pruebas_covid_fecha')->name('aislamientos.reporte_pruebas_covid_fecha');
    Route::get('reporte_casos_covid/{id?}', 'Admin\AislamientoController@reporte_casos_covid')->name('aislamientos.reporte_casos_covid');
    Route::post('reporte_casos_covid/', 'Admin\AislamientoController@reporte_casos_covid_fecha')->name('aislamientos.reporte_casos_covid_fecha');
   
    Route::get('reporte_graficos/{id?}', 'Admin\AislamientoController@reporte_grafico')->name('aislamientos.reporte_grafico');
    Route::get('reporte_positivos/{id?}', 'Admin\AislamientoController@reporte_positivos')->name('aislamientos.reporte_positivos');

    Route::get('reporte_departamento_hospitalizado_titulares_actividad/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_titulares_actividad')->name('aislamientos.reporte_departamento_hospitalizado_titulares_actividad');
    Route::post('reporte_departamento_hospitalizado_titulares_actividad/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_titulares_actividad_fecha')->name('aislamientos.reporte_departamento_hospitalizado_titulares_actividad_fecha');
    Route::get('reporte_departamento_hospitalizado_titulares_retiro/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_titulares_retiro')->name('aislamientos.reporte_departamento_hospitalizado_titulares_retiro');
    Route::post('reporte_departamento_hospitalizado_titulares_retiro/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_titulares_retiro_fecha')->name('aislamientos.reporte_departamento_hospitalizado_titulares_retiro_fecha');
    Route::get('reporte_departamento_hospitalizado_familiares/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_familiares')->name('aislamientos.reporte_departamento_hospitalizado_familiares');
    Route::post('reporte_departamento_hospitalizado_familiares/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizado_familiares_fecha')->name('aislamientos.reporte_departamento_hospitalizado_familiares_fecha');
    Route::get('reporte_fallecido_departamentos/{id?}', 'Admin\AislamientoController@reporte_fallecido_departamentos')->name('aislamientos.reporte_fallecido_departamentos');
    Route::post('reporte_fallecido_departamentos/{id?}', 'Admin\AislamientoController@reporte_fallecido_departamentos_fecha')->name('aislamientos.reporte_fallecido_departamentos_fecha');
    Route::get('reporte_departamento_hospitalizados/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizados')->name('aislamientos.reporte_departamento_hospitalizados');
    Route::post('reporte_departamento_hospitalizados/{id?}', 'Admin\AislamientoController@reporte_departamento_hospitalizados_fecha')->name('aislamientos.reporte_departamento_hospitalizados_fecha');
    

    //exportar
    Route::get('exportar_reporte_aislamientos/{fechaDesde}/{fechaHasta}/{id_departamento?}/{dni?}', 'Admin\AislamientoController@exportar_reporte_aislamientos')->name('aislamientos.exportar_reporte_aislamientos');
    Route::get('exportar_reporte_hospitalizados/{fechaDesde}/{fechaHasta}/{id_departamento?}/{dni_beneficiario?}', 'Admin\AislamientoController@exportar_reporte_hospitalizados')->name('aislamientos.exportar_reporte_hospitalizados');
    
    //Aislamiento
    Route::resource('aislamientos', 'Admin\AislamientoController');
    Route::get('todos_registros/{id?}', 'Admin\AislamientoController@todos_registros')->name('aislamientos.todos_registros');
    Route::get('reporte_todos_registros/{id?}', 'Admin\AislamientoController@reporte_todos_registros')->name('aislamientos.reporte_todos_registros');
    Route::post('/listar_aislamientos', 'Admin\AislamientoController@listar_aislamientos')->name('aislamientos.listar_aislamientos');
    Route::post('/listar_reportes_aislamientos', 'Admin\AislamientoController@listar_reportes_aislamientos')->name('aislamientos.listar_reportes_aislamientos');
    Route::post('/reporte_listar_aislamientos_hospitalizacion', 'Admin\AislamientoController@reporte_listar_aislamientos_hospitalizacion')->name('aislamientos.reporte_listar_aislamientos_hospitalizacion');
    Route::post('/listar_aislamientos_hospitalizacion', 'Admin\AislamientoController@listar_aislamientos_hospitalizacion')->name('aislamientos.listar_aislamientos_hospitalizacion');
    Route::post('actualizar/{idaislamiento}/{dni}/{riesgo}', 'Admin\AislamientoController@update_riesgo')->name('aislamientos.update_riesgo');    
    Route::patch('actualizar/{idaislamiento}/{dni}/{riesgo}', 'Admin\AislamientoController@update_riesgo')->name('aislamientos.update_riesgo');
    Route::get('registro/', 'Admin\AislamientoController@create')->name('aislamientos.index');
    Route::get('buscarpnp/', 'Admin\AislamientoController@buscar_paciente')->name('aislamientos.buscar_paciente');
    Route::post('registrar_personal/', 'Admin\AislamientoController@buscando')->name('aislamientos.buscando');

    //fichas
    Route::get('listar_fichas/{id}/{dni}', 'Admin\AislamientoController@listar_fichas')->name('aislamientos.listar_fichas');
    Route::get('ver_ficha/{idficha}/{idpaciente}/{dni}', 'Admin\AislamientoController@ver_ficha')->name('aislamientos.ver_ficha');
    Route::get('ver_fichas/{idficha}/{idpaciente}/{dni}', 'Admin\AislamientoController@ver_fichas')->name('aislamientos.ver_fichas');
    Route::get('cerrar_ficha/{idficha}/{idpaciente}/{dni}', 'Admin\AislamientoController@cerrar_ficha')->name('aislamientos.cerrar_ficha');
    Route::get('eliminar_ficha/{idficha}/{idpaciente}/{dni}', 'Admin\AislamientoController@eliminar_ficha')->name('aislamientos.eliminar_ficha');

    //editar paciente
    Route::get('editar_paciente/{id}/{dni}', 'Admin\AislamientoController@editar_paciente')->name('aislamientos.editar_paciente');
    Route::post('actualizar_paciente/{id}', 'Admin\AislamientoController@update_datospaciente')->name('aislamientos.update_datospaciente');
    Route::patch('actualizar_paciente/{id}', 'Admin\AislamientoController@update_datospaciente')->name('aislamientos.update_datospaciente');
    

    //antecedente epidemiologico
    Route::get('registro_antecedentes_epidemiologicos/{id}/{dni}', 'Admin\AislamientoController@create_antecedente_epidemiologico')->name('aislamientos.create_antecedente_epidemiologico');
    Route::get('editar_antecedentes_epidemiologicos/{id}/{dni}/{id_paciente}', 'Admin\AislamientoController@editar_antecedentes_epidemiologico')->name('aislamientos.editar_antecedentes_epidemiologico');
    Route::get('listar_antecedentes_epidemiologicos/{id}/{dni}', 'Admin\AislamientoController@listar_antecedentes_epidemiologicos')->name('aislamientos.listar_antecedentes_epidemiologicos');
    Route::post('actualizar_antecedente_epidemiologico/{id}', 'Admin\AislamientoController@update_antecedente_epidemiologico')->name('aislamientos.update_antecedente_epidemiologico');
    Route::patch('actualizar_antecedente_epidemiologico/{id}', 'Admin\AislamientoController@update_antecedente_epidemiologico')->name('aislamientos.update_antecedente_epidemiologico');
    Route::post('store_antecedentes_epidemiologico', 'Admin\AislamientoController@store_antecedentes')->name('aislamientos.store_antecedentes');
    Route::get('eliminar_antecedente/{id_ant}/{id}/{dni}', 'Admin\AislamientoController@eliminar_antecedente')->name('aislamientos.eliminar_antecedente');

    //hospitalizacion 
    Route::get('todos_registros_hospitalizacion/{id?}', 'Admin\AislamientoController@todos_registros_hospitalizacion')->name('aislamientos.todos_registros_hospitalizacion');
    Route::get('reporte_todos_registros_hospitalizacion/{id?}', 'Admin\AislamientoController@reporte_todos_registros_hospitalizacion')->name('aislamientos.reporte_todos_registros_hospitalizacion');
    Route::get('registro_hospitalizacion/{dni}/{id_paciente}/{id_ficha}', 'Admin\AislamientoController@create_hospitalizacion')->name('aislamientos.create_hospitalizacion');
    Route::get('editar_hospitalizacion/{id}/{dni}/{id_paciente}/{idficha}', 'Admin\AislamientoController@editar_hospitalizacion')->name('aislamientos.editar_hospitalizacion');
    Route::get('listar_hospitalizaciones/{id}/{dni}', 'Admin\AislamientoController@listar_hospitalizaciones')->name('aislamientos.listar_hospitalizaciones');
    Route::post('store_hospitalizacion', 'Admin\AislamientoController@store_hospitalizacion')->name('aislamientos.store_hospitalizacion');
    Route::get('dar_alta_hospitalizacion/{idficha}/{dni}/{id_paciente}', 'Admin\AislamientoController@dar_alta_hospitalizacion')->name('aislamientos.dar_alta_hospitalizacion');
    Route::post('store_alta_hospitalizacion', 'Admin\AislamientoController@store_alta_hospitalizacion')->name('aislamientos.store_alta_hospitalizacion');
    Route::get('eliminar_hospitalizaciones/{id_hosp}/{id}/{dni}', 'Admin\AislamientoController@eliminar_hospitalizaciones')->name('aislamientos.eliminar_hospitalizaciones');
    //evolucion
    Route::get('registro_evolucion/{id}/{dni}/{idficha}', 'Admin\AislamientoController@create_evolucion')->name('aislamientos.create_evolucion');
    Route::get('editar_evolucion/{id}/{dni}/{id_paciente}/{idficha}', 'Admin\AislamientoController@editar_evolucion')->name('aislamientos.editar_evolucion');
    Route::get('listar_evolucion/{id}/{dni}/{idficha}', 'Admin\AislamientoController@listar_evolucion')->name('aislamientos.listar_evolucion');
    Route::post('/store_laboratorio', 'Admin\AislamientoController@store_laboratorio')->name('aislamientos.store_laboratorio');
    Route::patch('store_evolucion_paciente', 'Admin\AislamientoController@store_evolucion_paciente')->name('aislamientos.store_evolucion_paciente');
    Route::get('eliminar_evolucion/{id_evol}/{id}/{dni}', 'Admin\AislamientoController@eliminar_evolucion')->name('aislamientos.eliminar_evolucion');

    //laboratorio
    Route::get('registro_laboratorio_paciente/{id}/{dni}/{id_ficha}', 'Admin\AislamientoController@editar_laboratorio')->name('aislamientos.editar_laboratorio');
    Route::get('eliminar_laboratorio/{id_lab}/{id}/{dni}/{idficha}', 'Admin\AislamientoController@eliminar_laboratorio')->name('aislamientos.eliminar_laboratorio');


    Route::get('registro_laboratorio/{id}/{dni}', 'Admin\AislamientoController@create_laboratorio')->name('aislamientos.create_laboratorio');
    Route::get('cargarresultados/{id}', 'Admin\AislamientoController@cargarresultados')->name('aislamientos.cargarresultados');
    
    //contacto
    Route::get('registro_contacto/{id}/{dni}/{id_ficha}', 'Admin\AislamientoController@create_contacto')->name('aislamientos.create_contacto');
    Route::get('editar_contacto/{id}/{dni}/{id_paciente}/{idficha}', 'Admin\AislamientoController@editar_contacto')->name('aislamientos.editar_contacto');
    Route::get('listar_contacto/{id}/{dni}/{idficha}', 'Admin\AislamientoController@listar_contacto')->name('aislamientos.listar_contacto');
    Route::post('/store_contacto', 'Admin\AislamientoController@store_contacto')->name('aislamientos.store_contacto');
    
    //diagnostico
    Route::get('/obtener_diagnostico/{buscar}', 'Admin\DiagnosticoController@obtener_diagnostico');

    Route::get('mostrar_archivos/{id}/{dni}', 'Admin\AislamientoController@mostrar_archivos')->name('aislamientos.mostrar_archivos');
    Route::patch('subir_archivo/{dni}/{idaislado}/{descripcion}', 'Admin\AislamientoController@subir_archivo')->name('aislamientos.subir_archivo');
    Route::get('eliminar_archivo/{id}/{idaislado}/{dni}', 'Admin\AislamientoController@eliminar_archivo')->name('aislamientos.eliminar_archivo');


    //Esavi
    Route::resource('esavis', 'Admin\EsaviController');
    Route::get('listar_esavis/{id}/{dni}', 'Admin\EsaviController@listar_esavis')->name('esavis.listar_esavis');
    Route::get('registro_esavi/{id}/{dni}', 'Admin\EsaviController@create_esavis')->name('esavis.create_esavis');
    Route::get('editar_esavi/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@editar_esavis')->name('esavis.editar_esavis');
    Route::post('store_esavi', 'Admin\EsaviController@store_esavis')->name('esavis.store_esavis');
    Route::post('actualizar_esavi/{id}', 'Admin\EsaviController@update_esavis')->name('esavis.update_esavis');
    Route::patch('actualizar_esavi/{id}', 'Admin\EsaviController@update_esavis')->name('esavis.update_esavis');


     //antecedente
    Route::get('registro_antecedentes_esavi/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@create_antecedente')->name('esavis.create_antecedente');
    Route::get('listar_antecedentes_esavi/{id}/{dni}', 'Admin\EsaviController@listar_antecedentes')->name('esavis.listar_antecedentes');
    Route::post('store_antecedentes_esavi', 'Admin\EsaviController@store_antecedentes')->name('esavis.store_antecedentes');
    
    //sintomas y signos
    Route::get('registro_signo_sintomas/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@create_signo_sintomas')->name('esavis.create_signo_sintomas');
    Route::get('listar_signo_sintoma/{id}/{dni}', 'Admin\EsaviController@listar_signo_sintoma')->name('esavis.listar_signo_sintoma');
    Route::post('store_signo_sintoma', 'Admin\EsaviController@store_signo_sintoma')->name('esavis.store_signo_sintoma');
    Route::get('editar_signo_sintomas/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@editar_signo_sintomas')->name('esavis.editar_signo_sintomas');
    Route::post('actualizar_signo_sintoma/{id}', 'Admin\EsaviController@update_signo_sintoma')->name('esavis.update_signo_sintoma');
    Route::patch('actualizar_signo_sintoma/{id}', 'Admin\EsaviController@update_signo_sintoma')->name('esavis.update_signo_sintoma');


    //esavi vacunacion
    Route::get('editar_vacunacion/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@editar_vacunacion')->name('esavis.editar_vacunacion');
    Route::post('actualizar_vacunacion/{id}', 'Admin\EsaviController@update_vacunacion_esavi')->name('esavis.update_vacunacion_esavi');
    Route::patch('actualizar_vacunacion/{id}', 'Admin\EsaviController@update_vacunacion_esavi')->name('esavis.update_vacunacion_esavi');

    //esavi cuadro clinico
    Route::get('listar_cuadro_clinico/{id}/{dni}', 'Admin\EsaviController@listar_cuadro_clinicos')->name('esavis.listar_cuadro_clinicos');
    Route::get('registro_cuadro_clinico/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@create_cuadro_clinicos')->name('esavis.create_cuadro_clinicos');
    Route::get('editar_cuadro_clinico/{id}/{dni}', 'Admin\EsaviController@editar_cuadro_clinico')->name('esavis.editar_cuadro_clinico');
    Route::post('store_cuadro_clinicos', 'Admin\EsaviController@store_cuadro_clinicos')->name('esavis.store_cuadro_clinicos');

    //hospitalizacion
    Route::get('listar_hospitalizacion_esavi/{id}/{dni}', 'Admin\EsaviController@listar_hospitalizacion_esavi')->name('esavis.listar_hospitalizacion_esavi');
    Route::get('editar_hospitalizacion_esavi/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@editar_hospitalizacion_esavi')->name('esavis.editar_hospitalizacion_esavi');
    Route::get('registro_hospitalizacion_esavi/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@create_hospitalizado_esavi')->name('esavis.create_hospitalizado_esavi');
    Route::post('store_hospitalizacion_esavi', 'Admin\EsaviController@store_hospitalizacion_esavi')->name('esavis.store_hospitalizacion_esavi');
    
    //seguimiento/clasificacion
    Route::get('listar_seguimiento_esavi/{id}/{dneguimientoi}', 'Admin\EsaviController@listar_seguimiento_esavi')->name('esavis.listar_seguimiento_esavi');
    Route::get('registro_seguimiento_esavi/{id}/{dni}', 'Admin\EsaviController@create_seguimiento_esavi')->name('esavis.create_seguimiento_esavi');
    Route::get('create_seguimiento_clasificacion/{id}/{dni}/{id_paciente}', 'Admin\EsaviController@create_seguimiento_esavi')->name('esavis.create_seguimiento_esavi');
    Route::post('store_seguimiento_esavi', 'Admin\EsaviController@store_seguimiento_esavi')->name('esavis.store_seguimiento_esavi');

    //importaciones
    //Route::get('todas_importaciones/{id?}', 'Admin\ImportacioneController@todas_importaciones')->name('importaciones.todas_importaciones');

    Route::get('importar_data_aislado/', 'Admin\AislamientoController@importar_data_aislado')->name('aislamientos.importar_data_aislado');
    Route::get('importar_data_hospitalizado/', 'Admin\AislamientoController@importar_data_hospitalizado')->name('aislamientos.importar_data_hospitalizado');
    
    Route::get('manual/{id}', 'Admin\UserController@manual')->name('users.manual');
    
});

Route::resource('aislamientosite', 'Site\AislamientoController');
Route::get('buscar_personal_dni/{dni}', 'Site\AislamientoController@buscar_personal_dni')->name('aislamientosite.buscar_personal_dni');
Route::get('buscar_personal_dni_dirrehum/{dni}', 'Site\AislamientoController@buscar_personal_dni_dirrehum')->name('aislamientosite.buscar_personal_dni_dirrehum');
Route::get('buscar_personal_dni_dirrehum2/{dni}', 'Site\AislamientoController@buscar_personal_dni_dirrehum2')->name('aislamientosite.buscar_personal_dni_dirrehum2');
Route::get('buscar_personal_dni_reniec/{dni}', 'Site\AislamientoController@buscar_personal_dni_reniec')->name('aislamientosite.buscar_personal_dni_reniec');

Route::get('cargadireccion/{id}', 'Admin\EstablecimientoController@cargadireccion')->name('establecimientos.cargadireccion');
Route::get('cargarprovincias/{id}', 'Admin\DepartamentoController@cargarprovincias')->name('departamentos.cargarprovincias');
Route::get('cargardistrito/{id_dep}/{id_prov}', 'Admin\ProvinciaController@cargardistrito')->name('provincias.cargardistrito');



Route::get('qr-code-g', function () {
  \QrCode::size(500)
            ->format('png')
            
            ->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));
    
  return view('qr');

Route::get('actualiza_ficha', 'Admin\AislamientoController@actualiza_ficha')->name('aislamientos.actualiza_ficha');



});
Route::get('todos_registros_abiertos/', 'Admin\AislamientoController@todos_registros_abiertos')->name('aislamientos.todos_registros_abiertos');

Route::get('buscar_personal_aislado_prueba/{dni}', 'Admin\AislamientoController@buscar_personal_aislado_prueba')->name('aislamientos.buscar_personal_aislado_prueba');

