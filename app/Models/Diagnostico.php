<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Diagnostico extends Model
{
    //
    public function ShowDiagnosticos() {        
        $datos=DB::table('diagnosticos')
                ->select('diagnosticos.*')   
                ->orderby('nombre','asc')
                ->where('estado',1)
                ->whereRaw('LENGTH(codigo) > 4')                
                ->get();
        return $datos;
    }
    
    public function GetDiagnosticoByCie($cie){
        $datos=DB::table('diagnosticos')
                ->select('diagnosticos.*')   
                ->where('codigo',$cie)
                ->where('estado',1)
                ->whereRaw('LENGTH(codigo) > 4')
                ->first();
        return $datos;
    }
    
    public function GetDiagnosticoByCieGet($id){
        $datos=DB::table('diagnosticos')
                ->select('diagnosticos.*')   
                ->where('codigo',$id)
                ->where('estado',1)
                ->whereRaw('LENGTH(codigo) > 4')
                ->get();
        return $datos;
    }

    public function GetDiagnosticoById($id){
        $datos=DB::table('diagnosticos')
                ->select('diagnosticos.*')   
                ->where('id',$id)
                ->where('estado',1)
                ->whereRaw('LENGTH(codigo) > 4')
                ->get();
        return $datos;
    }
	
	public function GetDiagnosticoxId($id){
        $datos=DB::table('diagnosticos')
                ->select('diagnosticos.*')   
                ->where('estado',1)
                ->where('id',$id)
                ->first();
        return $datos;
    }
	
	public function getDiagnosticoByNombre($buscar) {
        
        $cad = "select *
                from diagnosticos
                where codigo||nombre ilike '%".$buscar."%' and length(codigo) >4 and estado=1
                order By nombre asc
                limit 50 ";
        
        $data = DB::select($cad);
        return $data;		
    }

    function getDiagnosticos() {
        $cad = "Select id,codigo, nombre,estado From diagnosticos Order By id";
        $data = DB::select($cad);
        return $data;
    }

    public function diagnostico_yaregistrada($abreviatura){
        $datos=DB::table('diagnosticos') 
                ->where('diagnosticos.codigo','=',$abreviatura)
                ->where('estado',1)
                ->select('diagnosticos.*')
                ->first();
        return $datos;                      
    }

    public function GetDiagnosticoByIdAislado($id, $tipo) {

        $cad = "select distinct t1.id_diagnostico,coalesce(t1.tipo_diagnostico,0)id_tipo_diagnostico,codigo ,(case when codigo='Z21.X' or codigo ilike 'B20%' Then '' else nombre end)nombre
            from aislado_diagnosticos t1
            inner join diagnosticos t2 on t1.id_diagnostico=t2.id
            where t1.id_aislado=".$id." and t1.ingreso_egreso=".$tipo;
            
            
        $data = DB::select($cad);
        return $data;
    }

    public function GetDiagnosticoByHospitalizado($id, $tipo) {

        $cad = "select distinct t1.id_diagnostico,coalesce(t1.tipo_diagnostico,0)id_tipo_diagnostico,codigo ,(case when codigo='Z21.X' or codigo ilike 'B20%' Then '' else nombre end)nombre
            from diagnostico_hospitalizados t1
            inner join diagnosticos t2 on t1.id_diagnostico=t2.id
            where t1.id_hospitalizado=".$id." and t1.ingreso_egreso=".$tipo;
            
        $data = DB::select($cad);
        return $data;
    }

    public static function GetDiagnosticoByHosp($id, $tipo) {

        $cad = "select distinct t1.id_diagnostico,coalesce(t1.tipo_diagnostico,0)id_tipo_diagnostico,codigo ,(case when codigo='Z21.X' or codigo ilike 'B20%' Then '' else nombre end)nombre
            from diagnostico_hospitalizados t1
            inner join diagnosticos t2 on t1.id_diagnostico=t2.id
            where t1.id_hospitalizado=".$id." and t1.ingreso_egreso=".$tipo;
            
        $data = DB::select($cad);
        return $data;
    }

    public function GetDiagnosticoEsavi($id, $tipo) {

        $cad = "select distinct t1.diagnostico_id,coalesce(t1.tipo_diagnostico,0)id_tipo_diagnostico,codigo ,(case when codigo='Z21.X' or codigo ilike 'B20%' Then '' else nombre end)nombre
            from diagnostico_esavi t1
            inner join diagnosticos t2 on t1.diagnostico_id=t2.id
            where t1.aislado_id=".$id." and t1.ingreso_egreso=".$tipo;
            
            
        $data = DB::select($cad);
        return $data;
    }

}
