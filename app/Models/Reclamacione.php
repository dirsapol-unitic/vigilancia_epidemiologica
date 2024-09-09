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
class Reclamacione extends Model
{
    use SoftDeletes;

    public $table = 'reclamaciones';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'fecha_reclamacion',
        'fecha_registro',
        'nro_reclamacion',
        'id_establecimiento',
        'tipo_doc',
        'nro_doc',
        'nombres',        
        'departamento',
        'provincia',
        'distrito',
        'apellido_paterno',
        'apellido_materno',
        'domicilio',
        'telefono',
        'email',
        'celular',
        'reclamo',
        'autorizar_envio',
        'ano_reclamacion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_reclamacion' => 'string',
        'fecha_registro' => 'string',
        'nro_reclamacion' => 'string',
        'id_establecimiento' => 'integer',
        'tipo_doc' => 'string',
        'departamento' => 'string',
        'provincia' => 'string',
        'distrito' => 'string',
        'nombres' => 'string',
        'apellido_paterno' => 'string',
        'apellido_materno' => 'string',
        'domicilio' => 'string',
        'telefono' => 'string',
        'email' => 'string',
        'celular' => 'string',
        'reclamo' => 'string',
        'autorizar_envio' => 'string',
        'ano_reclamacion' => 'string',
        'estado' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //devolver valores de 1 a muchos
    
    
    public function getTodasReclamaciones(){
        
        $cad="select * from reclamaciones";
        $data = DB::select($cad);

        return $data;
    }

    /*public function getEstablecimientos($id){
        
        $cad="select * from establecimientos where id=".$id;
        $data = DB::select($cad);

        return $data;
    }*/

    public function getReclamaciones($id){
        
        $datos=DB::table('reclamaciones')
               ->where('reclamaciones.estado','=',1)
               ->where('reclamaciones.id','=',$id)
               ->select('reclamaciones.*')
               ->first();
        return $datos;
    }   

    function GetByNroReclamacion($id){
        $year = date('Y');
        $cad = "select LPAD(((count(*)+1)::text),5,'0')numero
                from reclamaciones R
                where R.id_establecimiento = ".$id." and ano_reclamacion = extract(year from now())::text";
        $data = DB::select($cad);
        //return $data[0]->numero;                
        return $data;
    }  

    public function AllReclamacionesDiariasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "", $estado = "") {

        $cad = "select r.*, r.created_at as fec_creacion, e.nombre, DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp) as tiempo
                from reclamaciones r
                Inner Join establecimientos e on  r.id_establecimiento = e.id                
                where  1=1";

        if ($dni_beneficiario):
            $cad .= " and r.nro_doc = '" . $dni_beneficiario . "'";        
        endif;

        if ($nro_reclamacion):
            $cad .= " and r.nro_reclamacion like '%" . $nro_reclamacion . "%'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and r.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and r.fecha_reclamacion <= '" . $fechaHasta . "'";
        if ($estado = 0)
            $cad .= " and r.estado = '" . $estado . "'";
        else            
            $cad .= " and r.estado>0 and r.estado<3 ";
        $cad .= " 
order By r.fecha_registro desc";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    public function AllReclamacionesFechaDesdeHasta($id_ipress="", $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "", $estado = "", $tiempo = "") {

        $cad = "select r.*, r.created_at as fec_creacion, e.nombre, DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp) as tiempo
                from reclamaciones r Inner Join establecimientos e on  r.id_establecimiento = e.id                
                where  1=1";

        if ($id_ipress!=0):
            $cad .= " and r.id_establecimiento = '" . $id_ipress . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and r.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and r.fecha_reclamacion <= '" . $fechaHasta . "'";

        if ($dni_beneficiario!=""):
            if ($dni_beneficiario!=0):
                $cad .= " and r.nro_doc = '" . $dni_beneficiario . "'";        
            endif;
        endif;

        if ($nro_reclamacion!=""):
            if ($nro_reclamacion!=0):
                $cad .= " and r.nro_reclamacion like '%" . $nro_reclamacion . "%'";
            endif;
        endif;

        if ($estado<3):
            $cad .= " and r.estado = '" . $estado . "'";        
        else:
            $cad .= " and r.estado > 0 and r.estado < 3";        
        endif;
        
        switch ($tiempo) {
            case '1':
                $cad .= " and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)>1 and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)<10";
                break;
            case '2':
                $cad .= " and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)>10 and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)<20";
                break;
            case '3':
                $cad .= " and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)>20 and DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp)<32";
                break;
        }
        
        
        $cad .= " order By r.fecha_registro desc";

                
        $data = DB::select($cad);
        return $data;
        
    }

    
        public function GetCountReclamacionesFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {

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

        $cad .= " and reclamaciones.estado>0 and reclamaciones.estado<3";

        $data = DB::select($cad);
        return $data[0]->cantidad;
    }

    public function GetReclamacionByIdReclamacion($id_reclamacion) {
        //$datos = Reclamacione::where('id', '=', $id_reclamacion)->first();
        $datos=DB::table('reclamaciones')
               ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
               ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
               ->join('provincias','reclamaciones.id_provincia','provincias.id')
               ->join('distritos','reclamaciones.id_distrito','distritos.id')
               ->where('reclamaciones.id','=',$id_reclamacion)
               ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
               ->first();
        return $datos;
        
    }

    public function ShowByNroReclamacionAndId_IpressInvalidada($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia','provincias.id')
                ->join('distritos','reclamaciones.id_distrito','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '=', 0)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();        
        return $datos;
    }

    public function GetIdRecetaByNroReclamacionInvalidada($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '=', 0)
                ->select('reclamaciones.id')
                ->first();
        return $datos;
    }

    public function ShowByNroReclamacionAndId_ipressValida($nro_reclamacion, $id_ipress, $id_reclamacion) {
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
    public function ShowByNroReclamacionSolucion($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia','provincias.id')
                ->join('distritos','reclamaciones.id_distrito','distritos.id')                
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }
    public function ShowByNroReclamacionAndId_ipressValida2($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento2','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia2','provincias.id')
                ->join('distritos','reclamaciones.id_distrito2','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '>', 0)
                ->where('reclamaciones.estado', '<', 3)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }
     public function ShowByNroReclamacionSoluciones($nro_reclamacion, $id_ipress, $id_reclamacion) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos','reclamaciones.id_establecimiento','establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento2','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia2','provincias.id')
                ->join('distritos','reclamaciones.id_distrito2','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }

    public function GetIdReclamacionByNroReclamacionValida($nro_reclamacion, $id_ipress) {
        $datos = DB::table('reclamaciones')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.estado', '>=', 1)
                ->where('reclamaciones.estado', '<=', 2)
                ->select('reclamaciones.id')
                ->first();
        return $datos;
    }

    public function AllReclamacionesDiariasInvalidasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {
        $cad = "select reclamaciones.*, establecimientos.nombre, establecimientos.direccion, DATE_PART('day', reclamaciones.fecha_vencimiento::timestamp - current_date::timestamp) as tiempo

                from reclamaciones
                inner join establecimientos on reclamaciones.id_establecimiento = establecimientos.id
                where   reclamaciones.estado=0 ";                

        if ($id_ipress):
            $cad .= " and reclamaciones.id_establecimiento = '" . $id_ipress . "'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

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

    public function AllReclamacionesInvalidasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {
        $cad = "select r.*, establecimientos.nombre, establecimientos.direccion, DATE_PART('day', r.fecha_vencimiento::timestamp - current_date::timestamp) as tiempo
                from reclamaciones r
                inner join establecimientos on r.id_establecimiento = establecimientos.id
                where   r.estado=0 
                AND     r.id_establecimiento=" . $id_ipress;

        if ($dni_beneficiario):
            $cad .= " and r.nro_doc = '" . $dni_beneficiario . "'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($nro_reclamacion):
            $cad .= " and r.nro_reclamacion like '%" . $nro_reclamacion . "%'";
            $fechaDesde = "";
            $fechaHasta = "";
        endif;

        if ($fechaDesde != "")
            $cad .= " and r.fecha_reclamacion >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and r.fecha_reclamacion <= '" . $fechaHasta . "'";

        $cad .= " order By r.id desc";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    public function GetCountReclamacionesInvalidasFechaDesdeHasta($id_ipress, $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $nro_reclamacion = "") {

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

    public function ShowByNroReclamacionAndId_ipress($nro_reclamacion, $id_ipress, $id_reclamacion = 0) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos', 'reclamaciones.id_establecimiento', '=', 'establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia','provincias.id')
                ->join('distritos','reclamaciones.id_distrito','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)
                ->where('reclamaciones.id_establecimiento', '=', $id_ipress)
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }

        public function ShowByNroReclamacionAndId_ipress2($nro_reclamacion, $id_reclamacion = 0) {
        $datos = DB::table('reclamaciones')
                ->join('establecimientos', 'reclamaciones.id_establecimiento', '=', 'establecimientos.id')
                ->join('departamentos','reclamaciones.id_departamento','departamentos.id')
                ->join('provincias','reclamaciones.id_provincia','provincias.id')
                ->join('distritos','reclamaciones.id_distrito','distritos.id')
                ->where('reclamaciones.nro_reclamacion', '=', $nro_reclamacion)                
                ->where('reclamaciones.id', '=', $id_reclamacion)
                ->select('reclamaciones.*','establecimientos.nombre','establecimientos.direccion','departamentos.nombre_dpto','provincias.nombre_prov','distritos.nombre_dist')
                ->get();
        return $datos;
    }



    function getFechaServidor() {

        $cad = "SELECT now()::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    function getFechaServidorRestaMeses($mes) {

        $cad = "SELECT (CAST(now() AS DATE) - CAST('" . $mes . " month' AS INTERVAL))::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    public static function GetReclamacionesAndFechasVencimiento($id_ipress, $fecha_inicio, $fecha_fin) {

        $cad = "select reclamaciones.id_establecimiento,reclamaciones.nro_reclamacion ,to_char(reclamaciones.fecha_vencimiento,'dd-mm-yyyy')fecha_vencimiento
,min(reclamaciones.created_at)created_at
from reclamaciones
where reclamaciones.estado>0 and reclamaciones.estado<3 and reclamaciones.id_establecimiento='" . $id_ipress . "'";
        $cad .= " And reclamaciones.fecha_vencimiento>='" . $fecha_inicio . "'";
        $cad .= " And reclamaciones.fecha_vencimiento<='" . $fecha_fin . "'";

        $cad .= " group by reclamaciones.id_establecimiento,reclamaciones.nro_reclamacion ,to_char(reclamaciones.fecha_vencimiento,'dd-mm-yyyy')
                    order by to_char(reclamaciones.fecha_vencimiento,'dd-mm-yyyy') asc";
        $data = DB::select($cad);
        return $data;
    }

    
 
    
}
