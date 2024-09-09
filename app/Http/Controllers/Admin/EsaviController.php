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
use App\Models\Seguimiento;
use App\Models\Clasificacion;
use App\Models\EstablecimientoSalud;
use App\Repositories\AislamientoRepository;
use App\Repositories\EsaviRepository;
use App\Http\Requests\CreateAislamientoRequest;
use App\Models\PnpCategoria;
use App\Models\Sino;
use App\Models\Sintoma;
use App\Models\Laboratorio;
use App\Models\Pregunta;
use App\Models\Signo;
use App\Models\FactorRiesgo;
use App\Models\InformeRiesgo;
use App\Models\Ocupacione;
use App\Models\Lugare;
use App\Models\HospitalizacionEsavi;
use App\Models\Diagnostico;
use App\Models\Antecedente;
use App\Models\Contacto;
use App\Models\Evolucion;
use App\Models\Esavi;
use App\Models\SignoSintoma;
use App\Models\EnfermedadRegione;
use App\Models\CuadroPatologico;
use App\Models\Vacuna;
use App\Models\EsaviVacuna;
use App\Models\Dosi;
use App\Models\Fabricante;
use App\Models\Sitio;
use App\Models\Via;
use App\Models\Previo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SoapClient;


use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EsaviController extends AppBaseController
{
    /** @var  EstablecimientosRepository */
    private $esaviRepository;

    public function __construct(EsaviRepository $esaviRepo)
    {
        $this->esaviRepository = $esaviRepo;
    }

    public function index(Request $request)
    {
    }

    
    public function store(Request $request)
    {   
        //dd($request);

        $aislamiento = new Aislamiento;
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $nombres = trim($request->name);
        $apellido_paterno = trim($request->paterno);
        $apellido_materno = trim($request->materno);
        $aislamiento->fecha_registro=$fecha_registro;
        $aislamiento->id_user=$request->id_user;
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
        $aislamiento->tipo_localidad=$request->tipo_localidad;
        $aislamiento->save();        
        $idaislamiento = $aislamiento->id; 
        $aislamiento->ocupacioneaislados()->attach($request->ocupaciones);   
        Flash::success('Se ha registrado correctamente.');
        return redirect('/editar_paciente/'. $idaislamiento.'/'.$request->dni);
    }
    
    

    public function listar_antecedentes($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_esavis = new Esavi();
        $esavis = $model_esavis->getEsavis($id,$dni);
        
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.listar_antecedentes')->with('paciente', $paciente)->with('esavis', $esavis)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto);

    }

    public function listar_esavis($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_esavis = new Esavi();
        $esavis = $model_esavis->getEsavis($id,$dni);
        
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.listar_esavis')->with('paciente', $paciente)->with('esavis', $esavis)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto);

    }

    public function create_esavis($id, $dni)
    {
     
        $date = Carbon::now();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $esavis = new Esavi();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_esavi_previos = new Previo();
        $esavi_previos = $model_esavi_previos->getPrevio();

        // foto 
        $foto=$this->buscar_foto($dni);
        
        //$foto = '';
        return view('admin.aislamientos.nuevo_esavi')->with('fechaServidor', $fechaServidor)->with('foto',$foto)->with('paciente',$paciente)->with('esavis',$esavis)->with('id',$id)->with('dni',$dni)->with('esavi_previos', $esavi_previos)->with('id_paciente', $id);
    }

    public function store_esavis(Request $request)
    {   
        $esavi = new Esavi();
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $esavi->dni=$request->dni;
        $esavi->id_aislado=$request->id_paciente;
        $esavi->tipo_esavi=$request->tipo_esavi;
        $esavi->fecha_registro=$fecha_registro;
        $esavi->fecha_notificacion=$request->fecha_notificacion;
        $esavi->esavi_previo=$request->esavi_previo;
        $esavi->otro_esavi_previo=$request->otro_esavi_previo;
        $esavi->id_user_registro=Auth::user()->id;
        $esavi->save(); 
        $idesavi = $esavi->id;

        $paciente = Aislamiento::where('id', $request->id_paciente)->Where('dni',$request->dni)->first();
        $paciente->esavi = 'SI';
        $paciente->save();

        $this->registra_checkbok($request->previos, 'esavi_previo', $idesavi, $request->dni, 'previoesavis','previo_id');
        
        Flash::success('Se ha registrado correctamente.');
        return redirect('/editar_esavi/'.$idesavi.'/'.$request->dni.'/'.$request->id_paciente);
    }

    public function editar_esavis($id_esavi, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $esavis = Esavi::where('id', $id_esavi)->Where('dni',$dni)->first();        
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $model_esavi_previos = new Previo();
        $esavi_previos = $model_esavi_previos->getPrevio();
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.editar_esavi')->with('fechaServidor', $fechaServidor)->with('dni', $dni)->with('id_paciente', $id_paciente)->with('paciente',$paciente)->with('foto',$foto)->with('esavis',$esavis)->with('id', $id_paciente)->with('id_esavi',$id_esavi)->with('esavi_previos', $esavi_previos);

    }
    
    public function update_esavis($id,Request $request)
    {
        
        $esavi = Esavi::where('id', $id)->Where('dni',$request->dni)->first();
        
        $date = Carbon::now();

        $fecha_registro = $date->format('d-m-Y');
        $esavi->tipo_esavi=$request->tipo_esavi;
        $esavi->esavi_previo=$request->esavi_previo;
        $esavi->otro_esavi_previo=$request->otro_esavi_previo;
        $esavi->fecha_registro=$request->fecha_registro;
        $esavi->fecha_notificacion=$request->fecha_notificacion;
        $esavi->id_user_registro=Auth::user()->id;
        
        $esavi->save();        

        $this->registra_checkbok($request->previos, 'esavi_previo', $id, $request->dni, 'previoesavis','previo_id');
        //$this->registra_checkbok($request->enfregiones, 'enfermedad_regione_esavi', $id, $request->dni, 'enfermedadesavis','enfermedad_regione_id');
        //$this->registra_checkbok($request->cuadropatologicos, 'cuadro_patologico_esavi', $id, $request->dni, 'patologicoesavis','cuadro_patologico_id');
        //$this->registra_checkbok($request->factorriesgos, 'esavi_factor_riesgo', $id, $request->dni, 'comorbilidadesavis','factor_riesgo_id');
        
        Flash::success('Se ha actualizado correctamente.');
        
        return redirect('/editar_esavi/'. $id.'/'.$request->dni.'/'.$request->id_paciente);
    }


    public function listar_cuadro_clinicos($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_esavis = new Esavi();
        $esavis = $model_esavis->getEsavis($id,$dni);
        
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.listar_cuadro_clinicos')->with('paciente', $paciente)->with('esavis', $esavis)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto);

    }

    function buscar_foto($dni){
        
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
        $foto = base64_encode($respuesta->resultadoDniMayor->foto);

        return $foto;
    }

   public function create_signo_sintomas($id, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_preguntas= new Pregunta();
        $preguntas = $model_preguntas->getTodasPreguntas();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto = ''; 
        
        return view('admin.aislamientos.editar_signo_sintomas')->with('fechaServidor', $fechaServidor)->with('preguntas', $preguntas)->with('foto',$foto)->with('paciente',$paciente)->with('id',$id_paciente)->with('dni',$dni)->with('id_esavi',$id);
    }

    public function update_signo_sintoma($id,Request $request)
    {    
        
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');

        $elimina_bd=DB::table('signo_sintomas')->where('id_aislado',$request->id_paciente)->where('id_esavi',$request->id_esavi)->where('dni',$request->dni)->delete();

        if(isset($request->minutop)):
            foreach ($request->minutop as $key => $value):
                if($request->minutop[$key]!=""){
                    $pregunta_id=$request->id_pregunta[$key];
                    $minuto=$request->minutop[$key];
                    $hora=$request->horap[$key];
                    $dia=$request->diap[$key];
                    $fecha_inicio=$request->fecha_iniciop[$key];
                    $fecha_termino=$request->fecha_terminop[$key];
                    DB::table('signo_sintomas')
                    ->insert([                    
                        'id_aislado' => $request->id_paciente,
                        'id_esavi' => $request->id_esavi,
                        'dni' => $request->dni,
                        'fecha_registro' => $fecha_registro,
                        'id_user_registro' => Auth::user()->id,
                        'pregunta_id' => $pregunta_id,
                        'minuto' => $minuto,
                        'hora' => $hora,
                        'dia' => $dia,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_termino' => $fecha_termino,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        if(isset($request->minutor)):        
            foreach ($request->minutor as $key => $value):
                if($request->minutor[$key]!=""){
                    $pregunta_id=$request->id_preguntar[$key];
                    $respuesta_id=$request->id_respuesta[$key];
                    $minuto=$request->minutor[$key];
                    $hora=$request->horar[$key];
                    $dia=$request->diar[$key];
                    $fecha_inicio=$request->fecha_inicior[$key];
                    $fecha_termino=$request->fecha_terminor[$key];
                    DB::table('signo_sintomas')
                    ->insert([                    
                        'id_aislado' => $request->id_paciente,
                        'id_esavi' => $request->id_esavi,
                        'dni' => $request->dni,
                        'fecha_registro' => $fecha_registro,
                        'id_user_registro' => Auth::user()->id,
                        'pregunta_id' => $pregunta_id,
                        'respuesta_id' => $respuesta_id,
                        'minuto' => $minuto,
                        'hora' => $hora,
                        'dia' => $dia,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_termino' => $fecha_termino,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        
        Flash::success('Se ha registrado correctamente.');
            
        return redirect('/listar_esavis/'. $request->id_paciente.'/'.$request->dni);
    }

    public function create_cuadro_clinicos($id, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $esavis = Esavi::where('id', $id)->Where('id_aislado',$id_paciente)->Where('dni',$dni)->first();
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
               
        //$foto = '';
        return view('admin.aislamientos.nuevo_cuadro_clinico')->with('fechaServidor', $fechaServidor)->with('foto',$foto)->with('paciente',$paciente)->with('esavis',$esavis)->with('id',$id_paciente)->with('dni',$dni)->with('id_esavi',$id);
    }

    public function store_cuadro_clinicos(Request $request)
    {   
        $esavi = Esavi::where('id', $request->id_esavi)->Where('id_aislado',$request->id_paciente)->Where('dni',$request->dni)->first();
        $date = Carbon::now();
        $esavi->fecha_sintoma=$request->fecha_sintoma;
        $esavi->gravedad_caso=$request->gravedad_caso;
        $esavi->secuencia_cronologica=$request->secuencia_cronologica;
        $esavi->examen_auxiliar=$request->examen_auxiliar;
        $esavi->tratamiento_recibido=$request->tratamiento_recibido;
        $esavi->evolucion=$request->evolucion;
        $esavi->save();        
        $idesavi = $esavi->id; 
        
        Flash::success('Se ha registrado correctamente.');
        //return redirect('/listar_esavis/'. $request->id_paciente.'/'.$request->dni);
        return redirect('/registro_cuadro_clinico/'. $request->id_esavi.'/'.$request->dni.'/'.$request->id_paciente);
    }


    public function create_seguimiento_esavi($id, $dni, $id_paciente)
    {     
        $date = Carbon::now();
        $seguimientos=Seguimiento::orderby('id','asc')->get();
        $clasificaciones=Clasificacion::orderby('id','asc')->get();
        
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $esavis = Esavi::where('id', $id)->Where('id_aislado',$id_paciente)->Where('dni',$dni)->first();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            
        // foto 
        $foto=$this->buscar_foto($dni);   
        //$foto = '';
        return view('admin.aislamientos.nuevo_seguimiento_esavis')->with('fechaServidor', $fechaServidor)->with('foto',$foto)->with('paciente',$paciente)->with('id',$id_paciente)->with('dni',$dni)->with('clasificaciones',$clasificaciones)->with('seguimientos',$seguimientos)->with('esavis',$esavis)->with('id_esavi',$id);
    }

    public function store_seguimiento_esavi(Request $request)
    {   
        $esavi = Esavi::where('id', $request->id_esavi)->Where('id_aislado',$request->id_paciente)->Where('dni',$request->dni)->first();

        $this->registra_checkbok($request->seguimientos, 'esavi_seguimiento', $request->id_esavi, $request->dni, 'seguimientoesavis','seguimiento_id');
        $this->registra_checkbok($request->clasificaciones, 'clasificacion_esavi', $request->id_esavi, $request->dni, 'clasificacionesavis','clasificacion_id');
        
        Flash::success('Se ha registrado correctamente.');
        return redirect('/create_seguimiento_clasificacion/'. $request->id_esavi.'/'.$request->dni.'/'.$request->id_paciente);
        //return redirect('/create_seguimiento_clasificacion/'. $request->id_paciente.'/'.$request->dni);
    }


    public function create_antecedente($id, $dni, $id_paciente)
    {     
        $date = Carbon::now();
        $enfermedadregiones=EnfermedadRegione::orderby('descripcion','asc')->get();
        $cuadropatologicos=CuadroPatologico::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $esavis = Esavi::where('id', $id)->Where('id_aislado',$id_paciente)->Where('dni',$dni)->first();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            
        // foto 
        $foto=$this->buscar_foto($dni);   
        //$foto = '';
        return view('admin.aislamientos.nuevo_antecedente')->with('fechaServidor', $fechaServidor)->with('factorriesgos', $factorriesgos)->with('enfermedadregiones', $enfermedadregiones)->with('cuadropatologicos', $cuadropatologicos)->with('foto',$foto)->with('paciente',$paciente)->with('esavis',$esavis)->with('id',$id_paciente)->with('dni',$dni)->with('id_esavi',$id);
    }

    public function store_antecedentes(Request $request)
    {   
        
        $esavi = Esavi::where('id', $request->id_esavi)->Where('id_aislado',$request->id_paciente)->Where('dni',$request->dni)->first();

        $this->registra_checkbok($request->enfregiones, 'enfermedad_regione_esavi', $request->id_esavi, $request->dni, 'enfermedadesavis','enfermedad_regione_id');
        $this->registra_checkbok($request->cuadropatologicos, 'cuadro_patologico_esavi', $request->id_esavi, $request->dni, 'patologicoesavis','cuadro_patologico_id');
        $this->registra_checkbok($request->factorriesgos, 'esavi_factor_riesgo', $request->id_esavi, $request->dni, 'comorbilidadesavis','factor_riesgo_id');

        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/registro_antecedentes_esavi/'. $request->id_esavi.'/'.$request->dni.'/'.$request->id_paciente);

        //
    }
    
    public function registra_checkbok($checkboxs, $tabla, $id_antecedente, $dni, $objeto,$campo_id )
    {
        $esavi = Esavi::where('id', $id_antecedente)->Where('dni',$dni)->first();
        $num_items=DB::table($tabla)->where('esavi_id',$id_antecedente)->count();

        //Sino se ha marcado ningun checkbox
        if (empty($checkboxs)) {
           if($num_items>0){
                $elimina_bd=DB::table($tabla)->where('esavi_id',$id_antecedente)->delete();
           }
        }else
        {
            //si esta vacio llenamos
            if($num_items==0){
                $esavi->$objeto()->attach($checkboxs); 
            }
            else
            {
                $datos_bd=DB::table($tabla)->where('esavi_id',$id_antecedente)->get();
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
                    $esavi->$objeto()->attach($datos_nuevos); //attach  
                }
                ///eliminamos los que no estan en los checkbox
                if($num_datos_desmarcado>0){
                    $esavi->$objeto()->detach($datos_desmarcado); //attach           
                }
            }
        }
    }
    
    /*public function editar_hospitalizacion_esavi($id_hospitalizacion, $dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
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
        
        $pac_hospitalizado = Hospitalizacion::where('id', $id_hospitalizacion)->where('id_paciente', $id_paciente)->Where('dni_paciente',$dni)->first();


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
            $uci=$pac_hospitalizado->uci;
            $id_hospitalizacion =$pac_hospitalizado->id;
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id_hospitalizacion);
            $count_diagnostico = count($diagnostico);
            $hospitalizaciones = $model_hospitalizaciones->getHospitalizacion($id_paciente,$dni);
            $count_hospitalizado = count($diagnostico);

            
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
            $uci=0;
            $id_hospitalizacion =0;
            $pac_hospitalizado = new Hospitalizacion();
            $diagnostico =0;
            $hospitalizaciones=0;
            $count_hospitalizado = 0;
            $count_diagnostico = 0;
        }
                
        // foto 
        //$foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.editar_hospitalizacion_esavi')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('foto',$foto)->with('sinos', $sinos)->with('count_hospitalizado', $count_hospitalizado)->with('hospitalizaciones', $hospitalizaciones);

    }
    */

    public function create_hospitalizado_esavi($id,$dni, $id_paciente)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');        
        $hospitalizado = HospitalizacionEsavi::where('esavi_id', $id)->where('paciente_id', $id_paciente)->Where('paciente_dni',$dni)->first();
        $nro_hospitalizado = HospitalizacionEsavi::where('esavi_id', $id)->where('paciente_id', $id_paciente)->Where('paciente_dni',$dni)->count();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $model_diagnostico= new Diagnostico();
        $model_establecimientos_salud= new EstablecimientoSalud();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();

        $fecha_alta = $paciente->fecha_alta;

        if($nro_hospitalizado==0){
            $fecha_ingreso=$date->format('Y-m-d');
            $fecha_alta=$date->format('Y-m-d');
            $estado_alta=0;
            $transferido=0;
            $id_hospitalizacion =0;
            $diagnostico1=0;
            $diagnostico2=0;
            $count_diagnostico1 = 0;
            $count_diagnostico2 = 0;
            $diagnostico =0;
            $nro_historia_clinica="";
            $establecimiento_transferido=0;
        }
        else
        {
            $fecha_ingreso=$hospitalizado->fecha_ingreso;
            $nro_historia_clinica=$hospitalizado->nro_historia_clinica;
            $fecha_alta=$hospitalizado->fecha_alta;
            $estado_alta=$hospitalizado->estado_alta;
            $transferido=$hospitalizado->transferido;
            $id_hospitalizacion =$hospitalizado->id;
            $diagnostico1 = $model_diagnostico->GetDiagnosticoEsavi($id_paciente,1);
            $diagnostico2 = $model_diagnostico->GetDiagnosticoEsavi($id_paciente,2);
            $count_diagnostico1 = count($diagnostico1);
            $count_diagnostico2 = count($diagnostico2);
            $diagnostico =0;
            $establecimiento_transferido=$hospitalizado->transferido;
        }    
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        //$foto='';
        return view('admin.aislamientos.editar_hospitalizacion_esavi')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('esavi_id', $id)->with('fecha_ingreso', $fecha_ingreso)->with('id_hospitalizacion', $id_hospitalizacion)->with('diagnostico1', $diagnostico1)->with('diagnostico2', $diagnostico2)->with('count_diagnostico1',$count_diagnostico1)->with('count_diagnostico2',$count_diagnostico2)->with('foto',$foto)->with('hospitalizado', $hospitalizado)->with('fecha_ingreso', $fecha_ingreso)->with('fecha_alta', $fecha_alta)->with('estado_alta', $estado_alta)->with('transferido', $transferido)->with('id_esavi', $id)->with('nro_historia_clinica', $nro_historia_clinica)->with('establecimiento_salud', $establecimiento_salud)->with('establecimiento_transferido', $establecimiento_transferido);

    }

    public function store_hospitalizacion_esavi(Request $request)
    {        
        
        $sw = 0 ;
        if($request->id_hospitalizacion==0){
        $hospitalizado = new HospitalizacionEsavi;   
        }
        else{
            $hospitalizado = HospitalizacionEsavi::where('id', $request->id_hospitalizacion)->where('paciente_id', $request->id_paciente_hospitalizacion)->Where('paciente_dni',$request->dni_hospitalizacion)->first();   
            $sw = 1 ;   
        }
        
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $hospitalizado->paciente_dni = $request->dni_hospitalizacion;
        $hospitalizado->nro_historia_clinica=$request->nro_historia_clinica;
        $hospitalizado->paciente_id = $request->id_paciente_hospitalizacion;
        $hospitalizado->esavi_id = $request->esavi_id;
        $hospitalizado->fecha_registro=$fecha_registro;
        $hospitalizado->fecha_alta=$request->fecha_alta;
        $hospitalizado->fecha_ingreso=$request->fecha_ingreso;
        $hospitalizado->estado_alta=$request->estado_alta;
        $hospitalizado->transferido=$request->transferido;
        $hospitalizado->detalle_transferido=$request->establecimiento_transferido;
        $hospitalizado->save();

        if($sw == 0 ){
        $id_hospitalizacion=$hospitalizado->id;
        }
        else
        {
            $id_hospitalizacion=$request->id_hospitalizacion;
        }
        

        if(isset($request->id_diagnostico)):
            
            foreach ($request->id_diagnostico as $key => $value):
                if($request->id_diagnostico[$key]!=""){

                    $id_diagnostico=$request->id_diagnostico[$key];
                    $id_tipo_diagnostico=$request->id_tipo_diagnostico[$key];

                    DB::table('diagnostico_esavi')
                    ->insert([                    
                        'aislado_id' => $request->id_paciente_hospitalizacion,
                        'diagnostico_id' => $id_diagnostico,
                        'tipo_diagnostico' => $id_tipo_diagnostico,
                        'ingreso_egreso' => 1,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;

        if(isset($request->id_diagnostico2)):
            
            foreach ($request->id_diagnostico2 as $key => $value):
                if($request->id_diagnostico2[$key]!=""){

                    $id_diagnostico=$request->id_diagnostico2[$key];
                    $id_tipo_diagnostico=$request->id_tipo_diagnostico2[$key];

                    DB::table('diagnostico_esavi')
                    ->insert([                    
                        'aislado_id' => $request->id_paciente_hospitalizacion,
                        'diagnostico_id' => $id_diagnostico,
                        'tipo_diagnostico' => $id_tipo_diagnostico,
                        'ingreso_egreso' => 2,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
            
        return redirect('/registro_hospitalizacion_esavi/'. $request->esavi_id.'/'.$request->dni_hospitalizacion.'/'.$request->id_paciente_hospitalizacion);


    }


    public function listar_hospitalizacion_esavi($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_hospitalizaciones= new HospitalizacionEsavi();
        $hospitalizaciones = $model_hospitalizaciones->getHospitalizacionEsavis($id,$dni);
        
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        
        
        //$foto='';
        return view('admin.aislamientos.listar_hospitalizacion_esavi')->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('id', $id)->with('dni', $dni)->with('foto',$foto)->with('hospitalizaciones', $hospitalizaciones);

    }

    public function listar_seguimiento_esavi($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_contacto = new Contacto();
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $model_signo = new SignoSintoma();
        $esavis = $model_signo->getSignosintomas($id,$dni);
        
        $contactos = $model_contacto->getContactos($id,$dni);

        /** foto **/
        $foto=$this->buscar_foto($dni);        
        
        //$foto ='';
        return view('admin.aislamientos.listar_seguimiento_esavi')->with('esavis',$esavis)->with('contactos',$contactos)->with('foto',$foto)->with('paciente', $paciente)->with('nombre_paciente',$nombre_paciente)->with('id',$id)->with('dni',$dni);
    }

    public function editar_vacunacion($id, $dni, $id_paciente)
    {
        
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $fechaServidor = $date->format('d-m-Y');
        $aislamientos = new Aislamiento();
        $paciente = Aislamiento::where('id', $id_paciente)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;

        $esavis = Esavi::where('id', $id)->Where('dni',$dni)->first();

        $model_esavi_vacunas= new EsaviVacuna();
        $esavi_vacunas = $model_esavi_vacunas->getEsaviVacunas($id,$dni,$id_paciente);

        $model_establecimientos_salud = new EstablecimientoSalud();
        $establecimiento_salud = $model_establecimientos_salud->getTodosEstablecimientoSalud();
        
        $model_vacuna = new Vacuna();
        $vacunas = $model_vacuna->getVacunas();

        $model_dosis = new Dosi();
        $dosis = $model_dosis->getDosis();
        
        $model_vias = new Via();
        $vias = $model_vias->getVias();
        
        $model_sitios = new Sitio();
        $sitios = $model_sitios->getSitios();

        $model_fabricantes = new Fabricante();
        $fabricantes = $model_fabricantes->getFabricantes();
        
        /** foto **/
        $foto=$this->buscar_foto($dni);
        $count_esavi_vacunas=count($esavi_vacunas);
        
        //$foto='';
        return view('admin.aislamientos.editar_vacunacion')->with('fechaServidor', $fechaServidor)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id_paciente)->with('foto',$foto)->with('count_esavi_vacunas',$count_esavi_vacunas)->with('vacunas',$vacunas)->with('id_esavi', $id)->with('esavis', $esavis)->with('establecimiento_salud',$establecimiento_salud)->with('dosis',$dosis)->with('vias',$vias)->with('sitios',$sitios)->with('fabricantes',$fabricantes)->with('esavi_vacunas',$esavi_vacunas);
    }

    public function update_vacunacion_esavi(Request $request)
    {        

        $esavi_vacunas= new EsaviVacuna();
        
        $esavi_vacunas->paciente_id = $request->paciente_id;
        $esavi_vacunas->esavi_id = $request->id_esavi;
        $esavi_vacunas->dni_paciente = $request->dni;
        $esavi_vacunas->nombre_vacuna = $request->vacunas;
        $esavi_vacunas->adyuvante = $request->adyuvante;
        $esavi_vacunas->dosis = $request->dosis;
        $esavi_vacunas->via = $request->vias;
        $esavi_vacunas->sitio = $request->sitios;
        $esavi_vacunas->fecha_vacunacion = $request->fecha_vacunacion;
        $esavi_vacunas->nombre_ipress = $request->establecimiento_salud;
        $esavi_vacunas->fabricante = $request->fabricantes;
        $esavi_vacunas->lote = $request->lote;
        $esavi_vacunas->fecha_expiracion = $request->fecha_expiracion;
        $esavi_vacunas->save();

        if($request->vacunas == 'ANTI COVID-19'):
            $paciente = Aislamiento::where('id', $request->paciente_id)->Where('dni',$request->dni)->first();
            $paciente->vacuna_covid = 'SI';
            if($request->dosis == 'Primera'):
                $paciente->vac_covid_primera = 'SI';
            else:
                $paciente->vac_covid_segunda = 'SI';
            endif;
            $paciente->save();
        endif;
        
        
        Flash::success('Se ha registrado correctamente.');
            
        return redirect('/editar_vacunacion/'. $request->id_esavi.'/'.$request->dni.'/'.$request->paciente_id);
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

    public function buscar_personal_dni($nro_doc, $tipo_doc) {
        
        $beneficiario=DB::connection('pgsql2')
                    ->table('beneficiarios')
                    ->select('beneficiarios.*')
                    ->where('nrodocafiliado',$nro_doc)
                    ->where('nomtipdocafiliado',$tipo_doc)
                    ->get();
        
        return $beneficiario;
    }   




}
