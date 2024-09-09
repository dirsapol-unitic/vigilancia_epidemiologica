<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use SoapClient;
use Carbon\Carbon;

/**
 * Class Establecimientos
 * @package App\Models
 * @version February 1, 2018, 7:57 am UTC
 */
class Aislamiento extends Model
{
    use SoftDeletes;

    public $table = 'aislados';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'fecha_registro',
        'dni',
        'cip',
        'nombres',        
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'grado',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'email',
        'celular',
        'domicilio',
        'id_pnpcategoria',
        'id_factor',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'fecha_registro'=> 'string',
        'dni'=> 'string',
        'cip'=> 'string',
        'nombres'=> 'string', 
        'apellido_paterno'=> 'string',
        'apellido_materno'=> 'string',
        'sexo'=> 'string',
        'fecha_nacimiento'=> 'string',
        'grado'=> 'string',
        'id_departamento'=> 'integer',
        'id_provincia'=> 'integer',
        'id_distrito'=> 'integer',
        'celular'=> 'string',
        'domicilio'=> 'string',
        'id_pnpcategoria'=> 'integer',
        'id_factor'=> 'integer',
        'estado'=> 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function ocupacioneaislados(){
        return $this->belongsToMany('App\Models\Ocupacione');
    }

    //devolver valores de 1 a muchos
    /*
    public function factoraislados(){
        return $this->belongsToMany('App\Models\FactorRiesgo');
    }

    public function sintomaaislados(){
        return $this->belongsToMany('App\Models\Sintoma');
    }

    public function signoaislados(){
        return $this->belongsToMany('App\Models\Signo');
    }

    

    public function lugaraislados(){
        return $this->belongsToMany('App\Models\Lugare');
    }

    public function getTodasAislamientos(){
        $cad="select * from aislados";
        $data = DB::select($cad);
        return $data;
    }
*/
    /*public function getAislamientos($id,$dni){
        
        $datos=DB::table('aislados')
               ->where('estado','=',1)
               ->where('id','=',$id)
               ->where('dni','=',$dni)
               ->select('aislados.*')
               ->first();
        return $datos;
    } 
    */ 

    
    function getAislamientos($id,$dni){
        $year = date('Y');
        $cad = "select aislados.*, departamentos.nombre_dpto , provincias.nombre_prov , distritos.nombre_dist, pnp_categorias.descripcion, date_part('year',age(to_date(to_char(aislados.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad from aislados
                inner join departamentos on departamentos.id=aislados.id_departamento
                inner join provincias on provincias.id=aislados.id_provincia
                inner join distritos on distritos.id=aislados.id_distrito
                inner join pnp_categorias on pnp_categorias.id=aislados.id_categoria
                
                where aislados.id = ".$id."and estado = 1 and aislados.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data[0];
    }  

    function getFechaServidorRestaMeses($mes) {

        $cad = "SELECT (CAST(now() AS DATE) - CAST('" . $mes . " month' AS INTERVAL))::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    /*
        $cad = "select aislados.id, aislados.fecha_registro, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, departamentos.nombre_dpto , provincias.nombre_prov , distritos.nombre_dist, pnp_categorias.descripcion, aislados.edad, aislados.estado, aislados.nombre_dpto, aislados.nombre_prov, aislados.nombre_dist from aislados
        inner join departamentos on departamentos.id=aislados.id_departamento
        inner join provincias on provincias.id=aislados.id_provincia
        inner join distritos on distritos.id=aislados.id_distrito
        inner join pnp_categorias on pnp_categorias.id=aislados.id_categoria
    */
    public function AllAislamientosFechaDesdeHasta2($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "",$id_provincia = "",$id_distrito = "" ) {

        $cad = "select aislados.id, aislados.fecha_registro, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo,  aislados.edad, aislados.estado, aislados.nombre_dpto, aislados.nombre_prov, aislados.nombre_dist from aislados
                
                where  1=1";

        if ($dni_beneficiario):
            $cad .= " and aislados.dni = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and aislados.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and aislados.fecha_registro <= '" . $fechaHasta . "'";        
        if ($id_departamento != "")
            $cad .= " and departamentos.id = '" . $id_departamento . "'";
        if ($id_provincia != "")
            $cad .= " and provincias.id = '" . $id_provincia . "'";
        if ($id_distrito != "")
            $cad .= " and distritos.id = '" . $id_distrito . "'";
        //if ($estado = 0)
        //    $cad .= " and aislados.estado = '" . $estado . "'";
        //else            
        //    $cad .= " and aislados.estado>0 and aislados.estado<3 ";
        
        $cad .= " 
            group by aislados.id, aislados.fecha_registro, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado

            order By aislados.id desc";
        
        

        $data = DB::select($cad);
        return $data;
    }

    public function AllAislamientosFechaDesdeHastaR($fechaDesde = "", $fechaHasta = "", $establecimiento_id = "",$dni_beneficiario = "") {

        $cad = "select aislados.id, fichas.created_at fecha_registro, fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo,date_part('year',age(to_date(to_char(aislados.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, aislados.estado, aislados.hospitalizado, aislados.fallecido, aislados.clasificacion , users.nombres as name, users.apellido_paterno, users.apellido_materno
            from aislados
            inner join fichas on fichas.id_aislado = aislados.id
            inner join antecedentes on fichas.id = antecedentes.idficha
            inner join establecimientos on establecimientos.id = antecedentes.id_establecimiento 
            inner join users on fichas.id_user  =  users.id
                where antecedentes.estado=1 and fichas.estado = 1 and aislados.estado =1 and users.establecimiento_id = " . $establecimiento_id ;

        if ($dni_beneficiario):
            $cad .= " and aislados.dni = '" . $dni_beneficiario . "'";        
        endif;

        $inicio = ':00:00';
            $fin=':23:59';
        
            if($establecimiento_id==1){
                
                $date = Carbon::now();
                $fechaDesde = date("Y-m-d", strtotime($fechaDesde));
                $fechaHasta = date("Y-m-d", strtotime($fechaHasta));

                if ($fechaDesde != "")
                $cad .= " and fichas.fecha_notificacion >= '" . $fechaDesde."'";
            
                if ($fechaHasta != "")
                    $cad .= " and fichas.fecha_notificacion <= '" . $fechaHasta."'";

                $cad .= " 
                    group by aislados.id, fichas.created_at, fichas.fecha_notificacion, fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado, users.nombres, users.apellido_paterno, users.apellido_materno
        
                    order By fichas.fecha_notificacion desc";
                
            }
            else{
                if ($fechaDesde != "")
                $cad .= " and fichas.created_at >= '" . $fechaDesde.$inicio."'";
            
                if ($fechaHasta != "")
                    $cad .= " and fichas.created_at <= '" . $fechaHasta.$fin."'";

                $cad .= " 
                group by aislados.id, fichas.created_at,fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado, users.nombres, users.apellido_paterno, users.apellido_materno
    
                order By aislados.id desc";
    
            }
        /*if ($fechaDesde != "")
            $cad .= " and fichas.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and fichas.created_at <= '" . $fechaHasta.$fin."'";

        if ($fechaDesde != "")
            $cad .= " and aislados.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and aislados.fecha_registro <= '" . $fechaHasta . "'";        
        

        $cad .= " 
            group by aislados.id, fichas.created_at,fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado, users.nombres, users.apellido_paterno, users.apellido_materno

            order By aislados.id desc";
        */
        
        $data = DB::select($cad);
        return $data;
    }

    public function TodosAislamientosFechaDesdeHastaR($fechaDesde = "", $fechaHasta = "", $establecimiento_id = "",$dni_beneficiario = "") {

        if($establecimiento_id==1):

            $cad = "select a.id, f.created_at fecha_reg_pac,f.fecha_notificacion, e.nombre establecimiento, d3.nombre_dpto dpto_establecimiento, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion  categoria, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto departamento, p.nombre_prov  provincia, d2.nombre_dist  distrito,a.otra_ocupacion,a.clasificacion, an.fecha_registro fecha_reg_antecedente, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto departamento_antecedente , pr.nombre_prov provincia_antecedente, di.nombre_dist distrito_antecedente, an.gestante, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro fecha_reg_ho,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro fecha_evolucion, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta alta_evolucion, e2.fecha_defuncion evolucion_defuncion,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion observacion_defuncion, h.otra_ubicacion, def.tipo_defuncion nota_certificado, def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at fecha_reg_lab,l.fecha_muestra, m.descripcion muestra, pru.descripcion prueba, res.descripcion res_muestra, l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia, an.id id_antecedente
                from aislados a
                inner join fichas f on f.id_aislado = a.id
                left join antecedentes an on an.idficha = f.id
                left join establecimientos e on e.id = an.id_establecimiento
                left join departamentos d3 on d3.id = e.departamento
                left join departamentos d on d.id = a.id_departamento
                left join provincias p on p.id = a.id_provincia
                left join distritos d2  on d2.id = a.id_distrito
                left join pnp_categorias pc on pc.id=a.id_categoria
                left join departamentos dep on dep.id = an.id_departamento2
                left join provincias pr on pr.id = an.id_provincia2
                left join distritos di on di.id = an.id_distrito2
                left join hospitalizados h on h.idficha = f.id and h.estado =1
                left join establecimiento_saluds es on es.id = h.establecimiento_proviene
                left join evolucions e2 on e2.idficha = f.id and e2.estado =1 and e2.id in (select max(id) from evolucions ev where ev.idficha = f.id)
                left join defunciones def on def.aislado_id = a.id
                left join laboratorios l on l.idficha = f.id and l.estado =1 --and l.id in (select max(id) from laboratorios lb where lb.idficha = f.id)
                left join muestras m on m.id = l.tipo_muestra
                left join pruebas pru on pru.id = l.tipo_prueba
                left join resultados res on res.id = l.resultado_muestra
                where  an.estado=1 and a.estado=1 and f.estado=1 and e.id = " . $establecimiento_id ;

            if ($dni_beneficiario):
                $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
            endif;

            $inicio = ':00:00';
                $fin=':23:59';
            
            $date = Carbon::now();
            $fechaDesde = date("Y-m-d", strtotime($fechaDesde));
            $fechaHasta = date("Y-m-d", strtotime($fechaHasta));


            if ($fechaDesde != "")
                $cad .= " and f.fecha_notificacion >= '" . $fechaDesde."'";
            
            if ($fechaHasta != "")
                $cad .= " and f.fecha_notificacion <= '" . $fechaHasta."'";        


            $cad .= " group by a.id, f.created_at, f.fecha_notificacion, e.nombre, d3.nombre_dpto, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto, p.nombre_prov, an.id, d2.nombre_dist,a.otra_ocupacion,a.clasificacion, an.fecha_registro, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto , pr.nombre_prov, di.nombre_dist, an.gestante,a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta , e2.fecha_defuncion ,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion , h.otra_ubicacion, def.tipo_defuncion , def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at,l.fecha_muestra, m.descripcion , pru.descripcion , res.descripcion , l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia"; 

            $cad .= " order By f.fecha_notificacion desc";
            
            $data = DB::select($cad);

        return $data;

    else:

        $cad = "select a.id, f.created_at fecha_reg_pac,f.fecha_notificacion, e.nombre establecimiento, d3.nombre_dpto dpto_establecimiento, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion  categoria, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto departamento, p.nombre_prov  provincia, d2.nombre_dist  distrito,a.otra_ocupacion,a.clasificacion, an.fecha_registro fecha_reg_antecedente, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto departamento_antecedente , pr.nombre_prov provincia_antecedente, di.nombre_dist distrito_antecedente, an.gestante, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro fecha_reg_ho,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro fecha_evolucion, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta alta_evolucion, e2.fecha_defuncion evolucion_defuncion,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion observacion_defuncion, h.otra_ubicacion, def.tipo_defuncion nota_certificado, def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at fecha_reg_lab,l.fecha_muestra, m.descripcion muestra, pru.descripcion prueba, res.descripcion res_muestra, l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia, an.id id_antecedente
            from aislados a
            inner join fichas f on f.id_aislado = a.id
            left join antecedentes an on an.idficha = f.id
            left join establecimientos e on e.id = an.id_establecimiento
            left join departamentos d3 on d3.id = e.departamento
            left join departamentos d on d.id = a.id_departamento
            left join provincias p on p.id = a.id_provincia
            left join distritos d2  on d2.id = a.id_distrito
            left join pnp_categorias pc on pc.id=a.id_categoria
            left join departamentos dep on dep.id = an.id_departamento2
            left join provincias pr on pr.id = an.id_provincia2
            left join distritos di on di.id = an.id_distrito2
            left join hospitalizados h on h.idficha = f.id and h.estado =1
            left join establecimiento_saluds es on es.id = h.establecimiento_proviene
            left join evolucions e2 on e2.idficha = f.id and e2.estado =1 and e2.id in (select max(id) from evolucions ev where ev.idficha = f.id)
            left join defunciones def on def.aislado_id = a.id
            left join laboratorios l on l.idficha = f.id and l.estado =1 --and l.id in (select max(id) from laboratorios lb where lb.idficha = f.id)
            left join muestras m on m.id = l.tipo_muestra
            left join pruebas pru on pru.id = l.tipo_prueba
            left join resultados res on res.id = l.resultado_muestra
            where  an.estado=1 and a.estado=1 and f.estado=1 and e.id = " . $establecimiento_id ;

        if ($dni_beneficiario):
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        endif;

        $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and f.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and f.created_at <= '" . $fechaHasta.$fin."'";        


        /*if ($fechaDesde != "")
            $cad .= " and a.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and a.fecha_registro <= '" . $fechaHasta . "'"; 
        */
        

        $cad .= " group by a.id, f.created_at, f.fecha_notificacion, e.nombre, d3.nombre_dpto, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto, p.nombre_prov, an.id, d2.nombre_dist,a.otra_ocupacion,a.clasificacion, an.fecha_registro, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto , pr.nombre_prov, di.nombre_dist, an.gestante,a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta , e2.fecha_defuncion ,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion , h.otra_ubicacion, def.tipo_defuncion , def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at,l.fecha_muestra, m.descripcion , pru.descripcion , res.descripcion , l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia"; 

        $cad .= " order By f.created_at desc";
        
        $data = DB::select($cad);

        return $data;

    endif;
    }

    public function AllHospitalizacionFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = 0, $id_departamento = 0 ) {

        $cad = "select a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  d.nombre_dpto ,h.ventilacion_mecanica, h.intubado, h.neumonia, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.sexo, f.id idficha
            from aislados a
            inner join fichas f on a.id = f.id_aislado
            inner join antecedentes an on f.id = an.idficha
            inner join hospitalizados h on a.id = h.id_paciente and h.id in (select max(id) from hospitalizados hp where hp.idficha = f.id)
            inner join departamentos d on d.id=an.id_departamento2
            inner join establecimiento_saluds e  on e.id = h.establecimiento_actual
                where  an.estado=1 and h.idficha = f.id and a.estado=1 and f.estado=1 and h.estado=1 and f.activo = 1 ";

        if ($dni_beneficiario!= 0):
            $cad .= " and h.dni_paciente = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and h.fecha_hospitalizacion >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and h.fecha_hospitalizacion <= '" . $fechaHasta . "'";        
        if ($id_departamento != 0)
            $cad .= " and d.id = " . $id_departamento;
        
        $cad .= " 
            group by a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  h.servicio_hospitalizacion , h.ventilacion_mecanica, h.intubado, h.neumonia, h.tipo_Seguro, d.nombre_dpto, f.id
            order By h.fecha_hospitalizacion desc";

        $data = DB::select($cad);
        return $data;
    }

    public function AllHospitalizacionFechaDesdeHastaTotal($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = 0, $id_departamento = 0 ) {

        $cad = "select a.id,a.created_at fecha_reg_pac,a.fecha_registro  fecha_notificacion, e.nombre establecimiento, d3.nombre_dpto dpto_establecimiento, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, pc.descripcion  categoria, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto departamento, p.nombre_prov  provincia, d2.nombre_dist  distrito,a.otra_ocupacion,a.clasificacion,an.fecha_registro fecha_reg_antecedente, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto departamento_antecedente , pr.nombre_prov provincia_antecedente, di.nombre_dist distrito_antecedente, an.gestante, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro fecha_reg_ho,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro fecha_evolucion, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta alta_evolucion, e2.fecha_defuncion evolucion_defuncion,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion observacion_defuncion, h.otra_ubicacion, def.tipo_defuncion nota_certificado, def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at fecha_reg_lab,l.fecha_muestra, m.descripcion muestra, pru.descripcion prueba, res.descripcion res_muestra, l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia 
            from aislados a
            inner join fichas f on f.id_aislado = a.id
            left join antecedentes an on an.idficha = f.id
            inner join departamentos d on d.id = a.id_departamento
            left join provincias p on p.id = a.id_provincia
            left join distritos d2  on d2.id = a.id_distrito
            left join pnp_categorias pc on pc.id=a.id_categoria
            inner join departamentos dep on dep.id = an.id_departamento2
            left join provincias pr on pr.id = an.id_provincia2
            left join distritos di on di.id = an.id_distrito2
            inner join hospitalizados h on a.id = h.id_paciente 
            inner join establecimientos e on e.id = f.id_establecimiento
            inner join departamentos d3 on d3.id = e.departamento
            --inner join establecimiento_saluds e on e.id = h.establecimiento_actual 
            left join establecimiento_saluds es on es.id = h.establecimiento_proviene
            left join evolucions e2 on e2.idficha = f.id and e2.estado =1 and e2.id in (select max(id) from evolucions ev where ev.idficha = f.id)
            left join defunciones def on def.aislado_id = a.id
            left join laboratorios l on l.idficha = f.id and l.estado =1 -- and l.id in (select max(id) from laboratorios lb where lb.idficha = f.id)
            left join muestras m on m.id = l.tipo_muestra
            left join pruebas pru on pru.id = l.tipo_prueba
            left join resultados res on res.id = l.resultado_muestra
            where  an.estado=1 and f.estado=1 and a.estado=1 and h.estado=1"; 
            
            $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and f.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and f.created_at <= '" . $fechaHasta.$fin."'";        

        if ($id_departamento != 0)
            $cad .= " and d3.id = ".$id_departamento;        

        if ($dni_beneficiario != 0)
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        
        $cad .= " group by  a.id, f.created_at, f.fecha_notificacion, e.nombre, d3.nombre_dpto, a.dni, a.nombres, a.paterno, a.materno, a.cip, 
            a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion, a.talla, 
            a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto, p.nombre_prov, d2.nombre_dist,a.otra_ocupacion,a.clasificacion, 
            an.fecha_registro, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto , pr.nombre_prov, di.nombre_dist, an.gestante,a.estado,
            an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, 
            a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , 
            h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,
            h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro, 
            e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta , e2.fecha_defuncion ,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion , 
            h.otra_ubicacion, def.tipo_defuncion , def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at,l.fecha_muestra, m.descripcion , pru.descripcion , 
            res.descripcion , l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia";
        
        $cad .= " order By f.created_at desc";
        
        $data = DB::select($cad);
        return $data;
    }

    public function AllHospitalizacionFechaDesdeHastaX($fechaDesde = "", $fechaHasta = "", $id_departamento = "", $dni_beneficiario = "" ) {

        $cad = "select a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  d.nombre_dpto  , d2.nombre_dpto dpto ,h.ventilacion_mecanica, h.intubado, h.neumonia, h.tipo_Seguro
            from aislados a
            inner join hospitalizados h on a.id = h.id_paciente
            inner join departamentos d on d.id=a.id_departamento
            inner join establecimientos e  on e.id = h.establecimiento_actual
            inner join departamentos d2 on  d2.id=e.departamento
                where a.estado=1 and h.estado=1 ";

        if ($dni_beneficiario):
            $cad .= " and aislados.dni = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and h.fecha_hospitalizacion >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and h.fecha_hospitalizacion <= '" . $fechaHasta . "'";        
        if ($id_departamento != "")
            $cad .= " and d.id = '" . $id_departamento . "'";
        
        $cad .= " 
            group by a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  h.servicio_hospitalizacion , h.ventilacion_mecanica, h.intubado, h.neumonia, h.tipo_Seguro, d.nombre_dpto, d2.nombre_dpto
            order By h.fecha_hospitalizacion desc";

        $data = DB::select($cad);
        return $data;
    }
    
    public function AllHospitalizacionFechaDesdeHastaR($fechaDesde = "", $fechaHasta = "", $id_establecimiento = "", $dni_beneficiario = "" ) {

        $cad = "select a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  d.nombre_dpto  , h.ventilacion_mecanica, h.intubado, h.neumonia, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.sexo, f.id idficha
            from aislados a
            inner join fichas f on a.id = f.id_aislado
            inner join hospitalizados h on a.id = h.id_paciente
            inner join departamentos d on d.id=a.id_departamento
            inner join establecimiento_saluds e  on e.id = h.establecimiento_actual
            inner join antecedentes on f.id = antecedentes.idficha
            inner join establecimientos on establecimientos.id = antecedentes.id_establecimiento 
            inner join users on f.id_user  =  users.id
            where a.estado=1 and h.idficha = f.id and f.estado=1 and h.estado=1 and users.establecimiento_id = " . $id_establecimiento ;

        if ($dni_beneficiario):
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and h.fecha_hospitalizacion >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and h.fecha_hospitalizacion <= '" . $fechaHasta . "'";        
        
        $cad .= " 
            group by a.id, h.fecha_hospitalizacion, a.dni, a.nombres , a.paterno , a.materno,  h.servicio_hospitalizacion , h.ventilacion_mecanica, h.intubado, h.neumonia, h.tipo_Seguro, d.nombre_dpto, f.id
            order By h.fecha_hospitalizacion desc";
        $data = DB::select($cad);


        return $data;
    }

    public function AllHospitalizacionFechaDesdeHastaTotalR($fechaDesde = "", $fechaHasta = "", $id_establecimiento = "", $dni_beneficiario = "" ){

        $cad = "select a.id,a.created_at fecha_reg_pac,a.fecha_registro  fecha_notificacion, e.nombre establecimiento, d3.nombre_dpto dpto_establecimiento, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, pc.descripcion  categoria, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto departamento, p.nombre_prov  provincia, d2.nombre_dist  distrito,a.otra_ocupacion,a.clasificacion,an.fecha_registro fecha_reg_antecedente, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto departamento_antecedente , pr.nombre_prov provincia_antecedente, di.nombre_dist distrito_antecedente, an.gestante, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro fecha_reg_ho,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro fecha_evolucion, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta alta_evolucion, e2.fecha_defuncion evolucion_defuncion,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion observacion_defuncion, h.otra_ubicacion, def.tipo_defuncion nota_certificado, def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at fecha_reg_lab,l.fecha_muestra, m.descripcion muestra, pru.descripcion prueba, res.descripcion res_muestra, l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia 
            from aislados a
            inner join fichas f on f.id_aislado = a.id
            left join antecedentes an on an.idficha = f.id
            inner join departamentos d on d.id = a.id_departamento
            left join provincias p on p.id = a.id_provincia
            left join distritos d2  on d2.id = a.id_distrito
            left join pnp_categorias pc on pc.id=a.id_categoria
            inner join departamentos dep on dep.id = an.id_departamento2
            left join provincias pr on pr.id = an.id_provincia2
            left join distritos di on di.id = an.id_distrito2
            inner join hospitalizados h on a.id = h.id_paciente and h.idficha = f.id
            inner join establecimientos e on e.id = h.establecimiento_actual 
            inner join departamentos d3 on d3.id = e.departamento
            left join establecimiento_saluds es on es.id = h.establecimiento_proviene
            left join evolucions e2 on e2.idficha = f.id and e2.estado =1 and e2.id in (select max(id) from evolucions ev where ev.idficha = f.id)
            left join defunciones def on def.aislado_id = a.id
            left join laboratorios l on l.idficha = f.id and l.estado =1 -- and l.id in (select max(id) from laboratorios lb where lb.idficha = f.id)
            left join muestras m on m.id = l.tipo_muestra
            left join pruebas pru on pru.id = l.tipo_prueba
            left join resultados res on res.id = l.resultado_muestra
            where an.estado=1 and a.estado=1 and f.estado=1 and h.estado=1 and e.id = " . $id_establecimiento ;

            $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and f.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and f.created_at <= '" . $fechaHasta.$fin."'";        

        if ($dni_beneficiario != 0)
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        
        $cad .= " group by  a.id, f.created_at, f.fecha_notificacion, e.nombre, d3.nombre_dpto, a.dni, a.nombres, a.paterno, a.materno, a.cip, 
            a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion, a.talla, 
            a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto, p.nombre_prov, d2.nombre_dist,a.otra_ocupacion,a.clasificacion, 
            an.fecha_registro, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto , pr.nombre_prov, di.nombre_dist, an.gestante,a.estado,
            an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, 
            a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , 
            h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,
            h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro, 
            e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta , e2.fecha_defuncion ,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion , 
            h.otra_ubicacion, def.tipo_defuncion , def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at,l.fecha_muestra, m.descripcion , pru.descripcion , 
            res.descripcion , l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia";
        
        $cad .= " order By f.created_at desc";
        
        $data = DB::select($cad);
        return $data;
    }

    public function AllAislamientosDiariasInvalidasFechaDesdeHasta( $fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "") {
        $cad = "select aislados.*, departamentos.nombre_dpto , provincias.nombre_prov , distritos.nombre_dist, pnp_categorias.descripcion from aislados
                inner join departamentos on departamentos.id=aislados.id_departamento
                inner join provincias on provincias.id=aislados.id_provincia
                inner join distritos on distritos.id=aislados.id_distrito
                inner join pnp_categorias on pnp_categorias.id=aislados.id_pnpcategoria
                                        
                where  1=1";

        if ($dni_beneficiario):
            $cad .= " and aislados.dni = '" . $dni_beneficiario . "'";        
        endif;

        if ($fechaDesde != "")
            $cad .= " and aislados.fecha_registro >= '" . $fechaDesde . "'";
        if ($fechaHasta != "")
            $cad .= " and aislados.fecha_registro <= '" . $fechaHasta . "'";
        if ($estado = 0)
            $cad .= " and aislados.estado = '" . $estado . "'";
        else            
            $cad .= " and aislados.estado>0 and aislados.estado<3 ";
        $cad .= " 
        order By aislados.fecha_registro desc";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    
    public function registrarPaciente($id_clasificacion, $id_establecimiento, $fecha_registro, $id_user, $dni,$name, $paterno, $materno, $cip="", $grado="", $sexo, $fecha_nacimiento,$edad, $telefono="",$unidad="",$situacion="",$id_categoria="",$peso="",$talla="",$parentesco,$etnia,$otra_raza="",$nacionalidad,$otra_nacion="",$migrante, $otro_migrante="",$domicilio="",$id_departamento,$id_provincia,$id_distrito,$fecha_sintoma,$fecha_aislamiento,$id_departamento2="",$id_provincia2="",$id_distrito2="",$contacto_directo="") {        
        //print_r(array($id_clasificacion, $id_establecimiento, $fecha_registro, $id_user, $dni,$name, $paterno, $materno, $cip, $grado, $sexo, $fecha_nacimiento, $telefono,$unidad,$id_categoria,$peso,$talla,$parentesco,$etnia,$otra_raza,$nacionalidad,$otra_nacion,$migrante, $otro_migrante,$domicilio,$id_departamento,$id_provincia,$id_distrito,$fecha_sintoma,$fecha_aislamiento,$id_departamento2,$id_provincia2,$id_distrito2,$contacto_directo));exit();
        $cad = "Select sp_insert_paciente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $data = DB::select($cad, array($id_clasificacion, $id_establecimiento, $fecha_registro, $id_user, $dni,$name, $paterno, $materno, $cip, $grado, $sexo, $fecha_nacimiento,$edad, $telefono,$unidad,$situacion,$id_categoria,$peso,$talla,$parentesco,$etnia,$otra_raza,$nacionalidad,$otra_nacion,$migrante, $otro_migrante,$domicilio,$id_departamento,$id_provincia,$id_distrito,$fecha_sintoma,$fecha_aislamiento,$id_departamento2,$id_provincia2,$id_distrito2,$contacto_directo));
        return $data[0]->sp_insert_paciente;
    }

    public function buscar_personal_aislado3($nro_doc) {    
        $tipodoc_beneficiario='1';
        $sw = false;
        $beneficiario = "";
        
        $client = new SoapClient("http://dev-wsdl.saludpol.gob.pe:8083/ws/WS_AfiliadoSP_Serv.php?wsdl", array('login' => 'D5p-R4v-@cci.ws.sp', 'password' => 'wS5p#cC1#D5p-'));

        $beneficiario = $client->getAseguradoValidate($tipodoc_beneficiario, $nro_doc);

        if (is_object($beneficiario)):
            $sw = true;
        endif;
        
        //$array["sw"] = $sw;
        //$array["beneficiario"] = $beneficiario;
        
        return  $beneficiario; 

        //echo json_encode($array);

    }

    

     public function ShowDataPacientesByEstablecimiento($fecha_inicio, $fecha_fin,  $id_establecimiento=0, $tipo_parentesco) {
        
        $cad = "select count(*) as contador 
                from aislados
                inner join fichas on fichas.id_aislado = aislados.id
                where aislados.estado=1 and fichas.estado=1 and  fichas.created_at >= '".$fecha_inicio."' and  fichas.created_at <= '".$fecha_fin."'  and aislados.parentesco = '".$tipo_parentesco."' ";
        
        if($id_establecimiento!=0){
            $cad.= " and aislados.establecimiento_id = ".$id_establecimiento ;
        }
        
        $data = DB::select($cad);
        
        if(count($data)>0):
            return $dato = $data[0]->contador;
        else:
            return $dato = 0; 
        endif;

        /*if(count($data[0]->contador)>0):
            $dato= 0;
        else:
            $dato = $data[0]->contador;
        endif;

        return $dato;
        */
    }  

    public function ShowDataPacientesBySexo($fecha_inicio, $fecha_fin, $id_establecimiento=0, $sexo) {
        $cad = "select count(*) as contador 
                from aislados
                inner join fichas on fichas.id_aislado = aislados.id
                where aislados.estado=1 and fichas.estado=1 and  fichas.created_at >= '".$fecha_inicio."' and  fichas.created_at <= '".$fecha_fin."'  and aislados.sexo = '".$sexo."' ";
        
        if($id_establecimiento!=0){
            $cad.= " and aislados.establecimiento_id = ".$id_establecimiento ;
        }
        
        

        $data = DB::select($cad);
        
        if(count($data)>0):
            //return $dato = $data[0]->contador;
            return $dato = $data;
        else:
            return $dato = 0; 
        endif;

        
    }

    public function ShowDataPacientesBySexoClasificacionPrueba($fecha_inicio, $fecha_fin, $id_establecimiento=0) {
        $cad = "select aislados.sexo, count(l.dni_paciente) as contador , l.tipo_prueba
                from aislados
                inner join fichas on fichas.id_aislado = aislados.id
                inner join antecedentes on antecedentes.idficha = fichas.id
                inner join users on antecedentes.id_user = users.id
                Inner Join establecimientos e on e.id = users.establecimiento_id
                inner join laboratorios l on l.idficha  = fichas.id 
                where users.estado=1 and antecedentes.estado=1 and l.estado=1 and (l.resultado_muestra = 1 or l.resultado_muestra = 3) and aislados.estado=1 and fichas.estado=1 and  l.created_at >= '".$fecha_inicio."' and  l.created_at <= '".$fecha_fin."'";
        
        if($id_establecimiento!=0){
            $cad.= " and users.establecimiento_id = ".$id_establecimiento ;
        }
        
        $cad.= " group by aislados.sexo, l.tipo_prueba ";
        //dd($cad);
        $data = DB::select($cad);
        
        if(count($data)>0):
            return $dato = $data;
        else:
            return $dato = 0; 
        endif;

    }

    public function ShowDataPacientesBySexoClasificacion($fecha_inicio, $fecha_fin, $id_establecimiento=0) {
        $cad = "select aislados.sexo, Count(Distinct aislados.dni) as contador 
                from aislados
                inner join fichas on fichas.id_aislado = aislados.id
                inner join antecedentes on antecedentes.idficha = fichas.id
                inner join users on antecedentes.id_user = users.id
                Inner Join establecimientos e on e.id = users.establecimiento_id 
                
                where antecedentes.estado=1 and antecedentes.id_clasificacion=1 and aislados.estado=1 and fichas.estado=1 and  fichas.created_at >= '".$fecha_inicio."' and  fichas.created_at <= '".$fecha_fin."'";
        
        if($id_establecimiento!=0){
            $cad.= " and users.establecimiento_id = ".$id_establecimiento ;
        }
        
        $cad.= " group by aislados.sexo ";        


        $data = DB::select($cad);
        
        if(count($data)>0):
            return $dato = $data;
        else:
            return $dato = 0; 
        endif;

    }

    public function ShowAisladosByDpto($fecha_inicio, $fecha_fin) {
        $datos = DB::table('aislados')
                ->join('departamentos', 'departamentos.id', '=', 'aislados.id_departamento')
                ->join('fichas','fichas.id_aislado','=','aislados.id')
                ->select('departamentos.id','departamentos.nombre_dpto', DB::raw('count(*) as saldo'))
                ->where('fichas.created_at', '>=', $fecha_inicio)
                ->where('fichas.created_at', '<=', $fecha_fin)
                ->groupBy('departamentos.id', 'departamentos.nombre_dpto')
                ->where('aislados.estado', '=', 1)
                ->orderBy('saldo', 'desc')
                ->where('fichas.estado', '=', 1)
                ->get();
        //var_dump($datos); exit;
        return $datos;
    }

    public function ShowDataPacientesInfectado($fecha_inicio, $fecha_fin, $id_establecimiento, $tipo_clasificacion) {
       /* $datos = DB::table('aislados')
                ->select(DB::raw('count(*) as contador'))
                ->join('fichas','fichas.id_aislado','=','aislados.id')
                //->where('aislados.establecimiento_id', '=', $id_establecimiento)                
                ->where('fichas.created_at', '>=', $fecha_inicio)
                ->where('fichas.created_at', '<=', $fecha_fin)
                ->where('aislados.clasificacion', '=', $tipo_clasificacion)
                ->where('aislados.estado', '=', 1)
                ->where('fichas.estado', '=', 1)
                ->get();

        return $datos;
        */
        $cad = "select count(*) as contador 
                from aislados
                inner join fichas on fichas.id_aislado = aislados.id
                where aislados.estado=1 and fichas.estado=1 and  fichas.created_at >= '".$fecha_inicio."' and  fichas.created_at <= '".$fecha_fin."'  and aislados.clasificacion = '".$tipo_clasificacion."' ";
        
        if($id_establecimiento!=0){
            $cad.= " and aislados.establecimiento_id = ".$id_establecimiento ;
        }
        
        

        $data = DB::select($cad);
        
        if(count($data)>0):
            //return $dato = $data[0]->contador;
            return $dato = $data;
        else:
            return $dato = 0; 
        endif;

    }

    function getFechaRestaMeses($mes) {

        $cad = "SELECT (CAST(now() AS DATE) - 6 - CAST('" . $mes . " month' AS INTERVAL) )::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    public function AllResumenAisladosByDepartamento( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consultation_aislados_departamentos('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    }
    
    public function AllResumenAisladosByDepartamentoConsolidado( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consultation_aislados_departamentos_consolidado('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    }

    public function AllResumenAisladosByIpressConsolidado( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consultation_aislados_ipress_consolidado('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    } 

    public function AllResumenHospitalizadosByDepartamentoTitularesActividad( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_titulares_actividad('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    }

    public function AllResumenHospitalizadosByDepartamentoTitularesActividadIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_titulares_actividad_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    }

    public function AllResumenHospitalizadosByDepartamentoTitularesRetiro( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_titulares_retiro('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    }
    public function AllResumenHospitalizadosByDepartamentoTitularesRetiroIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_titulares_retiro_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    }

    public function AllResumenHospitalizadosByDepartamentoFamiliares( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_familiares('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    } 

    public function AllResumenHospitalizadosByDepartamentoFamiliaresIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consulta_dptos_hospitalizacion_familiares_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    }


    public function AllResumenFallecidoByDepartamento( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consultation_fallecidos_departamentos('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    }  

    public function AllResumenFallecidoByDepartamentoIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consultation_fallecidos_departamentos_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    }   

    public function AllResumenCasosCovidByDepartamento( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_aislados_departamentos_casos_covid('" . $fechaDesde . "','" . $fechaHasta . "');");
       
        return $data;
    } 

    public function AllResumenCasosCovidByDepartamentoIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_aislados_departamentos_casos_covid_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
       
        return $data;
    }  

    public function AllResumenCasosPositivosCovid( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_casos_positivos_covid('" . $fechaDesde . "','" . $fechaHasta . "');");
       
        return $data;
    } 

    public function AllResumenCasosPositivosCovidIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_casos_positivos_covid_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
       
        return $data;
    }  

    public function AllAislamientosFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "") {

        $cad = "select a.id, f.created_at fecha_registro, f.fecha_notificacion, a.dni, a.nombres , a.paterno , a.materno, a.sexo, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado, d.nombre_dpto departamento, p.nombre_prov provincia, d2.nombre_dist distrito, a.clasificacion, f.id idficha 
            from aislados a
            inner join fichas f on a.id = f.id_aislado
            inner join antecedentes an on an.idficha = f.id
            inner join departamentos d on d.id = an.id_departamento2 
            inner join provincias p on p.id = an.id_provincia2 
            inner join distritos d2  on d2.id = an.id_distrito2
            where an.estado=1 and a.estado=1 and f.estado=1 and 1=1";

        if ($dni_beneficiario):
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        endif;

        $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and f.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and f.created_at <= '" . $fechaHasta.$fin."'";


/*        if ($fechaDesde != "")
            $cad .= " and a.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and a.fecha_registro <= '" . $fechaHasta . "'";        
*/
        if ($id_departamento != "")
            $cad .= " and d.id = '" . $id_departamento . "'";
        
        $cad .= " 
            group by a.id, f.created_at, f.fecha_notificacion, a.dni, a.nombres , a.paterno , a.materno, a.sexo, a.estado,d.nombre_dpto, p.nombre_prov, d2.nombre_dist, f.id
            order By a.id desc";

        $data = DB::select($cad);
        return $data;
    }

    public function TodosAislamientosFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "" ) {

        $cad = "select a.id,f.created_at fecha_reg_pac,f.fecha_notificacion, e.nombre establecimiento, d3.nombre_dpto dpto_establecimiento, a.dni, a.nombres, a.paterno, a.materno, a.cip, a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, pc.descripcion  categoria, a.talla, a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto departamento, p.nombre_prov  provincia, d2.nombre_dist  distrito,a.otra_ocupacion,a.clasificacion,an.fecha_registro fecha_reg_antecedente, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto departamento_antecedente , pr.nombre_prov provincia_antecedente, di.nombre_dist distrito_antecedente, an.gestante, date_part('year',age(to_date(to_char(a.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, a.estado,an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro fecha_reg_ho,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro fecha_evolucion, e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta alta_evolucion, e2.fecha_defuncion evolucion_defuncion,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion observacion_defuncion, h.otra_ubicacion, def.tipo_defuncion nota_certificado, def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at fecha_reg_lab,l.fecha_muestra, m.descripcion muestra, pru.descripcion prueba, res.descripcion res_muestra, l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia, an.id id_antecedente 
            from aislados a  
            inner join fichas f on f.id_aislado = a.id
            left join antecedentes an on an.idficha = f.id
            --inner join users u on u.id = a.id_user
            left join establecimientos e on e.id = an.id_establecimiento
            left join departamentos d3 on d3.id = e.departamento
            left join departamentos d on d.id = a.id_departamento
            left join provincias p on p.id = a.id_provincia
            left join distritos d2  on d2.id = a.id_distrito
            left join pnp_categorias pc on pc.id=a.id_categoria
            left join departamentos dep on dep.id = an.id_departamento2
            left join provincias pr on pr.id = an.id_provincia2
            left join distritos di on di.id = an.id_distrito2
            left join hospitalizados h on h.idficha = f.id and h.estado =1
            left join establecimiento_saluds es on es.id = h.establecimiento_proviene
            left join evolucions e2 on e2.idficha = f.id and e2.estado =1 and e2.id in (select max(id) from evolucions)
            left join defunciones def on def.aislado_id = a.id
            left join laboratorios l on l.idficha = f.id and l.estado =1
            left join muestras m on m.id = l.tipo_muestra
            left join pruebas pru on pru.id = l.tipo_prueba
            left join resultados res on res.id = l.resultado_muestra
            where  f.estado=1 and a.estado=1 "; 
            //and (l.resultado_muestra = 1 or l.resultado_muestra = 3 or l.resultado_muestra = 5 or l.resultado_muestra = 7 or l.resultado_muestra = 9)
            $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and f.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and f.created_at <= '" . $fechaHasta.$fin."'";        

        if ($id_departamento != 0)
            $cad .= " and d3.id = ".$id_departamento;        

        if ($dni_beneficiario != 0)
            $cad .= " and a.dni = '" . $dni_beneficiario . "'";        
        
        $cad .= " group by  a.id, f.created_at, f.fecha_notificacion, e.nombre, d3.nombre_dpto, a.dni, a.nombres, a.paterno, a.materno, a.cip, 
            a.grado, a.sexo, a.fecha_nacimiento , a.parentesco, a.unidad, a.situacion, a.hospitalizado, a.fallecido, pc.descripcion, a.talla, 
            a.peso, a.telefono, a.domicilio, a.referencia, d.nombre_dpto, p.nombre_prov, d2.nombre_dist,a.otra_ocupacion,a.clasificacion, 
            an.fecha_registro, an.fecha_sintoma, an.fecha_aislamiento, dep.nombre_dpto , pr.nombre_prov, di.nombre_dist, an.gestante,a.estado,
            an.fecha_vacunacion_1, an.fabricante_1, an.fecha_vacunacion_2 , an.fabricante_2, an.fecha_vacunacion_3, an.fabricante_3, an.sintoma_reinfeccion, 
            a.tipo_caso,an.fecha_sintoma_reinfeccion, an.observacion, h.fecha_registro,h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , 
            h.fecha_hospitalizacion, h.intubado, an.id_clasificacion,h.neumonia, h.ventilacion_mecanica, h.uci, h.fecha_ingreso_s2,h.fecha_alta_s2,h.fecha_ingreso_s3,
            h.fecha_alta_s3,h.fecha_ingreso_s4,h.fecha_alta_s4,h.fecha_ingreso_s5,h.fecha_alta_s5,h.fecha_ingreso_s6,h.fecha_alta_s6, h.fecha_alta_hospi,e2.fecha_registro, 
            e2.evolucion, e2.descripcion_evolucion, e2.fecha_alta , e2.fecha_defuncion ,  e2.tipo_defuncion , e2.hora_defuncion, e2.lugar_defuncion, e2.observacion , an.id, 
            h.otra_ubicacion, def.tipo_defuncion , def.nro_defuncion, def.fecha_defuncion , def.nombre_archivo,l.created_at,l.fecha_muestra, m.descripcion , pru.descripcion , 
            res.descripcion , l.fecha_resultado, l.enviado_minsa, l.linaje, l.sg, l.tomografia, l.radiografia";
        
        $cad .= " order By f.created_at desc";
        
        $data = DB::select($cad);
        return $data;
    }

    public function AllOcupacionesAislado($id_aislado) {
        $cad = "select a.dni, string_agg(o.descripcion,', ') ocupacion   
                from aislamiento_ocupacione ao
                inner join aislados a on a.id = ao.aislamiento_id 
                inner join ocupaciones o on o.id = ao.ocupacione_id
                where a.id = ".$id_aislado;
        $cad .= " group by a.dni ";
        $data = DB::select($cad);
        return $data;
    }

    public function AllAntecedentesAislado($id_antecedentes) {
        $cad = " select a2.id, string_agg(fr.descripcion ,', ') riesgo
from antecedente_factor_riesgo afr
inner join antecedentes a2 on a2.id = afr.antecedente_id 
inner join factor_riesgos fr on fr.id = afr.factor_riesgo_id 
where a2.id = ".$id_antecedentes;
        $cad .= " group by a2.id ";
        $data = DB::select($cad);
        return $data;
    }

    public function AllDiagnosticosHospitalizacion($id_paciente) {
        $cad = " select h.id_paciente, string_agg(d.codigo,', ') diagnostic
from diagnostico_hospitalizados dh
inner join hospitalizados h on h.id = dh.id_hospitalizado 
inner join diagnosticos d on d.id = dh.id_diagnostico
where h.id_paciente  = ".$id_paciente;
        $cad .= " group by h.id_paciente ";
        $data = DB::select($cad);
        return $data;
    }

    public function AllAntecedentesFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "",$id_provincia = "",$id_distrito = "" ) {

        $cad = "select a.dni, c.descripcion clasificacion, a.id_tipo_caso, a.fecha_sintoma, a.fecha_aislamiento, d.nombre_dpto departamento_antecedente, p.nombre_prov provincia_antecedente, d2.nombre_dist distrito_antecedente, a.gestante, 
                a.fecha_vacunacion_1, a.fabricante_1, a.fecha_vacunacion_2 , a.fabricante_2, a.fecha_vacunacion_3, a.fabricante_3, a.sintoma_reinfeccion,
                a.fecha_sintoma_reinfeccion, a.observacion  
                from antecedentes a 
                inner join aislados a2 on a.dni = a2.dni
                inner join clasificaciones c on c.id = a.id_clasificacion 
                inner join departamentos d on d.id = a.id_departamento2 
                inner join provincias p on p.id = a.id_provincia2  
                inner join distritos d2 on d2.id = a.id_distrito2
                where  a.estado=1";

        if ($fechaDesde != "")
            $cad .= " and a.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and a.fecha_registro <= '" . $fechaHasta . "'";        
        
        $cad .= " order By a2.fecha_registro desc";

        $data = DB::select($cad);
        return $data;
    }

    public function AllHospitalizadosFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "",$id_provincia = "",$id_distrito = "" ) {

        $cad = "select h.referido, es.nombre_establecimiento_salud , h.fecha_referencia , h.fecha_hospitalizacion, h.intubado, h.neumonia, h.ventilacion_mecanica, h.uci, fecha_alta_hospi  
            from hospitalizados h 
            inner join aislados a2 on h.dni_paciente = a2.dni
            inner join establecimiento_saluds es on es.id = h.establecimiento_proviene
                where  h.estado=1";

        if ($fechaDesde != "")
            $cad .= " and h.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and h.fecha_registro <= '" . $fechaHasta . "'";        
        
        $cad .= " order By h.fecha_registro desc";

        $data = DB::select($cad);
        return $data;
    }


    public function AllEvolucionesFechaDesdeHasta($fechaDesde = "", $fechaHasta = "", $dni_beneficiario = "", $id_departamento = "",$id_provincia = "",$id_distrito = "" ) {

        $cad = "select e.evolucion, e.descripcion_evolucion, e.fecha_alta, e.fecha_defuncion, e.tipo_defuncion, e.hora_defuncion, e.lugar_defuncion, e.observacion, 
                d.tipo_defuncion, d.nro_defuncion, d.fecha_defuncion, d.nombre_archivo  
                from evolucions e 
                inner join aislados a on e.dni = a.dni
                left join defunciones d on d.aislado_id = a.id
                where  e.estado=1";

        if ($fechaDesde != "")
            $cad .= " and e.fecha_registro >= '" . $fechaDesde . "'";
        
        if ($fechaHasta != "")
            $cad .= " and e.fecha_registro <= '" . $fechaHasta . "'";        
        
        $cad .= " order By e.fecha_registro desc";

        $data = DB::select($cad);
        return $data;
    }
    


    public function buscar_personal_aislado($nro_doc) {

        $beneficiario = new Aislamiento;
        
            $location_URL = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc';
            $wsdl = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

            $sw = false;$sw2 = false;
            $beneficiario_encontrado = "";

            $client = new SoapClient($wsdl, array(
                'location' => $location_URL,
                'uri'      => "",
                'trace'    => 1,            
                ));
            
            $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'VIGILANCIA EPIDEMIOLOGICA COVID-19', 'Operador'=>'31081306']);
           
            $json = json_encode($busca_datos);
            $beneficiario_encontrado = json_decode($json,TRUE);
            
            $ncont_titular=0;
            
            //titular
            if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                    $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
                }
                if($ncont_titular>1){    
                    $beneficiario->nrodocafiliado=$nro_doc;            
                    $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                    $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                    $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                    $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];                                
                    $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];


                    $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                    $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                    $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                    $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                    $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                    
                    $beneficiario->sw=true;
                    $sw = true;
                }
                else
                {   
                    foreach($beneficiario_encontrado as $beneficiario1){
                        $beneficiario->nrodocafiliado=$nro_doc;
                        $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                        $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                        $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                        $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                        $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];

                        $beneficiario->apepatafiliado=$beneficiario1['TitularFamiliar']['PATERNO'];
                        $beneficiario->apematafiliado=$beneficiario1['TitularFamiliar']['MATERNO'];
                        $beneficiario->nomafiliado=$beneficiario1['TitularFamiliar']['NOMBRES'];
                        $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                        $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                        $beneficiario->sw=true;
                        $sw = true;
                    }
                }
            }

            //familiar
            if($sw==false){

                $busca_datos_familiar = $client->BuscarTitularFamiliar(['TipoBusqueda' => 3,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'VIGILANCIA EPIDEMIOLOGICA COVID-19', 'Operador'=>'31081306']);
           
                $json_familiar = json_encode($busca_datos_familiar);
                $beneficiario_encontrado = json_decode($json_familiar,TRUE);
                $ncont_titular=0;
                
                if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                    if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                        $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
                    }
                    if($ncont_titular>1){                
                        $beneficiario->nrodocafiliado=$nro_doc;
                        $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                        $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                        $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                        $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                        $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';

                        $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                        $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                        $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                        $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];
                        $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                        //////////////////////////////////////
                        $originalDate = $beneficiario->fecnacafiliado;
                        $fech_nac = explode("/", $originalDate);                            
                        $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];
                        $dbDate = Carbon::parse($nacimiento);
                        $diffYears = Carbon::now()->diffInYears($dbDate);
                        
                        $beneficiario->edadafiliado=$diffYears;
                        $beneficiario->sw=true;
                        $sw=true;
                        if($diffYears<18):
                            $sw2 = true;
                        endif;
                    }
                    else
                    {   
                        foreach($beneficiario_encontrado as $beneficiario1){
                            $beneficiario->nrodocafiliado=$nro_doc;
                            $beneficiario->apepatafiliado=utf8_encode($beneficiario1['TitularFamiliar']['PATERNO']);
                            $beneficiario->apematafiliado=utf8_encode($beneficiario1['TitularFamiliar']['MATERNO']);
                            $beneficiario->nomafiliado=utf8_encode($beneficiario1['TitularFamiliar']['NOMBRES']);

                            $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                            $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                            if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                            $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                            $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                            $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                            $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                            $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                            
                            /////////////////////////////////////////
                            $originalDate = $beneficiario->fecnacafiliado;
                            $fech_nac = explode("/", $originalDate);                            
                            $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];
                            $dbDate = Carbon::parse($nacimiento);
                            $diffYears = Carbon::now()->diffInYears($dbDate);
                            
                            $beneficiario->edadafiliado=$diffYears;
                            $beneficiario->sw=true;
                            $sw=true;
                            if($diffYears<18):
                                $sw2 = true;
                            endif;
                            
                        }
                    }
                }
            }
                
            $soapClient = new SoapClient('http://192.168.10.44:7001/ServicioReniecImpl/ServicioReniecImplService?WSDL', array('trace'=>1,"encoding"=>"ISO-8859-1"));
            $sw1=false;$sw3=false;
            $parametros = array("clienteUsuario"=>"DIRSAPOL", 
              "clienteClave"=>"WUK9XPhx", 
              "servicioCodigo"=>"WS_RENIEC_MAY_MEN", 
              "clienteSistema"=>"SOAP_DESARROLLO", 
              "clienteIp"=>"172.31.2.249",
              "clienteMac"=>"AA:BB:CC:DD:EE:FF",
              "dniAutorizado"=>"07022086",
              "tipoDocUserClieFin"=>"1",
              "nroDocUserClieFin"=>"391402",
              "inDni"=>$nro_doc,
              "inPioridad"=>"priority"
            );

            $respuesta = $soapClient->consultarDniMayor($parametros);

            switch ($respuesta->resultadoDniMayor->codigoMensaje) {
              case 'MR':
                $datos_rinec = array(
                  "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
                  "descripcionMensaje" => "No se encontraron datos en RENIEC relacionados al número del documento"
                  
                );
                $sw3=true;
                //return json_encode($datos_rinec, TRUE);
                break;
              
              case '17':
                $datos_rinec = array(
                  "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
                  "descripcionMensaje" => "Surgieron problemas al conectarse al servidor RENIEC, intente de nuevo"
                  
                );
                $sw3=true;
                //return json_encode($datos_rinec, TRUE);
                break;
            }

            
            if($sw2==true){ //menor de edad encontrado en dirrehum
                $beneficiario->nompaisdelafiliado='PER';
                $beneficiario->nomtipdocafiliado='DNI';
                $beneficiario->nrodocafiliado=$nro_doc;
                $beneficiario->apecasafiliado='';
                $beneficiario->nombre_dpto='';
                $beneficiario->nombre_prov='';
                $beneficiario->emision='';
                $beneficiario->nombre_dist='';
                $beneficiario->domicilio='';
                $beneficiario->estatura='';
                $beneficiario->fechaExpedicion='';
                $beneficiario->foto='';
                $beneficiario->estado=0;
                $beneficiario->otroseguro='';
                $beneficiario->sw=true;
            }
            else{

                if($sw3==false){ //encontro reniec 
                    $beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$nro_doc;
                    $beneficiario->apepatafiliado=utf8_encode($respuesta->resultadoDniMayor->paterno);
                    $beneficiario->apematafiliado=utf8_encode($respuesta->resultadoDniMayor->materno);
                    $beneficiario->nomafiliado=utf8_encode($respuesta->resultadoDniMayor->nombres);
                    $beneficiario->apecasafiliado='';
                    $beneficiario->fecnacafiliado=utf8_encode($respuesta->resultadoDniMayor->fechaNacimiento);
                    $originalDate = $beneficiario->fecnacafiliado;
                    $nacimiento=$originalDate[8].$originalDate[9].'-'.$originalDate[5].$originalDate[6].'-'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
                    $fecha_nacimiento=$originalDate[8].$originalDate[9].'/'.$originalDate[5].$originalDate[6].'/'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
                    $beneficiario->fecnacafiliado=$fecha_nacimiento;
                    $dbDate = Carbon::parse($nacimiento);
                    $diffYears = Carbon::now()->diffInYears($originalDate);
                    $beneficiario->edadafiliado=$diffYears;
                    $dia=$originalDate[8].$originalDate[9];
                    $mes=$originalDate[5].$originalDate[6];
                    $ano=$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];
                    $Born = Carbon::create($ano,$mes,$dia);
                    $age = $Born->diff(Carbon::now())->format('%y Años, %m meses %d dias');
                    $beneficiario->age=$age;
                    $beneficiario->nomsexo=utf8_encode($respuesta->resultadoDniMayor->sexo);
                        if($beneficiario->nomsexo=='FEMENINO')
                            $beneficiario->nomsexo='F';
                        else
                            $beneficiario->nomsexo='M';
                    //$foto = base64_encode($respuesta->resultadoDniMayor->foto);
                    $foto = '';
                    $beneficiario->nombre_dpto=utf8_encode($respuesta->resultadoDniMayor->departamentoDomicilio);
                    $beneficiario->nombre_prov=utf8_encode($respuesta->resultadoDniMayor->provinciaDomicilio);
                    $beneficiario->emision=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                    $beneficiario->nombre_dist=utf8_encode($respuesta->resultadoDniMayor->distritoDomicilio);
                    $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMayor->direccionDomicilio);
                    $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMayor->estatura);
                    $beneficiario->fechaExpedicion=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                    
                    $beneficiario->foto='';
                    $beneficiario->estado=0;
                    $beneficiario->sw=true;

                    if($sw!=true){ //encontro pnp
                        $beneficiario->estado='';
                        $beneficiario->parentesco='';
                        $beneficiario->cip='';
                        $beneficiario->grado='';
                        $beneficiario->situacion='';
                        $beneficiario->unidad='';
                        $beneficiario->otroseguro='';
                        $sw = true;
                    } 
                }
                else
                {
                    if($sw!=true){
                        
                        $beneficiario->nompaisdelafiliado='PER';
                        $beneficiario->nomtipdocafiliado='DNI';
                        $beneficiario->nrodocafiliado=$nro_doc;
                        $beneficiario->apepatafiliado='';
                        $beneficiario->apematafiliado='';
                        $beneficiario->apecasafiliado='';
                        $beneficiario->nomafiliado='';
                        $beneficiario->fecnacafiliado='';
                        $beneficiario->fecnacafiliado='';
                        $beneficiario->edadafiliado='';
                        $beneficiario->age='';
                        $beneficiario->nomsexo='';
                        $foto = '';
                        $beneficiario->estado='';
                        $beneficiario->parentesco='';
                        $beneficiario->nomtipdoctitular='';
                        $beneficiario->nrodoctitular='';
                        $beneficiario->apepattitular='';
                        $beneficiario->apemattitular='';
                        $beneficiario->apecastitular='';
                        $beneficiario->nomtitular='';
                        $beneficiario->cip='';
                        $beneficiario->grado='';
                        $beneficiario->situacion='';
                        $beneficiario->unidad='';
                        $beneficiario->caducidad='';
                        $beneficiario->discapacidad=0;
                        $beneficiario->otroseguro='';
                        $beneficiario->nombre_dpto='';
                        $beneficiario->nombre_prov='';
                        $beneficiario->emision='';
                        $beneficiario->nombre_dist='';
                        $beneficiario->domicilio='';
                        $beneficiario->estatura='';
                        $beneficiario->foto='';
                        $beneficiario->est=0;
                        $beneficiario->fechaExpedicion='';
                        //$beneficiario->sw=true;
                        $beneficiario->sw=false;
                        $sw = true;
                        }
                }
            }
    
    $array["sw"] = $sw;
    $array["sw1"] = $sw1;
    $array["beneficiario"] = $beneficiario;
    
    return $beneficiario;
    //echo json_encode($array);

    } 
    
    public function buscar_personal_aislado_dirrehum($nro_doc) {

        $beneficiario = new Aislamiento;
        
            $location_URL = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc';
            $wsdl = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

            $sw = false;$sw2 = false;
            $beneficiario_encontrado = "";

            $client = new SoapClient($wsdl, array(
                'location' => $location_URL,
                'uri'      => "",
                'trace'    => 1,            
                ));

            $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'VIGILANCIA EPIDEMIOLOGICA COVID-19', 'Operador'=>'31081306']);
           
            $json = json_encode($busca_datos);
            $beneficiario_encontrado = json_decode($json,TRUE);
            
            $ncont_titular=0;
            
            //titular
            if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                    $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
                }
                if($ncont_titular>1){                
                    $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                    $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                    $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                    $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];                                
                    $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                    $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                    $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                    $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                    $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                    $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                    $beneficiario->nrodocafiliado=$nro_doc;
                    
                    $beneficiario->sw=true;
                    $sw = true;
                    $sw2 = true;
                }
                else
                {   
                    foreach($beneficiario_encontrado as $beneficiario1){
                        
                        $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                        $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                        $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                        $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                        $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];

                        $beneficiario->apepatafiliado=$beneficiario1['TitularFamiliar']['PATERNO'];
                        $beneficiario->apematafiliado=$beneficiario1['TitularFamiliar']['MATERNO'];
                        $beneficiario->nomafiliado=$beneficiario1['TitularFamiliar']['NOMBRES'];
                        $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                        $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                        $beneficiario->nrodocafiliado=$nro_doc;
                    
                        $beneficiario->sw=true;
                        $sw = true;
                        $sw2 = true;
                            
                            
                    }
                }
            }

            //familiar
            if($sw==false){

                $busca_datos_familiar = $client->BuscarTitularFamiliar(['TipoBusqueda' => 3,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'VIGILANCIA EPIDEMIOLOGICA COVID-19', 'Operador'=>'31081306']);
           
                $json_familiar = json_encode($busca_datos_familiar);
                $beneficiario_encontrado = json_decode($json_familiar,TRUE);
                $ncont_titular=0;
                
                if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                    if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                        $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
                    }
                    if($ncont_titular>1){                
                        $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                        $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                        $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                        $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                        $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';

                        $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                        $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                        $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                        $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];
                        $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                        $beneficiario->nrodocafiliado=$nro_doc;
                    
                        //////////////////////////////////////
                        $originalDate = $beneficiario->fecnacafiliado;
                        $fech_nac = explode("/", $originalDate);                            
                        $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];
                        $dbDate = Carbon::parse($nacimiento);
                        $diffYears = Carbon::now()->diffInYears($dbDate);
                        $beneficiario->edadafiliado=$diffYears;
                        $beneficiario->sw=true;
                        
                        $sw2 = true;
                        
                    }
                    else
                    {   
                        foreach($beneficiario_encontrado as $beneficiario1){
                            $beneficiario->apepatafiliado=utf8_encode($beneficiario1['TitularFamiliar']['PATERNO']);
                            $beneficiario->apematafiliado=utf8_encode($beneficiario1['TitularFamiliar']['MATERNO']);
                            $beneficiario->nomafiliado=utf8_encode($beneficiario1['TitularFamiliar']['NOMBRES']);

                            $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                            $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                            if($beneficiario->nomsexo=='FEMENINO')
                                $beneficiario->nomsexo='F';
                            else
                                $beneficiario->nomsexo='M';
                            $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                            $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                            $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                            $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                            $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                            $beneficiario->nrodocafiliado=$nro_doc;
                    
                            
                            /////////////////////////////////////////
                            $originalDate = $beneficiario->fecnacafiliado;
                            $fech_nac = explode("/", $originalDate);                            
                            $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];
                            $dbDate = Carbon::parse($nacimiento);
                            $diffYears = Carbon::now()->diffInYears($dbDate);
                            
                            $beneficiario->edadafiliado=$diffYears;
                            $beneficiario->sw=true;
                            $sw2 = true;
                        }
                    }
                }
            }
                
            
            

            

            if($sw2==true  || $sw==false ){ //menor de edad encontrado en dirrehum
                $beneficiario->nompaisdelafiliado='PER';
                $beneficiario->nomtipdocafiliado='DNI';
                $beneficiario->nrodocafiliado=$nro_doc;
                $beneficiario->apecasafiliado='';
                $beneficiario->nombre_dpto='';
                $beneficiario->nombre_prov='';
                $beneficiario->emision='';
                $beneficiario->nombre_dist='';
                $beneficiario->domicilio='';
                $beneficiario->estatura='';
                $beneficiario->fechaExpedicion='';
                $beneficiario->foto='';
                $beneficiario->estado=0;
                $beneficiario->otroseguro='';
                $beneficiario->sw=false;
            }
            /*
            else{

                if($sw1==false){ //encontro reniec 
                    $beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$nro_doc;
                    $beneficiario->apepatafiliado=utf8_encode($respuesta->resultadoDniMayor->paterno);
                    $beneficiario->apematafiliado=utf8_encode($respuesta->resultadoDniMayor->materno);
                    $beneficiario->nomafiliado=utf8_encode($respuesta->resultadoDniMayor->nombres);
                    $beneficiario->apecasafiliado='';
                    $beneficiario->fecnacafiliado=utf8_encode($respuesta->resultadoDniMayor->fechaNacimiento);
                    $originalDate = $beneficiario->fecnacafiliado;
                    $nacimiento=$originalDate[8].$originalDate[9].'-'.$originalDate[5].$originalDate[6].'-'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
                    $fecha_nacimiento=$originalDate[8].$originalDate[9].'/'.$originalDate[5].$originalDate[6].'/'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
                    $beneficiario->fecnacafiliado=$fecha_nacimiento;
                    $dbDate = Carbon::parse($nacimiento);
                    $diffYears = Carbon::now()->diffInYears($originalDate);
                    $beneficiario->edadafiliado=$diffYears;
                    $dia=$originalDate[8].$originalDate[9];
                    $mes=$originalDate[5].$originalDate[6];
                    $ano=$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];
                    $Born = Carbon::create($ano,$mes,$dia);
                    $age = $Born->diff(Carbon::now())->format('%y Años, %m meses %d dias');
                    $beneficiario->age=$age;
                    $beneficiario->nomsexo=utf8_encode($respuesta->resultadoDniMayor->sexo);
                        if($beneficiario->nomsexo=='FEMENINO')
                            $beneficiario->nomsexo='F';
                        else
                            $beneficiario->nomsexo='M';
                    //$foto = base64_encode($respuesta->resultadoDniMayor->foto);
                    $foto = '';
                    $beneficiario->nombre_dpto=utf8_encode($respuesta->resultadoDniMayor->departamentoDomicilio);
                    $beneficiario->nombre_prov=utf8_encode($respuesta->resultadoDniMayor->provinciaDomicilio);
                    $beneficiario->emision=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                    $beneficiario->nombre_dist=utf8_encode($respuesta->resultadoDniMayor->distritoDomicilio);
                    $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMayor->direccionDomicilio);
                    $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMayor->estatura);
                    $beneficiario->fechaExpedicion=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                    
                    $beneficiario->foto='';
                    $beneficiario->estado=0;
                    $beneficiario->sw=true;

                    if($sw!=true){ //encontro pnp
                        $beneficiario->estado='';
                        $beneficiario->parentesco='';
                        $beneficiario->cip='';
                        $beneficiario->grado='';
                        $beneficiario->situacion='';
                        $beneficiario->unidad='';
                        $beneficiario->otroseguro='';
                        $sw = true;
                    } 
                }
                else
                {
                    
                    $beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$nro_doc;
                    $beneficiario->apepatafiliado='';
                    $beneficiario->apematafiliado='';
                    $beneficiario->apecasafiliado='';
                    $beneficiario->nomafiliado='';
                    $beneficiario->fecnacafiliado='';
                    $beneficiario->fecnacafiliado='';
                    $beneficiario->edadafiliado='';
                    $beneficiario->age='';
                    $beneficiario->nomsexo='';
                    $foto = '';
                    $beneficiario->estado='';
                    $beneficiario->parentesco='';
                    $beneficiario->nomtipdoctitular='';
                    $beneficiario->nrodoctitular='';
                    $beneficiario->apepattitular='';
                    $beneficiario->apemattitular='';
                    $beneficiario->apecastitular='';
                    $beneficiario->nomtitular='';
                    $beneficiario->cip='';
                    $beneficiario->grado='';
                    $beneficiario->situacion='';
                    $beneficiario->unidad='';
                    $beneficiario->caducidad='';
                    $beneficiario->discapacidad=0;
                    $beneficiario->otroseguro='';
                    $beneficiario->nombre_dpto='';
                    $beneficiario->nombre_prov='';
                    $beneficiario->emision='';
                    $beneficiario->nombre_dist='';
                    $beneficiario->domicilio='';
                    $beneficiario->estatura='';
                    $beneficiario->foto='';
                    $beneficiario->est=0;
                    $beneficiario->fechaExpedicion='';
                    //$beneficiario->sw=true;
                    $beneficiario->sw=false;
                    $sw = true;
                } 
            } */
    
    //$array["sw"] = $sw;
    //$array["sw1"] = $sw1;
    //$array["beneficiario"] = $beneficiario;
    return $beneficiario;
    //echo json_encode($array);

    } 

    public function AllResumenHospitalizadosByDepartamento( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_consultation_hospitalizados_departamentos_consolidado('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    } 

    public function AllResumenHospitalizadosByDepartamentoIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_consultation_hospitalizados_departamentos_consolidado_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento. ");");
        
        return $data;
    }   


    public function AllResumenAisladosPruebasCovidByDepartamento( $fechaDesde = "", $fechaHasta = "") {
        $data = DB::select("select * From sp_pruebas_covid('" . $fechaDesde . "','" . $fechaHasta . "');");
        
        return $data;
    } 

    public function AllResumenAisladosPruebasCovidByIpress( $fechaDesde = "", $fechaHasta = "", $id_establecimiento) {
        $data = DB::select("select * From sp_pruebas_covid_ipress('" . $fechaDesde . "','" . $fechaHasta . "'," . $id_establecimiento . ");");
        
        return $data;
    } 

    public function AllFichasAbiertas($fechaDesde,$fechaHasta, $establecimiento_id) {

        $cad = "select aislados.id, aislados.fecha_registro, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo,  aislados.edad, aislados.estado, aislados.nombre_dpto departamento, aislados.nombre_prov provincia, aislados.nombre_dist distrito, aislados.clasificacion , fichas.fecha_notificacion
            from aislados
            inner join fichas on fichas.id_aislado = aislados.id 
            inner join antecedentes on fichas.id = antecedentes.idficha
            left join establecimientos on establecimientos.id = antecedentes.id_establecimiento 
            left join users on fichas.id_user  =  users.id
                where  fichas.estado = 1 and aislados.estado =1 and fichas.activo =1 and users.establecimiento_id = " . $establecimiento_id ;

            $inicio = ':00:00';
            $fin=':23:59';
        if ($fechaDesde != "")
            $cad .= " and fichas.created_at >= '" . $fechaDesde.$inicio."'";
        
        if ($fechaHasta != "")
            $cad .= " and fichas.created_at <= '" . $fechaHasta.$fin."'";

        $cad .= " 
            group by aislados.id, aislados.fecha_registro, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado, fichas.fecha_notificacion

            order By aislados.id desc";
            
        $data = DB::select($cad);
        return $data;
    }

    public function AllFichasAbiertasR( $establecimiento_id = "") {

        $cad = "select aislados.id, fichas.created_at fecha_registro, fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo,date_part('year',age(to_date(to_char(aislados.fecha_nacimiento::date,'DD/MM/YYYY'),'DD/MM/YYYY'))) edad, aislados.estado, aislados.hospitalizado, aislados.fallecido, aislados.clasificacion , users.nombres as name, users.apellido_paterno, users.apellido_materno
            from aislados
            inner join fichas on fichas.id_aislado = aislados.id
            inner join antecedentes on fichas.id = antecedentes.idficha
            inner join establecimientos on establecimientos.id = antecedentes.id_establecimiento 
            inner join users on fichas.id_user  =  users.id
                where fichas.estado = 1 and aislados.estado =1 and fichas.activo =1 and users.establecimiento_id = " . $establecimiento_id ;

        $cad .= " 
            group by aislados.id, fichas.created_at,fichas.fecha_notificacion, aislados.dni, aislados.nombres , aislados.paterno , aislados.materno, aislados.sexo, aislados.edad, aislados.estado, users.nombres, users.apellido_paterno, users.apellido_materno

            order By aislados.id desc";
        
        
        $data = DB::select($cad);
        return $data;
    }

}
