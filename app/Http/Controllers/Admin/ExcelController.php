<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\Establecimiento;
use App\Models\Aislamiento;
use App\Models\Importacione;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use Illuminate\Validation;
use App;
use SoapClient;
use App\Models\Reclamacione;
use App\Models\Solucione;

ini_set('memory_limit', '-1');
set_time_limit(0);

class ExcelController extends Controller {

    public function exportar_reporte_soluciones($fecha_inicio, $fecha_fin, $id_medico = 0 , $dni_beneficiario = "" ,$f_riesgo = 0, $estado = 0) {    
    
        Excel::create('Exportar Lista de Evaluacion Medica', function($excel) use($fecha_inicio, $fecha_fin, $id_medico, $dni_beneficiario ,$f_riesgo, $estado) {
            $excel->sheet('GENERAL', function($sheet) use($fecha_inicio, $fecha_fin, $id_medico, $dni_beneficiario ,$f_riesgo, $estado) {
                
        //----------------------------------------------------------------------
        $rol=Auth::user()->rol;
                     
        if (is_null($dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($dni_beneficiario);

        if (is_null($fecha_inicio))
            $fechaDesde="";
        else
            $fechaDesde=$fecha_inicio;
        
        if (is_null($fecha_fin))
            $fechaHasta="";
        else
            $fechaHasta=$fecha_fin;

        if (is_null($f_riesgo))
            $f_riesgo="";
        else
            $f_riesgo=$f_riesgo;

        if (is_null($id_medico))
            $id_medico="";
        else
            $id_medico=$id_medico;

        $date = Carbon::now();
        $model_soluciones= new Solucione();

        if($rol==1){    
          $f_riesgo=$f_riesgo;
        }
        else
        {
          $f_riesgo=Auth::user()->factor_id;
        }
        
        if (is_null($estado))
            $estado="";
        else
            $estado=$estado;

         

            $soluciones = $model_soluciones->AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde, $fechaHasta,$f_riesgo,$id_medico, $dni_beneficiario, $estado);

            $variable = [];
            $n = 0;
            foreach ($soluciones as $c) {
                $n++;
            }
            array_push($variable, array("Reporte de Evaluacion Medica de SANIDAD POLICIAL"));
            array_push($variable, array('De ' . $fecha_inicio . ' a ' . $fecha_fin));
            array_push($variable, array(""));
            array_push($variable, array("N","Fecha", "DNI", "PERSONAL PNP","Factor Riesgo","MEDICO","Estado","Solucion"));

            $m = 1;
            foreach ($soluciones as $c) {
                $originalDate1 = $c->fecha_solucion;
                $fechaE = date("d-m-Y", strtotime($originalDate1));
                
                switch($c->resultado_solucion){
                    case 1: $resultado= "Fundado"; break;
                    case 2: $resultado= "Infundado"; break;
                    case 3: $resultado= "Concluido Anticipado"; break;
                    case 4: $resultado= "Improcedente"; break;
                }

                $Sintomas2 = DB::table('aislados')
                                ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                                ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                                ->where('aislamiento_factor_riesgo.aislamiento_id',$c->id)                    
                                ->get();
                $fr=""; $p=1;
                foreach ($Sintomas2 as $d) {
                    if($p==1)
                        $fr=$d->descripcion.', ';
                    else
                        $fr.=$d->descripcion.', ';
                    $p++;
                }

                array_push($variable, array($m++,$fechaE, $c->dni, $c->nombres." , ".$c->apellido_paterno." ".$c->apellido_materno, $fr, $c->medico_solucionador,$resultado, $c->solucion_rpta));
                
            }
            $sheet->with($variable)->mergeCells('A2:D2')->mergeCells('A3:C3')->mergeCells('A4:C4');
            });
        })->export('xlsx');
    }

    public function exportar_reporte_aislamientos($fecha_inicio, $fecha_fin,   $departamento=0 ,$provincia=0 , $distrito=0, $dni_beneficiario="",$estado=0, $f_riesgo=0 ) {
    
        Excel::create('Exportar Lista de Aislado de Sanidad Policial', function($excel) use($fecha_inicio, $fecha_fin, $dni_beneficiario ,$f_riesgo, $departamento, $provincia, $distrito, $estado) {
            $excel->sheet('GENERAL', function($sheet) use($fecha_inicio, $fecha_fin, $dni_beneficiario ,$f_riesgo, $departamento, $provincia, $distrito, $estado) {               
                //$id_establecimiento = Auth::user()->establecimiento_id;
                //-------------------------------------------------------------
                $date = Carbon::now();
                $rol=Auth::user()->rol;        
                $estado = $estado;                
                
                if (is_null($dni_beneficiario))
                    $dni_beneficiario="";
                else
                    $dni_beneficiario=strtoupper($dni_beneficiario);

                if (is_null($fecha_inicio))
                    $fechaDesde="";
                else
                    $fechaDesde = date("d-m-Y", strtotime($fecha_inicio));
                
                if (is_null($fecha_fin))
                    $fechaHasta="";
                else
                    $fechaHasta = date("d-m-Y", strtotime($fecha_fin));

                if (is_null($departamento) || $departamento==0)
                    $departamento="";
                
                if (is_null($provincia)  || $provincia==0)
                    $provincia="";
                
                if (is_null($distrito)  || $distrito==0)
                    $distrito="";
                
                if (is_null($f_riesgo) || $f_riesgo==0)
                    $f_riesgo="";
                
                $model_aislamientos = new Aislamiento();

                if($rol==1){
                    $aislados = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado, $f_riesgo, $departamento, $provincia, $distrito);
                }

                if(count($aislados)>0){
                  $variable = [];
                  $n = 0;
                  foreach ($aislados as $c) {
                      $n++;
                  }
                  array_push($variable, array("Reporte de Personal Aislados de SANIDAD POLICIAL"));
                  array_push($variable, array('De ' . $fecha_inicio . ' a ' . $fecha_fin));
                  array_push($variable, array(""));
                  array_push($variable, array("N","Fecha", "DNI","Beneficiario","Sexo","Edad","Departamento","Provincia","Distrito","Factor Riesgo", "Estado"));                  
                  $m = 1;
            
                
                foreach ($aislados as $c) {
                    $originalDate2 = $c->fecha_registro;
                    $fecha = date("d-m-Y", strtotime($originalDate2));
                    
                    $Sintomas2 = DB::table('aislados')
                                ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                                ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                                ->where('aislamiento_factor_riesgo.aislamiento_id',$c->id)                    
                                ->get();
                    $fr=""; $p=1;
                    foreach ($Sintomas2 as $d) {
                        if($p==1)
                            $fr=$d->descripcion.', ';
                        else
                            $fr.=$d->descripcion.', ';
                        $p++;
                    }

                    switch($c->estado){
                        case 1: $estado="Pendiente"; break;
                        case 2: $estado="Derivado"; break;
                    }

                    array_push($variable, array($m++,$fecha, $c->dni, $c->apellido_paterno." ".$c->apellido_materno.", ".$c->nombres, $c->sexo, $c->edad,$c->nombre_dpto,$c->nombre_prov,$c->nombre_dist,$fr,$estado));
                  }
                  $sheet->with($variable)->mergeCells('A2:D2')->mergeCells('A3:C3')->mergeCells('A4:C4');
                }
            });
        })->export('xlsx');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
