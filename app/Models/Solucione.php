<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Establecimientos
 * @package App\Models
 * @version February 1, 2018, 7:57 am UTC
 */
class Solucione extends Model
{
    use SoftDeletes;

    public $table = 'soluciones';
    

    protected $dates = ['deleted_at'];

    public $fillable = [
        'id_reclamo',
        'id_establecimiento',
        'personal_solucionador',
        'trato_directo',
        'fecha_solucion',
        'fecha_registro',
        'nro_doc',        
        'nro_notificacion',
        'estado_reclamo',
        'resultado_reclamo',
        'solucion_rpta',
        'ano_reclamacion',
        'estado'
        
    ];

    protected $casts = [
        'id_reclamo' => 'integer',
        'id_establecimiento' => 'integer',
        'personal_solucionador' => 'string',
        'trato_directo' => 'string',        
        'fecha_solucion' => 'string',
        'fecha_registro' => 'string',
        'nro_doc' => 'string',
        'nro_notificacion' => 'string',
        'estado_reclamo' => 'integer',
        'resultado_reclamo' => 'integer',
        'solucion_rpta' => 'string',
        'ano_reclamacion' => 'string',
        'estado' => 'integer'
    ];

    public static $rules = [
        
    ];

    //devolver valores de 1 a muchos
    public function getTodasSoluciones(){
        
        $cad="select * from soluciones";
        $data = DB::select($cad);

        return $data;
    }
    
    public function getDoluciones($id){
        
        $datos=DB::table('soluciones')
               ->where('soluciones.estado','=',1)
               ->where('soluciones.id','=',$id)
               ->select('soluciones.*')
               ->first();
        return $datos;
    }   

    function GetByNroSolucion($id, $trato){
        $year = date('Y');
        $cad = "select LPAD(((count(*)+1)::text),5,'0')numero, E.cod_ipress
                from soluciones S
                inner join establecimientos E on E.id=S.id_establecimiento
                where S.id_establecimiento = ".$id." and trato_directo = '".$trato."'  and ano_reclamacion = extract(year from now())::text
                group by E.cod_ipress
                ";
        $data = DB::select($cad);
        
        return $data;
    }

    public function AllSolucionesFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {

        $cad = "select r.*, r.created_at as fec_creacion, e.nombre
                from soluciones r
                Inner Join establecimientos e on  r.id_establecimiento = e.id
                --Inner Join soluciones c On reclamaciones.id=c.id_reclamo
                where r.id_establecimiento=" . $id_ipress;

        if ($dni_beneficiario):
            $cad .= " and r.nro_doc = '" . $dni_beneficiario . "'";
        //$fechaDesde="";$fechaHasta="";
        endif;

        if ($nro_reclamacion):
            $cad .= " and r.nro_reclamacion like '%" . $nro_reclamacion . "%'";
        //$fechaDesde="";$fechaHasta="";
        endif;

        if ($fechaDesde != "")
            $cad .= " and r.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and r.fecha_reclamacion <= '" . $fechaHasta . "'";

        $cad .= " and r.estado=1
order By r.fecha_registro desc";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

        public function GetCountSolucionesFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {

        $cad = "select count(1) cantidad
from reclamaciones
where reclamaciones.id_establecimiento=" . $id_ipress;

        if ($dni_beneficiario):
            $cad .= " and reclamaciones.nro_doc = '" . $dni_beneficiario . "'";
        //$fechaDesde="";$fechaHasta="";
        endif;

        if ($nro_reclamacion):
            $cad .= " and reclamaciones.nro_reclamacion = '" . $nro_reclamacion . "'";
        //$fechaDesde="";$fechaHasta="";
        endif;

        if ($fechaDesde != "")
            $cad .= " and reclamaciones.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and reclamaciones.fecha_reclamacion <= '" . $fechaHasta . "'";

        $cad .= " and reclamaciones.estado=1";

        $data = DB::select($cad);
        return $data[0]->cantidad;
    }

    public function GetSolucionByIdSolucion($id_solucion) {
        
        $datos=DB::table('soluciones')
               ->join('establecimientos','soluciones.id_establecimiento','establecimientos.id')
               ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
               ->join('provincias','reclamaciones.id_provincia','provincias.id')
               ->join('distritos','reclamaciones.id_distrito','distritos.id')
               ->where('soluciones.id','=',$id_solucion)
               ->select('soluciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
               ->first();
        return $datos;
        
    }

    public function GetIdSolucionyNroReclamacionInvalidada($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '=', 0)
                ->select('reclamaciones.id')
                ->first();
        return $datos;
    }

    public function ShowByNroSolucionAndId_ipressValida($id_reclamacion) {
        $datos = DB::table('soluciones')
                ->join('establecimientos','soluciones.id_establecimiento','establecimientos.id')                
                ->where('soluciones.id_reclamacion', '=', $id_reclamacion)                
                ->where('soluciones.estado_reclamo', '>', 1)
                ->select('soluciones.*','establecimientos.nombre','establecimientos.direccion')
                ->get();
        return $datos;
    }

/*    public function ShowByNroReclamacionAndId_ipressValida($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia','provincias.id')
                ->join('distritos','reclamaciones.id_distrito','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '>', 0)
                ->where('reclamaciones.estado', '<', 3)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }
*/

    public function GetIdSolucionByNroSolucionValida($id_reclamacion) {
        $datos = DB::table('soluciones')
                ->where('soluciones.id_reclamacion', '=', $id_reclamacion)                
                ->where('soluciones.estado_reclamo', '>', 1)
                ->select('soluciones.id')
                ->first();
        return $datos;
    }

    public function AllSolucionesInvalidasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {
        $cad = "select reclamaciones.*, establecimientos.nombre, establecimientos.direccion
                from reclamaciones
                inner join establecimientos on reclamaciones.id_establecimiento = establecimientos.id
                where   reclamaciones.estado=0 
                AND     reclamaciones.id_establecimiento=" . $id_ipress;

        if ($dni_beneficiario):
            $cad .= " and reclamaciones.nro_doc = '" . $dni_beneficiario . "'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($nro_reclamacion):
            $cad .= " and reclamaciones.nro_reclamacion like '%" . $nro_reclamacion . "%'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($fechaDesde != "")
            $cad .= " and reclamaciones.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and reclamaciones.fecha_reclamacion <= '" . $fechaHasta . "'";

        $cad .= " order By reclamaciones.id desc";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    public function GetCountSolucionesInvalidasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {

        $cad = "select count(1) cantidad
from reclamaciones
where   reclamaciones.estado=0 
and     reclamaciones.id_establecimiento=" . $id_ipress;

        if ($dni_beneficiario):
            $cad .= " and reclamaciones.nro_doc = '" . $dni_beneficiario . "'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($nro_reclamacion):
            $cad .= " and reclamaciones.nro_reclamacion = '" . $nro_reclamacion . "'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($fechaDesde != "")
            $cad .= " and reclamaciones.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and reclamaciones.fecha_reclamacion <= '" . $fechaHasta . "'";


        $data = DB::select($cad);
        return $data[0]->cantidad;
        ;
    }

    public function ShowByNroSolucionAndId_ipress($nro_reclamacion, $id_ipress, $id_reclamacion = 0) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos', 'reclamaciones.id_establecimiento', '=', 'establecimientos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }

    function getRestaMeses($mes) {

        $cad = "SELECT (CAST(now() AS DATE) - CAST('" . $mes . " month' AS INTERVAL))::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    public function AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $id_factor=0,  $id_medico=0, $dni_beneficiario = "", $estado = 0) {

        $cad = "select soluciones.id, soluciones.fecha_solucion, soluciones.estado_solucion, soluciones.medico_solucionador , soluciones.dni_medico , aislados.id as busca, aislados.dni , aislados.nombres , aislados.apellido_paterno , aislados.apellido_materno, soluciones.resultado_solucion, soluciones.solucion_rpta
                from aislados
                inner join soluciones on soluciones.id_aislado =aislados.id
                inner join aislamiento_factor_riesgo on aislamiento_factor_riesgo.aislamiento_id = aislados.id 
                inner join users on users.dni = soluciones.dni_medico                        
                where  1=1  ";

        if ($id_factor!=""):
            $cad .= " and aislamiento_factor_riesgo.factor_riesgo_id = " . $id_factor . "";        
        endif;

        if ($id_medico!=0):
            $cad .= " and users.id = " . $id_medico . "";        
        endif;

        if ($dni_beneficiario):
            $cad .= " and aislados.dni = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and soluciones.fecha_solucion >= '" . $fechaDesde . "'";

        if ($fechaHasta != "")
            $cad .= " and soluciones.fecha_solucion <= '" . $fechaHasta . "'";
        
        if ($estado!=0){
            if ($estado != 9)
                $cad .= " and soluciones.resultado_solucion = " . $estado ."";
            else
                $cad .= " and soluciones.resultado_solucion >= 0";
        }
        $cad .= "   group by soluciones.id, soluciones.fecha_solucion, soluciones.estado_solucion, soluciones.medico_solucionador , soluciones.dni_medico , aislados.id, aislados.dni , aislados.nombres , aislados.apellido_paterno , aislados.apellido_materno, soluciones.resultado_solucion, soluciones.solucion_rpta
                    order By soluciones.fecha_solucion desc";

        
        
        $data = DB::select($cad);
        return $data;
    }

}
