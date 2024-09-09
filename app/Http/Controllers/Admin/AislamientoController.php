<?php
namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Aislamiento;
use App\Models\Solucione;
use App\Models\Distrito;
use App\Models\User;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Establecimiento;
use App\Models\EstablecimientoSalud;
use App\Repositories\AislamientoRepository;
use App\Http\Requests\CreateAislamientoRequest;
use App\Models\PnpCategoria;
use App\Models\Sino;
use App\Models\Sintoma;
use App\Models\Laboratorio;
use App\Models\Signo;
use App\Models\FactorRiesgo;
use App\Models\InformeRiesgo;
use App\Models\Ocupacione;
use App\Models\Lugare;
use App\Models\Hospitalizacion;
use App\Models\Diagnostico;
use App\Models\Antecedente;
use App\Models\Contacto;
use App\Models\Evolucion;
use App\Models\Esavi;
use App\Models\EnfermedadRegione;
use App\Models\CuadroPatologico;
use App\Models\Muestra;
use App\Models\Prueba;
use App\Models\Resultado;
use App\Models\Fabricante;
use App\Models\Data;
use App\Models\Ficha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SoapClient;
use Maatwebsite\Excel\Facades\Excel;


use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AislamientoController extends AppBaseController
{
    /** @var  EstablecimientosRepository */
    private $aislamientoRepository;

    public function __construct(AislamientoRepository $aislamientoRepo)
    {
        $this->aislamientoRepository = $aislamientoRepo;
    }

    public function index(Request $request)
    {
    }

    public function buscar_paciente()
    {
       return view('admin.aislamientos.buscar');
    }

    public function buscando(Request $request)
    {
       
        $paciente = Aislamiento::Where('dni',$request->dni)->where('estado',1)->first();
       //cuando hay registro de paciente
       if(is_object($paciente)){
            return redirect('/listar_fichas/'. $paciente->id.'/'.$paciente->dni);

       }else{ 
            //cuando es nuevo
            $aislados = new Aislamiento;
            $pacientes =  array();
            $pacientes=$aislados->buscar_personal_aislado($request->dni);
            //$pacientes=$aislados->buscar_personal_aislado_dirrehum($request->dni);
            
            if($pacientes->sw!=false){
                $date = Carbon::now();
                $model_categorias= new PnpCategoria();
                $pnpcategorias = $model_categorias->getPnpCategoria();
                $model_departamentos= new Departamento();
                $departamentos = $model_departamentos->getDepartamento();
                $model_provincias= new Provincia();
                $model_distritos= new Distrito();
                $fechaServidor = $fechaHasta = $date->format('d-m-Y');
                $model_establecimientos= new Establecimiento();
                $establecimientos = $model_establecimientos->getTodosEstablecimientos();
                $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
                
                return view('admin.aislamientos.nuevo_paciente')->with('paciente', $pacientes)->with('fechaServidor', $fechaServidor)->with('pnpcategorias', $pnpcategorias)->with('departamentos', $departamentos)->with('establecimientos', $establecimientos)->with('ocupaciones', $ocupaciones)->with('aislados', $aislados);
            }
            else
            {
                $date = Carbon::now();
                $model_categorias= new PnpCategoria();
                $pnpcategorias = $model_categorias->getPnpCategoria();
                $model_departamentos= new Departamento();
                $departamentos = $model_departamentos->getDepartamento();
                $model_provincias= new Provincia();
                $model_distritos= new Distrito();
                $fechaServidor = $fechaHasta = $date->format('d-m-Y');
                $model_establecimientos= new Establecimiento();
                $establecimientos = $model_establecimientos->getTodosEstablecimientos();
                $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
                return view('admin.aislamientos.nuevo_paciente_2')->with('paciente', $pacientes)->with('fechaServidor', $fechaServidor)->with('pnpcategorias', $pnpcategorias)->with('departamentos', $departamentos)->with('establecimientos', $establecimientos)->with('ocupaciones', $ocupaciones)->with('aislados', $aislados);
            }
       }  
    }
    
    public function store(Request $request)
    {   
        //dd($request);

        $aislamiento = new Aislamiento;
        $date = Carbon::now();
        $nombres = trim($request->name);
        $apellido_paterno = trim($request->paterno);
        $apellido_materno = trim($request->materno);
        $aislamiento->fecha_registro= $request->fecha_registro;
        $aislamiento->id_user=Auth::user()->id;
        $aislamiento->dni=$request->dni;
        $aislamiento->nombres=$nombres;
        $aislamiento->paterno=$apellido_paterno;
        $aislamiento->materno=$apellido_materno;
        $aislamiento->cip=$request->cip;
        $aislamiento->grado=$request->grado;
        $aislamiento->sexo=$request->sexo;
        $aislamiento->fecha_nacimiento=$request->fecha_nacimiento;
        $aislamiento->edad=$request->edad;
        $aislamiento->telefono=$request->telefono;
        $aislamiento->unidad=$request->unidad;
        $aislamiento->situacion=$request->situacion;
        $aislamiento->id_categoria=$request->id_categoria;
        $aislamiento->peso=$request->peso;
        $aislamiento->talla=$request->talla;
        if($request->parentesco==""):
            $aislamiento->parentesco='SR';
        else:
            $aislamiento->parentesco=$request->parentesco;
        endif;
        if($request->menor!=""):
            $aislamiento->menor=$request->menor;
            if($request->menor=="SI"):
                $aislamiento->tutor=$request->tutor;
                if($request->sexo=="F"):
                    $aislamiento->parentesco='HIJA';
                else:
                    $aislamiento->parentesco='HIJO';
                endif;

            endif;
        endif;
        $aislamiento->etnia=$request->etnia;
        $aislamiento->otra_raza=$request->otra_raza;
        $aislamiento->nacionalidad=$request->nacionalidad;
        $aislamiento->otra_nacion=$request->otra_nacion;
        $aislamiento->migrante=$request->migrante;
        $aislamiento->otro_migrante=$request->otro_migrante;
        $aislamiento->domicilio=$request->domicilio;
        $aislamiento->id_departamento=$request->id_departamento;
        $aislamiento->id_provincia=$request->id_provincia;
        $aislamiento->id_distrito=$request->id_distrito;
        $aislamiento->otra_ocupacion=$request->otra_ocupacion;
        $aislamiento->referencia=$request->referencia;
        $aislamiento->age=$request->age;
        $aislamiento->tipo_localidad=$request->tipo_localidad;
        $aislamiento->establecimiento_id=$request->id_establecimiento;
        $aislamiento->save();        
        $idaislamiento = $aislamiento->id; 
        $aislamiento->ocupacioneaislados()->attach($request->ocupaciones);

        
        /*$ficha = new Ficha;
        $ficha->dni=$idaislamiento;
        $ficha->id_aislado=$request->dni;
        $ficha->id_user=Auth::user()->id;
        $ficha->estado=1;
        $ficha->activo=1;
        $ficha->save();
        */
        Flash::success('Se ha registrado correctamente.');
        return redirect('/registro_antecedentes_epidemiologicos/'. $idaislamiento.'/'.$request->dni);
    }

    public function editar_paciente($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_departamentos= new Departamento();
        $model_provincias= new Provincia();
        $model_distritos= new Distrito();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        $aislamientos = new Aislamiento();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        

        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->Where('estado',1)->first();

        if(!empty($paciente)):
            $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
            $provincias = $model_provincias->getProvincia($paciente->id_departamento);
            $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
            $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
            
            $foto = '';
            return view('admin.aislamientos.editar_paciente')->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('dni', $dni)->with('id', $id)->with('foto',$foto)->with('establecimientos', $establecimientos)->with('ocupaciones', $ocupaciones);
        else:
            Flash::error('Paciente no encontrado');
            return redirect('/todos_registros/');
        endif;


    }
   
   public function update_datospaciente($id,Request  $request)
    {
        $aislamiento = Aislamiento::where('id', $id)->Where('dni',$request->dni)->first();
        $date = Carbon::now();

        $fecha_registro = $date->format('d-m-Y');
        $nombres = trim($request->name);
        $apellido_paterno = trim($request->paterno);
        $apellido_materno = trim($request->materno);        
        $aislamiento->id_user=Auth::user()->id;
        $aislamiento->dni=$request->dni;
        $aislamiento->nombres=$nombres;
        $aislamiento->paterno=$apellido_paterno;
        $aislamiento->materno=$apellido_materno;
        $aislamiento->cip=$request->cip;
        $aislamiento->grado=$request->grado;
        $aislamiento->sexo=$request->sexo;
        $aislamiento->fecha_nacimiento=$request->fecha_nacimiento;
        $aislamiento->edad=$request->edad;
        $aislamiento->telefono=$request->telefono;
        $aislamiento->unidad=$request->unidad;
        $aislamiento->situacion=$request->situacion;
        $aislamiento->id_categoria=$request->id_categoria;
        $aislamiento->peso=$request->peso;
        $aislamiento->talla=$request->talla;
        $aislamiento->parentesco=$request->parentesco;
        $aislamiento->etnia=$request->etnia;
        $aislamiento->otra_raza=$request->otra_raza;
        $aislamiento->otra_ocupacion=$request->otra_ocupacion;
        $aislamiento->nacionalidad=$request->nacionalidad;
        $aislamiento->otra_nacion=$request->otra_nacion;
        $aislamiento->migrante=$request->migrante;
        $aislamiento->otro_migrante=$request->otro_migrante;
        $aislamiento->domicilio=$request->domicilio;
        $aislamiento->id_departamento=$request->id_departamento;
        $aislamiento->id_provincia=$request->id_provincia;
        $aislamiento->id_distrito=$request->id_distrito;
        $aislamiento->referencia=$request->referencia;
        $aislamiento->age=$request->age;
        $aislamiento->age=$request->menor;
        $aislamiento->age=$request->tutor;
        $aislamiento->tipo_localidad=$request->tipo_localidad;
        $aislamiento->save();        
        $opcion=$request->opcion;
        
        $num_items=DB::table('aislamiento_ocupacione')->where('aislamiento_id',$request->id)->count();
        if (empty($request->ocupaciones)) {
           if($num_items>0){
                $elimina_bd=DB::table('aislamiento_ocupacione')->where('hospitalizacion_id',$request->id)->delete();
           }
        }else
        {
            //si esta vacio llenamos
            if($num_items==0){
                $aislamiento->ocupacioneaislados()->attach($request->ocupaciones); 
            }
            else
            {
                $datos_bd=DB::table('aislamiento_ocupacione')->where('aislamiento_id',$request->id)->get();
                //checkbox desmarcados
                $datos_desmarcado=$datos_bd->pluck('ocupacione_id')->diff($request->ocupaciones);
                $num_datos_desmarcado=count($datos_bd->pluck('ocupacione_id')->diff($request->ocupaciones));

                //convertimos a arreglo
                $arreglo = $datos_bd->pluck('ocupacione_id')->toArray();

                //los nuevos checkbox
                $num_datos_nuevos=count(array_diff($request->ocupaciones,$arreglo));
                $datos_nuevos=array_diff($request->ocupaciones,$arreglo);

                ///Insertamos los nuevos           
                if($num_datos_nuevos>0){
                    //$aislamiento->petitorios()->attach($medicamentos_nuevos); //attach 
                    $aislamiento->ocupacioneaislados()->attach($datos_nuevos); //attach  
                }
                ///eliminamos los que no estan en los checkbox
                if($num_datos_desmarcado>0){
                    $aislamiento->ocupacioneaislados()->detach($datos_desmarcado); //attach           
                }
            }
        }        
        Flash::success('Se ha actualizado correctamente.');
        return redirect('/editar_paciente/'. $id.'/'.$request->dni);
    }

    public function listar_antecedentes_epidemiologicos($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_antecedentes = new Antecedente();
        $antecedentes = $model_antecedentes->getAntecedentes($id,$dni);
        
        

        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $foto='';
        return view('admin.aislamientos.listar_antecedentes_epidemiologicos')->with('paciente', $paciente)->with('antecedentes', $antecedentes)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto);

    }

    public function listar_fichas($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_fichas = new Ficha();
        $fichas = $model_fichas->getFichas($id,$dni);
        $activo = Ficha::Where('dni',$dni)->Where('estado',1)->Where('activo',1)->count();
        
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        //dd($fichas);
        $foto='';
        return view('admin.aislamientos.listar_fichas')->with('paciente', $paciente)->with('fichas', $fichas)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto)->with('activo',$activo);

    }

    public function eliminar_antecedente($id_ant, $id, $dni)
    {
        
        $antecedente_encontrado = Antecedente::where('id', $id_ant)->Where('estado',1)->first();
        
        if(is_object($antecedente_encontrado)){
            Flash::success('Se ha eliminado correctamente.');
            $antecedente_encontrado->estado=0; 
            $antecedente_encontrado->id_user_actualizacion=Auth::user()->id;
            $antecedente_encontrado->save();               
        }
        else{
            Flash::success('No se ha podido eliminar el registro, contacte con el administrador.');
        }

        return redirect('/listar_antecedentes_epidemiologicos/'. $id.'/'.$dni);
    }

    function buscar_foto($dni){
        $sw1=false;
        $soapClient = new SoapClient('http://192.168.10.44:7001/ServicioReniecImpl/ServicioReniecImplService?WSDL', array('trace'=>1,"encoding"=>"ISO-8859-1"));
        
        $parametros = array("clienteUsuario"=>"DIRSAPOL", 
          "clienteClave"=>"WUK9XPhx", 
          "servicioCodigo"=>"WS_RENIEC_MAY_MEN", 
          "clienteSistema"=>"SOAP_DESARROLLO", 
          "clienteIp"=>"172.31.2.249",
          "clienteMac"=>"AA:BB:CC:DD:EE:FF",
          "dniAutorizado"=>"42214047",
          "tipoDocUserClieFin"=>"1",
          "nroDocUserClieFin"=>"391402",
          "inDni"=>$dni,
          "inPioridad"=>"priority"
        );

        $respuesta = $soapClient->consultarDniMayor($parametros);

        switch ($respuesta->resultadoDniMayor->codigoMensaje) {
              case 'MR':
                $sw1=true;
                break;
              
              case '17':
                $sw1=true;
                break;
            }

        $$foto = '';
        
        return $foto;
    }

   public function create_antecedente_epidemiologico($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $model_departamentos= new Departamento();
        $departamentos2 = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        $model_factor= new Sintoma();
        $Sintomas = $model_factor->getSintoma();
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $antecedentes = new Antecedente();
        $model_fabricantes = new Fabricante();
        $fabricantes = $model_fabricantes->getFabricantes();
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $foto = '';
        return view('admin.aislamientos.nuevo_antecedentes_epidemiologico')->with('establecimientos', $establecimientos)->with('fechaServidor', $fechaServidor)->with('departamentos2', $departamentos2)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('foto',$foto)->with('paciente',$paciente)->with('antecedentes',$antecedentes)->with('id',$id)->with('dni',$dni)->with('fabricantes',$fabricantes);
    }

    public function store_antecedentes(Request $request)
    {   
        
        //crear ficha
        $ficha = new Ficha();
        $ficha->fecha_notificacion =  $request->fecha_notificacion;
        $ficha->id_aislado =  $request->id_paciente;
        $ficha->dni=$request->dni;
        $ficha->id_establecimiento=Auth::user()->establecimiento_id;
        $ficha->id_user=Auth::user()->id;
        $ficha->hospitalizado=$request->caso_hospitalizado;
        $ficha->activo=1;
        $ficha->estado=1;
        $ficha->save();
        $idficha = $ficha->id;
        

        //crear antecedente
        $antecedente = new Antecedente();
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $antecedente->id_clasificacion=$request->id_clasificacion;
        $antecedente->id_tipo_caso=$request->id_tipo_caso;
        $antecedente->id_establecimiento=Auth::user()->establecimiento_id;
        $antecedente->fecha_registro=$fecha_registro;
        $antecedente->id_user=Auth::user()->id;
        $antecedente->dni=$request->dni;
        $antecedente->fecha_sintoma=$request->fecha_sintoma;
        $antecedente->fecha_aislamiento=$request->fecha_aislamiento;
        $antecedente->gestante=$request->gestante;
        $antecedente->semana_gestacion=$request->semana_gestacion;
        $antecedente->id_departamento2=$request->id_departamento;
        $antecedente->id_provincia2=$request->id_provincia;
        $antecedente->id_distrito2=$request->id_distrito;
        $antecedente->contacto_directo=$request->contacto_directo;
        $antecedente->ficha_contacto=$request->ficha_contacto;
        $antecedente->caso_reinfeccion=$request->caso_reinfeccion;
        $antecedente->sintoma_reinfeccion=$request->sintoma_reinfeccion;
        $antecedente->fecha_sintoma_reinfeccion=$request->fecha_sintoma_reinfeccion;
        $antecedente->prueba_confirmatoria=$request->prueba_confirmatoria;
        $antecedente->fecha_resultado_reinfeccion=$request->fecha_resultado_reinfeccion;
        $antecedente->clasificacion_reinfeccion=$request->clasificacion_reinfeccion;

        switch ($request->covid) {
            case '1': $antecedente->vacuna_covid =  'SI' ; 
                      $antecedente->fabricante_1 =  $request->fabricante_1; $antecedente->fecha_vacunacion_1 =  $request->fecha_vacunacion_1 ;
                      $antecedente->fabricante_2 =  $request->fabricante_2; $antecedente->fecha_vacunacion_2 =  $request->fecha_vacunacion_2 ;
                      $antecedente->fabricante_3 =  $request->fabricante_3; $antecedente->fecha_vacunacion_3 =  $request->fecha_vacunacion_3 ;
                      $antecedente->fabricante_4 =  $request->fabricante_4; $antecedente->fecha_vacunacion_4 =  $request->fecha_vacunacion_4 ;
                        break;
            case '2': $antecedente->vacuna_covid =  'NO' ; break;
            
        }
        
        $antecedente->observacion=$request->observacion;
        $antecedente->idficha=$idficha;
        $antecedente->save();        
        $idantecedente = $antecedente->id; 
        $antecedente->sintomaantecedentes()->attach($request->sintomas);
        $antecedente->signoantecedentes()->attach($request->signos);  
        $antecedente->factorantecedentes()->attach($request->factorriesgos);  
        $antecedente->ocupacioneantecedentes()->attach($request->ocupaciones);   
        $antecedente->lugarantecedentes()->attach($request->lugar);

        //actualizar clasificacion
        switch ($request->id_clasificacion) {
            case '1': $clasificacion_aislamiento = 'CONFIRMADO'; break;
            case '2': $clasificacion_aislamiento = 'PROBABLE'; break;
            case '3': $clasificacion_aislamiento = 'SOSPECHOSO'; break;
            case '4': $clasificacion_aislamiento = 'DESCARTADO'; break;
        }
        
        switch ($request->id_tipo_caso) {
            case '1': $tipo_caso = 'SINTOMATICO'; break;
            case '2': $tipo_caso = 'ASINTOMATICO'; break;
            
        }

        $aislamiento = Aislamiento::where('id', $request->id_paciente)->Where('dni',$request->dni)->first();
        $aislamiento->fecha_registro =  $request->fecha_notificacion;
        $aislamiento->clasificacion =  $clasificacion_aislamiento;
        $aislamiento->tipo_caso =  $tipo_caso;
        $aislamiento->save();
        
        Flash::success('Se ha registrado correctamente.');
        
        if($request->caso_hospitalizado=='SI'){ //mandar formulario hospitalizado
            return redirect('/registro_hospitalizacion/'. $request->dni.'/'.$request->id_paciente.'/'.$idficha);
        }
        else{
            return redirect('/registro_laboratorio_paciente/'. $request->id_paciente.'/'.$request->dni.'/'.$idficha);
           
        }
            
        
    }
    
    public function update_antecedente_epidemiologico($id,Request $request)
    {
        
        //crear ficha
        $ficha = Ficha::where('id', $request->idficha)->Where('estado',1)->first();
        $ficha->fecha_notificacion =  $request->fecha_notificacion;
        $ficha->id_user_actualizacion=Auth::user()->id;
        $ficha->hospitalizado=$request->caso_hospitalizado;
        $ficha->save();
        $aislamiento = Antecedente::where('id', $id)->Where('dni',$request->dni_antecedente)->Where('estado',1)->first();
        
        $date = Carbon::now();
        
        $fecha_registro = $date->format('d-m-Y');
        $aislamiento->fecha_sintoma=$request->fecha_sintoma;
        $aislamiento->id_clasificacion=$request->id_clasificacion;
        $aislamiento->id_tipo_caso=$request->id_tipo_caso;
        $aislamiento->fecha_aislamiento=$request->fecha_aislamiento;
        $aislamiento->id_departamento2=$request->id_departamento2;
        $aislamiento->id_provincia2=$request->id_provincia2;
        $aislamiento->id_distrito2=$request->id_distrito2;
        $aislamiento->contacto_directo=$request->contacto_directo;
        $aislamiento->ficha_contacto=$request->ficha_contacto;
        $aislamiento->sintoma_reinfeccion=$request->sintoma_reinfeccion;
        $aislamiento->caso_reinfeccion=$request->caso_reinfeccion;
        $aislamiento->fecha_sintoma_reinfeccion=$request->fecha_sintoma_reinfeccion;
        $aislamiento->prueba_confirmatoria=$request->prueba_confirmatoria;
        $aislamiento->fecha_resultado_reinfeccion=$request->fecha_resultado_reinfeccion;
        $aislamiento->clasificacion_reinfeccion=$request->clasificacion_reinfeccion;
        //$aislamiento->ubicacion_hospitalizacion=$request->ubicacion_hospitalizacion;
        $aislamiento->gestante=$request->gestante;
        $aislamiento->semana_gestacion=$request->semana_gestacion;
        switch ($request->covid) {
            case 1: $aislamiento->vacuna_covid =  'SI' ; 
                      $aislamiento->fabricante_1 =  $request->fabricante_1; $aislamiento->fecha_vacunacion_1 =  $request->fecha_vacunacion_1 ;
                      $aislamiento->fabricante_2 =  $request->fabricante_2; $aislamiento->fecha_vacunacion_2 =  $request->fecha_vacunacion_2 ;
                      $aislamiento->fabricante_3 =  $request->fabricante_3; $aislamiento->fecha_vacunacion_3 =  $request->fecha_vacunacion_3 ;
                      $aislamiento->fabricante_4 =  $request->fabricante_4; $aislamiento->fecha_vacunacion_4 =  $request->fecha_vacunacion_4 ;
                        break;
            case 2: $aislamiento->vacuna_covid =  'NO' ; break;
            
        }
        
        $aislamiento->observacion=$request->observacion;

        $aislamiento->save();        

        $idaislamiento = $aislamiento->id;


        $this->registra_checkbok($request->sintomas, 'antecedente_sintoma', $id, $request->dni_antecedente, 'sintomaantecedentes','sintoma_id');
        $this->registra_checkbok($request->signos, 'antecedente_signo', $id, $request->dni_antecedente, 'signoantecedentes','signo_id');
        $this->registra_checkbok($request->factorriesgos, 'antecedente_factor_riesgo', $id, $request->dni_antecedente, 'factorantecedentes','factor_riesgo_id');
        $this->registra_checkbok($request->ocupaciones, 'antecedente_ocupacione', $id, $request->dni_antecedente, 'ocupacioneantecedentes','ocupacione_id');
        $this->registra_checkbok($request->lugar, 'antecedente_lugare', $id, $request->dni_antecedente, 'lugarantecedentes','lugare_id');
        
        //actualizar clasificacion
        switch ($request->id_clasificacion) {
            case '1': $clasificacion_aislamiento = 'CONFIRMADO'; break;
            case '2': $clasificacion_aislamiento = 'PROBABLE'; break;
            case '3': $clasificacion_aislamiento = 'SOSPECHOSO'; break;
            case '4': $clasificacion_aislamiento = 'DESCARTADO'; break;
        }
        
        switch ($request->id_tipo_caso) {
            case '1': $tipo_caso = 'SINTOMATICO'; break;
            case '2': $tipo_caso = 'ASINTOMATICO'; break;
            
        }

        $paciente = Aislamiento::where('id', $request->id_paciente)->Where('dni',$request->dni_antecedente)->first();
        $paciente->fecha_registro =  $request->fecha_notificacion;
        $paciente->clasificacion =  $clasificacion_aislamiento;
        $paciente->tipo_caso =  $tipo_caso;
        $paciente->save();
        
        Flash::success('Se ha actualizado correctamente.');
        
        return redirect('/listar_fichas/'. $request->id_paciente.'/'. $request->dni_antecedente);
    }

    public function registra_checkbok($checkboxs, $tabla, $id_antecedente, $dni, $objeto,$campo_id )
    {
        $antecedente = Antecedente::where('id', $id_antecedente)->Where('dni',$dni)->first();
        $num_items=DB::table($tabla)->where('antecedente_id',$id_antecedente)->count();

        //Sino se ha marcado ningun checkbox
        if (empty($checkboxs)) {
           if($num_items>0){
                $elimina_bd=DB::table($tabla)->where('antecedente_id',$id_antecedente)->delete();
           }
        }else
        {
            //si esta vacio llenamos
            if($num_items==0){
                $antecedente->$objeto()->attach($checkboxs); 
            }
            else
            {
                $datos_bd=DB::table($tabla)->where('antecedente_id',$id_antecedente)->get();
                //checkbox desmarcados
                //$medicamentos_desmarcado=$medicamentos_bd->pluck('petitorio_id')->diff($checkboxs);
                $datos_desmarcado=$datos_bd->pluck($campo_id)->diff($checkboxs);
                $num_datos_desmarcado=count($datos_bd->pluck($campo_id)->diff($checkboxs));

                //convertimos a arreglo
                $arreglo = $datos_bd->pluck($campo_id)->toArray();

                //los nuevos checkbox
                $num_datos_nuevos=count(array_diff($checkboxs,$arreglo));
                $datos_nuevos=array_diff($checkboxs,$arreglo);

                ///Insertamos los nuevos           
                if($num_datos_nuevos>0){
                    //$aislamiento->petitorios()->attach($medicamentos_nuevos); //attach 
                    $antecedente->$objeto()->attach($datos_nuevos); //attach  
                }
                ///eliminamos los que no estan en los checkbox
                if($num_datos_desmarcado>0){
                    $antecedente->$objeto()->detach($datos_desmarcado); //attach           
                }
            }
        }
    }
    
    
      public function create_antecedente($id, $dni)
    {
     
        $date = Carbon::now();
        $aislamientos = new Aislamiento();
        $enfermedadregiones=EnfermedadRegione::orderby('descripcion','asc')->get();
        $cuadropatologicos=CuadroPatologico::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $esavis = new Esavi();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            
        // foto 
        //$foto=$this->buscar_foto($dni);
        
        $foto = '';         
        
        return view('admin.aislamientos.nuevo_antecedente')->with('fechaServidor', $fechaServidor)->with('factorriesgos', $factorriesgos)->with('aislamientos', $aislamientos)->with('enfermedadregiones', $enfermedadregiones)->with('cuadropatologicos', $cuadropatologicos)->with('foto',$foto)->with('paciente',$paciente)->with('esavis',$esavis)->with('id',$id)->with('dni',$dni);
    }

    

    public function editar_antecedentes_epidemiologico($id_ficha, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $antecedentes = Antecedente::where('idficha', $id_ficha)->Where('dni',$dni)->Where('estado',1)->first();
        
        if(!empty($antecedentes)):

            $model_establecimientos= new Establecimiento();
            $model_establecimientos_salud= new EstablecimientoSalud();
            $establecimientos = $model_establecimientos->getTodosEstablecimientos();
            $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
            $model_departamentos= new Departamento();
            $model_provincias= new Provincia();
            $model_distritos= new Distrito();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $model_diagnostico= new Diagnostico();
            $model_laboratorio= new Laboratorio();
            $Sintomas = $model_factor->getSintoma();
            $signos=Signo::orderby('descripcion','asc')->get();
            $sintomas=Sintoma::orderby('descripcion','asc')->get();
            $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
            $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
            $lugares=Lugare::orderby('descripcion','asc')->get();
            $model_sino= new Sino();
            $sinos = $model_sino->getSino();

            $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->Where('estado',1)->first();
            $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
            $departamentos2 = $model_departamentos->getDepartamento();
            $provincias2 = $model_provincias->getProvincia($antecedentes->id_departamento2);
            $distritos2 = $model_distritos->getDistrito($antecedentes->id_departamento2,$antecedentes->id_provincia2);
            //$fecha_alta = $paciente->fecha_alta;
            //$fecha_defuncion = $paciente->fecha_defuncion;
            /** foto **/
            //$foto=$this->buscar_foto($dni);
            $ficha = Ficha::where('id', $id_ficha)->Where('estado',1)->first();
            
            $model_fabricantes = new Fabricante();
            $fabricantes = $model_fabricantes->getFabricantes();

            $nro_hosp = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
            $nro_lab = Laboratorio::where('idficha', $id_ficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
            $conta_hospi = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
            if($conta_hospi>0):
                $hospi = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->first();
                $id_hospitalizacion = $hospi->id;
            else:
                $id_hospitalizacion = 0;
            endif;
            //$id_hospitalizacion = 0;
            $existe_ficha_contacto = $antecedentes->ficha_contacto; 

            $foto='';

            return view('admin.aislamientos.editar_antecedente_epidemiologica')->with('fechaServidor', $fechaServidor)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('nombre_paciente', $nombre_paciente)->with('departamentos2', $departamentos2)->with('dni', $dni)->with('id_paciente', $id_paciente)->with('paciente',$paciente)->with('foto',$foto)->with('antecedentes',$antecedentes)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('id', $id_paciente)->with('fabricantes', $fabricantes)->with('idficha', $id_ficha)->with('ficha', $ficha)->with('nro_hosp', $nro_hosp)->with('nro_lab', $nro_lab)->with('id_hospitalizacion', $id_hospitalizacion)->with('existe_ficha_contacto', $existe_ficha_contacto);

        else:
            return redirect('/registro_antecedentes_epidemiologicos/'. $id_paciente.'/'.$dni);
        endif;

    }
    

    public function editar_hospitalizacion($id_hospitalizacion, $dni, $id_paciente, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');        
        $model_diagnostico= new Diagnostico();
        $signos=Signo::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $model_hospitalizaciones= new Hospitalizacion();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $fecha_alta = $paciente->fecha_alta;

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        $pac_hospitalizado = Hospitalizacion::where('id', $id_hospitalizacion)->where('idficha', $idficha)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();

        if(is_object($pac_hospitalizado)){
            $establecimiento_proviene=$pac_hospitalizado->establecimiento_proviene;
            $fecha_hospitalizacion=$pac_hospitalizado->fecha_hospitalizacion;
            $establecimiento_actual=$pac_hospitalizado->establecimiento_actual;
            $tipo_seguro=$pac_hospitalizado->tipo_seguro;
            $otro_signo_ho=$pac_hospitalizado->otro_signo_ho;
            $servicio_hospitalizacion=$pac_hospitalizado->servicio_hospitalizacion;
            $ventilacion_mecanica=$pac_hospitalizado->ventilacion_mecanica;
            $intubado=$pac_hospitalizado->intubado;
            $neumonia=$pac_hospitalizado->neumonia;
            $iaas=$pac_hospitalizado->uci;
            $id_hospitalizacion =$pac_hospitalizado->id;
            $diagnostico = $model_diagnostico->GetDiagnosticoByHospitalizado($id_hospitalizacion,1);
            $count_diagnostico = count($diagnostico);
            $hospitalizaciones = $model_hospitalizaciones->getHospitalizacion($id_paciente,$dni);
            $count_hospitalizado = count($diagnostico);
            $referido = $pac_hospitalizado->referido;
            $fecha_ingreso_hospi=$pac_hospitalizado->fecha_ingreso_hospi;
            $fecha_alta_hospi=$pac_hospitalizado->fecha_alta_hospi;
            $fecha_referencia=$pac_hospitalizado->fecha_referencia;
            $otra_ubicacion=$pac_hospitalizado->otra_ubicacion;
            $fecha_ingreso_s2=$pac_hospitalizado->fecha_ingreso_s2;
            $fecha_alta_s2=$pac_hospitalizado->fecha_alta_s2;
            $fecha_ingreso_s3=$pac_hospitalizado->fecha_ingreso_s3;
            $fecha_alta_s3=$pac_hospitalizado->fecha_alta_s3;
            $fecha_ingreso_s4=$pac_hospitalizado->fecha_ingreso_s4;
            $fecha_alta_s4=$pac_hospitalizado->fecha_alta_s4;
            $fecha_ingreso_s5=$pac_hospitalizado->fecha_ingreso_s5;
            $fecha_alta_s5=$pac_hospitalizado->fecha_alta_s5;
            $fecha_ingreso_s6=$pac_hospitalizado->fecha_ingreso_s6;
            $fecha_alta_s6=$pac_hospitalizado->fecha_alta_s6;
            $observacion = $pac_hospitalizado->observacion;
        }
        else
        {
            $establecimiento_proviene=0;
            $fecha_hospitalizacion=$date->format('Y-m-d');
            $establecimiento_actual=0;
            $tipo_seguro=0;
            $otro_signo_ho="";
            $servicio_hospitalizacion=0;
            $ventilacion_mecanica=0;
            $intubado=0;
            $neumonia=0;
            $iaas=0;
            $id_hospitalizacion =0;
            $pac_hospitalizado = new Hospitalizacion();
            $diagnostico =0;
            $hospitalizaciones=0;
            $count_hospitalizado = 0;
            $count_diagnostico = 0;
            $referido = 0;
            $fecha_ingreso_hospi=$date->format('Y-m-d');
            $fecha_alta_hospi=$date->format('Y-m-d');
            $fecha_referencia=$date->format('Y-m-d');
            $otra_ubicacion='';
            $fecha_ingreso_s2='';
            $fecha_alta_s2='';
            $fecha_ingreso_s3='';
            $fecha_alta_s3='';
            $fecha_ingreso_s4='';
            $fecha_alta_s4='';
            $fecha_ingreso_s5='';
            $fecha_alta_s5='';
            $fecha_ingreso_s6='';
            $fecha_alta_s6='';
            $observacion='';
        }

        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $antecedente = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 
        $foto='';
        return view('admin.aislamientos.editar_hospitalizacion')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('iaas', $iaas)->with('id_hospitalizacion', $id_hospitalizacion)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('foto',$foto)->with('sinos', $sinos)->with('count_hospitalizado', $count_hospitalizado)->with('hospitalizaciones', $hospitalizaciones)->with('referido', $referido)->with('fecha_alta_hospi', $fecha_alta_hospi)->with('fecha_ingreso_hospi', $fecha_ingreso_hospi)->with('fecha_referencia', $fecha_referencia)->with('otra_ubicacion', $otra_ubicacion)->with('fecha_ingreso_s2', $fecha_ingreso_s2)->with('fecha_ingreso_s3', $fecha_ingreso_s3)->with('fecha_ingreso_s4', $fecha_ingreso_s4)->with('fecha_ingreso_s5', $fecha_ingreso_s5)->with('fecha_ingreso_s6', $fecha_ingreso_s6)->with('fecha_alta_s2', $fecha_alta_s2)->with('fecha_alta_s3', $fecha_alta_s3)->with('fecha_alta_s4', $fecha_alta_s4)->with('fecha_alta_s5', $fecha_alta_s5)->with('fecha_alta_s6', $fecha_alta_s6)->with('observacion', $observacion)->with('nro_hosp', $nro_hosp)->with('ficha', $ficha)->with('idficha', $idficha)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    public function eliminar_hospitalizaciones($id_hosp, $id, $dni)
    {
        
        $hospitalizacion_encontrado = Hospitalizacion::where('id', $id_hosp)->Where('estado',1)->first();
        
        if(is_object($hospitalizacion_encontrado)){
            Flash::success('Se ha eliminado correctamente.');
            $hospitalizacion_encontrado->estado=0; 
            $hospitalizacion_encontrado->id_user_actualizacion=Auth::user()->id;
            $hospitalizacion_encontrado->save();

            $aislado = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
            $aislado->hospitalizado='NO';
            $aislado->save();

        }
        else{
            Flash::success('No se ha podido eliminar el registro, contacte con el administrador.');
        }

        return redirect('/listar_hospitalizaciones/'. $id.'/'.$dni);
    }


    public function dar_alta_hospitalizacion($idficha, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');
        $pac_hospitalizado = Hospitalizacion::where('idficha', $idficha)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();
        $model_diagnostico= new Diagnostico();
        $model_establecimientos_salud= new EstablecimientoSalud();
        

        if(is_object($pac_hospitalizado)){

            $fecha_alta=$pac_hospitalizado->fecha_alta;

            if(is_null($fecha_alta)):
                $fecha_alta=$date->format('Y-m-d');
            endif;

            $motivo_egreso=$pac_hospitalizado->motivo_egreso;
            $establecimiento_actual=$pac_hospitalizado->establecimiento_actual;
            if(!is_null($pac_hospitalizado->establecimiento_alta)):
                $establecimiento_alta=$pac_hospitalizado->establecimiento_alta;
            else:
                $establecimiento_alta=$establecimiento_actual;
            endif;

            $id_hospitalizacion =$pac_hospitalizado->id;
            $diagnostico = $model_diagnostico->GetDiagnosticoByHospitalizado($id_hospitalizacion,2);
            $count_diagnostico = count($diagnostico);
            $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();

        }
        else
        {
            $establecimiento_alta=Auth::user()->establecimiento_id;
            $establecimiento_actual=Auth::user()->establecimiento_id;
            $diagnostico =0;
            $fecha_alta=$date->format('Y-m-d');
            $count_diagnostico = 0;
            $id_hospitalizacion =0;
            $establecimiento_actual=0;
            $motivo_egreso=0;
        }
        
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        

        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $foto = '';
        return view('admin.aislamientos.dar_alta_paciente')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('motivo_egreso', $motivo_egreso)->with('id', $id_paciente)->with('foto',$foto)->with('fecha_alta',$fecha_alta)->with('establecimiento_alta',$establecimiento_alta)->with('id_hospitalizacion',$id_hospitalizacion)->with('diagnostico',$diagnostico)->with('id_hospitalizacion', $id_hospitalizacion)->with('establecimiento_salud',$establecimiento_salud)->with('count_diagnostico',$count_diagnostico)->with('establecimiento_actual',$establecimiento_actual)->with('idficha',$idficha);

    }

    public function create_hospitalizacion($dni, $id_paciente, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');        
        $model_diagnostico= new Diagnostico();
        $signos=Signo::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $model_hospitalizaciones= new Hospitalizacion();

        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;

        $fecha_alta = $paciente->fecha_alta;

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
            $establecimiento_proviene=0;
            $fecha_hospitalizacion=$date->format('Y-m-d');
            $establecimiento_actual=0;
            $tipo_seguro=0;
            $otro_signo_ho="";
            $servicio_hospitalizacion=0;
            $ventilacion_mecanica=0;
            $intubado=0;
            $neumonia=0;
            $iaas=0;
            $id_hospitalizacion =0;
            $pac_hospitalizado = new Hospitalizacion();
            $diagnostico =0;
            $hospitalizaciones=0;
            $count_hospitalizado = 0;
            $count_diagnostico = 0;
            $referido = 0;
            $fecha_referencia = $date->format('Y-m-d');
            $otra_ubicacion  = '';
            $fecha_ingreso_hospi=$date->format('Y-m-d');
            $fecha_alta_hospi=$date->format('Y-m-d');
            $fecha_referencia=$date->format('Y-m-d');
            //$fecha_ingreso_s2=$date->format('Y-m-d');
            $fecha_ingreso_s2='';
            $fecha_alta_s2='';
            //$fecha_ingreso_s3=$date->format('Y-m-d');
            $fecha_ingreso_s3='';
            $fecha_alta_s3='';
            $fecha_ingreso_s4='';
            //$fecha_ingreso_s4=$date->format('Y-m-d');
            $fecha_alta_s4='';
            $fecha_ingreso_s5='';
            //$fecha_ingreso_s5=$date->format('Y-m-d');
            $fecha_alta_s5='';
            //$fecha_ingreso_s6=$date->format('Y-m-d');
            $fecha_ingreso_s6='';
            $fecha_alta_s6='';
            $observacion='';
       
        //}
                
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $antecedente = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 

        $foto='';
        return view('admin.aislamientos.editar_hospitalizacion')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('iaas', $iaas)->with('id_hospitalizacion', $id_hospitalizacion)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('foto',$foto)->with('sinos', $sinos)->with('count_hospitalizado', $count_hospitalizado)->with('hospitalizaciones', $hospitalizaciones)->with('referido', $referido)->with('fecha_referencia', $fecha_referencia)->with('otra_ubicacion', $otra_ubicacion)->with('fecha_alta_hospi', $fecha_alta_hospi)->with('fecha_ingreso_hospi', $fecha_ingreso_hospi)->with('fecha_ingreso_s2', $fecha_ingreso_s2)->with('fecha_ingreso_s3', $fecha_ingreso_s3)->with('fecha_ingreso_s4', $fecha_ingreso_s4)->with('fecha_ingreso_s5', $fecha_ingreso_s5)->with('fecha_ingreso_s6', $fecha_ingreso_s6)->with('fecha_alta_s2', $fecha_alta_s2)->with('fecha_alta_s3', $fecha_alta_s3)->with('fecha_alta_s4', $fecha_alta_s4)->with('fecha_alta_s5', $fecha_alta_s5)->with('fecha_alta_s6', $fecha_alta_s6)->with('observacion', $observacion)->with('ficha', $ficha)->with('idficha', $idficha)->with('nro_hosp', $nro_hosp)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    public function store_hospitalizacion(Request $request)
    {        
        $sw = 0 ;
        if($request->id_hospitalizacion==0){
            $hospitalizado = new Hospitalizacion;   
        }
        else{
            $hospitalizado = Hospitalizacion::where('id', $request->id_hospitalizacion)->where('id_paciente', $request->id_paciente_hospitalizacion)->Where('dni_paciente',$request->dni_hospitalizacion)->where('idficha', $request->idficha)->first();   
            $sw = 1 ;   
        }
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $hospitalizado->dni_paciente = $request->dni_hospitalizacion;
        $hospitalizado->id_paciente = $request->id_paciente_hospitalizacion;
        $hospitalizado->id_user_registro = Auth::user()->id;
        $hospitalizado->fecha_registro=$fecha_registro;
        $hospitalizado->establecimiento_proviene=$request->establecimiento_salud_proviene;
        $hospitalizado->fecha_hospitalizacion=$request->fecha_hospitalizacion;
        $hospitalizado->establecimiento_actual=$request->establecimiento_salud;
        //$hospitalizado->establecimiento_actual=Auth::user()->establecimiento_id;
        $hospitalizado->tipo_seguro=$request->tipo_seguro;
        $hospitalizado->otro_signo_ho=$request->otro_signo_ho;
        $hospitalizado->otra_ubicacion=$request->otra_ubicacion;
        $hospitalizado->servicio_hospitalizacion=$request->servicio_hospitalizacion;
        $hospitalizado->intubado=$request->intubado;
        $hospitalizado->uci=$request->iaas;
        $hospitalizado->ventilacion_mecanica=$request->ventilacion_mecanica;
        $hospitalizado->neumonia=$request->neumonia;

        $hospitalizado->referido=$request->referido;
        $hospitalizado->fecha_referencia=$request->fecha_referencia;
        $hospitalizado->fecha_alta_hospi=$request->fecha_alta_hospi;
        $hospitalizado->fecha_ingreso_hospi=$request->fecha_ingreso_hospi;

        $hospitalizado->fecha_ingreso_s2=$request->fecha_ingreso_s2;
        $hospitalizado->fecha_alta_s2=$request->fecha_alta_s2;
        $hospitalizado->fecha_ingreso_s3=$request->fecha_ingreso_s3;
        $hospitalizado->fecha_alta_s3=$request->fecha_alta_s3;
        $hospitalizado->fecha_ingreso_s4=$request->fecha_ingreso_s4;
        $hospitalizado->fecha_alta_s4=$request->fecha_alta_s4;
        $hospitalizado->fecha_ingreso_s5=$request->fecha_ingreso_s5;
        $hospitalizado->fecha_alta_s5=$request->fecha_alta_s5;
        $hospitalizado->fecha_ingreso_s6=$request->fecha_ingreso_s6;
        $hospitalizado->fecha_alta_s6=$request->fecha_alta_s6;
        $hospitalizado->observacion=$request->observacion;

        $hospitalizado->idficha=$request->idficha;
        $hospitalizado->save();

        $aislamiento = Aislamiento::Where('id', $request->id_paciente_hospitalizacion)->Where('dni',$request->dni_hospitalizacion)->first();
        $aislamiento->hospitalizado = 'SI';
        $aislamiento->save();
        
        if($sw == 0 ){
            $hospitalizado->signohospitalizados()->attach($request->signos_hospitalizacion);
            $id_hospitalizacion=$hospitalizado->id;
        }
        else
        {
            $num_items=DB::table('hospitalizacion_signo')->where('hospitalizacion_id',$request->id_hospitalizacion)->count();
            $id_hospitalizacion=$request->id_hospitalizacion;
            //Sino se ha marcado ningun checkbox
            if (empty($request->signos_hospitalizacion)) {
               if($num_items>0){
                    $elimina_bd=DB::table('hospitalizacion_signo')->where('hospitalizacion_id',$request->id_hospitalizacion)->delete();
               }
            }else
            {
                //si esta vacio llenamos
                if($num_items==0){
                    $hospitalizado->signohospitalizados()->attach($request->signos_hospitalizacion); 
                }
                else
                {
                    $datos_bd=DB::table('hospitalizacion_signo')->where('hospitalizacion_id',$request->id_hospitalizacion)->get();
                    //checkbox desmarcados
                    //$medicamentos_desmarcado=$medicamentos_bd->pluck('petitorio_id')->diff($checkboxs);
                    $datos_desmarcado=$datos_bd->pluck('signo_id')->diff($request->signos_hospitalizacion);
                    $num_datos_desmarcado=count($datos_bd->pluck('signo_id')->diff($request->signos_hospitalizacion));

                    //convertimos a arreglo
                    $arreglo = $datos_bd->pluck('signo_id')->toArray();

                    //los nuevos checkbox
                    $num_datos_nuevos=count(array_diff($request->signos_hospitalizacion,$arreglo));
                    $datos_nuevos=array_diff($request->signos_hospitalizacion,$arreglo);

                    ///Insertamos los nuevos           
                    if($num_datos_nuevos>0){
                        //$aislamiento->petitorios()->attach($medicamentos_nuevos); //attach 
                        $hospitalizado->signohospitalizados()->attach($datos_nuevos); //attach  
                    }
                    ///eliminamos los que no estan en los checkbox
                    if($num_datos_desmarcado>0){
                        $hospitalizado->signohospitalizados()->detach($datos_desmarcado); //attach           
                    }
                }
            }
        }
        
        if(isset($request->id_diagnostico)):
            
            foreach ($request->id_diagnostico as $key => $value):
                if($request->id_diagnostico[$key]!=""){

                    $id_diagnostico=$request->id_diagnostico[$key];
                    $id_tipo_diagnostico=$request->id_tipo_diagnostico[$key];

                    DB::table('diagnostico_hospitalizados')
                    ->insert([                    
                        'id_hospitalizado' => $id_hospitalizacion,
                        'id_diagnostico' => $id_diagnostico,
                        'tipo_diagnostico' => $id_tipo_diagnostico,
                        'ingreso_egreso' => 1, //1 ingreso 2 salida
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
            
        return redirect('/registro_laboratorio_paciente/'. $request->id_paciente_hospitalizacion.'/'.$request->dni_hospitalizacion.'/'.$request->idficha);
    }

    public function store_alta_hospitalizacion(Request $request)
    {        
        $hospitalizado = Hospitalizacion::where('idficha', $request->idficha)->where('id_paciente', $request->id_paciente_hospitalizacion)->Where('dni_paciente',$request->dni_hospitalizacion)->first();
        $hospitalizado->id_user_alta = Auth::user()->id;        
        $hospitalizado->fecha_alta=$request->fecha_alta;
        $hospitalizado->motivo_egreso=$request->motivo_egreso;
        $hospitalizado->establecimiento_alta= Auth::user()->establecimiento_id;
        $hospitalizado->save();

        if(isset($request->id_diagnostico)):
            
            foreach ($request->id_diagnostico as $key => $value):
                if($request->id_diagnostico[$key]!=""){

                    $id_diagnostico=$request->id_diagnostico[$key];
                    $id_tipo_diagnostico=$request->id_tipo_diagnostico[$key];

                    DB::table('diagnostico_hospitalizados')
                    ->insert([                    
                        'id_hospitalizado' => $request->id_hospitalizacion,
                        'id_diagnostico' => $id_diagnostico,
                        'tipo_diagnostico' => $id_tipo_diagnostico,
                        'ingreso_egreso' => 2, //1 ingreso 2 salida
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;

        $ficha_encontrada = Ficha::where('id', $request->idficha)->Where('id_aislado',$request->id_paciente_hospitalizacion)->Where('dni',$request->dni_hospitalizacion)->Where('estado',1)->first();
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');

        if(is_object($ficha_encontrada)){
            Flash::success('Se ha cerrado la ficha correctamente.');
            $ficha_encontrada->estado=1;
            $ficha_encontrada->activo=2; 
            $ficha_encontrada->id_user_actualizacion=Auth::user()->id;
            $ficha_encontrada->fecha_cierre=$fecha_actual; 
            $ficha_encontrada->save();               
        }
        else{
            Flash::success('No se ha podido cerrar la ficha, contacte con el administrador.');
        }
            
        return redirect('/listar_fichas/'. $request->id_paciente_hospitalizacion.'/'.$request->dni_hospitalizacion);
    }

    public function listar_hospitalizaciones($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_hospitalizaciones= new Hospitalizacion();
        $hospitalizaciones = $model_hospitalizaciones->getHospitalizacion($id,$dni);
        
        

        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        
        $foto='';
        return view('admin.aislamientos.listar_hospitalizaciones')->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto)->with('hospitalizaciones', $hospitalizaciones);

    }

    public function listar_evolucion($id, $dni, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;

        $model_evoluciones= new Evolucion();
        $evoluciones = $model_evoluciones->getEvolucion($dni, $idficha);
        
        
        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $antecedente = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 

        $foto='';
        return view('admin.aislamientos.listar_evolucion')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('foto',$foto)->with('evoluciones', $evoluciones)->with('ficha', $ficha)->with('idficha', $idficha)->with('nro_hosp', $nro_hosp)->with('id_hospitalizacion', $id_hospitalizacion)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    

    public function create_evolucion($id, $dni, $id_ficha) //id_paciente, dni, idficha
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $evolucion = new Evolucion();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->Where('estado',1)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();

        $establecimiento_actual=0;

        $count_diagnostico=0;
        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $archivos= DB::table('archivos')
                    ->where('idficha','=',$id_ficha)
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('idficha','=',$id_ficha)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('idficha','=',$id_ficha)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $id_evolucion =  0;
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $ficha = Ficha::where('id', $id_ficha)->Where('dni',$dni)->Where('estado',1)->first();
        $nro_hosp = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $conta_hospi = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();

        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        $antecedente = Antecedente::where('idficha', $id_ficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 
        $foto='';
        return view('admin.aislamientos.editar_evolucion')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('foto',$foto)->with('id_evolucion',$id_evolucion)->with('evolucion',$evolucion)->with('id_paciente', $id)->with('archivos', $archivos)->with('count_diagnostico',$count_diagnostico)->with('establecimiento_salud',$establecimiento_salud)->with('establecimiento_actual',$establecimiento_actual)->with('idficha', $id_ficha)->with('ficha', $ficha)->with('nro_hosp', $nro_hosp)->with('id_hospitalizacion', $id_hospitalizacion)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    public function store_evolucion_paciente(Request $request)
    {   

        $sw = 0 ;
        if($request->id_evolucion==0){
            $evolucion = new Evolucion;   
        }
        else{
            $evolucion = Evolucion::where('id', $request->id_evolucion)->Where('dni',$request->dni_evolucion)->first();   
            $sw = 1 ;   
        }
        
        $paciente = Aislamiento::where('id', $request->id_paciente_evolucion)->Where('dni',$request->dni_evolucion)->first();
        
        //$paciente = Aislamiento::where('id', $request->id_paciente_evolucion)->Where('dni',$request->dni_evolucion)->first();

        $date = Carbon::now();

        $evolucion->evolucion=$request->evolucion;
        $evolucion->idficha=$request->idficha;
        $evolucion->dni=$request->dni_evolucion;
        $evolucion->id_user=Auth::user()->id;
        $fecha_actual = $date->format('d-m-Y'); 
        $evolucion->fecha_registro=$fecha_actual;

        switch ($request->evolucion) {
            case '1': $paciente->evolucion = 'FAVORABLE'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion;break;

            case '2': $paciente->evolucion = 'DESFAVORABLE'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion;break;
            
            case '3':   $paciente->evolucion = 'FALLECIO';
                        $paciente->fallecido = 'SI'; 
                        $evolucion->descripcion_evolucion = $request->descripcion_evolucion;
                        $evolucion->tipo_defuncion=$request->tipo_defuncion;
                        $evolucion->fecha_defuncion=$request->fecha_defuncion;
                        $evolucion->hora_defuncion=$request->hora_defuncion;
                        $evolucion->lugar_defuncion=$request->lugar_defuncion;
                        $evolucion->observacion=$request->motivo_muerte;

                        $evolucion->otro_lugar_fallecimiento=$request->otro_lugar;
                        $evolucion->hospital_fallecimiento=$request->establecimiento_salud;
                        
                        
                        if(isset($request->id_tipo_certificado)):
                            foreach ($request->id_tipo_certificado as $key => $value):
                                if($request->id_tipo_certificado[$key]!=""){

                                    $tipo_certificado=$request->id_tipo_certificado[$key];
                                    $nro_doc=$request->nro_doc[$key];
                                    $fecha_doc=$request->id_fecha_doc[$key];
                                    $dni= $request->dni_evolucion;

                                    if ($request->hasFile('photo')){
                                        
                                        $name_photo = time().'-'.$request->photo[$key]->getClientOriginalName();
                                        $original_name=$request->photo[$key]->getClientOriginalName();

                                        $input['photo'] = '/upload/archivos/'.$dni.'/'.$name_photo;            
                                        $request->photo[$key]->move(public_path('/upload/archivos/'.$dni.'/'), $input['photo']);
                                        $extension_archivo= $request->photo[$key]->getClientOriginalExtension();
                                    }

                                    if($tipo_certificado==1):
                                        $descripcion='Nota Informativa';
                                    else:
                                        $descripcion='Certificado Defuncion';
                                    endif;

                                    DB::table('defunciones')
                                        ->insert([
                                            'aislado_id' => $request->id_paciente_evolucion,                
                                            'nombre_archivo'=>$original_name,
                                            'nro_defuncion'=>$nro_doc,
                                            'fecha_defuncion'=>$fecha_doc,
                                            'descarga_archivo'=>$input['photo'],
                                            'descripcion_archivo'=>$descripcion,
                                            'extension_archivo'=>$extension_archivo,
                                            'tipo_defuncion'=>$tipo_certificado,
                                            'created_at'=>Carbon::now(),
                                            "updated_at"=>Carbon::now()
                                    ]);
                                }
                            endforeach;
                        endif;
                        break;

            case '4': $paciente->evolucion = 'ALTA AISLAMIENTO'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion; $evolucion->fecha_alta=$request->fecha_alta;break;
            case '5': $paciente->evolucion = 'ALTA AISLAMIENTO'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion; $evolucion->fecha_alta=$request->fecha_alta;break;
            case '6': $paciente->evolucion = 'ALTA AISLAMIENTO'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion; $evolucion->fecha_alta=$request->fecha_alta;break;
            case '7': $paciente->evolucion = 'ALTA AISLAMIENTO'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion; $evolucion->fecha_alta=$request->fecha_alta;break;
            case '8': $paciente->evolucion = 'ALTA AISLAMIENTO'; $evolucion->descripcion_evolucion = $request->descripcion_evolucion; $evolucion->fecha_alta=$request->fecha_alta;break;
        }

        $evolucion->save();
        $paciente->save();        
        
        Flash::success('Se ha registrado correctamente.');
        
        if($request->evolucion>2){
            return redirect('/dar_alta_hospitalizacion/'. $request->idficha.'/'.$request->dni_evolucion.'/'.$request->id_paciente_evolucion);
        }
        else{
            return redirect('/listar_evolucion/'. $request->id_paciente_evolucion.'/'.$request->dni_evolucion.'/'.$request->idficha);
        }

        
        
    }
    
    public function editar_evolucion($id, $dni, $id_paciente, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;

        $model_diagnostico= new Diagnostico();
        $diagnostico = $model_diagnostico->GetDiagnosticoByHospitalizado($id_paciente,1);

        $count_diagnostico = count($diagnostico);

        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();

        $establecimiento_actual=0;

        $evolucion = Evolucion::where('id', $id)->Where('dni',$dni)->first();
        $fecha_alta = $evolucion->fecha_alta;
        $fecha_defuncion = $evolucion->fecha_defuncion;
        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $establecimiento_actual=$evolucion->hospital_fallecimiento;
        $otro_lugar=$evolucion->otro_lugar_fallecimiento;
        $observacion=$evolucion->observacion;

        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
                $archivos= DB::table('defunciones')
                    ->where('aislado_id','=',$id_paciente)
                    ->where('estado',1)
                    ->get();


        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id_paciente)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id_paciente)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        
        $id_evolucion = $id;
        
        //$pac_hospitalizado = Hospitalizacion::where('idficha', $idficha)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();
        //$id_hospitalizacion= $pac_hospitalizado->id;

        $ficha = Ficha::where('id', $idficha)->Where('estado',1)->first();

        //Hospitalizacion
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $nro_lab = Laboratorio::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;

        $antecedente = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 
        
        $foto='';
        return view('admin.aislamientos.editar_evolucion')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id_paciente)->with('id_paciente', $id_paciente)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('foto',$foto)->with('evolucion',$evolucion)->with('id_evolucion',$id_evolucion)->with('archivos',$archivos)->with('count_diagnostico',$count_diagnostico)->with('establecimiento_salud',$establecimiento_salud)->with('establecimiento_actual',$establecimiento_actual)->with('id_hospitalizacion',$id_hospitalizacion)->with('ficha',$ficha)->with('nro_hosp',$nro_hosp)->with('nro_lab',$nro_lab)->with('conta_hospi',$conta_hospi)->with('idficha',$idficha)->with('existe_ficha_contacto',$existe_ficha_contacto);

  }

    public function eliminar_evolucion($id_evol, $id, $dni)
    {
        
        $evolucion_encontrado = Evolucion::where('id', $id_evol)->Where('estado',1)->first();
        
        if(is_object($evolucion_encontrado)){
            Flash::success('Se ha eliminado correctamente.');
            $evolucion_encontrado->estado=0; 
            $evolucion_encontrado->id_user_actualizacion=Auth::user()->id;
            $evolucion_encontrado->save();               
        }
        else{
            Flash::success('No se ha podido eliminar el registro, contacte con el administrador.');
        }

        return redirect('/listar_evolucion/'. $id.'/'.$dni);
    }

    public function ver_ficha($idficha, $dni, $id_paciente)
    {
        
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $antecedentes = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        

        $model_aislamientos= new Aislamiento();
        $dato_paciente = $model_aislamientos->getAislamientos($id_paciente,$dni);

        if(!empty($antecedentes)):
            $existe_ficha_contacto = $antecedentes->ficha_contacto; 
            $model_establecimientos= new Establecimiento();
            $model_establecimientos_salud= new EstablecimientoSalud();
            $establecimientos = $model_establecimientos->getTodosEstablecimientos();
            $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
            $model_sino= new Sino();
            $model_departamentos= new Departamento();
            $model_provincias= new Provincia();
            $model_distritos= new Distrito();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $model_diagnostico= new Diagnostico();
            $model_laboratorio= new Laboratorio();
            $Sintomas = $model_factor->getSintoma();
            $signos=Signo::orderby('descripcion','asc')->get();
            $conta_signos=count($signos);
            $sintomas=Sintoma::orderby('descripcion','asc')->get();
            $conta_sintomas=count($sintomas);
            $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
            $conta_factoriesgos=count($factorriesgos);
            $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
            $lugares=Lugare::orderby('descripcion','asc')->get();
            $model_sino= new Sino();
            $sinos = $model_sino->getSino();

            $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->Where('estado',1)->first();
            $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
            $departamentos2 = $model_departamentos->getDepartamento();
            $provincias2 = $model_provincias->getProvincia($antecedentes->id_departamento2);
            $distritos2 = $model_distritos->getDistrito($antecedentes->id_departamento2,$antecedentes->id_provincia2);
            $existe_antecedente= 'SI';
        else:
            $Sintomas = '';
            $signos='';
            $conta_signos=0;
            $sintomas='';
            $conta_sintomas=0;
            $factorriesgos='';
            $conta_factorriesgos=0;
            $ocupaciones='';
            $lugares='';
            $sinos = '';
            $departamentos2 = '';
            $provincias2 = '';
            $distritos2 = '';
            $existe_antecedente= 'NO'; 
            $existe_ficha_contacto ='NO';
        endif;
        
        $ficha = Ficha::where('id', $idficha)->Where('estado',1)->first();
        $model_fabricantes = new Fabricante();
        $fabricantes = $model_fabricantes->getFabricantes();

        
        //Hospitalizacion
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $nro_lab = Laboratorio::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        //$id_hospitalizacion = 0;

        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');        
        $model_diagnostico= new Diagnostico();
        $signos=Signo::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $model_hospitalizaciones= new Hospitalizacion();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $fecha_alta = $paciente->fecha_alta;

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        $pac_hospitalizado = Hospitalizacion::where('id', $id_hospitalizacion)->where('idficha', $idficha)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();

        if(is_object($pac_hospitalizado)){
            $iaas=$pac_hospitalizado->uci;
            $id_hospitalizacion =$pac_hospitalizado->id;
            $diagnostico = $model_diagnostico->GetDiagnosticoByHospitalizado($id_hospitalizacion,1);
            $count_diagnostico = count($diagnostico);
            $hospitalizaciones = $model_hospitalizaciones->getHospitalizacion($id_paciente,$dni);
            $count_hospitalizado = count($diagnostico);
            $existe_hospitalizacion= 'SI';
        }
        else{
            $diagnostico ='';
            $count_diagnostico =0;
            $hospitalizaciones='';
            $count_hospitalizado =0;
            $iaas='';
            $id_hospitalizacion=0;
            $existe_hospitalizacion= 'NO';
        }
        
        //Laboratorio
        $model_laboratorio = new Laboratorio();
        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id_paciente, $dni, $idficha);
        $count_laboratorio = count($laboratorio);
        $model_muestra = new Muestra();
        $muestras = $model_muestra->getMuestras();
        $model_prueba = new Prueba();
        $pruebas = $model_prueba->getPruebas();
        $model_resultado = new Resultado();
        $resultados = $model_resultado->getResultados(1);

        //Evolucion
        $model_evoluciones= new Evolucion();
        $evoluciones = $model_evoluciones->getEvolucion($dni, $idficha);

        //Contacto
        $model_contacto= new Contacto();
        $contactos = $model_contacto->getContactos($id_paciente,$dni, $idficha);


        return view('admin.aislamientos.ver_fichas')->with('fabricantes', $fabricantes)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('departamentos2', $departamentos2)->with('antecedentes', $antecedentes)->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('sinos', $sinos)->with('count_hospitalizado', $count_hospitalizado)->with('hospitalizaciones', $hospitalizaciones)->with('nro_hosp', $nro_hosp)->with('ficha', $ficha)->with('idficha', $idficha)->with('existe_antecedente', $existe_antecedente)->with('existe_hospitalizacion', $existe_hospitalizacion)->with('iaas', $iaas)->with('id_hospitalizacion', $id_hospitalizacion)->with('laboratorio', $laboratorio)->with('count_laboratorio', $count_laboratorio)->with('muestras', $muestras)->with('pruebas', $pruebas)->with('resultados', $resultados)->with('id_paciente_lab', $id_paciente)->with('evoluciones', $evoluciones)->with('contactos', $contactos)->with('dato_paciente', $dato_paciente)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    public function ver_fichas($idficha, $dni, $id_paciente)
    {
        
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $antecedentes = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        

        $model_aislamientos= new Aislamiento();
        $dato_paciente = $model_aislamientos->getAislamientos($id_paciente,$dni);

        if(!empty($antecedentes)):
            $existe_ficha_contacto = $antecedentes->ficha_contacto; 
            $model_establecimientos= new Establecimiento();
            $model_establecimientos_salud= new EstablecimientoSalud();
            $establecimientos = $model_establecimientos->getTodosEstablecimientos();
            $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
            $model_sino= new Sino();
            $model_departamentos= new Departamento();
            $model_provincias= new Provincia();
            $model_distritos= new Distrito();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $model_diagnostico= new Diagnostico();
            $model_laboratorio= new Laboratorio();
            $Sintomas = $model_factor->getSintoma();
            $signos=Signo::orderby('descripcion','asc')->get();
            $conta_signos=count($signos);
            $sintomas=Sintoma::orderby('descripcion','asc')->get();
            $conta_sintomas=count($sintomas);
            $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
            $conta_factoriesgos=count($factorriesgos);
            $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
            $lugares=Lugare::orderby('descripcion','asc')->get();
            $model_sino= new Sino();
            $sinos = $model_sino->getSino();

            $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->Where('estado',1)->first();
            $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
            $departamentos2 = $model_departamentos->getDepartamento();
            $provincias2 = $model_provincias->getProvincia($antecedentes->id_departamento2);
            $distritos2 = $model_distritos->getDistrito($antecedentes->id_departamento2,$antecedentes->id_provincia2);
            $existe_antecedente= 'SI';
        else:
            $Sintomas = '';
            $signos='';
            $conta_signos=0;
            $sintomas='';
            $conta_sintomas=0;
            $factorriesgos='';
            $conta_factorriesgos=0;
            $ocupaciones='';
            $lugares='';
            $sinos = '';
            $departamentos2 = '';
            $provincias2 = '';
            $distritos2 = '';
            $existe_antecedente= 'NO'; 
            $existe_ficha_contacto ='NO';
        endif;
        
        $ficha = Ficha::where('id', $idficha)->Where('estado',1)->first();
        $model_fabricantes = new Fabricante();
        $fabricantes = $model_fabricantes->getFabricantes();

        
        //Hospitalizacion
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $nro_lab = Laboratorio::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        //$id_hospitalizacion = 0;

        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');        
        $model_diagnostico= new Diagnostico();
        $signos=Signo::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $model_hospitalizaciones= new Hospitalizacion();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $fecha_alta = $paciente->fecha_alta;

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        $pac_hospitalizado = Hospitalizacion::where('id', $id_hospitalizacion)->where('idficha', $idficha)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();

        if(is_object($pac_hospitalizado)){
            $iaas=$pac_hospitalizado->uci;
            $id_hospitalizacion =$pac_hospitalizado->id;
            $diagnostico = $model_diagnostico->GetDiagnosticoByHospitalizado($id_hospitalizacion,1);
            $count_diagnostico = count($diagnostico);
            $hospitalizaciones = $model_hospitalizaciones->getHospitalizacion($id_paciente,$dni);
            $count_hospitalizado = count($diagnostico);
            $existe_hospitalizacion= 'SI';
        }
        else{
            $diagnostico ='';
            $count_diagnostico =0;
            $hospitalizaciones='';
            $count_hospitalizado =0;
            $iaas='';
            $id_hospitalizacion=0;
            $existe_hospitalizacion= 'NO';
        }
        
        //Laboratorio
        $model_laboratorio = new Laboratorio();
        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id_paciente, $dni, $idficha);
        $count_laboratorio = count($laboratorio);
        $model_muestra = new Muestra();
        $muestras = $model_muestra->getMuestras();
        $model_prueba = new Prueba();
        $pruebas = $model_prueba->getPruebas();
        $model_resultado = new Resultado();
        $resultados = $model_resultado->getResultados(1);

        //Evolucion
        $model_evoluciones= new Evolucion();
        $evoluciones = $model_evoluciones->getEvolucion($dni, $idficha);

        //Contacto
        $model_contacto= new Contacto();
        $contactos = $model_contacto->getContactos($id_paciente,$dni, $idficha);


        return view('admin.aislamientos.ver_ficha_comandancia')->with('fabricantes', $fabricantes)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('departamentos2', $departamentos2)->with('antecedentes', $antecedentes)->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('sinos', $sinos)->with('count_hospitalizado', $count_hospitalizado)->with('hospitalizaciones', $hospitalizaciones)->with('nro_hosp', $nro_hosp)->with('ficha', $ficha)->with('idficha', $idficha)->with('existe_antecedente', $existe_antecedente)->with('existe_hospitalizacion', $existe_hospitalizacion)->with('iaas', $iaas)->with('id_hospitalizacion', $id_hospitalizacion)->with('laboratorio', $laboratorio)->with('count_laboratorio', $count_laboratorio)->with('muestras', $muestras)->with('pruebas', $pruebas)->with('resultados', $resultados)->with('id_paciente_lab', $id_paciente)->with('evoluciones', $evoluciones)->with('contactos', $contactos)->with('dato_paciente', $dato_paciente)->with('existe_ficha_contacto', $existe_ficha_contacto);

    }

    public function cerrar_ficha($id_ficha, $id_paciente, $dni)
    {
        
        $ficha_encontrada = Ficha::where('id', $id_ficha)->Where('id_aislado',$id_paciente)->Where('dni',$dni)->Where('estado',1)->first();
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');

        if(is_object($ficha_encontrada)){
            Flash::success('Se ha cerrado la ficha correctamente.');
            $ficha_encontrada->estado=1;
            $ficha_encontrada->activo=2; 
            $ficha_encontrada->id_user_actualizacion=Auth::user()->id;
            $ficha_encontrada->fecha_cierre=$fecha_actual; 
            $ficha_encontrada->save();               
        }
        else{
            Flash::success('No se ha podido cerrar la ficha, contacte con el administrador.');
        }

        return redirect('/listar_fichas/'. $id_paciente.'/'.$dni);
    }

    public function eliminar_ficha($id_ficha, $dni, $id_paciente)
    {
        
        $ficha_encontrada = Ficha::where('id', $id_ficha)->Where('id_aislado',$id_paciente)->Where('dni',$dni)->Where('estado',1)->first();
        
        if(is_object($ficha_encontrada)){
            Flash::success('Se ha eliminado la ficha, y todo lo relacionado con ella correctamente.');
            $ficha_encontrada->estado=0;
            $ficha_encontrada->id_user_actualizacion=Auth::user()->id;
            $ficha_encontrada->save();

            $antecedentes = Antecedente::where('idficha', $id_ficha)->Where('dni',$dni)->Where('estado',1)->first();          
            if(is_object($antecedentes)){
                $antecedentes->estado=0;
                $antecedentes->save();
            }

            if($ficha_encontrada->hospitalizado=='SI'){
                $hospitalizaciones = Hospitalizacion::where('idficha', $id_ficha)->Where('dni_paciente',$dni)->Where('estado',1)->first();          
                if(is_object($hospitalizaciones)){
                    $hospitalizaciones->estado=0;
                    $hospitalizaciones->save();
                }

                if(is_object($evoluciones)){
                    $evoluciones = Evolucion::where('idficha', $id_ficha)->Where('dni',$dni)->Where('estado',1)->first();          
                    $evoluciones->estado=0;
                    $evoluciones->save();
                }

                $db_update=DB::table('archivos')
                        ->where('dni','=',$dni)
                        ->where('idficha','=',$id_ficha)
                        ->where('aislado_id','=',$id_paciente)
                        ->update(['estado' => 0]);
            }
            
            $laboratorios = Laboratorio::where('idficha', $id_ficha)->Where('dni_paciente',$dni)->Where('estado',1)->first();     
            if(is_object($laboratorios)){     
                $laboratorios->estado=0;
                $laboratorios->save();
            }

            if($antecedentes->ficha_contacto=='SI'){
                $contactos = Contacto::where('idficha', $id_ficha)->Where('dni_aislado',$dni)->Where('estado',1)->first();          
                if(is_object($contactos)){
                    $contactos->estado=0;
                    $contactos->save();
                }
            }
        }
        else{
            Flash::success('No se ha podido eliminar la ficha, contacte con el administrador.');
        }

        return redirect('/listar_fichas/'. $id_paciente.'/'.$dni);
    }

    public function editar_laboratorio($id, $dni, $idficha)
    {
        $date = Carbon::now();
        $fechaServidor = $date->format('d-m-Y'); 
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;

        $model_laboratorio = new Laboratorio();
        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni, $idficha);
        $count_laboratorio = count($laboratorio);

        $model_muestra = new Muestra();
        $muestras = $model_muestra->getMuestras();

        $model_prueba = new Prueba();
        $pruebas = $model_prueba->getPruebas();

        $model_resultado = new Resultado();
        $resultados = $model_resultado->getResultados(1);

        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $antecedente = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedente->ficha_contacto; 

        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $nro_lab = Laboratorio::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($nro_hosp>0):
            $pac_hospitalizado = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $pac_hospitalizado->id;
        else:
            $id_hospitalizacion = 0;
        endif;

        $nro_contacto = Contacto::where('idficha', $idficha)->Where('id_aislado',$id)->Where('dni_aislado',$dni)->Where('estado',1)->count();
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $foto='';
        return view('admin.aislamientos.editar_laboratorio')->with('fechaServidor', $fechaServidor)->with('aislamientos', $aislamientos)->with('paciente', $paciente)->with('id_paciente_lab',$id)->with('laboratorio',$laboratorio)->with('count_laboratorio',$count_laboratorio)->with('id',$id)->with('dni',$dni)->with('nombre_paciente',$nombre_paciente)->with('foto',$foto)->with('muestras',$muestras)->with('pruebas',$pruebas)->with('resultados',$resultados)->with('idficha',$idficha)->with('ficha',$ficha)->with('nro_hosp',$nro_hosp)->with('id_hospitalizacion',$id_hospitalizacion)->with('existe_ficha_contacto',$existe_ficha_contacto)->with('nro_lab',$nro_lab)->with('nro_contacto',$nro_contacto);

    }

    public function eliminar_laboratorio($id_lab, $id, $dni, $idficha)
    {
        
        $laboratorio_encontrado = Laboratorio::where('id', $id_lab)->Where('estado',1)->first();
        
        if(is_object($laboratorio_encontrado)){
            Flash::success('Se ha eliminado correctamente.');
            $laboratorio_encontrado->estado=0; 
            $laboratorio_encontrado->id_user_actualizacion=Auth::user()->id;
            $laboratorio_encontrado->save();               
        }
        else{
            Flash::success('No se ha podido eliminar el registro, contacte con el administrador.');
        }

        return redirect('/registro_laboratorio_paciente/'. $id.'/'.$dni.'/'.$idficha);
    }

    public function cargarresultados($id)
    {
        $model_resultados= new Resultado();
        $resultado = $model_resultados->getResultados($id);

        return $resultado;

    }

    public function listar_contacto($id, $dni, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_contacto = new Contacto();
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        $contactos = $model_contacto->getContactos($id,$dni, $idficha);

        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;

        /** foto **/
        //$foto=$this->buscar_foto($dni);
        $antecedentes = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedentes->ficha_contacto; 
        $foto='';
        return view('admin.aislamientos.listar_contacto')->with('contactos',$contactos)->with('foto',$foto)->with('paciente', $paciente)->with('nombre_paciente',$nombre_paciente)->with('id',$id)->with('dni',$dni)->with('idficha',$idficha)->with('ficha',$ficha)->with('nro_hosp',$nro_hosp)->with('id_hospitalizacion',$id_hospitalizacion)->with('existe_ficha_contacto',$existe_ficha_contacto);
    }

public function create_contacto($id, $dni, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        $contacto = new Contacto();
        $model_departamentos = new Departamento();
        $departamentos3 = $model_departamentos->getDepartamento();
        $model_provincias = new Provincia();
        $model_distritos = new Distrito();
        $provincias3 = $model_provincias->getProvincia(1);
        $distritos3 = $model_distritos->getDistrito(1,1); 
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        
            $dni_contacto="";
            $name_contacto="";
            $paterno_contacto="";
            $materno_contacto="";
            $sexo_contacto='0';
            $fecha_nacimiento_contacto="";
            $correo_contacto="";
            $telefono_contacto="";
            $domicilio_contacto="";
            $id_departamento_contacto=0;
            $id_provincia_contacto =0;
            $id_distrito_contacto=0;
            $tipo_contacto=0;
            $fecha_contacto=$date->format('Y-m-d'); 
            $fecha_cuarentena_contacto=''; 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso ="";
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;

            $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        
        $foto='';

        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        $antecedentes = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedentes->ficha_contacto; 

        return view('admin.aislamientos.editar_contacto')->with('dni', $dni)->with('id', $id)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('contacto',$contacto)->with('foto',$foto)->with('paciente',$paciente)->with('sinos',$sinos)->with('factorriesgos',$factorriesgos)->with('idficha',$idficha)->with('ficha',$ficha)->with('nro_hosp',$nro_hosp)->with('id_hospitalizacion',$id_hospitalizacion)->with('existe_ficha_contacto',$existe_ficha_contacto);
    }


public function editar_contacto($id, $dni, $id_paciente, $idficha)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $model_departamentos = new Departamento();
        $model_provincias = new Provincia();
        $model_distritos = new Distrito();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        
        
        
        $contacto = Contacto::where('id_aislado', $id_paciente)->Where('dni_aislado',$dni)->first();

        if(is_object($contacto)){
            $departamentos3 = $model_departamentos->getDepartamento();
            $provincias3 = $model_provincias->getProvincia($contacto->id_departamento_contacto);
            $distritos3 = $model_distritos->getDistrito($contacto->id_departamento_contacto,$contacto->id_provincia_contacto);    
        }
        else
        {
            $contacto = new Contacto();
            $departamentos3 = $model_departamentos->getDepartamento();
             $provincias3 = $model_provincias->getProvincia(1);
            $distritos3 = $model_distritos->getDistrito(1,1); 
        }
        
        $pac_contacto = Contacto::where('id_aislado', $id_paciente)->Where('dni_aislado',$dni)->first();

        if(is_object($pac_contacto)){
            $dni_contacto=$pac_contacto->dni_contacto;
            $name_contacto=$pac_contacto->nombres_contacto;
            $paterno_contacto=$pac_contacto->paterno_contacto;
            $materno_contacto=$pac_contacto->materno_contacto;
            $sexo_contacto=$pac_contacto->sexo_contacto;
            $fecha_nacimiento_contacto=$pac_contacto->fecha_nacimiento_contacto;
            $correo_contacto=$pac_contacto->correo_contacto;
            $telefono_contacto=$pac_contacto->telefono_contacto;
            $domicilio_contacto=$pac_contacto->domicilio_contacto;
            $departamentos3 = $model_departamentos->getDepartamento();
            $provincias3 = $model_provincias->getProvincia($pac_contacto->id_departamento_contacto);
            $distritos3 = $model_distritos->getDistrito($pac_contacto->id_departamento_contacto,$pac_contacto->id_provincia_contacto);
            $id_departamento_contacto=$pac_contacto->id_departamento_contacto;
            $id_provincia_contacto =$pac_contacto->id_provincia_contacto;
            $id_distrito_contacto=$pac_contacto->id_distrito_contacto;
            
            $tipo_contacto =$pac_contacto->tipo_contacto;
            $fecha_contacto =$pac_contacto->fecha_contacto;
            $fecha_cuarentena_contacto =$pac_contacto->fecha_cuarentena_contacto;
            $contacto_sospechoso =$pac_contacto->contacto_sospechoso;
            $tipo_contacto_sospechoso =$pac_contacto->tipo_contacto_sospechoso;
            $otro_factor_riesgo_contacto =$pac_contacto->otro_factor_riesgo_contacto;
            $id_contacto =$pac_contacto->id;
            $id_paciente_lab =$id;
        }
        else
        {
            $dni_contacto="";
            $name_contacto="";
            $paterno_contacto="";
            $materno_contacto="";
            $sexo_contacto='0';
            $fecha_nacimiento_contacto="";
            $correo_contacto="";
            $telefono_contacto="";
            $domicilio_contacto="";
            $id_departamento_contacto=0;
            $id_provincia_contacto =0;
            $id_distrito_contacto=0;
            $tipo_contacto=0;
            $fecha_contacto=$date->format('Y-m-d'); 
            $fecha_cuarentena_contacto=''; 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso =0;
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;
        }

            $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        
        
        /** foto **/
        //$foto=$this->buscar_foto($dni);
        $nro_hosp = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        $ficha = Ficha::where('id', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        
        $conta_hospi = Hospitalizacion::where('idficha', $idficha)->Where('id_paciente',$id)->Where('dni_paciente',$dni)->Where('estado',1)->count();
        if($conta_hospi>0):
            $hospi = Hospitalizacion::where('idficha', $id_ficha)->Where('id_paciente',$id_paciente)->Where('dni_paciente',$dni)->Where('estado',1)->first();
            $id_hospitalizacion = $hospi->id;
        else:
            $id_hospitalizacion = 0;
        endif;
        
        $antecedentes = Antecedente::where('idficha', $idficha)->Where('dni',$dni)->Where('estado',1)->first();
        $existe_ficha_contacto = $antecedentes->ficha_contacto; 

        $foto='';
        return view('admin.aislamientos.editar_contacto')->with('dni', $dni)->with('id', $id_paciente)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('contacto',$contacto)->with('foto',$foto)->with('sinos',$sinos)->with('factorriesgos',$factorriesgos)->with('paciente',$paciente)->with('nombre_paciente',$nombre_paciente)->with('idficha',$idficha)->with('ficha',$ficha)->with('nro_hosp',$nro_hosp)->with('id_hospitalizacion',$id_hospitalizacion)->with('existe_ficha_contacto',$existe_ficha_contacto);
    }

    


    public function store_laboratorio(Request $request)
    {        
        

        $laboratorio = new Laboratorio();    
        
        $laboratorio->id_paciente=$request->id_paciente_lab;
        $laboratorio->dni_paciente=$request->dni_lab;
        $laboratorio->fecha_muestra=$request->fecha_muestra;
        $laboratorio->tipo_muestra=$request->muestra;
        $laboratorio->tipo_prueba=$request->prueba;
        $laboratorio->resultado_muestra=$request->resultado;
        $laboratorio->fecha_resultado=$request->fecha_resultado;
        $laboratorio->enviado_minsa=$request->minsa;

        $laboratorio->sg=$request->sg;
        $laboratorio->linaje=$request->linaje;
        $laboratorio->tomografia=$request->tomografia;
        $laboratorio->radiografia=$request->radiografia;
        $laboratorio->idficha=$request->id_ficha;
        $laboratorio->save();

        $paciente = Aislamiento::where('id',  $request->id_paciente_lab)->Where('dni',$request->dni_lab)->first();
        $paciente->laboratorio = 'SI';
        $paciente->save();
        
        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/registro_laboratorio_paciente/'. $request->id_paciente_lab.'/'.$request->dni_lab.'/'.$request->id_ficha);
    }

    public function store_contacto(Request $request)
    {        
        $sw = 0;

        if($request->id_contacto==0){
            $contacto = new Contacto;    
        }
        else{
            $contacto = Contacto::where('id', $request->id_contacto)->where('id_aislado', $request->id_paciente_contacto)->Where('dni_aislado',$request->dni_paciente_contacto)->first();      
            $sw = 1;
        }
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $nombres = trim($request->name_contacto);
        $apellido_paterno = trim($request->paterno_contacto);
        $apellido_materno = trim($request->materno_contacto);
        $contacto->dni_aislado = $request->dni_paciente_contacto;
        $contacto->id_aislado = $request->id_paciente_contacto;
        $contacto->fecha_registro=$fecha_registro;
        $contacto->dni_contacto = $request->dni_contacto;
        $contacto->nombres_contacto=$nombres;
        $contacto->paterno_contacto=$apellido_paterno;
        $contacto->materno_contacto=$apellido_materno;
        $contacto->sexo_contacto=$request->sexo_contacto;
        $contacto->fecha_nacimiento_contacto=$request->fecha_nacimiento_contacto;
        $contacto->telefono_contacto=$request->telefono_contacto;
        $contacto->domicilio_contacto=$request->domicilio_contacto;
        $contacto->correo_contacto=$request->correo_contacto;
        $contacto->id_departamento_contacto=$request->id_departamento_contacto;
        $contacto->id_provincia_contacto=$request->id_provincia_contacto;
        $contacto->id_distrito_contacto=$request->id_distrito_contacto;
        $contacto->tipo_contacto=$request->tipo_contacto;
        $contacto->fecha_contacto=$request->fecha_contacto;
        $contacto->fecha_cuarentena_contacto=$request->fecha_cuarentena_contacto;
        $contacto->contacto_sospechoso=$request->contacto_sospechoso;
        $contacto->fecha_cuarentena_contacto=$request->fecha_cuarentena_contacto;
        $contacto->otro_factor_riesgo_contacto=$request->otro_factor_riesgo_contacto;
        $contacto->idficha=$request->idficha;
        $contacto->save();

        $paciente = Aislamiento::where('id',  $request->id_paciente_contacto)->Where('dni',$request->dni_paciente_contacto)->first();
        $paciente->contacto = 'SI';
        $paciente->save();
        

        if($sw == 0 ){
            $contacto->factorcontactos()->attach($request->factorriesgos_contacto);
        }
        else
        {
            $num_items=DB::table('contacto_factor_riesgo')->where('contacto_id',$request->id_contacto)->count();

            //Sino se ha marcado ningun checkbox
            if (empty($request->factorriesgos_contacto)) {
               if($num_items>0){
                    $elimina_bd=DB::table('contacto_factor_riesgo')->where('contacto_id',$request->id_contacto)->delete();
               }
            }else
            {
                //si esta vacio llenamos
                if($num_items==0){
                    $contacto->factorcontactos()->attach($request->factorriesgos_contacto); 
                }
                else
                {
                    $datos_bd=DB::table('contacto_factor_riesgo')->where('contacto_id',$request->id_contacto)->get();
                    //checkbox desmarcados
                    //$medicamentos_desmarcado=$medicamentos_bd->pluck('petitorio_id')->diff($checkboxs);
                    $datos_desmarcado=$datos_bd->pluck('factor_riesgo_id')->diff($request->factorriesgos_contacto);
                    $num_datos_desmarcado=count($datos_bd->pluck('factor_riesgo_id')->diff($request->factorriesgos_contacto));

                    //convertimos a arreglo
                    $arreglo = $datos_bd->pluck('factor_riesgo_id')->toArray();

                    //los nuevos checkbox
                    $num_datos_nuevos=count(array_diff($request->factorriesgos_contacto,$arreglo));
                    $datos_nuevos=array_diff($request->factorriesgos_contacto,$arreglo);

                    ///Insertamos los nuevos           
                    if($num_datos_nuevos>0){
                        //$aislamiento->petitorios()->attach($medicamentos_nuevos); //attach 
                        $contacto->factorcontactos()->attach($datos_nuevos); //attach  
                    }
                    ///eliminamos los que no estan en los checkbox
                    if($num_datos_desmarcado>0){
                        $contacto->factorcontactos()->detach($datos_desmarcado); //attach           
                    }
                }
            }
        }
        
        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/listar_contacto/'. $request->id_paciente_contacto.'/'.$request->dni_paciente_contacto.'/'.$request->idficha);
    }


    public function update_riesgo(Request $request,$idaislamiento,$dni,$id_riesgo)
    {           

        $aislamiento = $this->aislamientoRepository->findWithoutFail($idaislamiento);
        $users = DB::table('aislados')->where('dni',$dni)->where('id',$idaislamiento)->get();

        $dni_medico=Auth::user()->dni;
        $nombre_medico=Auth::user()->name;
        $telefono=Auth::user()->telefono;

        /***********************************/
        $riesgos_bd=DB::table('aislamiento_factor_riesgo')
                                ->where('aislamiento_id',$idaislamiento)                                
                                ->get();
        
        $x=1;
        foreach($riesgos_bd as $fr){
            $factor = DB::table('sintomas')->where('id',$fr->factor_riesgo_id)->get();
            if($x==1){
                $inserta_factor_anterior=$factor->get(0)->descripcion.', ';
            }
            else
            {
                $inserta_factor_anterior.=$factor->get(0)->descripcion.', ';   
            }
            $x++;
        }
            
        /***********************************/
        //checkbox desmarcados
        $riesgos_desmarcado=$riesgos_bd->pluck('factor_riesgo_id')->diff($request->id_factor);
        $num_riesgos_desmarcado=count($riesgos_desmarcado);

        //convertimos a arreglo
        $arreglo = $riesgos_bd->pluck('factor_riesgo_id')->toArray();

        //los nuevos checkbox
        $num_riesgos_nuevos=count(array_diff($request->id_factor,$arreglo));
        $riesgos_nuevos=array_diff($request->id_factor,$arreglo);

        ///Insertamos los nuevos           
        if($num_riesgos_nuevos>0){
            $aislamiento->factoraislados()->attach($riesgos_nuevos); //attach
        }
        ///eliminamos los que no estan en los checkbox
        if($num_riesgos_desmarcado>0){            
            $aislamiento->factoraislados()->detach($riesgos_desmarcado); //attach           
        }

        /***********************************/
        $riesgos_bd2=DB::table('aislamiento_factor_riesgo')
                                ->where('aislamiento_id',$idaislamiento)                                
                                ->get();

        $x=1;
        foreach($riesgos_bd2 as $fr2){
            $factory = DB::table('sintomas')->where('id',$fr2->factor_riesgo_id)->get();
            if($x==1){
                $inserta_factor_actual=$factory->get(0)->descripcion.', ';

            }
            else
            {
                $inserta_factor_actual.=$factory->get(0)->descripcion.', ';   
            }
            $x++;
        }        

        
        
        DB::table('derivados')
            ->insert([                    
                    'dni' => $dni_medico,
                    'nombre_medico' => $nombre_medico,
                    'celular'=>$telefono,
                    'factor_anterior'=> $inserta_factor_anterior,
                    'factor_actual'=> $inserta_factor_actual,
                    'dni_paciente' => $users->get(0)->dni,
                    'idaislado' => $users->get(0)->id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
        ]);

        DB::table('aislados')
            ->where('dni','=',$dni)
            ->where('id','=',$idaislamiento)
            ->update([                
                'estado' => 2
        ]);
        
        Flash::success('Se derivo, satisfactoriamente');
        return redirect('/todos_registros/'.$id_riesgo);
                
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
    }

    

    public function destroy($id)
    {
    }

    public function carganroaislamiento($id) {
        $model = new Aislamiento();
        $numero = $model->GetByNroAislamiento($id);
        
        return $numero;
    }

    public function buscar_personal_dni($nro_doc, $tipo_doc) {
        
        $beneficiario=DB::connection('pgsql2')
                    ->table('beneficiarios')
                    ->select('beneficiarios.*')
                    ->where('nrodocafiliado',$nro_doc)
                    ->where('nomtipdocafiliado',$tipo_doc)
                    ->get();
        
        return $beneficiario;
    }   

    public function pdf_aislamiento($id_aislamiento)
    {
        $establecimiento_id=Auth::user()->establecimiento_id;

        $aislamientos = Aislamiento::find($id_aislamiento);

        if (empty($aislamientos)) {
            Flash::error('Aislado no encontrado');
            return redirect(route('aislamientos.index'));
        }
        
        $pdf = \PDF::loadView('admin.pdf.descargar_aislamiento_pdf',['aislamientos'=>$aislamientos]);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('aislamiento.pdf');        
    } 

    public function todos_registros($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');

        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        
        if($rol==1):
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado);
            return view('admin.aislamientos.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        else:
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni_beneficiario);
            return view('admin.aislamientos.all_aislamientos_responsables', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        endif;    
    }

    public function reporte_todos_registros($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');

        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        
        if($rol==3):
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado);
            return view('admin.aislamientos.all_aislamientos_comandancia', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        endif;    
    }

    public function listar_reportes_aislamientos(Request $request) {

        
        $date = Carbon::now();
        $rol=Auth::user()->rol;        
        
        if (is_null($request->dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($request->dni_beneficiario);

        if (is_null($request->fechaDesde))
            $fechaDesde="";
        else
            $fechaDesde=$request->fechaDesde;
        
        if (is_null($request->fechaHasta))
            $fechaHasta="";
        else
            $fechaHasta=$request->fechaHasta;

        if (is_null($request->departamento))
            $id_departamento="";
        else
            $id_departamento=$request->departamento;

        if (is_null($request->provincia))
            $provincia="";
        else
            $provincia=$request->provincia;

        if (is_null($request->distrito))
            $distrito="";
        else
            $distrito=$request->distrito;

        
        $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
        $fechaDesde = date('d-m-Y', strtotime($fechaDesde));

        $date = Carbon::now();

        $model_aislamientos= new Aislamiento();

        $id_establecimiento = Auth::user()->establecimiento_id;

        //dd($request);

        $estado = 3;
       
        if($rol==3){
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $id_departamento);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos_comandancia', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'departamentos','Sintomas','id_departamento', 'provincia', 'distrito'));
        }
    }

    public function reporte_todos_registros_hospitalizacion($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = 3;
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaHasta = $date->format('d-m-Y');
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        
        if($rol==3):
            //====================
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario);
            return view('admin.aislamientos.all_aislamientos_hospitalizacion_comandancia', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        endif;

        
    }

    public function reporte_listar_aislamientos_hospitalizacion(Request $request) {

        $date = Carbon::now();
        $rol=Auth::user()->rol;        
        
        if (is_null($request->dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($request->dni_beneficiario);

        if (is_null($request->fechaDesde))
            $fechaDesde="";
        else
            $fechaDesde=$request->fechaDesde;
        
        if (is_null($request->fechaHasta))
            $fechaHasta="";
        else
            $fechaHasta=$request->fechaHasta;

        if (is_null($request->departamento))
            $departamento="";
        else
            $departamento=$request->departamento;

        if (is_null($request->provincia))
            $provincia="";
        else
            $provincia=$request->provincia;

        if (is_null($request->distrito))
            $distrito="";
        else
            $distrito=$request->distrito;

        
        $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
        $fechaDesde = date('d-m-Y', strtotime($fechaDesde));
        $date = Carbon::now();
        $model_aislamientos= new Aislamiento();
        $id_establecimiento = Auth::user()->establecimiento_id;
        $estado = 3;
       
        if($rol==3){
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $departamento);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos_hospitalizacion_comandancia', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'departamentos','Sintomas'));
        }
    }

    public function todos_registros_hospitalizacion($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = 3;
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaHasta = $date->format('d-m-Y');
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        
        if($rol==1):
            //====================
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario);
            return view('admin.aislamientos.all_aislamientos_hospitalizacion', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        else:
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni_beneficiario);
            return view('admin.aislamientos.all_aislamientos_hospitalizacion_responsable', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        endif;

        
    }

    public function listar_aislamientos(Request $request) {

        
        $date = Carbon::now();
        $rol=Auth::user()->rol;        
        
        if (is_null($request->dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($request->dni_beneficiario);

        if (is_null($request->fechaDesde))
            $fechaDesde="";
        else
            $fechaDesde=$request->fechaDesde;
        
        if (is_null($request->fechaHasta))
            $fechaHasta="";
        else
            $fechaHasta=$request->fechaHasta;

        if (is_null($request->departamento))
            $id_departamento="";
        else
            $id_departamento=$request->departamento;

        if (is_null($request->provincia))
            $provincia="";
        else
            $provincia=$request->provincia;

        if (is_null($request->distrito))
            $distrito="";
        else
            $distrito=$request->distrito;

        
        $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
        $fechaDesde = date('d-m-Y', strtotime($fechaDesde));

        $date = Carbon::now();

        $model_aislamientos= new Aislamiento();

        $id_establecimiento = Auth::user()->establecimiento_id;

        //dd($request);

        $estado = 3;
       
        if($rol==1){
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $id_departamento);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'departamentos','Sintomas','id_departamento', 'provincia', 'distrito'));
        }
        else
        {
            
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni_beneficiario);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            return view('admin.aislamientos.all_aislamientos_responsables', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos', 'provincia', 'distrito'));

        }
    }

    public function listar_aislamientos_hospitalizacion(Request $request) {

        $date = Carbon::now();
        $rol=Auth::user()->rol;        
        
        if (is_null($request->dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($request->dni_beneficiario);

        if (is_null($request->fechaDesde))
            $fechaDesde="";
        else
            $fechaDesde=$request->fechaDesde;
        
        if (is_null($request->fechaHasta))
            $fechaHasta="";
        else
            $fechaHasta=$request->fechaHasta;

        if (is_null($request->departamento))
            $departamento="";
        else
            $departamento=$request->departamento;

        if (is_null($request->provincia))
            $provincia="";
        else
            $provincia=$request->provincia;

        if (is_null($request->distrito))
            $distrito="";
        else
            $distrito=$request->distrito;

        
        $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
        $fechaDesde = date('d-m-Y', strtotime($fechaDesde));
        $date = Carbon::now();
        $model_aislamientos= new Aislamiento();
        $id_establecimiento = Auth::user()->establecimiento_id;
        $estado = 3;
       
        if($rol==1){
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $departamento);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos_hospitalizacion', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'departamentos','Sintomas'));
        }
        else
        {
            //====================
            $model_aislamientos = new Aislamiento();
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni_beneficiario);

            return view('admin.aislamientos.all_aislamientos_hospitalizacion_responsable', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        }
    }

    
    public function derivar_personal_aislado($idaislado, $dni) {        

        //$model_aislamientos = new Aislamiento();
        //$aislamientos= $model_aislamientos->getAislamientos($idaislado,$dni);
        $aislamientos = Aislamiento::find($idaislado);

        if (empty($aislamientos)) {
                Flash::error('Personal PNP no encontrado o no registrado');
                return redirect(route('aislamientosite.index'));
        }

        $fecha_registro=$aislamientos->fecha_registro;
        $dni=$aislamientos->dni;
        $cip=$aislamientos->cip;
        $nombres=$aislamientos->nombres;
        $apellido_paterno=$aislamientos->apellido_paterno;
        $apellido_materno=$aislamientos->apellido_materno;  
        $grado=$aislamientos->grado;        
        $riesgos=$aislamientos->id_factor;
        //$model_factor= new Sintoma();
        //$Sintomas = $model_factor->getSintoma();
        $Sintomas=Sintoma::orderby('descripcion','asc')->get();
        //dd($Sintomas);
        $derivados = DB::table('derivados')->where('dni_paciente',$dni)->where('idaislado',$idaislado)->get();
        

        return view('admin.aislamientos.derivar', compact('fecha_registro', 'dni','cip','nombres','apellido_paterno','apellido_materno','grado','riesgos','Sintomas','aislamientos','derivados'));
        
    }

    public function invalidar_aislamiento(Request $request) {        

        $id_establecimiento = $request->id_establecimiento;
        $nro_aislamiento = $request->nro_aislamiento;
        $id_user = $request->id_user;
        $id_aislamiento = $request->id_aislamiento;

        $user = User::where('id', $id_user)->first();
        $name = $user->nombres.' '.$user->apellido_paterno.' '.$user->apellido_materno;

        $aislamientos = Aislamiento::where('id', $id_aislamiento)->first();

        //----------------------------------------------------------------------
        $date = Carbon::now();
        $fecha = $date->format('d-m-Y');
        $aislamientos->fecha_eliminacion = $fecha;        
        $aislamientos->usuario_invalidador = $name ;
        $aislamientos->motivo = $request->motivo;        
        $aislamientos->estado = 0;
        $aislamientos->save();       
        
        
        
        Flash::success('Aislamientos anulada.');
        return redirect('/ver_aislamiento/' . $id_user . '/' . $nro_aislamiento . '/' . $id_aislamiento);
    }

    public function ver_aislamiento($id_user, $nro_aislamiento, $id_aislamiento) {

        
        $user = User::where('id', $id_user)->first();
        $id_establecimiento = $user->establecimiento_id;
        //--------------------------------------------
        $model_aislamientos = new Aislamiento;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');
        //--------------------------------------------
        //$aislamientos = $model_aislamientos->ShowByNroAislamientoAndId_ipress($nro_aislamiento, $id_establecimiento , $id_aislamiento);
        $aislamientos = $model_aislamientos->ShowByNroAislamientoAndId_ipress2($nro_aislamiento, $id_aislamiento);
        //---------------------------------------------------------------------            
        return view('admin.aislamientos.mostrar', compact('aislamientos', 'fecha_actual'));
    }

    public function ver_paciente_atendida($idaislamiento, $dni)
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);
        
        $model_aislamientos = new Aislamiento();
        $aislamientos= $model_aislamientos->getAislamientos($idaislamiento,$dni);


        if (empty($aislamientos)) {
                Flash::error('Personal PNP no encontrado o no registrado');
                return redirect(route('aislamientosite.index'));
        }

        $fecha_registro=$aislamientos->fecha_registro;
        $dni=$aislamientos->dni;
        $cip=$aislamientos->cip;
        $nombres=$aislamientos->nombres;
        $apellido_paterno=$aislamientos->apellido_paterno;
        $apellido_materno=$aislamientos->apellido_materno;
        $sexo=$aislamientos->sexo;
        if($sexo=='M'):
            $sexo='MASCULINO';
        else:
            $sexo='FEMENINO';
        endif;
        $fecha_nacimiento=$aislamientos->fecha_nacimiento;
        $grado=$aislamientos->grado;
        $email=$aislamientos->email;
        $celular=$aislamientos->celular;
        $domicilio=$aislamientos->domicilio;
        $nombre_dpto=$aislamientos->nombre_dpto;
        $nombre_prov=$aislamientos->nombre_prov;
        $nombre_dist=$aislamientos->nombre_dist;
        $categoriapnp=$aislamientos->descripcion;
        //$riesgos=$aislamientos->riesgos;
        $riesgos = DB::table('aislados')
                    ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                    ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                    ->where('aislamiento_factor_riesgo.aislamiento_id',$idaislamiento)                    
                    ->get();
        $edad=$aislamientos->edad;
        $cip=$aislamientos->cip;
        $fecha_aislamiento=$aislamientos->fecha_aislamiento;
        $reincorporacion=$aislamientos->reincorporacion;
        $dj=$aislamientos->dj;
        if($dj==1):
            $dj='SI';
        else:
            $dj='NO';
        endif;
        $atencion=$aislamientos->atencion;
        if($atencion==1):
            $atencion='SI';
        else:
            $atencion='NO';
        endif;
        $trabajo_remoto=$aislamientos->trabajo_remoto;
        if($trabajo_remoto==1):
            $trabajo_remoto='SI';
        else:
            $trabajo_remoto='NO';
        endif;

        $informes_medicos= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $contar_im= count($informes_medicos);
        

        $certificado_medicos= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $contar_cm= count($certificado_medicos);

        $examen_laboratorio= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',3)
                    ->get();

        $contar_el= count($examen_laboratorio);

        $examen_imagen= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',4)
                    ->get();

        $contar_ei= count($examen_imagen);

        $informe_procedimiento= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('tipo_archivo',5)
                    ->where('estado',1)
                    ->get();

        $contar_ip= count($informe_procedimiento);

        $recetas_vales= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',6)
                    ->get();

        $contar_rv= count($recetas_vales);
        
        return view('admin.aislamientos.mostrar', compact('fecha_registro','idaislamiento',  'dni', 'cip', 'nombres', 'apellido_paterno','apellido_materno','sexo','fecha_nacimiento','grado','email','celular','domicilio','nombre_dpto','categoriapnp','riesgos','fecha_aislamiento','reincorporacion','dj','atencion','trabajo_remoto','nombre_prov','nombre_dist','informes_medicos','certificado_medicos','examen_laboratorio','examen_imagen','informe_procedimiento','recetas_vales','idaislamiento','contar_im','contar_cm','contar_el','contar_ei','contar_ip','contar_rv','edad','cip','idaislamiento'));    

    
    }

    public function solucionar_expedientes($id_aislado = 0,$dni = "") {

        
        $model_aislamientos = new Aislamiento();
        $aislamientos= $model_aislamientos->getAislamientos($id_aislado,$dni);


        if (empty($aislamientos)) {
                Flash::error('Personal PNP no encontrado o no registrado');
                return redirect(route('aislamientosite.index'));
        }

        $fecha_registro=$aislamientos->fecha_registro;        
        $cip=$aislamientos->cip;
        $nombres=$aislamientos->nombres;
        $apellido_paterno=$aislamientos->apellido_paterno;
        $apellido_materno=$aislamientos->apellido_materno;
        $sexo=$aislamientos->sexo;
        if($sexo=='M'):
            $sexo='MASCULINO';
        else:
            $sexo='FEMENINO';
        endif;
        $estado=$aislamientos->estado;
        $id_factor=$aislamientos->id_factor;
        //$factor_riesgo=$aislamientos->riesgos;
        $celular=$aislamientos->celular;

//        $mostrar_fr=Sintoma::orderby('descripcion','asc')->get();

        $mostrar_fr = DB::table('aislados')
                    ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                    ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                    ->where('aislamiento_factor_riesgo.aislamiento_id',$id_aislado)                    
                    ->get();
        
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');

        if ($estado == 1 || $estado == 2):                
            return view('admin.soluciones.nueva_solucion', compact('dni', 'id_aislado','nombres','apellido_paterno','apellido_materno','sexo','estado','id_factor','fechaServidor','fecha_registro','celular','mostrar_fr'));
        else:

            $model_soluciones = new Solucione;
            $soluciones = $model_soluciones->ShowByNroSolucionAndId_ipressValida($id_aislado,$dni);
            $solucion = $model_soluciones->GetIdSolucionByNroSolucionValida($id_aislado,$dni);

            $id_solucion = $solucion->id;

            return view('admin.soluciones.editar_solucion', compact('soluciones','fechaServidor','id_solucion'));
        endif;
    }

    public function subir_archivo(Request $request,$dni,$idaislamiento,$id_informe)
    {
        $input = $request->all();
        
        if ($request->hasFile('photo')){
            $name_photo = time().'-'.$request->photo->getClientOriginalName();
            $original_name=$request->photo->getClientOriginalName();

            $input['photo'] = '/upload/archivos/'.$dni.'/'.$name_photo;            
            $request->photo->move(public_path('/upload/archivos/'.$dni.'/'), $input['photo']);
            $extension_archivo= $request->photo->getClientOriginalExtension();
        }

        $model_informe= new InformeRiesgo();
        $informeriesgos = $model_informe->getInforme($id_informe);

        $descripcion=$informeriesgos->descripcion;

        DB::table('archivos')
            ->insert([
                'dni' => $dni,
                'aislado_id' => $idaislamiento,                
                'nombre_archivo'=>$original_name,
                'fecha_archivo'=>$fecha_archivo,                
                'descarga_archivo'=>$input['photo'],
                'descripcion_archivo'=>$descripcion,
                'extension_archivo'=>$extension_archivo,
                'tipo_archivo'=>$id_informe,
                'created_at'=>Carbon::now(),
        ]);
        
        return redirect('/mostrar_archivos/' . $idaislamiento. '/' .$dni);        
    }

    public function eliminar_archivo($id,$idaislamiento,$dni)
    {
             
        DB::table('archivos')
            ->where('id','=',$id)
            ->where('dni','=',$dni)
            ->where('aislado_id','=',$idaislamiento)
            ->update([
                'estado' => 0                
        ]);

        Flash::success('Se elimino, satisfactoriamente');        
        
        return redirect('/mostrar_archivos/' . $idaislamiento. '/' .$dni);
                
    }


    public function reporte_general($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        //$fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');

        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;

        //$fechaHasta = $date->format('d-m-Y');

        //$fechaDesde = $date->subMonth(1)->format('d-m-Y');;
        
        if($rol==2){
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni_beneficiario);
            $establecimiento_id = Auth::user()->establecimiento_id;
        }
        else{
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado);  
            $establecimiento_id = 0;
        }

        

        $esposa = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'ESPOSA');
        
        $esposo = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'ESPOSO');
        
        $ex_conyugue = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'EX-CONYUGE');

        $otro = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SR');
        
        $hija = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'HIJA'); 
        
        $hijo = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'HIJO'); 
        
        $padre = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'PADRE'); 
        
        $madre = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'MADRE'); 
        
        $titular = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'TITULAR');
        
        
        $M = $model_aislamientos->ShowDataPacientesBySexo($fechaDesde1, $fechaHasta1, $establecimiento_id, 'M');
        
        $F = $model_aislamientos->ShowDataPacientesBySexo($fechaDesde1, $fechaHasta1, $establecimiento_id, 'F'); 
        
        $nro_departamentos = $model_aislamientos->ShowAisladosByDpto($fechaDesde1, $fechaHasta1);
        
        $x = 0;

        $confirmado = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'CONFIRMADO');
        $sospechoso = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SOSPECHOSO');
        $probable = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'PROBABLE');
        $descartado = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'DESCARTADO');
        $sr = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SIN REGISTRO');

        
        //====================
        return view('admin.reportes.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','titular','padre','madre','hijo','esposa','esposo','ex_conyugue','hija','fechaDesde','fechaHasta','M','F','nro_departamentos','x','confirmado','sospechoso','probable','descartado','sr','otro'));

        
    }

    public function busca_reporte_general(Request $request) {

        $rol=Auth::user()->rol;
        if($rol==2):
            $establecimiento_id = Auth::user()->establecimiento_id;
        else:
            $establecimiento_id = 0;
        endif;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = date('d-m-Y', strtotime($request->fechaDesde));
        $fechaHasta = date('d-m-Y', strtotime($request->fechaHasta));

        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        
        if($rol==2){
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHastaR($fechaDesde, $fechaHasta, $establecimiento_id, $dni_beneficiario);
        }
        else{
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado);
        }

        $esposa = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'ESPOSA');
        
        $esposo = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'ESPOSO');
        
        $ex_conyugue = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'EX-CONYUGE');

        $otro = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SR');
        
        $hija = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'HIJA'); 
        
        $hijo = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'HIJO'); 
        
        $padre = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'PADRE'); 
        
        $madre = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'MADRE'); 
        
        $titular = $model_aislamientos->ShowDataPacientesByEstablecimiento($fechaDesde1, $fechaHasta1, $establecimiento_id, 'TITULAR');
        
        
        $M = $model_aislamientos->ShowDataPacientesBySexo($fechaDesde1, $fechaHasta1, $establecimiento_id, 'M');
        
        $F = $model_aislamientos->ShowDataPacientesBySexo($fechaDesde1, $fechaHasta1, $establecimiento_id, 'F'); 
        
        $nro_departamentos = $model_aislamientos->ShowAisladosByDpto($fechaDesde1, $fechaHasta1);
        
        $x = 0;

        $confirmado = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'CONFIRMADO');
        $sospechoso = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SOSPECHOSO');
        $probable = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'PROBABLE');
        $descartado = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'DESCARTADO');
        $sr = $model_aislamientos->ShowDataPacientesInfectado($fechaDesde1, $fechaHasta1, $establecimiento_id, 'SIN REGISTRO');

        $fechaDesde = date('Y-m-d', strtotime($request->fechaDesde));
        $fechaHasta = date('Y-m-d', strtotime($request->fechaHasta));
        
        
        //====================
        return view('admin.reportes.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','titular','padre','madre','hijo','esposa','esposo','ex_conyugue','hija','fechaDesde','fechaHasta','M','F','nro_departamentos','x','confirmado','sospechoso','probable','descartado','sr','otro'));

        
    }

    public function reporte_casos_covid($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
       
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
       
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenCasosCovidByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacion($fechaDesde1, $fechaHasta1, $id_establecimiento);

        }
        else{
            $resumen=$model_aislamientos->AllResumenCasosCovidByDepartamento($fechaDesde1 ,$fechaHasta1);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacion($fechaDesde1, $fechaHasta1, 0);
        }

        $F=0; $M=0;
        if(!empty($dato_clasificacion_sexo[0]->contador)):
            if($dato_clasificacion_sexo[0]->sexo == 'F'):
                $F=$dato_clasificacion_sexo[0]->contador;
            endif;
            if($dato_clasificacion_sexo[0]->sexo == 'M'):
                $M=$dato_clasificacion_sexo[0]->contador;
            endif;
        endif;
        if(!empty($dato_clasificacion_sexo[1]->contador)):
            if($dato_clasificacion_sexo[1]->sexo == 'M'):
                $M=$dato_clasificacion_sexo[1]->contador;
            endif;
            if($dato_clasificacion_sexo[1]->sexo == 'F'):
                $F=$dato_clasificacion_sexo[1]->contador;
            endif;
        endif;
        
        $ntitular_actividad_positivo=0; $ntitular_actividad_negativo=0;
        $ntitular_retiro_positivo=0;$ntitular_retiro_negativo=0;
        $familiar_positivo=0;$familiar_negativo=0;
        $civil_positivo=0; $civil_negativo=0;
        
        
        foreach ($resumen as $key => $rowResumen):
                                
            $ntitular_actividad_positivo=$ntitular_actividad_positivo+$rowResumen->_ntitular_actividad_positivo;
            $ntitular_actividad_negativo=$ntitular_actividad_negativo+$rowResumen->_ntitular_actividad_negativo;
            $ntitular_retiro_positivo=$ntitular_retiro_positivo+$rowResumen->_ntitular_retiro_positivo;
            $ntitular_retiro_negativo=$ntitular_retiro_negativo+ $rowResumen->_ntitular_retiro_negativo;
            $familiar_positivo=$familiar_positivo+$rowResumen->_familiar_positivo;
            $familiar_negativo=$familiar_negativo+$rowResumen->_familiar_negativo;
            $civil_positivo=$civil_positivo+$rowResumen->_civil_positivo;
            $civil_negativo=$civil_negativo+$rowResumen->_civil_negativo;
            
        endforeach;

        //====================
        return view('admin.reportes.reporte_departamento_casos_covid', compact('fechaDesde', 'fechaHasta','resumen','ntitular_actividad_positivo','ntitular_actividad_negativo','ntitular_retiro_positivo','ntitular_retiro_negativo','familiar_positivo','familiar_negativo','civil_positivo','civil_negativo','F','M'));
   
    }

    public function reporte_casos_covid_fecha(Request $request) {
       
        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
       
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
       
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
       
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenCasosCovidByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacion($fechaDesde1, $fechaHasta1, $id_establecimiento);

        }
        else{
            $resumen=$model_aislamientos->AllResumenCasosCovidByDepartamento($fechaDesde1 ,$fechaHasta1);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacion($fechaDesde1, $fechaHasta1, 0);

        }
        $F=0; $M=0;
        
        if(!empty($dato_clasificacion_sexo[0]->contador)):
            if($dato_clasificacion_sexo[0]->sexo == 'F'):
                $F=$dato_clasificacion_sexo[0]->contador;
            endif;
            if($dato_clasificacion_sexo[0]->sexo == 'M'):
                $M=$dato_clasificacion_sexo[0]->contador;
            endif;
        endif;
        if(!empty($dato_clasificacion_sexo[1]->contador)):
            if($dato_clasificacion_sexo[1]->sexo == 'M'):
                $M=$dato_clasificacion_sexo[1]->contador;
            endif;
            if($dato_clasificacion_sexo[1]->sexo == 'F'):
                $F=$dato_clasificacion_sexo[1]->contador;
            endif;
        endif;

        $ntitular_actividad_positivo=0; $ntitular_actividad_negativo=0;
        $ntitular_retiro_positivo=0;$ntitular_retiro_negativo=0;
        $familiar_positivo=0;$familiar_negativo=0;
        $civil_positivo=0; $civil_negativo=0;
        
        
        foreach ($resumen as $key => $rowResumen):
                                
            $ntitular_actividad_positivo=$ntitular_actividad_positivo+$rowResumen->_ntitular_actividad_positivo;
            $ntitular_actividad_negativo=$ntitular_actividad_negativo+$rowResumen->_ntitular_actividad_negativo;
            $ntitular_retiro_positivo=$ntitular_retiro_positivo+$rowResumen->_ntitular_retiro_positivo;
            $ntitular_retiro_negativo=$ntitular_retiro_negativo+ $rowResumen->_ntitular_retiro_negativo;
            $familiar_positivo=$familiar_positivo+$rowResumen->_familiar_positivo;
            $familiar_negativo=$familiar_negativo+$rowResumen->_familiar_negativo;
            $civil_positivo=$civil_positivo+$rowResumen->_civil_positivo;
            $civil_negativo=$civil_negativo+$rowResumen->_civil_negativo;
            

        endforeach;

        

        
        //====================
        return view('admin.reportes.reporte_departamento_casos_covid', compact('fechaDesde', 'fechaHasta','resumen','ntitular_actividad_positivo','ntitular_actividad_negativo','ntitular_retiro_positivo','ntitular_retiro_negativo','familiar_positivo','familiar_negativo','civil_positivo','civil_negativo','F','M'));
   
    }

    public function reporte_positivos(Request $request) {
       
        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
       
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenCasosPositivosCovidIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenCasosPositivosCovid($fechaDesde1 ,$fechaHasta1);
        }
        $i=1; $total_registro=count($resumen); $enmedio_label=''; $enmedio_data_titulares='';$enmedio_data_retiro='';$enmedio_data_familiar='';$enmedio_data_civil='';
        foreach ($resumen as $key => $rowResumen):

            if($i==1){
                $ini_label="labels  : ['".$rowResumen->_semana."',";
                $ini_data_titulares="data  : [".$rowResumen->_ntitular_actividad_positivo." ,";
                $ini_data_retiro="data  : [".$rowResumen->_ntitular_retiro_positivo." ,";
                $ini_data_familiar="data  : [".$rowResumen->_familiar_positivo." ,";
                $ini_data_civil="data  : [".$rowResumen->_civil_positivo." ,";
            }
            else
            {
                if($i==$total_registro){
                    $fin_label= "'".$rowResumen->_semana."'],";
                    $fin_data_titulares=  $rowResumen->_ntitular_actividad_positivo." ]";
                    $fin_data_retiro=  $rowResumen->_ntitular_retiro_positivo." ]";
                    $fin_data_familiar=  $rowResumen->_familiar_positivo." ]";
                    $fin_data_civil=  $rowResumen->_civil_positivo." ]";
                }
                else
                {
                    $enmedio_label= $enmedio_label." '".$rowResumen->_semana."', ";   
                    $enmedio_data_titulares= $enmedio_data_titulares." ".$rowResumen->_ntitular_actividad_positivo.", ";   
                    $enmedio_data_retiro= $enmedio_data_retiro." ".$rowResumen->_ntitular_retiro_positivo.", ";   
                    $enmedio_data_familiar= $enmedio_data_familiar." ".$rowResumen->_familiar_positivo.", ";   
                    $enmedio_data_civil= $enmedio_data_civil." ".$rowResumen->_civil_positivo.", ";   
                }

            }
            $i++;
        endforeach;

        $label = $ini_label.' '.$enmedio_label.' '.$fin_label;
        $data_titular = $ini_data_titulares.' '.$enmedio_data_titulares.' '.$fin_data_titulares;
        $data_retiro = $ini_data_retiro.' '.$enmedio_data_retiro.' '.$fin_data_retiro;
        $data_familiar = $ini_data_familiar.' '.$enmedio_data_familiar.' '.$fin_data_familiar;
        $data_civil = $ini_data_civil.' '.$enmedio_data_civil.' '.$fin_data_civil;

        //==========================================================================================
        return view('admin.reportes.reporte_casos_positivos_covid', compact('fechaDesde', 'fechaHasta','resumen','label','data_titular','data_retiro','data_familiar','data_civil'));
    }

    public function reporte_departamentos($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        //$fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');

        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;

        if($rol==2){
            $resumen=$model_aislamientos->AllResumenAisladosByIpressConsolidado($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenAisladosByDepartamentoConsolidado($fechaDesde1 ,$fechaHasta1);
        }
        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_ncivil;
        
        endforeach;
        
        //====================
        return view('admin.reportes.aislados_por_dptos', compact('resumen', 'fechaDesde', 'fechaHasta', 'fechaHasta','resumen','nroactividad','nroretiro','nrofamiliares','nrociviles'));
        
    }

    public function reporte_departamentos_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenAisladosByIpressConsolidado($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenAisladosByDepartamentoConsolidado($fechaDesde1 ,$fechaHasta1);
        }
        
        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_ncivil;
        
        endforeach;
        
        //====================
        return view('admin.reportes.aislados_por_dptos', compact('resumen', 'fechaDesde', 'fechaHasta', 'fechaHasta','resumen','nroactividad','nroretiro','nrofamiliares','nrociviles'));

        
    }

    public function reporte_pruebas_covid($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $date = Carbon::now();
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenAisladosPruebasCovidByIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacionPrueba($fechaDesde1, $fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenAisladosPruebasCovidByDepartamento($fechaDesde1 ,$fechaHasta1);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacionPrueba($fechaDesde1, $fechaHasta1);
        }

        $AF=0; $AM=0; $MF=0; $MM=0;
        if(!empty($dato_clasificacion_sexo[0]->contador)):
            if($dato_clasificacion_sexo[0]->sexo == 'F'):
                if($dato_clasificacion_sexo[0]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[0]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[0]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[0]->sexo == 'M'):
                if($dato_clasificacion_sexo[0]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[0]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[0]->contador;
                endif;
            endif;
        endif;
        
        if(!empty($dato_clasificacion_sexo[1]->contador)):
            if($dato_clasificacion_sexo[1]->sexo == 'F'):
                if($dato_clasificacion_sexo[1]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[1]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[1]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[1]->sexo == 'M'):
                if($dato_clasificacion_sexo[1]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[1]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[1]->contador;
                endif;
            endif;
        endif;
        
        if(!empty($dato_clasificacion_sexo[2]->contador)):
            if($dato_clasificacion_sexo[2]->sexo == 'F'):
                if($dato_clasificacion_sexo[2]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[2]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[2]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[2]->sexo == 'M'):
                if($dato_clasificacion_sexo[2]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[2]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[2]->contador;
                endif;
            endif;
        endif;
        if(!empty($dato_clasificacion_sexo[3]->contador)):
            if($dato_clasificacion_sexo[3]->sexo == 'F'):
                if($dato_clasificacion_sexo[3]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[3]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[3]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[3]->sexo == 'M'):
                if($dato_clasificacion_sexo[3]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[3]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[3]->contador;
                endif;
            endif;
        endif;
        


        $mmpositivo=0; $mmnegativo=0;
        $mmpendiente=0;$mmrechazado=0;
        $mmsininfo=0;$mmnetlab=0;
        $nnpositivo=0; $nnnegativo=0;
        $nnpendiente=0;$nnrechazado=0;
        $nnsininfo=0;$nnnetlab=0;
        
        foreach ($resumen as $key => $rowResumen):
                                
            $mmpositivo=$mmpositivo+$rowResumen->_mpositivo;
            $mmnegativo=$mmnegativo+$rowResumen->_mnegativo;
            $mmpendiente=$mmpendiente+$rowResumen->_mpendiente;
            $mmrechazado=$mmrechazado+ $rowResumen->_mrechazado;
            $mmsininfo=$mmsininfo+$rowResumen->_msininfo;
            $mmnetlab=$mmnetlab+$rowResumen->_mnetlab;

            $nnpositivo=$nnpositivo+$rowResumen->_apositivo;
            $nnnegativo=$nnnegativo+$rowResumen->_anegativo;
            $nnpendiente=$nnpendiente+$rowResumen->_apendiente;
            $nnrechazado=$nnrechazado+ $rowResumen->_arechazado;
            $nnsininfo=$nnsininfo+$rowResumen->_asininfo;
            $nnnetlab=$nnnetlab+$rowResumen->_anetlab;

        endforeach;

        //====================
        return view('admin.reportes.reporte_departamento_pruebas_covid', compact('fechaDesde', 'fechaHasta','resumen','mmpositivo','mmnegativo','mmpendiente','mmrechazado','mmsininfo','mmnetlab','nnpositivo','nnnegativo','nnpendiente','nnrechazado','nnsininfo','nnnetlab','AM','AF','MM','MF'));

        
    }

    public function reporte_pruebas_covid_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $date = Carbon::now();
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;

        if($rol==2){
            $resumen=$model_aislamientos->AllResumenAisladosPruebasCovidByIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacionPrueba($fechaDesde1, $fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenAisladosPruebasCovidByDepartamento($fechaDesde1 ,$fechaHasta1);
            $dato_clasificacion_sexo = $model_aislamientos->ShowDataPacientesBySexoClasificacionPrueba($fechaDesde1, $fechaHasta1);
        }

        $AF=0; $AM=0; $MF=0; $MM=0;
        if(!empty($dato_clasificacion_sexo[0]->contador)):
            if($dato_clasificacion_sexo[0]->sexo == 'F'):
                if($dato_clasificacion_sexo[0]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[0]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[0]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[0]->sexo == 'M'):
                if($dato_clasificacion_sexo[0]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[0]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[0]->contador;
                endif;
            endif;
        endif;
        
        if(!empty($dato_clasificacion_sexo[1]->contador)):
            if($dato_clasificacion_sexo[1]->sexo == 'F'):
                if($dato_clasificacion_sexo[1]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[1]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[1]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[1]->sexo == 'M'):
                if($dato_clasificacion_sexo[1]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[1]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[1]->contador;
                endif;
            endif;
        endif;
        
        if(!empty($dato_clasificacion_sexo[2]->contador)):
            if($dato_clasificacion_sexo[2]->sexo == 'F'):
                if($dato_clasificacion_sexo[2]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[2]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[2]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[2]->sexo == 'M'):
                if($dato_clasificacion_sexo[2]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[2]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[2]->contador;
                endif;
            endif;
        endif;
        if(!empty($dato_clasificacion_sexo[3]->contador)):
            if($dato_clasificacion_sexo[3]->sexo == 'F'):
                if($dato_clasificacion_sexo[3]->tipo_prueba == 1):
                    $MF=$dato_clasificacion_sexo[3]->contador;
                else:
                    $AF=$dato_clasificacion_sexo[3]->contador;
                endif;
            endif;
            if($dato_clasificacion_sexo[3]->sexo == 'M'):
                if($dato_clasificacion_sexo[3]->tipo_prueba == 1):
                    $MM=$dato_clasificacion_sexo[3]->contador;
                else:
                    $AM=$dato_clasificacion_sexo[3]->contador;
                endif;
            endif;
        endif;

        
        $mmpositivo=0; $mmnegativo=0;
        $mmpendiente=0;$mmrechazado=0;
        $mmsininfo=0;$mmnetlab=0;
        $nnpositivo=0; $nnnegativo=0;
        $nnpendiente=0;$nnrechazado=0;
        $nnsininfo=0;$nnnetlab=0;
        
        foreach ($resumen as $key => $rowResumen):
                                
            $mmpositivo=$mmpositivo+$rowResumen->_mpositivo;
            $mmnegativo=$mmnegativo+$rowResumen->_mnegativo;
            $mmpendiente=$mmpendiente+$rowResumen->_mpendiente;
            $mmrechazado=$mmrechazado+ $rowResumen->_mrechazado;
            $mmsininfo=$mmsininfo+$rowResumen->_msininfo;
            $mmnetlab=$mmnetlab+$rowResumen->_mnetlab;

            $nnpositivo=$nnpositivo+$rowResumen->_apositivo;
            $nnnegativo=$nnnegativo+$rowResumen->_anegativo;
            $nnpendiente=$nnpendiente+$rowResumen->_apendiente;
            $nnrechazado=$nnrechazado+ $rowResumen->_arechazado;
            $nnsininfo=$nnsininfo+$rowResumen->_asininfo;
            $nnnetlab=$nnnetlab+$rowResumen->_anetlab;

        endforeach;

        //====================
        return view('admin.reportes.reporte_departamento_pruebas_covid', compact('fechaDesde', 'fechaHasta','resumen','mmpositivo','mmnegativo','mmpendiente','mmrechazado','mmsininfo','mmnetlab','nnpositivo','nnnegativo','nnpendiente','nnrechazado','nnsininfo','nnnetlab','AM','AF','MM','MF'));


    }

    public function reporte_departamento_hospitalizado_titulares_actividad($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesActividadIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesActividad($fechaDesde1 ,$fechaHasta1);    
        }
        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_titulares_actividad', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_departamento_hospitalizado_titulares_actividad_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesActividadIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesActividad($fechaDesde1 ,$fechaHasta1);
        }
        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_titulares_actividad', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_departamento_hospitalizado_titulares_retiro($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesRetiroIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesRetiro($fechaDesde1 ,$fechaHasta1);
        }

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_titulares_retiro', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_departamento_hospitalizado_titulares_retiro_fecha(Request $request) {
        
        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesRetiroIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoTitularesRetiro($fechaDesde1 ,$fechaHasta1);
        }

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_titulares_retiro', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_departamento_hospitalizado_familiares($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        

        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoFamiliaresIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoFamiliares($fechaDesde1 ,$fechaHasta1);
        }

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_familiares', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_departamento_hospitalizado_familiares_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoFamiliaresIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenHospitalizadosByDepartamentoFamiliares($fechaDesde1 ,$fechaHasta1);
        }

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado_familiares', compact('fechaDesde', 'fechaHasta','resumen'));
   
    }

    public function reporte_fallecido_departamentos($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenFallecidoByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenFallecidoByDepartamento($fechaDesde1 ,$fechaHasta1);
        }

        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_ncivil;
        
        endforeach;

        //====================
        return view('admin.reportes.reporte_fallecido_departamentos', compact('fechaDesde', 'fechaHasta', 'resumen','nroactividad','nroretiro','nrofamiliares','nrociviles'));
   
    }

    public function reporte_fallecido_departamentos_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen=$model_aislamientos->AllResumenFallecidoByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen=$model_aislamientos->AllResumenFallecidoByDepartamento($fechaDesde1 ,$fechaHasta1);
        }


        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_nfallecidos-($rowResumen->_ntitulares+$rowResumen->_nfamiliares);
        
        endforeach;

        //====================
        return view('admin.reportes.reporte_fallecido_departamentos', compact('fechaDesde', 'fechaHasta', 'resumen','nroactividad','nroretiro','nrofamiliares','nrociviles'));
   
    }

    public function reporte_departamento_hospitalizados($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;

        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen_ho=$model_aislamientos->AllResumenHospitalizadosByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen_ho=$model_aislamientos->AllResumenHospitalizadosByDepartamento($fechaDesde1 ,$fechaHasta1);    
        }

        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen_ho as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_ncivil;
        
        endforeach;
        

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado', compact('fechaDesde', 'fechaHasta','resumen_ho','nroactividad','nroretiro','nrofamiliares','nrociviles'));
   
    }

    public function reporte_departamento_hospitalizados_fecha(Request $request) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        
        $inicio = ':00:00';
        $fin=':23:59';
        $fechaDesde1 = $fechaDesde.$inicio;
        $fechaHasta1 = $fechaHasta.$fin;
        
        if($rol==2){
            $resumen_ho=$model_aislamientos->AllResumenHospitalizadosByDepartamentoIpress($fechaDesde1 ,$fechaHasta1, $id_establecimiento);
        }
        else{
            $resumen_ho=$model_aislamientos->AllResumenHospitalizadosByDepartamento($fechaDesde1 ,$fechaHasta1);
        }

        $nroactividad=0;
        $nroretiro=0;
        $nrofamiliares=0;
        $nrociviles=0;

        foreach ($resumen_ho as $key => $rowResumen):
                                
            $nroactividad=$nroactividad+$rowResumen->_nactividad;
            $nroretiro=$nroretiro+$rowResumen->_nretiro;
            $nrofamiliares=$nrofamiliares+$rowResumen->_nfamiliares;
            $nrociviles=$nrociviles+ $rowResumen->_ncivil;
        
        endforeach;
        

        //====================
        return view('admin.reportes.reporte_departamento_hospitalizado', compact('fechaDesde', 'fechaHasta','resumen_ho','nroactividad','nroretiro','nrofamiliares','nrociviles'));
   
    }

    public function exportar_reporte_aislamientos($fechaDesde , $fechaHasta, $id_departamento="", $dni="") {
        $nombre_establecimiento=Auth::user()->nombre_establecimiento;
        //====================
        Excel::create('Reporte_Covid_' . $nombre_establecimiento, function($excel) use($fechaDesde, $fechaHasta,$dni,$id_departamento, $nombre_establecimiento ) {
            $excel->sheet('GENERAL', function($sheet) use($fechaDesde, $fechaHasta, $dni,$nombre_establecimiento, $id_departamento ) {
                
                $variable = [];
                $n = 1;
                $rol=Auth::user()->rol;
                
                if (is_null($dni))
                    $dni="";
                else
                    $dni=strtoupper($dni);

                $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
                $fechaDesde = date('d-m-Y', strtotime($fechaDesde));

                if($rol==1 || $rol==3){
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $aislamientos = $model_aislamientos->TodosAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni, $id_departamento);
                 }
                else
                {
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $id_establecimiento = Auth::user()->establecimiento_id;
                    $aislamientos = $model_aislamientos->TodosAislamientosFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni);
                }
                
                //dd($aislamientos);

                $sheet->mergeCells('A1:CK1');
                $sheet->cell('A1', function($cell) {$cell->setValue('MODELO DE FORMATO DE BASE DE DATOS COVID-19 ');  $cell->setFontSize(15); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); });
                
                $sheet->mergeCells('A3:A3');
                $sheet->cell('A3', function($cell) {$cell->setValue('#');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#3809F7'); });
                $sheet->mergeCells('B3:E3');
                $sheet->cell('B3', function($cell) {$cell->setValue('DATOS DE LAS IPRESS QUE NOTIFICA');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#F73409'); });
                $sheet->mergeCells('E3:R3');
                $sheet->cell('E3', function($cell) {$cell->setValue('DATOS DEL PACIENTE');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#09BB62');});
                $sheet->mergeCells('AC3:AU3');
                $sheet->cell('AC3', function($cell) {$cell->setValue('ANTECEDENTES EPIDEMIOLOGICA');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#F78409');});
                $sheet->mergeCells('AV3:BP3');
                $sheet->cell('AV3', function($cell) {$cell->setValue('HOSPITALIZACION');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#CFB1E2');});
                $sheet->mergeCells('BQ3:CA3');
                $sheet->cell('BQ3', function($cell) {$cell->setValue('EVOLUCION');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#A4F7F6');});
                $sheet->mergeCells('CB3:CK3');
                $sheet->cell('CB3', function($cell) {$cell->setValue('EXAMENES DE LABORATORIO');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#957441');});
                
                array_push($variable, array('Reporte Aislados  De ' . $fechaDesde . ' a ' . $fechaHasta));
                array_push($variable, array(""));
                array_push($variable, array("N","Fecha Registro","Fecha Notificación", "Establecimiento","Departamento","DNI", "Nombre", "Apellido Paterno", "Apellido Materno", "CIP","Grado","Sexo","Edad", "Fecha Nacimiento", "Parentesco", "Unidad", "Situación","Categoría","Talla","Peso", "Telefono","Domicilio", "Referencia", "Departamento Domicilio", "Provincia Domicilio", "Distrito Domicilio", "Ocupación", "Otra Ocupación","Fecha Registro","clasificación", "Tipo de Caso", "Fecha Sintomas","Fecha Aislamiento","Departamento", "Provincia", "Distrito ", "Comorbilidades", "Gestante", "Fecha Primera Dosis","Tipo Vacuna","Fecha Segunda Dosis", "Tipo Vacuna 2", "Fecha Tercera Dosis", "Tipo Vacuna 3", "Reinfeccion","Fecha de Reinfección","Observación","Fecha Registro","Referido", "Ipress Proviene", "Fecha Referencia","Fecha Hospitalización","Diagnostico de Ingreso", "Intubado", "Neumonia", "Ventilación Mecánica ", "IAAS", "UCIntensivo F.Ingreso","UCIntensivo F.Alta","UCIntermedio F.Ingreso","UCIntermedio F.Alta","TShock F. Ingreso", "TShock F.Alta","Sala F.Ingreso","Sala F.Alta","OTRO","F.Ingreso", "F. Alta","Fecha Registro", "Evolucion", "Descripción Evolución", "Fecha Alta", "Clasificacion","Fecha Defunción","Hora Defunción","Observación", "Nota Certificado", "Nro", "Fecha", "Fecha Registro", "Fecha Muestra", "Tipo Muestra","Tipo Prueba","Resultado", "Fecha Resultado", "Secuenciamiento Genetico", "Linaje", "Tomografia Computarizada", "Radiografia de Tórax"));
                dd($aislamientos);
                foreach ($aislamientos as $u) {
                    if($u->gestante==1):
                        $gestante='SI';
                    else:
                        $gestante='NO';
                    endif;

                    switch($u->evolucion){
                        case 0: $descripcion_evol ='' ; break;
                        case 1: $descripcion_evol ='Favorable' ; break;
                        case 2: $descripcion_evol ='Desfavorable' ; break;
                        case 3: $descripcion_evol ='Fallecio' ; break;
                        case 4: $descripcion_evol ='Alta Médica/Aislamiento' ; break;
                        case 5: $descripcion_evol ='Alta Voluntaria' ; break;
                        case 6: $descripcion_evol ='Referido' ; break;
                        case 7: $descripcion_evol ='Fugado' ; break;
                        case 8: $descripcion_evol ='Alta Médica/Hospitalaria' ; break;
                        case 9: $descripcion_evol ='En Observación' ; break;
                        case 10: $descripcion_evol ='Estable' ; break;
                        case 11: $descripcion_evol ='Estacionario' ; break;
                    }

                    $ocupaciones = $model_aislamientos->AllOcupacionesAislado($u->id);
                    if(empty($ocupaciones)): $ocupacion=''; else: $ocupacion=$ocupaciones[0]->ocupacion; endif;

                    if(!empty($u->gestante)):if($u->gestante==1):$gestante='SI';else:$gestante='NO';endif;else:$gestante='';endif;

                    if(!empty($u->referido)):if($u->referido==1):$referido='SI';else:$referido='NO';endif;else:$referido='';endif;

                    if(!empty($u->intubado)):if($u->intubado==1):$intubado='SI';else:$intubado='NO';endif;else:$intubado='';endif;

                    if(!empty($u->neumonia)):if($u->neumonia==1):$neumonia='SI';else:$neumonia='NO';endif;else:$neumonia='';endif;

                    if(!empty($u->ventilacion_mecanica)):if($u->ventilacion_mecanica==1):$ventilacion_mecanica='SI';else:$ventilacion_mecanica='NO';endif;else:$ventilacion_mecanica='';endif;

                    if(!empty($u->uci)):
                        switch($u->uci){
                            case 1: $uci ='SI' ; break;
                            case 2: $uci ='NO' ; break;
                            case 3: $uci ='Desconocido' ; break;
                        }
                    else:
                        $uci='';
                    endif;

                    if(!empty($u->sintoma_reinfeccion)):if($u->sintoma_reinfeccion=='SI'):$fecha_sintoma_reinfeccion=$u->fecha_sintoma_reinfeccion;else:$fecha_sintoma_reinfeccion='';endif;else:$fecha_sintoma_reinfeccion='';endif;

                    $comorbilidades = $model_aislamientos->AllAntecedentesAislado($u->dni);

                    if(empty($comorbilidades)): $comorbilidad=''; else: $comorbilidad=$comorbilidades[0]->riesgo; endif;

                    $diagnosticos_hosp = $model_aislamientos->AllDiagnosticosHospitalizacion($u->id);
                    if(empty($diagnosticos_hosp)): $diagnostico_h=''; else: $diagnostico_h=$diagnosticos_hosp[0]->diagnostic; endif;

                    if(!empty($u->tipo_defuncion)):
                        switch($u->tipo_defuncion){
                            case 0: $tipo_defuncion ='' ; break;
                            case 1: $tipo_defuncion ='Criterio Virologico' ; break;
                            case 2: $tipo_defuncion ='Criterio Serologico' ; break;
                            case 3: $tipo_defuncion ='Criterio Radiologico' ; break;
                            case 4: $tipo_defuncion ='Nexo Epidemiológico' ; break;
                            case 5: $tipo_defuncion ='Criterio Investigacion epidemiologica' ; break;
                            case 6: $tipo_defuncion ='Criterio Clinico' ; break;
                            case 7: $tipo_defuncion ='Criterio SINADEF' ; break;
                        }
                    else:
                        $tipo_defuncion='';
                    endif;

                    if(!empty($u->nota_certificado)):if($u->nota_certificado==1):$nota_certificado='Nota Informativa';else:$nota_certificado='Certificado de Defunción';endif;else:$nota_certificado='';endif;

                    if(empty($u->fecha_reg_lab)):$fecha_reg_lab=''; else:$fecha_reg_lab = date('d-m-Y', strtotime($u->fecha_reg_lab));  endif;
                    if(empty($u->fecha_aislamiento) || ($u->fecha_aislamiento=='1970-01-01')):$fecha_aislamiento=''; else:$fecha_aislamiento = date('d-m-Y', strtotime($u->fecha_aislamiento));  endif;

                    $fecha_reg_pac = date('d-m-Y', strtotime($u->fecha_reg_pac));

                    if(!empty($u->id_clasificacion)):
                        switch($u->id_clasificacion){
                            case 1: $clasificacion_covid ='CONFIRMADO' ; break;
                            case 2: $clasificacion_covid ='PROBABLE' ; break;
                            case 3: $clasificacion_covid ='SOSPECHOSO' ; break;
                            case 4: $clasificacion_covid ='DESCARTADO' ; break;
                        }
                    else:
                        $clasificacion='';
                    endif;


                    //if($u->id_clasificacion=='SIN REGISTRO'):$clasificacion=''; else:$clasificacion = $u->clasificacion;  endif;
                    
                    array_push($variable, array($n++, $fecha_reg_pac, $u->fecha_notificacion,$u->establecimiento,$u->dpto_establecimiento,$u->dni, $u->nombres, $u->paterno, $u->materno, $u->cip,$u->grado,$u->sexo, $u->edad,$u->fecha_nacimiento, $u->parentesco, $u->unidad,$u->situacion,$u->categoria,$u->talla,$u->peso,$u->telefono,$u->domicilio,$u->referencia,$u->departamento,$u->provincia,$u->distrito,$ocupacion,$u->otra_ocupacion, $u->fecha_reg_antecedente,$clasificacion_covid,$u->tipo_caso,$u->fecha_sintoma,$fecha_aislamiento, $u->departamento_antecedente, $u->provincia_antecedente, $u->distrito_antecedente, $comorbilidad, $gestante,$u->fecha_vacunacion_1,$u->fabricante_1, $u->fecha_vacunacion_2, $u->fabricante_2, $u->fecha_vacunacion_3,$u->fabricante_3,$u->sintoma_reinfeccion,$fecha_sintoma_reinfeccion,$u->observacion,$u->fecha_reg_ho, $referido,$u->nombre_establecimiento_salud,$u->fecha_referencia, $u->fecha_hospitalizacion, $diagnostico_h, $intubado, $neumonia, $ventilacion_mecanica,$uci, $u->fecha_ingreso_s2,$u->fecha_alta_s2,$u->fecha_ingreso_s3,$u->fecha_alta_s3,$u->fecha_ingreso_s4,$u->fecha_alta_s4,$u->fecha_ingreso_s5,$u->fecha_alta_s5,$u->otra_ubicacion,$u->fecha_ingreso_s6, $u->fecha_alta_s6, $u->fecha_evolucion, $descripcion_evol, $u->descripcion_evolucion, $u->alta_evolucion, $tipo_defuncion,$u->evolucion_defuncion, $u->hora_defuncion, $u->observacion_defuncion, $nota_certificado, $u->nro_defuncion, $u->fecha_defuncion,$fecha_reg_lab, $u->fecha_muestra, $u->muestra, $u->prueba, $u->res_muestra, $u->fecha_resultado, $u->sg, $u->linaje, $u->tomografia, $u->radiografia ));
                }

                $sheet->with($variable)->mergeCells('A2:CK2');
            });
        })->export('xlsx');
    }

    public function exportar_reporte_hospitalizados2($fechaDesde , $fechaHasta, $id_departamento="", $dni="") {
        $nombre_establecimiento=Auth::user()->nombre_establecimiento;
        //====================
        Excel::create('importAislamiento_' . $nombre_establecimiento, function($excel) use($fechaDesde, $fechaHasta,$dni,$nombre_establecimiento,$id_departamento ) {
            $excel->sheet('GENERAL', function($sheet) use($fechaDesde, $fechaHasta, $dni,$nombre_establecimiento,$id_departamento ) {
                
                $variable = [];
                $n = 1;
                $rol=Auth::user()->rol;
                
                if (is_null($dni))
                    $dni="";
                else
                    $dni=strtoupper($dni);

                $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
                $fechaDesde = date('d-m-Y', strtotime($fechaDesde));
                
                if($rol==1 || $rol==3){
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHasta($fechaDesde, $fechaHasta, $id_departamento, $dni);
                 }
                else
                {
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $id_establecimiento = Auth::user()->establecimiento_id;
                    $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHastaR($fechaDesde, $fechaHasta, $id_establecimiento, $dni);
                }

                array_push($variable, array('Personal Hospitalizados de COVID-19 del ' . $fechaDesde . ' a ' . $fechaHasta));
                array_push($variable, array("N", "DNI", "Nombre", "Apellido Paterno", "Apellido Materno", "Sexo", "Edad", "Dpto Origen","Dpto Actual", "Ventilacion mecanica","Intubado","Tuvo/Tenia neumonia"));
                foreach ($aislamientos as $u) {
                    
                    switch ($u->ventilacion_mecanica) {
                        case '1': $v_m = "SI"; break;
                        case '2': $v_m = "NO"; break;
                        case '3': $v_m = "DESCONOCIDO"; break;
                    }

                    switch ($u->intubado) {
                        case '1': $intu = "SI"; break;
                        case '2': $intu = "NO"; break;
                        case '3': $intu = "DESCONOCIDO"; break;
                        default: $intu = ""; break;
                    }

                    switch ($u->neumonia) {
                        case '1': $neumo = "SI"; break;
                        case '2': $neumo = "NO"; break;
                        case '3': $neumo = "DESCONOCIDO"; break;
                        default: $neumo = ""; break;
                    }
                    
                    array_push($variable, array($n++, $u->dni, $u->nombres, $u->paterno, $u->materno, $u->sexo, $u->edad, $u->nombre_dpto, $u->dpto, $v_m,$intu,$neumo));
                }
                //--------------------------------------------------------------
                $sheet->with($variable)->mergeCells('A2:G2');
            });

        })->export('xlsx');
    }

    public function exportar_reporte_hospitalizados($fechaDesde , $fechaHasta, $id_departamento="", $dni="") {
        $nombre_establecimiento=Auth::user()->nombre_establecimiento;
        //====================
        Excel::create('Reporte_Hospitalizados_Covid_' . $nombre_establecimiento, function($excel) use($fechaDesde, $fechaHasta,$dni,$id_departamento, $nombre_establecimiento ) {
            $excel->sheet('GENERAL', function($sheet) use($fechaDesde, $fechaHasta, $dni,$nombre_establecimiento, $id_departamento ) {
                
                $variable = [];
                $n = 1;
                $rol=Auth::user()->rol;
                
                if (is_null($dni))
                    $dni="";
                else
                    $dni=strtoupper($dni);

                $fechaHasta = date('d-m-Y', strtotime($fechaHasta));
                $fechaDesde = date('d-m-Y', strtotime($fechaDesde));

                if($rol==1 || $rol==3){
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHastaTotal($fechaDesde, $fechaHasta, $dni, $id_departamento);
                }
                else
                {
                    //====================
                    $model_aislamientos = new Aislamiento();
                    $id_establecimiento = Auth::user()->establecimiento_id;
                    $aislamientos = $model_aislamientos->AllHospitalizacionFechaDesdeHastaTotalR($fechaDesde, $fechaHasta, $id_establecimiento, $dni);
                }

                $sheet->mergeCells('A1:CK1');
                $sheet->cell('A1', function($cell) {$cell->setValue('MODELO DE FORMATO DE BASE DE DATOS COVID-19 ');  $cell->setFontSize(15); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); });
                
                $sheet->mergeCells('A3:A3');
                $sheet->cell('A3', function($cell) {$cell->setValue('#');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#3809F7'); });
                $sheet->mergeCells('B3:E3');
                $sheet->cell('B3', function($cell) {$cell->setValue('DATOS DE LAS IPRESS QUE NOTIFICA');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#F73409'); });
                $sheet->mergeCells('F3:AB3');
                $sheet->cell('F3', function($cell) {$cell->setValue('DATOS DEL PACIENTE');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#09BB62');});
                $sheet->mergeCells('AC3:AU3');
                $sheet->cell('AC3', function($cell) {$cell->setValue('ANTECEDENTES EPIDEMIOLOGICA');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#F78409');});
                $sheet->mergeCells('AV3:BP3');
                $sheet->cell('AV3', function($cell) {$cell->setValue('HOSPITALIZACION');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#CFB1E2');});
                $sheet->mergeCells('BQ3:CA3');
                $sheet->cell('BQ3', function($cell) {$cell->setValue('EVOLUCION');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#A4F7F6');});
                $sheet->mergeCells('CB3:CK3');
                $sheet->cell('CB3', function($cell) {$cell->setValue('EXAMENES DE LABORATORIO');   $cell->setFontSize(13); $cell->setFontWeight('bold'); $cell->setAlignment('center'); $cell->setValignment('middle'); $cell->setBackground('#957441');});
                
                array_push($variable, array('Reporte Aislados  De ' . $fechaDesde . ' a ' . $fechaHasta));
                array_push($variable, array(""));
                array_push($variable, array("N","Fecha Registro","Fecha Notificación", "Establecimiento","Departamento","DNI", "Nombre", "Apellido Paterno", "Apellido Materno", "CIP","Grado","Sexo","Edad", "Fecha Nacimiento", "Parentesco", "Unidad", "Situación","Categoría","Talla","Peso", "Telefono","Domicilio", "Referencia", "Departamento Domicilio", "Provincia Domicilio", "Distrito Domicilio", "Ocupación", "Otra Ocupación","Fecha Registro","clasificación", "Tipo de Caso", "Fecha Sintomas","Fecha Aislamiento","Departamento", "Provincia", "Distrito ", "Comorbilidades", "Gestante", "Fecha Primera Dosis","Tipo Vacuna","Fecha Segunda Dosis", "Tipo Vacuna 2", "Fecha Tercera Dosis", "Tipo Vacuna 3", "Reinfeccion","Fecha de Reinfección","Observación","Fecha Registro","Referido", "Ipress Proviene", "Fecha Referencia","Fecha Hospitalización","Diagnostico de Ingreso", "Intubado", "Neumonia", "Ventilación Mecánica ", "IAAS", "UCIntensivo F.Ingreso","UCIntensivo F.Alta","UCIntermedio F.Ingreso","UCIntermedio F.Alta","TShock F. Ingreso", "TShock F.Alta","Sala F.Ingreso","Sala F.Alta","OTRO","F.Ingreso", "F. Alta","Fecha Registro", "Evolucion", "Descripción Evolución", "Fecha Alta", "Clasificacion","Fecha Defunción","Hora Defunción","Observación", "Nota Certificado", "Nro", "Fecha", "Fecha Registro", "Fecha Muestra", "Tipo Muestra","Tipo Prueba","Resultado", "Fecha Resultado", "Secuenciamiento Genetico", "Linaje", "Tomografia Computarizada", "Radiografia de Tórax"));

                foreach ($aislamientos as $u) {
                    if($u->gestante==1):
                        $gestante='SI';
                    else:
                        $gestante='NO';
                    endif;

                    switch($u->evolucion){
                        case 0: $descripcion_evol ='' ; break;
                        case 1: $descripcion_evol ='Favorable' ; break;
                        case 2: $descripcion_evol ='Desfavorable' ; break;
                        case 3: $descripcion_evol ='Fallecio' ; break;
                        case 4: $descripcion_evol ='Alta Médica/Aislamiento' ; break;
                        case 5: $descripcion_evol ='Alta Voluntaria' ; break;
                        case 6: $descripcion_evol ='Referido' ; break;
                        case 7: $descripcion_evol ='Fugado' ; break;
                        case 8: $descripcion_evol ='Alta Médica/Hospitalaria' ; break;
                        case 9: $descripcion_evol ='En Observación' ; break;
                        case 10: $descripcion_evol ='Estable' ; break;
                        case 11: $descripcion_evol ='Estacionario' ; break;
                    }

                    $ocupaciones = $model_aislamientos->AllOcupacionesAislado($u->id);
                    if(empty($ocupaciones)): $ocupacion=''; else: $ocupacion=$ocupaciones[0]->ocupacion; endif;

                    if(!empty($u->gestante)):if($u->gestante==1):$gestante='SI';else:$gestante='NO';endif;else:$gestante='';endif;

                    if(!empty($u->referido)):if($u->referido==1):$referido='SI';else:$referido='NO';endif;else:$referido='';endif;

                    if(!empty($u->intubado)):if($u->intubado==1):$intubado='SI';else:$intubado='NO';endif;else:$intubado='';endif;

                    if(!empty($u->neumonia)):if($u->neumonia==1):$neumonia='SI';else:$neumonia='NO';endif;else:$neumonia='';endif;

                    if(!empty($u->ventilacion_mecanica)):if($u->ventilacion_mecanica==1):$ventilacion_mecanica='SI';else:$ventilacion_mecanica='NO';endif;else:$ventilacion_mecanica='';endif;

                    if(!empty($u->uci)):
                        switch($u->uci){
                            case 1: $uci ='SI' ; break;
                            case 2: $uci ='NO' ; break;
                            case 3: $uci ='Desconocido' ; break;
                        }
                    else:
                        $uci='';
                    endif;

                    if(!empty($u->sintoma_reinfeccion)):if($u->sintoma_reinfeccion=='SI'):$fecha_sintoma_reinfeccion=$u->fecha_sintoma_reinfeccion;else:$fecha_sintoma_reinfeccion='';endif;else:$fecha_sintoma_reinfeccion='';endif;

                    $comorbilidades = $model_aislamientos->AllAntecedentesAislado($u->dni);

                    if(empty($comorbilidades)): $comorbilidad=''; else: $comorbilidad=$comorbilidades[0]->riesgo; endif;

                    $diagnosticos_hosp = $model_aislamientos->AllDiagnosticosHospitalizacion($u->id);
                    if(empty($diagnosticos_hosp)): $diagnostico_h=''; else: $diagnostico_h=$diagnosticos_hosp[0]->diagnostic; endif;

                    if(!empty($u->tipo_defuncion)):
                        switch($u->tipo_defuncion){
                            case 0: $tipo_defuncion ='' ; break;
                            case 1: $tipo_defuncion ='Criterio Virologico' ; break;
                            case 2: $tipo_defuncion ='Criterio Serologico' ; break;
                            case 3: $tipo_defuncion ='Criterio Radiologico' ; break;
                            case 4: $tipo_defuncion ='Nexo Epidemiológico' ; break;
                            case 5: $tipo_defuncion ='Criterio Investigacion epidemiologica' ; break;
                            case 6: $tipo_defuncion ='Criterio Clinico' ; break;
                            case 7: $tipo_defuncion ='Criterio SINADEF' ; break;
                        }
                    else:
                        $tipo_defuncion='';
                    endif;

                    if(!empty($u->nota_certificado)):if($u->nota_certificado==1):$nota_certificado='Nota Informativa';else:$nota_certificado='Certificado de Defunción';endif;else:$nota_certificado='';endif;

                    if(empty($u->fecha_reg_lab)):$fecha_reg_lab=''; else:$fecha_reg_lab = date('d-m-Y', strtotime($u->fecha_reg_lab));  endif;
                    if(empty($u->fecha_aislamiento) || ($u->fecha_aislamiento=='1970-01-01')):$fecha_aislamiento=''; else:$fecha_aislamiento = date('d-m-Y', strtotime($u->fecha_aislamiento));  endif;

                    $fecha_reg_pac = date('d-m-Y', strtotime($u->fecha_reg_pac));

                    if($u->clasificacion=='SIN REGISTRO'):$clasificacion=''; else:$clasificacion = $u->clasificacion;  endif;
                    
                    array_push($variable, array($n++, $fecha_reg_pac, $u->fecha_notificacion,$u->establecimiento,$u->dpto_establecimiento,$u->dni, $u->nombres, $u->paterno, $u->materno, $u->cip,$u->grado,$u->sexo, $u->edad,$u->fecha_nacimiento, $u->parentesco, $u->unidad,$u->situacion,$u->categoria,$u->talla,$u->peso,$u->telefono,$u->domicilio,$u->referencia,$u->departamento,$u->provincia,$u->distrito,$ocupacion,$u->otra_ocupacion, $u->fecha_reg_antecedente,$clasificacion,$u->tipo_caso,$u->fecha_sintoma,$fecha_aislamiento, $u->departamento_antecedente, $u->provincia_antecedente, $u->distrito_antecedente, $comorbilidad, $gestante,$u->fecha_vacunacion_1,$u->fabricante_1, $u->fecha_vacunacion_2, $u->fabricante_2, $u->fecha_vacunacion_3,$u->fabricante_3,$u->sintoma_reinfeccion,$fecha_sintoma_reinfeccion,$u->observacion,$u->fecha_reg_ho, $referido,$u->nombre_establecimiento_salud,$u->fecha_referencia, $u->fecha_hospitalizacion, $diagnostico_h, $intubado, $neumonia, $ventilacion_mecanica,$uci, $u->fecha_ingreso_s2,$u->fecha_alta_s2,$u->fecha_ingreso_s3,$u->fecha_alta_s3,$u->fecha_ingreso_s4,$u->fecha_alta_s4,$u->fecha_ingreso_s5,$u->fecha_alta_s5,$u->otra_ubicacion,$u->fecha_ingreso_s6, $u->fecha_alta_s6, $u->fecha_evolucion, $descripcion_evol, $u->descripcion_evolucion, $u->alta_evolucion, $tipo_defuncion,$u->evolucion_defuncion, $u->hora_defuncion, $u->observacion_defuncion, $nota_certificado, $u->nro_defuncion, $u->fecha_defuncion,$fecha_reg_lab, $u->fecha_muestra, $u->muestra, $u->prueba, $u->res_muestra, $u->fecha_resultado, $u->sg, $u->linaje, $u->tomografia, $u->radiografia ));
                }

                $sheet->with($variable)->mergeCells('A2:CK2');
            });
        })->export('xlsx');
    }
    

    public function buscar_personal_aislado_prueba($nro_doc) {

        $beneficiario = new Aislamiento;
        
            $location_URL = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc';
            $wsdl = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

            $sw = false;
            $beneficiario_encontrado = "";

            $client = new SoapClient($wsdl, array(
                'location' => $location_URL,
                'uri'      => "",
                'trace'    => 1,            
                ));

            $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'VIGILANCIA EPIDEMIOLOGICA COVID-19', 'Operador'=>'31081306']);
           
            $json = json_encode($busca_datos);
            $beneficiario_encontrado = json_decode($json,TRUE);
            //dd($beneficiario_encontrado);
            $ncont_titular=0;
            
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
                    $beneficiario->sw=true;
                    $sw = true;
                }
                else
                {   
                    foreach($beneficiario_encontrado as $beneficiario1){
                        
                        $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                        $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                        $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                        $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                        $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                        $beneficiario->sw=true;
                        $sw = true;
                    }
                }
            }

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
                        $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                        $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                        $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                        $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];                                
                        $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                        $beneficiario->sw=true;
                        $sw = true;
                    }
                    else
                    {   
                        foreach($beneficiario_encontrado as $beneficiario1){
                            
                            $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                            $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                            $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                            $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                            $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                            $beneficiario->sw=true;
                            $sw = true;
                        }
                    }
                }
            }

            $soapClient = new SoapClient('http://192.168.10.44:7001/ServicioReniecImpl/ServicioReniecImplService?WSDL', array('trace'=>1,"encoding"=>"ISO-8859-1"));
            $sw1=false;
            $parametros = array("clienteUsuario"=>"DIRSAPOL", 
              "clienteClave"=>"WUK9XPhx", 
              "servicioCodigo"=>"WS_RENIEC_MAY_MEN", 
              "clienteSistema"=>"SOAP_DESARROLLO", 
              "clienteIp"=>"172.31.2.249",
              "clienteMac"=>"AA:BB:CC:DD:EE:FF",
              "dniAutorizado"=>"42214047",
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
                $sw1=true;
                //return json_encode($datos_rinec, TRUE);
                break;
              
              case '17':
                $datos_rinec = array(
                  "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
                  "descripcionMensaje" => "Surgieron problemas al conectarse al servidor RENIEC, intente de nuevo"
                  
                );
                $sw1=true;
                //return json_encode($datos_rinec, TRUE);
                break;
            }
            
            

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
                $foto = base64_encode($respuesta->resultadoDniMayor->foto);
                $beneficiario->nombre_dpto=utf8_encode($respuesta->resultadoDniMayor->departamentoDomicilio);
                $beneficiario->nombre_prov=utf8_encode($respuesta->resultadoDniMayor->provinciaDomicilio);
                $beneficiario->emision=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                $beneficiario->nombre_dist=utf8_encode($respuesta->resultadoDniMayor->distritoDomicilio);
                $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMayor->direccionDomicilio);
                $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMayor->estatura);
                $beneficiario->fechaExpedicion=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
                
                $beneficiario->foto='';
                $beneficiario->estado=0;

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

    //dd($beneficiario);
    $array["sw"] = $sw;
    $array["sw1"] = $sw1;
    $array["beneficiario"] = $beneficiario;
    
    return $beneficiario;
    //echo json_encode($array);

    }


    public function actualiza_ficha() {
        
        $aislados=DB::table('aislados')
                    ->orderby('id','asc')->get();
        
        $i=1;
        $errorWS = 0;
        foreach ($aislados as $bene) {

            DB::table('fichas')
                    ->insert([                    
                        'id_aislado' => $bene->id,
                        'dni' => $bene->dni,
                        'id_user' => $bene->id_user,
                        'id_establecimiento' => $bene->establecimiento_id,
                        'id_user_actualizacion' => $bene->id_user_actualizacion,
                        'fecha_notificacion' => $bene->fecha_registro,
                        'hospitalizado' => $bene->hospitalizado,
                        'activo' => $bene->estado,
                        'estado' => $bene->estado,
                        'created_at'=>$bene->created_at,
                        'updated_at'=>$bene->updated_at,
                    ]);
            
            $ficha = Ficha::where('id_aislado', $bene->id)->Where('dni',$bene->dni)->first();


            $db_update=DB::table('antecedentes')
                        ->where('dni', $bene->dni)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('antecedentes')
                        ->where('dni', $bene->dni)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('hospitalizados')
                        ->where('dni_paciente', $bene->dni)
                        ->where('id_paciente', $bene->id)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('evolucions')
                        ->where('dni', $bene->dni)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('laboratorios')
                        ->where('dni_paciente', $bene->dni)
                        ->where('id_paciente', $bene->id)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('archivos')
                        ->where('dni', $bene->dni)
                        ->where('aislado_id', $bene->id)
                        ->update(['idficha' => $ficha->id]);

            $db_update=DB::table('contactos')
                        ->where('dni_aislado', $bene->dni)
                        ->where('id_aislado', $bene->id)
                        ->update(['idficha' => $ficha->id]);

        }
    }

    public function todos_registros_abiertos() {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->establecimiento_id;
        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');

        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        
        if($rol==1):
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta();
            return view('admin.aislamientos.all_fichas_abiertas', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        else:
            $aislamientos = $model_aislamientos->AllFichasAbiertasR($id_establecimiento);
            return view('admin.aislamientos.all_fichas_responsables', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));
        endif;    
    }

    
}
