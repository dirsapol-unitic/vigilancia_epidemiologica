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
use App\Models\Contacto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SoapClient;


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
       $paciente = Aislamiento::Where('dni',$request->dni)->first();
       if(is_object($paciente)){
            return redirect('/registro_paciente/'. $paciente->id.'/'.$paciente->dni);
       }else{
            //aislamientos.create
            $pnp = new Aislamiento;
            $paciente =  array();
            $paciente=$pnp->buscar_personal_aislado($request->dni);
            $date = Carbon::now();
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $model_departamentos= new Departamento();
            $model_provincias= new Provincia();
            $model_distritos= new Distrito();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            return view('admin.aislamientos.index')->with('paciente', $paciente)->with('fechaServidor', $fechaServidor)->with('pnpcategorias', $pnpcategorias)->with('departamentos', $departamentos);            
       }
       
    }
    
    public function create()
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
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
        
        return view('admin.aislamientos.index')->with('establecimientos', $establecimientos)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares);
    }

    public function editar_paciente($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
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
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();

        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        
        $provincias = $model_provincias->getProvincia($paciente->id_departamento);
        $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;

        /** foto **/
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
        
        //$foto = '';        
        return view('admin.aislamientos.editar_paciente')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('dni', $dni)->with('id', $id)->with('foto',$foto);

    }

   public function create_antecedente($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
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
        /** foto **/
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
        
        //$foto = '';        
        
        return view('admin.aislamientos.antecedentes_epidemiologico')->with('establecimientos', $establecimientos)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('foto',$foto)->with('paciente',$paciente)->with('id',$id)->with('dni',$dni);
    }
    
    public function editar_antecedentes_epidemiologico($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
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
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();

        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $provincias = $model_provincias->getProvincia($paciente->id_departamento);
        $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
        $departamentos2 = $model_departamentos->getDepartamento();
        $provincias2 = $model_provincias->getProvincia($paciente->id_departamento2);
        $distritos2 = $model_distritos->getDistrito($paciente->id_departamento2,$paciente->id_provincia2);
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;


        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni);
        $count_laboratorio = count($laboratorio);

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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

        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $pac_hospitalizado = Hospitalizacion::where('id_paciente', $id)->Where('dni_paciente',$dni)->first();

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
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id);
            $count_diagnostico = count($diagnostico);
            
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
            $count_diagnostico = 0;
        }
        
        $pac_contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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
            $fecha_cuarentena_contacto=$date->format('Y-m-d'); 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso =0;
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;
        }
        
        /** foto **/
        
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
        
        //$foto='';
        return view('admin.aislamientos.antecedentes_epidemiologico')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('departamentos2', $departamentos2)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('id_paciente_lab',$id_paciente_lab)->with('laboratorio',$laboratorio)->with('count_laboratorio',$count_laboratorio)->with('contacto',$contacto)->with('foto',$foto);

    }

    public function editar_hospitalizacion($id, $dni)
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

        //$laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni);
        //$count_laboratorio = count($laboratorio);

        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();
        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;

        $fecha_alta = $paciente->fecha_alta;

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        $pac_hospitalizado = Hospitalizacion::where('id_paciente', $id)->Where('dni_paciente',$dni)->first();

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
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id);
            $count_diagnostico = count($diagnostico);
            
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
            $count_diagnostico = 0;
        }
        
        
        /** foto **/
        
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
        
        //$foto='';
        return view('admin.aislamientos.editar_hospitalizacion')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('signos', $signos)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('dni', $dni)->with('id', $id)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('foto',$foto)->with('sinos', $sinos);

    }

    public function editar_evolucion($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
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
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();

        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $provincias = $model_provincias->getProvincia($paciente->id_departamento);
        $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
        $departamentos2 = $model_departamentos->getDepartamento();
        $provincias2 = $model_provincias->getProvincia($paciente->id_departamento2);
        $distritos2 = $model_distritos->getDistrito($paciente->id_departamento2,$paciente->id_provincia2);
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;


        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni);
        $count_laboratorio = count($laboratorio);

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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

        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $pac_hospitalizado = Hospitalizacion::where('id_paciente', $id)->Where('dni_paciente',$dni)->first();

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
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id);
            $count_diagnostico = count($diagnostico);
            
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
            $count_diagnostico = 0;
        }
        
        $pac_contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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
            $fecha_cuarentena_contacto=$date->format('Y-m-d'); 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso =0;
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;
        }
        
        /** foto **/
        
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
        
        //$foto='';
        return view('admin.aislamientos.editar_evolucion')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('departamentos2', $departamentos2)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('id_paciente_lab',$id_paciente_lab)->with('laboratorio',$laboratorio)->with('count_laboratorio',$count_laboratorio)->with('contacto',$contacto)->with('foto',$foto);

    }

    public function editar_laboratorio($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
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
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();

        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $provincias = $model_provincias->getProvincia($paciente->id_departamento);
        $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
        $departamentos2 = $model_departamentos->getDepartamento();
        $provincias2 = $model_provincias->getProvincia($paciente->id_departamento2);
        $distritos2 = $model_distritos->getDistrito($paciente->id_departamento2,$paciente->id_provincia2);
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;


        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni);
        $count_laboratorio = count($laboratorio);

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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

        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $pac_hospitalizado = Hospitalizacion::where('id_paciente', $id)->Where('dni_paciente',$dni)->first();

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
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id);
            $count_diagnostico = count($diagnostico);
            
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
            $count_diagnostico = 0;
        }
        
        $pac_contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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
            $fecha_cuarentena_contacto=$date->format('Y-m-d'); 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso =0;
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;
        }
        
        /** foto **/
        
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
        
        //$foto='';
        return view('admin.aislamientos.editar_laboratorio')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('departamentos2', $departamentos2)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('id_paciente_lab',$id_paciente_lab)->with('laboratorio',$laboratorio)->with('count_laboratorio',$count_laboratorio)->with('contacto',$contacto)->with('foto',$foto);

    }

    public function editar_contacto($id, $dni)
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
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
        $aislamientos = new Aislamiento();
        $signos=Signo::orderby('descripcion','asc')->get();
        $sintomas=Sintoma::orderby('descripcion','asc')->get();
        $factorriesgos=FactorRiesgo::orderby('descripcion','asc')->get();
        $ocupaciones=Ocupacione::orderby('descripcion','asc')->get();
        $lugares=Lugare::orderby('descripcion','asc')->get();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $paciente = Aislamiento::where('id', $id)->Where('dni',$dni)->first();

        $nombre_paciente=$paciente->nombres.', '.$paciente->paterno.' '.$paciente->materno;
        $provincias = $model_provincias->getProvincia($paciente->id_departamento);
        $distritos = $model_distritos->getDistrito($paciente->id_departamento,$paciente->id_provincia);
        $departamentos2 = $model_departamentos->getDepartamento();
        $provincias2 = $model_provincias->getProvincia($paciente->id_departamento2);
        $distritos2 = $model_distritos->getDistrito($paciente->id_departamento2,$paciente->id_provincia2);
        $fecha_alta = $paciente->fecha_alta;
        $fecha_defuncion = $paciente->fecha_defuncion;


        $laboratorio = $model_laboratorio->GetLaboratorioByIdPaciente($id, $dni);
        $count_laboratorio = count($laboratorio);

        if(is_null($fecha_alta))
            $fecha_alta=$date->format('Y-m-d');
        
        if(is_null($fecha_defuncion))
            $fecha_defuncion=$date->format('Y-m-d');

        $contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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

        $nota_informativa= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_defuncion= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$id)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $pac_hospitalizado = Hospitalizacion::where('id_paciente', $id)->Where('dni_paciente',$dni)->first();

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
            $diagnostico = $model_diagnostico->GetDiagnosticoByIdPaciente($id);
            $count_diagnostico = count($diagnostico);
            
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
            $count_diagnostico = 0;
        }
        
        $pac_contacto = Contacto::where('id_aislado', $id)->Where('dni_aislado',$dni)->first();

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
            $fecha_cuarentena_contacto=$date->format('Y-m-d'); 
            $contacto_sospechoso="";
            $tipo_contacto_sospechoso =0;
            $otro_factor_riesgo_contacto ="";
            $id_contacto =0;
            $id_paciente_lab=0;
        }
        
        /** foto **/
        
        
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
        
        //$foto ='';
        return view('admin.aislamientos.editar_contacto')->with('establecimientos', $establecimientos)->with('establecimiento_salud', $establecimiento_salud)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('factorriesgos', $factorriesgos)->with('sinos', $sinos)->with('aislamientos', $aislamientos)->with('signos', $signos)->with('sintomas', $sintomas)->with('ocupaciones', $ocupaciones)->with('lugares', $lugares)->with('paciente', $paciente)->with('nombre_paciente', $nombre_paciente)->with('provincias', $provincias)->with('distritos', $distritos)->with('departamentos2', $departamentos2)->with('provincias2', $provincias2)->with('distritos2', $distritos2)->with('nota_informativa', $nota_informativa)->with('certificado_defuncion', $certificado_defuncion)->with('dni', $dni)->with('id', $id)->with('establecimiento_proviene', $establecimiento_proviene)->with('fecha_hospitalizacion', $fecha_hospitalizacion)->with('establecimiento_actual', $establecimiento_actual)->with('tipo_seguro', $tipo_seguro)->with('otro_signo_ho', $otro_signo_ho)->with('servicio_hospitalizacion', $servicio_hospitalizacion)->with('ventilacion_mecanica', $ventilacion_mecanica)->with('intubado', $intubado)->with('neumonia', $neumonia)->with('uci', $uci)->with('id_hospitalizacion', $id_hospitalizacion)->with('dni_contacto', $dni_contacto)->with('name_contacto', $name_contacto)->with('paterno_contacto', $paterno_contacto)->with('materno_contacto', $materno_contacto)->with('sexo_contacto', $sexo_contacto)->with('fecha_nacimiento_contacto', $fecha_nacimiento_contacto)->with('correo_contacto', $correo_contacto)->with('telefono_contacto', $telefono_contacto)->with('domicilio_contacto', $domicilio_contacto)->with('id_departamento_contacto', $id_departamento_contacto)->with('id_provincia_contacto', $id_provincia_contacto)->with('id_distrito_contacto', $id_distrito_contacto)->with('tipo_contacto', $tipo_contacto)->with('fecha_contacto', $fecha_contacto)->with('contacto_sospechoso', $contacto_sospechoso)->with('tipo_contacto_sospechoso', $tipo_contacto_sospechoso)->with('otro_factor_riesgo_contacto', $otro_factor_riesgo_contacto)->with('id_contacto', $id_contacto)->with('departamentos3', $departamentos3)->with('provincias3', $provincias3)->with('distritos3', $distritos3)->with('fecha_cuarentena_contacto', $fecha_cuarentena_contacto)->with('pac_hospitalizado', $pac_hospitalizado)->with('diagnostico', $diagnostico)->with('count_diagnostico',$count_diagnostico)->with('fecha_alta',$fecha_alta)->with('fecha_defuncion',$fecha_defuncion)->with('id_paciente_lab',$id_paciente_lab)->with('laboratorio',$laboratorio)->with('count_laboratorio',$count_laboratorio)->with('contacto',$contacto)->with('foto',$foto);

    }




    public function store(Request $request)
    {   
        $aislamiento = new Aislamiento;
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $nombres = trim($request->name);
        $apellido_paterno = trim($request->paterno);
        $apellido_materno = trim($request->materno);
        $aislamiento->id_clasificacion=$request->id_clasificacion;
        $aislamiento->id_establecimiento=$request->id_establecimiento;
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
        /*******************************************/
        /*$aislamiento->fecha_sintoma=$request->fecha_sintoma;
        $aislamiento->fecha_aislamiento=$request->fecha_aislamiento;
        $aislamiento->id_departamento2=$request->id_departamento2;
        $aislamiento->id_provincia2=$request->id_provincia2;
        $aislamiento->id_distrito2=$request->id_distrito2;
        $aislamiento->contacto_directo=$request->contacto_directo;
        $aislamiento->ficha_contacto=$request->ficha_contacto;
        $aislamiento->caso_reinfeccion=$request->caso_reinfeccion;
        $aislamiento->ubicacion_hospitalizacion=$request->servicio_hospitalizacion;
        $aislamiento->indicacion=$request->indicacion;
        $aislamiento->motivo=$request->observacion;
        */
        /********************************************/

        $aislamiento->save();        

        $idaislamiento = $aislamiento->id; 

        /*
        $aislamiento->sintomaaislados()->attach($request->sintomas);
        $aislamiento->signoaislados()->attach($request->signos);  
        $aislamiento->factoraislados()->attach($request->factorriesgos);  
        $aislamiento->ocupacioneaislados()->attach($request->ocupaciones);   
        $aislamiento->lugaraislados()->attach($request->lugar);
        $opcion='datospaciente';
        */

        /*$id_paciente = $model_aislamiento->registrarPaciente(
            $request->id_clasificacion, $request->id_establecimiento, $fecha_registro, $request->id_user, $request->dni,$nombres, $apellido_paterno, $apellido_materno, $request->cip, $request->grado, $sexo, $request->fecha_nacimiento,$request->edad, $request->telefono,$request->unidad,$request->situacion,$request->id_categoria,$request->peso,$request->talla,$request->parentesco,$request->etnia,$request->otra_raza,$request->nacionalidad,$request->otra_nacion,$request->migrante, $request->otro_migrante,$request->domicilio,$request->id_departamento,$request->id_provincia,$request->id_distrito,$request->fecha_sintoma,$request->fecha_aislamiento,$request->id_departamento2,$request->id_provincia2,$request->id_distrito2,$request->contacto_directo);
        */

        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/registro_paciente/'. $idaislamiento.'/'.$request->dni);
         
        
    }

    public function update_datospaciente($id,Request  $request)
    {
        $aislamiento = Aislamiento::where('id', $id)->Where('dni',$request->dni)->first();
        $date = Carbon::now();

        $fecha_registro = $date->format('d-m-Y');
        $nombres = trim($request->name);
        $apellido_paterno = trim($request->paterno);
        $apellido_materno = trim($request->materno);        
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
        $aislamiento->save();        
        $opcion=$request->opcion;
        
        Flash::success('Se ha actualizado correctamente.');
        
        return redirect('/registro_paciente/'. $id.'/'.$request->dni);
    }


    public function store_antecedentes(Request $request)
    {   
        $aislamiento = new Aislamiento;
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $aislamiento->fecha_sintoma=$request->fecha_sintoma;
        $aislamiento->fecha_aislamiento=$request->fecha_aislamiento;
        $aislamiento->id_departamento2=$request->id_departamento2;
        $aislamiento->id_provincia2=$request->id_provincia2;
        $aislamiento->id_distrito2=$request->id_distrito2;
        $aislamiento->contacto_directo=$request->contacto_directo;
        $aislamiento->ficha_contacto=$request->ficha_contacto;
        $aislamiento->caso_reinfeccion=$request->caso_reinfeccion;
        $aislamiento->ubicacion_hospitalizacion=$request->servicio_hospitalizacion;
        $aislamiento->indicacion=$request->indicacion;
        $aislamiento->motivo=$request->observacion;
        $aislamiento->save();        
        $idaislamiento = $aislamiento->id; 

        $aislamiento->sintomaaislados()->attach($request->sintomas);
        $aislamiento->signoaislados()->attach($request->signos);  
        $aislamiento->factoraislados()->attach($request->factorriesgos);  
        $aislamiento->ocupacioneaislados()->attach($request->ocupaciones);   
        $aislamiento->lugaraislados()->attach($request->lugar);
        $opcion='datospaciente';

        Flash::success('Se ha registrado correctamente.');
        return redirect('/registro_paciente/'. $idaislamiento.'/'.$request->dni);
    }

    
    public function update_antecedente_epidemiologico($id, Request $request)
    {
        $aislamiento = Aislamiento::where('id', $id)->Where('dni',$request->dni_antecedente)->first();
        
        $date = Carbon::now();

        $fecha_registro = $date->format('d-m-Y');
        $aislamiento->fecha_sintoma=$request->fecha_sintoma;
        $aislamiento->fecha_aislamiento=$request->fecha_aislamiento;
        $aislamiento->id_departamento2=$request->id_departamento2;
        $aislamiento->id_provincia2=$request->id_provincia2;
        $aislamiento->id_distrito2=$request->id_distrito2;
        $aislamiento->contacto_directo=$request->contacto_directo;
        $aislamiento->ficha_contacto=$request->ficha_contacto;
        $aislamiento->caso_reinfeccion=$request->caso_reinfeccion;
        $aislamiento->ubicacion_hospitalizacion=$request->ubicacion_hospitalizacion;
        $aislamiento->indicacion=$request->indicacion;
        $aislamiento->motivo=$request->observacion;

        $aislamiento->save();        

        $idaislamiento = $aislamiento->id;


        $this->registra_checkbok($request->sintomas, 'aislamiento_sintoma', $id, $request->dni_antecedente, 'sintomaaislados','sintoma_id');
        $this->registra_checkbok($request->signos, 'aislamiento_signo', $id, $request->dni_antecedente, 'signoaislados','signo_id');
        $this->registra_checkbok($request->factorriesgos, 'aislamiento_factor_riesgo', $id, $request->dni_antecedente, 'factoraislados','factor_riesgo_id');
        $this->registra_checkbok($request->ocupaciones, 'aislamiento_ocupacione', $id, $request->dni_antecedente, 'ocupacioneaislados','ocupacione_id');
        $this->registra_checkbok($request->lugar, 'aislamiento_lugare', $id, $request->dni_antecedente, 'lugaraislados','lugare_id');
        /*$aislamiento->sintomaaislados()->attach($request->sintomas);
        $aislamiento->signoaislados()->attach($request->signos);  
        $aislamiento->factoraislados()->attach($request->factorriesgos);  
        $aislamiento->ocupacioneaislados()->attach($request->ocupaciones);   
        $aislamiento->lugaraislados()->attach($request->lugar); */
        $opcion=$request->opcion;

        Flash::success('Se ha actualizado correctamente.');
        
        return redirect('/registro_paciente/'. $id.'/'.$request->dni_antecedente);
    }

    public function registra_checkbok($checkboxs, $tabla, $id_aislado, $dni, $objeto,$campo_id )
    {
        $aislamiento = Aislamiento::where('id', $id_aislado)->Where('dni',$dni)->first();
        $num_items=DB::table($tabla)->where('aislamiento_id',$id_aislado)->count();

        //Sino se ha marcado ningun checkbox
        if (empty($checkboxs)) {
           if($num_items>0){
                $elimina_bd=DB::table($tabla)->where('aislamiento_id',$id_aislado)->delete();
           }
        }else
        {
            //si esta vacio llenamos
            if($num_items==0){
                $aislamiento->$objeto()->attach($checkboxs); 
            }
            else
            {
                $datos_bd=DB::table($tabla)->where('aislamiento_id',$id_aislado)->get();
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
                    $aislamiento->$objeto()->attach($datos_nuevos); //attach  
                }
                ///eliminamos los que no estan en los checkbox
                if($num_datos_desmarcado>0){
                    $aislamiento->$objeto()->detach($datos_desmarcado); //attach           
                }
            }
        }
    }
    
    public function store_hospitalizacion(Request $request)
    {        
        $sw = 0 ;
        if($request->id_hospitalizacion==0){
            $hospitalizado = new Hospitalizacion;   
        }
        else{
            $hospitalizado = Hospitalizacion::where('id', $request->id_hospitalizacion)->where('id_paciente', $request->id_paciente_hospitalizacion)->Where('dni_paciente',$request->dni_hospitalizacion)->first();   
            $sw = 1 ;   
        }
        
        $date = Carbon::now();
        $fecha_registro = $date->format('d-m-Y');
        $hospitalizado->dni_paciente = $request->dni_hospitalizacion;
        $hospitalizado->id_paciente = $request->id_paciente_hospitalizacion;
        $hospitalizado->fecha_registro=$fecha_registro;
        $hospitalizado->establecimiento_proviene=$request->establecimiento;
        $hospitalizado->fecha_hospitalizacion=$request->fecha_hospitalizacion;
        $hospitalizado->establecimiento_actual=$request->establecimiento_salud;
        $hospitalizado->tipo_seguro=$request->tipo_seguro;
        $hospitalizado->otro_signo_ho=$request->otro_signo_ho;
        $hospitalizado->servicio_hospitalizacion=$request->servicio_hospitalizacion;
        $hospitalizado->intubado=$request->intubado;
        $hospitalizado->uci=$request->uci;
        $hospitalizado->ventilacion_mecanica=$request->ventilacion_mecanica;
        $hospitalizado->neumonia=$request->neumonia;
        $hospitalizado->save();        
        
        if($sw == 0 ){
            $hospitalizado->signohospitalizados()->attach($request->signos_hospitalizacion);
        }
        else
        {
            $num_items=DB::table('hospitalizacion_signo')->where('hospitalizacion_id',$request->id_hospitalizacion)->count();

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
                    DB::table('aislado_diagnosticos')
                    ->insert([                    
                        'id_aislado' => $request->id_paciente_hospitalizacion,
                        'id_diagnostico' => $id_diagnostico,
                        'id_tipo_diagnostico' => $id_tipo_diagnostico,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
            
        return redirect('/registro_paciente/'. $request->id_paciente_hospitalizacion.'/'.$request->dni_hospitalizacion);
    }



    public function store_evolucion_paciente(Request $request)
    {   
        $paciente = Aislamiento::where('id', $request->id_paciente_evolucion)->Where('dni',$request->dni_evolucion)->first();

        $date = Carbon::now();
        //$paciente->evolucion=$request->evolucion;

        if($request->evolucion==4){
            $paciente->fecha_alta=$request->fecha_alta;
        }
        if($request->evolucion==3){
        /*    $paciente->tipo_defuncion=$request->tipo_defuncion;
            $paciente->fecha_defuncion=$request->fecha_defuncion;
            $paciente->hora_defuncion=$request->hora_defuncion;
            $paciente->lugar_defuncion=$request->lugar_defuncion;
            $paciente->causa_muerte=$request->causa_muerte;
            $paciente->motivo_muerte=$request->motivo_muerte;
        */
            
            if(isset($request->id_tipo_certificado)):
                
                foreach ($request->id_tipo_certificado as $key => $value):
                    if($request->id_tipo_certificado[$key]!=""){

                        $tipo_certificado=$request->id_tipo_certificado[$key];
                        $nro_doc=$request->nro_doc[$key];
                        $fecha_doc=$request->id_fecha_doc[$key];
                        $dni= $request->dni_evolucion;

                        if ($request->hasFile('photo')){
                            dd($request);
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

                        /*DB::table('defunciones')
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
                        */
                    }
                endforeach;
            endif;
        }

        $paciente->save();        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/registro_paciente/'. $request->id_paciente_evolucion.'/'.$request->dni_evolucion);
        
    }
    public function store_laboratorio(Request $request)
    {        
        if($request->id_paciente_lab==0){
            $laboratorio = new Laboratorio();    
        }
        else{
            $laboratorio = Laboratorio::where('id_paciente', $request->id_paciente_lab)->Where('dni_paciente',$request->dni_lab)->first();      
        }
        
        if(isset($request->fecha_muestra)):
            
            foreach ($request->fecha_muestra as $key => $value):
                if($request->fecha_muestra[$key]!=""){

                    $fecha_muestra=$request->fecha_muestra[$key];
                    $id_item_tipo_muestra=$request->id_item_tipo_muestra[$key];
                    $id_item_tipo_prueba=$request->id_item_tipo_prueba[$key];
                    $id_item_resultado=$request->id_item_resultado[$key];
                    $id_fecha_resultado=$request->id_fecha_resultado[$key];
                    $id_item_minsa=$request->id_item_minsa[$key];
                    
                    DB::table('laboratorios')
                    ->insert([                    
                        'id_paciente' => $request->id_paciente_lab,
                        'dni_paciente' => $request->dni_lab,
                        'fecha_muestra' => $fecha_muestra,
                        'tipo_muestra' => $id_item_tipo_muestra,
                        'tipo_prueba' => $id_item_tipo_prueba,
                        'resultado_muestra' => $id_item_resultado,
                        'fecha_resultado' => $id_fecha_resultado,
                        'enviado_minsa' => $id_item_minsa,
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now()
                    ]);
                }
            endforeach;
        endif;
        
        $opcion=$request->opcion;
        Flash::success('Se ha registrado correctamente.');
        
        return redirect('/registro_paciente/'. $request->id_paciente_lab.'/'.$request->dni_lab);
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
        $contacto->save();

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
        
        return redirect('/registro_paciente/'. $request->id_paciente_contacto.'/'.$request->dni_paciente_contacto);
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
            Flash::error('Aislamiento no encontrado');
            return redirect(route('aislamientos.index'));
        }
        
        $pdf = \PDF::loadView('admin.pdf.descargar_aislamiento_pdf',['aislamientos'=>$aislamientos]);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('aislamiento.pdf');        
    } 

    public function todos_registros($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->id_establecimiento;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = "";
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        //$fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaDesde = $date->format('d-m-Y');
        $fechaHasta = $date->format('d-m-Y');
        $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado);

        

        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        
        //====================
        return view('admin.aislamientos.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));

        
    }

    public function todos_registros_hospitalizacion($id_riesgo = 0) {

        $rol=Auth::user()->rol;
        $id_establecimiento = Auth::user()->id_establecimiento;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = 3;
        $tiempo = "";
        $date = Carbon::now();
        
        $model_aislamientos = new Aislamiento();
        $fechaDesde = $model_aislamientos->getFechaServidorRestaMeses(1);
        $fechaHasta = $date->format('d-m-Y');
        $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $estado, $id_riesgo);
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        
        $model_informe= new InformeRiesgo();
        $informeriesgos = $model_informe->getInformeRiesgo();            
        //====================
        return view('admin.aislamientos.all_aislamientos_hospitalizacion', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'estado','departamentos'));

        
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

        $estado = 3;
       
        if($rol==1){
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $departamento, $provincia, $distrito);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'departamentos','Sintomas'));
        }
        else
        {
            
            //====================
            $model_aislamientos = new Aislamiento();
            $aislamientos = $model_aislamientos->AllAislamientosFechaDesdeHasta($fechaDesde, $fechaHasta, $dni_beneficiario, $departamento, $provincia, $distrito);
            $model_departamentos= new Departamento();
            $departamentos = $model_departamentos->getDepartamento();
            $fechaServidor = $fechaHasta = $date->format('d-m-Y');
            $model_categorias= new PnpCategoria();
            $pnpcategorias = $model_categorias->getPnpCategoria();
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            //====================
            return view('admin.aislamientos.all_aislamientos', compact('aislamientos', 'fechaDesde', 'fechaHasta', 'dni_beneficiario','departamentos','Sintomas'));
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


    


}
