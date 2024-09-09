<?php

namespace App\Http\Controllers\Site;

use DB;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Reclamacione;
use App\Models\Solucione;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Establecimiento;
use App\Models\User;
use App\Repositories\ReclamacioneRepository;
use App\Http\Requests\CreateReclamacioneRequest;
use Carbon\Carbon;
use SoapClient;


use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ReclamacioneController extends AppBaseController
{
    /** @var  EstablecimientosRepository */
    private $reclamacioneRepository;

    public function __construct(ReclamacioneRepository $reclamacioneRepo)
    {
        $this->reclamacioneRepository = $reclamacioneRepo;
    }

    /**
     * Display a listing of the Establecimientos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getTodasReclamaciones();
        
        return view('site.reclamaciones.index')
            ->with('reclamaciones', $reclamaciones);
    }

    /**
     * Show the form for creating a new Establecimientos.
     *
     * @return Response
     */
    public function create()
    {
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y'); 
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');

        return view('site.reclamaciones.index')->with('establecimientos', $establecimientos)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos);
    }

    public function store(Request $request)
    {
        
        
        $reclamacion = new Reclamacione;
        $fechaHasta = $reclamacion->getFechaServidorRestaMeses(-1);

        $date = Carbon::now();

        $reclamacion->fecha_reclamacion = $request->fecha_reclamo;
        $reclamacion->fecha_registro = $date->format('d-m-Y');        
        $reclamacion->nro_reclamacion = $request->nro_reclamacion;
        $reclamacion->id_establecimiento = $request->id_establecimiento;

        $reclamacion->tipo_doc = $request->tipo_doc;
        $reclamacion->nro_doc = trim($request->nro_doc);

        $reclamacion->nombres = trim($request->name);
        $reclamacion->apellido_paterno = trim($request->paterno);
        $reclamacion->apellido_materno = trim($request->materno);

        $reclamacion->id_departamento = $request->id_departamento;
        $reclamacion->id_provincia = $request->id_provincia;
        $reclamacion->id_distrito = $request->id_distrito;
        
        $reclamacion->domicilio = $request->domicilio;
        $reclamacion->email = $request->email;
        $reclamacion->telefono = $request->telefono;
        $reclamacion->otro_usuario = 'NO';

        $otro=0;
        if($request->selectall=='SI'){

            $reclamacion->tipo_doc2 = $request->tipo_doc_2;
            $reclamacion->nro_doc2 = trim($request->nro_doc_2);

            $reclamacion->nombres2 = trim($request->name_2);
            $reclamacion->apellido_paterno2 = trim($request->paterno_2);
            $reclamacion->apellido_materno2 = trim($request->materno_2);

            $reclamacion->id_departamento2 = $request->id_departamento_2;
            $reclamacion->id_provincia2 = $request->id_provincia_2;
            $reclamacion->id_distrito2 = $request->id_distrito_2;
            
            $reclamacion->domicilio2 = $request->domicilio_2;
            $reclamacion->email2 = $request->email_2;
            $reclamacion->telefono2 = $request->telefono_2;
            $reclamacion->otro_usuario = 'SI';
            $otro=1;

        }    
        
        $reclamacion->reclamo = $request->descripcion;        
        $reclamacion->autorizar_envio = $request->notificado;    
        $reclamacion->ano_reclamacion = $date->format('Y');       
        $reclamacion->fecha_vencimiento = $fechaHasta;

        $reclamacion->save();        

        $idreclamacion = $reclamacion->id;

        $input = $request->all();
        
        if ($request->hasFile('photo')){
            $name_photo = time().'-'.$request->photo->getClientOriginalName();
            $original_name=$request->photo->getClientOriginalName();
            $input['photo'] = '/upload/photo/'.$request->nro_doc.'/'.$name_photo;            
            $request->photo->move(public_path('/upload/photo/'.$request->nro_doc.'/'), $input['photo']);
            $extension_archivo= $request->photo->getClientOriginalExtension();

            DB::table('archivos')
            ->insert([
                'dni' => $request->nro_doc,
                'reclamacion_id' => $idreclamacion,                
                'nombre_archivo'=>$original_name,
                'descarga_archivo'=>$input['photo'],
                'extension_archivo'=>$extension_archivo,
                'created_at'=>Carbon::now(),
            ]);
        }

        
 
        Flash::success('Se ha registrado correctamente su reclamo.');
        return redirect('/mostrar_agradecimiento/' . $idreclamacion. '/' .$otro);
    }

    public function mostrar_agradecimiento($id,$otro)
    {   
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getReclamaciones($id);
        if($otro==0){
            $nombre=$reclamaciones->nombres.' '. $reclamaciones->apellido_paterno;            
        }
        else
        {
            if($otro==1){
                $nombre=$reclamaciones->nombres2.' '. $reclamaciones->apellido_paterno2;
            }
            else
            {
             Flash::success('Usuario no registrado.');
             return redirect(route('reclamacionesite.index'));   
            }

        }
        $numero_reclamo=$reclamaciones->nro_reclamacion;
        return view('site.reclamaciones.agradecimiento')->with('nombre', $nombre)->with('numero_reclamo', $numero_reclamo)->with('id_reclamacion', $id)->with('otro', $otro);
    }
    /**
     * Display the specified Establecimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getReclamaciones($id);

//        $establecimientos = $this->establecimientoRepository->findWithoutFail($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacionesite.index'));
        }

        return view('site.reclamaciones.show')->with('reclamaciones', $reclamaciones);
    }

    /**
     * Show the form for editing the specified Establecimientos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getReclamaciones($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacionesite.index'));
        }
        return view('site.reclamaciones.edit')->with('reclamaciones', $reclamaciones);
    }

    /**
     * Update the specified Establecimientos in storage.
     *
     * @param  int              $id
     * @param UpdateEstablecimientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReclamacioneRequest $request)
    {
        $reclamaciones = $this->reclamacioneRepository->findWithoutFail($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacionesite.index'));
        }

        $reclamaciones = $this->reclamacioneRepository->update($request->all(), $id);

        Flash::success('Reclamaciones actualizado satisfactoriamente.');

        return redirect(route('reclamacionesite.index'));
    }

    /**
     * Remove the specified Reclamaciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reclamaciones = $this->reclamacioneRepository->findWithoutFail($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacionesite.index'));
        }

        $this->reclamacioneRepository->delete($id);

        Flash::success('Reclamaciones eliminado.');

        return redirect(route('reclamacione.index'));
    }

    public function carganroreclamacion($id) {
        $model = new Reclamacione();
        $nro = $model->GetByNroReclamacion($id);
        $model = new Establecimiento();
        $codigo = $model->GetByCodigo($id);        
        
        $numero=($codigo[0]->cod_ipress.''.$nro[0]->numero);

        return $numero;
    }

    public function buscar_personal_dni2($nro_doc, $tipo_doc) {
        
        $beneficiario=DB::connection('pgsql2')
                    ->table('beneficiarios')
                    ->select('beneficiarios.*')
                    ->where('nrodocafiliado',$nro_doc)
                    ->where('nomtipdocafiliado',$tipo_doc)
                    ->get();
        
        //dd($beneficiario[0]);
        return $beneficiario;
    }   

    public function buscar_personal_dni($nro_doc) {
    //public function buscar_personal_dni_pnp($nro_doc) {
        $location_URL = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc';
        $wsdl = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

        $sw = false;
        $beneficiario_encontrado = "";

        $client = new SoapClient($wsdl, array(
            'location' => $location_URL,
            'uri'      => "",
            'trace'    => 1,            
            ));

        $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'SISTEMA DE GESTION DE FARMACIA', 'Operador'=>'31081306']);
       
        $json = json_encode($busca_datos);
        $beneficiario_encontrado = json_decode($json,TRUE);
        $beneficiario = new User;
        $ncont_titular=0;
        

        if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
            if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
            }
            if($ncont_titular>1){                
                $beneficiario->nompaisdelafiliado='PER';
                $beneficiario->nomtipdocafiliado='DNI';
                $beneficiario->nrodocafiliado=$nro_doc;
                $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];                
                $beneficiario->apecasafiliado='';
                $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                $originalDate = $beneficiario->fecnacafiliado;
                $fech_nac = explode("/", $originalDate);
                $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];                
                $dbDate = Carbon::parse($nacimiento);
                $diffYears = Carbon::now()->diffInYears($dbDate);
                $beneficiario->edadafiliado=$diffYears;
                $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                if($beneficiario->nomsexo=='FEMENINO')
                    $beneficiario->nomsexo='F';
                else
                    $beneficiario->nomsexo='M';
                $beneficiario->estado='ACTIVO';
                $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                $beneficiario->nomtipdoctitular='DNI';
                $beneficiario->nrodoctitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['DNI'];
                $beneficiario->apepattitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                $beneficiario->apemattitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];                
                $beneficiario->apecastitular='';
                $beneficiario->nomtitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                $beneficiario->ubigeo='';
                $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];                                
                $beneficiario->caducidad='';
                $beneficiario->discapacidad=0;
                $beneficiario->otroseguro='FONAFUN';
                $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                $sw = true;
            }
            else
            {   
                foreach($beneficiario_encontrado as $beneficiario1){
                    
                    $beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$nro_doc;                
                    $beneficiario->apepatafiliado=$beneficiario1['TitularFamiliar']['PATERNO'];
                    $beneficiario->apematafiliado=$beneficiario1['TitularFamiliar']['MATERNO'];
                    $beneficiario->apecasafiliado='';
                    $beneficiario->nomafiliado=$beneficiario1['TitularFamiliar']['NOMBRES'];
                    $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                    $originalDate = $beneficiario->fecnacafiliado;
                    $fech_nac = explode("/", $originalDate);                    
                    $nacimiento='';
                    if(count($fech_nac)==3){
                    $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0]; 
                    }             
                    $dbDate = Carbon::parse($nacimiento);
                    $diffYears = Carbon::now()->diffInYears($dbDate);
                    $beneficiario->edadafiliado=$diffYears;
                    $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                    if($beneficiario->nomsexo=='FEMENINO')
                        $beneficiario->nomsexo='F';
                    else
                        $beneficiario->nomsexo='M';
                    $beneficiario->estado='ACTIVO';
                    $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                    $beneficiario->nomtipdoctitular='DNI';
                    $beneficiario->nrodoctitular=$beneficiario1['TitularFamiliar']['DNI'];
                    $beneficiario->apepattitular=$beneficiario1['TitularFamiliar']['PATERNO'];
                    $beneficiario->apemattitular=$beneficiario1['TitularFamiliar']['MATERNO'];
                    $beneficiario->apecastitular='';
                    $beneficiario->nomtitular=$beneficiario1['TitularFamiliar']['NOMBRES'];
                    $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                    $beneficiario->ubigeo='';
                    $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                    $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                    $beneficiario->caducidad='';
                    $beneficiario->discapacidad=0;
                    $beneficiario->otroseguro='FONAFUN';
                    $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                    $sw = true;
                }
            }
        }

        if($sw==false){

            $busca_datos_familiar = $client->BuscarTitularFamiliar(['TipoBusqueda' => 3,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'SISTEMA DE GESTION DE FARMACIA', 'Operador'=>'31081306']);
       
            $json_familiar = json_encode($busca_datos_familiar);
            $beneficiario_encontrado = json_decode($json_familiar,TRUE);
            $ncont_titular=0;

            if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                    $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
                }
                if($ncont_titular>1){                
                    $beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$nro_doc;
                    $beneficiario->apepatafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                    $beneficiario->apematafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];                
                    $beneficiario->apecasafiliado='';
                    $beneficiario->nomafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                    $beneficiario->fecnacafiliado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NACIMIENTO'];
                    $originalDate = $beneficiario->fecnacafiliado;
                    $fech_nac = explode("/", $originalDate);
                    $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];                
                    $dbDate = Carbon::parse($nacimiento);
                    $diffYears = Carbon::now()->diffInYears($dbDate);
                    $beneficiario->edadafiliado=$diffYears;
                    $beneficiario->nomsexo=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SEXO'];
                    if($beneficiario->nomsexo=='FEMENINO')
                        $beneficiario->nomsexo='F';
                    else
                        $beneficiario->nomsexo='M';
                    $beneficiario->estado='ACTIVO';
                    $beneficiario->parentesco=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['TIPO']; //ver tipo
                    $beneficiario->nomtipdoctitular='DNI';
                    $beneficiario->nrodoctitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['DNI'];
                    $beneficiario->apepattitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                    $beneficiario->apemattitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];                
                    $beneficiario->apecastitular='';
                    $beneficiario->nomtitular=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                    $beneficiario->cip=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                    $beneficiario->ubigeo='';
                    $beneficiario->grado=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                    $beneficiario->situacion=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['SITUACION'];                                
                    $beneficiario->caducidad='';
                    $beneficiario->discapacidad=0;
                    $beneficiario->otroseguro='FONAFUN';
                    $beneficiario->unidad=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['UNIDAD'];
                    $sw = true;
                }
                else
                {   
                    foreach($beneficiario_encontrado as $beneficiario1){
                        
                        $beneficiario->nompaisdelafiliado='PER';
                        $beneficiario->nomtipdocafiliado='DNI';
                        $beneficiario->nrodocafiliado=$nro_doc;                
                        $beneficiario->apepatafiliado=$beneficiario1['TitularFamiliar']['PATERNO'];
                        $beneficiario->apematafiliado=$beneficiario1['TitularFamiliar']['MATERNO'];
                        $beneficiario->apecasafiliado='';
                        $beneficiario->nomafiliado=$beneficiario1['TitularFamiliar']['NOMBRES'];
                        $beneficiario->fecnacafiliado=$beneficiario1['TitularFamiliar']['NACIMIENTO'];
                        $originalDate = $beneficiario->fecnacafiliado;
                        $fech_nac = explode("/", $originalDate);                    
                        $nacimiento='';
                        if(count($fech_nac)==3){
                        $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0]; 
                        }             
                        $dbDate = Carbon::parse($nacimiento);
                        $diffYears = Carbon::now()->diffInYears($dbDate);
                        $beneficiario->edadafiliado=$diffYears;
                        $beneficiario->nomsexo=$beneficiario1['TitularFamiliar']['SEXO'];
                        if($beneficiario->nomsexo=='FEMENINO')
                            $beneficiario->nomsexo='F';
                        else
                            $beneficiario->nomsexo='M';
                        $beneficiario->estado='ACTIVO';
                        $beneficiario->parentesco=$beneficiario1['TitularFamiliar']['TIPO'];
                        $beneficiario->nomtipdoctitular='DNI';
                        $beneficiario->nrodoctitular=$beneficiario1['TitularFamiliar']['DNI'];
                        $beneficiario->apepattitular=$beneficiario1['TitularFamiliar']['PATERNO'];
                        $beneficiario->apemattitular=$beneficiario1['TitularFamiliar']['MATERNO'];
                        $beneficiario->apecastitular='';
                        $beneficiario->nomtitular=$beneficiario1['TitularFamiliar']['NOMBRES'];
                        $beneficiario->cip=$beneficiario1['TitularFamiliar']['CARNE'];
                        $beneficiario->ubigeo='';
                        $beneficiario->grado=$beneficiario1['TitularFamiliar']['GRADO'];
                        $beneficiario->situacion=$beneficiario1['TitularFamiliar']['SITUACION'];
                        $beneficiario->caducidad='';
                        $beneficiario->discapacidad=0;
                        $beneficiario->otroseguro='FONAFUN';
                        $beneficiario->unidad=$beneficiario1['TitularFamiliar']['UNIDAD'];
                        $sw = true;
                    }
                }
            }
        }

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
          "inDni"=>$nro_doc,
          "inPioridad"=>"priority"
        );

//        $respuesta = $soapClient->consultarDniMenor($parametros);
        $respuesta = $soapClient->consultarDniMayor($parametros);

        //dd($respuesta);
            
        switch ($respuesta->resultadoDniMayor->codigoMensaje) {
          case 'MR':
            $datos_rinec = array(
              "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
              "descripcionMensaje" => "No se encontraron datos en RENIEC relacionados al número del documento"
            );
            return json_encode($datos_rinec, TRUE);
            break;
          
          case '17':
            $datos_rinec = array(
              "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
              "descripcionMensaje" => "Surgieron problemas al conectarse al servidor RENIEC, intente de nuevo"
            );
            return json_encode($datos_rinec, TRUE);
            break;
        }

        if($sw==true){

            $foto = base64_encode($respuesta->resultadoDniMayor->foto);
            $beneficiario->departamento=utf8_encode($respuesta->resultadoDniMayor->departamentoDomicilio);
            $beneficiario->provincia=utf8_encode($respuesta->resultadoDniMayor->provinciaDomicilio);
            $beneficiario->emision=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
            $beneficiario->distrito=utf8_encode($respuesta->resultadoDniMayor->distritoDomicilio);
            $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMayor->direccionDomicilio);
            $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMayor->estatura);
            $beneficiario->foto=$foto;
            $sw=true;
        }
        else
        {
            
            $beneficiario->nompaisdelafiliado='PER';
            $beneficiario->nomtipdocafiliado='DNI';
            $beneficiario->nrodocafiliado=$nro_doc;
            $beneficiario->apepatafiliado=utf8_encode($respuesta->resultadoDniMayor->paterno);
            $beneficiario->apematafiliado=utf8_encode($respuesta->resultadoDniMayor->materno);
            $beneficiario->apecasafiliado='';
            $beneficiario->nomafiliado=utf8_encode($respuesta->resultadoDniMayor->nombres);
            $beneficiario->fecnacafiliado=utf8_encode($respuesta->resultadoDniMayor->fechaNacimiento);
            $originalDate = $beneficiario->fecnacafiliado;
            $nacimiento=$originalDate[8].$originalDate[9].'-'.$originalDate[5].$originalDate[6].'-'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
            $fecha_nacimiento=$originalDate[8].$originalDate[9].'/'.$originalDate[5].$originalDate[6].'/'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
            $beneficiario->fecnacafiliado=$fecha_nacimiento;
            $dbDate = Carbon::parse($nacimiento);
            $diffYears = Carbon::now()->diffInYears($originalDate);
            $beneficiario->edadafiliado=$diffYears;
            $beneficiario->nomsexo=utf8_encode($respuesta->resultadoDniMayor->sexo);
            if($beneficiario->nomsexo=='FEMENINO')
                $beneficiario->nomsexo='F';
            else
                $beneficiario->nomsexo='M';
            $foto = base64_encode($respuesta->resultadoDniMayor->foto);
            $beneficiario->estado='';
            $beneficiario->parentesco='';
            $beneficiario->nomtipdoctitular='DNI';
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
            $beneficiario->departamento=utf8_encode($respuesta->resultadoDniMayor->departamentoDomicilio);
            $beneficiario->provincia=utf8_encode($respuesta->resultadoDniMayor->provinciaDomicilio);
            $beneficiario->emision=utf8_encode($respuesta->resultadoDniMayor->fechaExpedicion);
            $beneficiario->distrito=utf8_encode($respuesta->resultadoDniMayor->distritoDomicilio);
            $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMayor->direccionDomicilio);
            $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMayor->estatura);
            $beneficiario->foto=$foto;
            $sw=true;

        }

        /*
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
          "inDni"=>$nro_doc,
          "inPioridad"=>"priority"
        );

        $respuesta = $soapClient->consultarDniMenor($parametros);
        
        dd($respuesta);

        switch ($respuesta->resultadoDniMenor->codigoMensaje) {
          case 'MR':
            $datos_rinec = array(
              "codigoMensaje" => $respuesta->resultadoDniMenor->codigoMensaje,
              "descripcionMensaje" => "No se encontraron datos en RENIEC relacionados al número del documento"
            );
            return json_encode($datos_rinec, TRUE);
            break;
          
          case '17':
            $datos_rinec = array(
              "codigoMensaje" => $respuesta->resultadoDniMenor->codigoMensaje,
              "descripcionMensaje" => "Surgieron problemas al conectarse al servidor RENIEC, intente de nuevo"
            );
            return json_encode($datos_rinec, TRUE);
            break;
        }

        if($sw==true){

            $foto = base64_encode($respuesta->resultadoDniMenor->foto);
            $beneficiario->departamento=utf8_encode($respuesta->resultadoDniMenor->departamentoDomicilio);
            $beneficiario->provincia=utf8_encode($respuesta->resultadoDniMenor->provinciaDomicilio);
            $beneficiario->emision=utf8_encode($respuesta->resultadoDniMenor->fechaExpedicion);
            $beneficiario->distrito=utf8_encode($respuesta->resultadoDniMenor->distritoDomicilio);
            $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMenor->direccionDomicilio);
            $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMenor->estatura);
            $beneficiario->foto=$foto;
            $sw=true;
        }
        else
        {
            
            $beneficiario->nompaisdelafiliado='PER';
            $beneficiario->nomtipdocafiliado='DNI';
            $beneficiario->nrodocafiliado=$nro_doc;
            $beneficiario->apepatafiliado=utf8_encode($respuesta->resultadoDniMenor->paterno);
            $beneficiario->apematafiliado=utf8_encode($respuesta->resultadoDniMenor->materno);
            $beneficiario->apecasafiliado='';
            $beneficiario->nomafiliado=utf8_encode($respuesta->resultadoDniMenor->nombres);
            $beneficiario->fecnacafiliado=utf8_encode($respuesta->resultadoDniMenor->fechaNacimiento);
            $originalDate = $beneficiario->fecnacafiliado;
            $nacimiento=$originalDate[8].$originalDate[9].'-'.$originalDate[5].$originalDate[6].'-'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
            $fecha_nacimiento=$originalDate[8].$originalDate[9].'/'.$originalDate[5].$originalDate[6].'/'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
            $beneficiario->fecnacafiliado=$fecha_nacimiento;
            $dbDate = Carbon::parse($nacimiento);
            $diffYears = Carbon::now()->diffInYears($originalDate);
            $beneficiario->edadafiliado=$diffYears;
            $beneficiario->nomsexo=utf8_encode($respuesta->resultadoDniMenor->sexo);
            if($beneficiario->nomsexo=='FEMENINO')
                $beneficiario->nomsexo='F';
            else
                $beneficiario->nomsexo='M';
            $foto = base64_encode($respuesta->resultadoDniMenor->foto);
            $beneficiario->estado='';
            $beneficiario->parentesco='';
            $beneficiario->nomtipdoctitular='DNI';
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
            $beneficiario->departamento=utf8_encode($respuesta->resultadoDniMenor->departamentoDomicilio);
            $beneficiario->provincia=utf8_encode($respuesta->resultadoDniMenor->provinciaDomicilio);
            $beneficiario->emision=utf8_encode($respuesta->resultadoDniMenor->fechaExpedicion);
            $beneficiario->distrito=utf8_encode($respuesta->resultadoDniMenor->distritoDomicilio);
            $beneficiario->domicilio=utf8_encode($respuesta->resultadoDniMenor->direccionDomicilio);
            $beneficiario->estatura=utf8_encode($respuesta->resultadoDniMenor->estatura);
            $beneficiario->foto=$foto;
            $sw=true;

        }

        */
        
        $array["sw"] = $sw;
        $array["beneficiario"] = $beneficiario;
        
        echo json_encode($array);

    }
    /*
    public function buscar_personal_dni($nro_doc, $tipo_doc) {
        
        //$location_URL = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc';
        //$wsdl = 'https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

        $location_URL = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc';
        $wsdl = 'https://sigcpd.policia.gob.pe:7071/TitularFamiliarWS.svc?singleWsdl';

        $client = new SoapClient($wsdl, array(
            'location' => $location_URL,
            'uri'      => "",
            'trace'    => 1,            
            ));
        
        //$busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => '32089474','Clave' => '47498023']);
        $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'LIBRO DE RECLAMACIONES', 'Operador'=>'31081306']);

       
        $json = json_encode($busca_datos);
        $beneficiario_encontrado = json_decode($json,TRUE);
        $beneficiario["dni"]='0';        

        $dni_beneficiario=$nro_doc;
        $cont=0;
        $ncont_titular=0;
        $ncont_familiar=0;

        if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
            if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){
                $ncont_titular=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                
            }
            if($ncont_titular>1){                
                $beneficiario["dni"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['DNI'];
                $beneficiario["nombre"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                $beneficiario["paterno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                $beneficiario["materno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                $beneficiario["carne"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                $beneficiario["grado"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
            }
            else
            {
                $beneficiario["dni"]=$dni_beneficiario;
                foreach($beneficiario_encontrado as $beneficiario1){
                    $beneficiario["nombre"]=$beneficiario1['TitularFamiliar']['NOMBRES'];
                    $beneficiario["paterno"]=$beneficiario1['TitularFamiliar']['PATERNO'];
                    $beneficiario["materno"]=$beneficiario1['TitularFamiliar']['MATERNO'];
                    $beneficiario["carne"]=$beneficiario1['TitularFamiliar']['CARNE'];
                    $beneficiario["grado"]=$beneficiario1['TitularFamiliar']['GRADO'];
                }
            }
        }
        else
        {
            $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 3,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'LIBRO DE RECLAMACIONES', 'Operador'=>'31081306']);
            $json = json_encode($busca_datos);
            $beneficiario_encontrado = json_decode($json,TRUE);
            if($beneficiario_encontrado['BuscarTitularFamiliarResult']!=null){
                if(count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'])<13){ 
                    $ncont_familiar=count($beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']);                    
                }
                if($ncont_titular>1){  
                    $beneficiario["dni"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['DNI'];
                    $beneficiario["nombre"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['NOMBRES'];
                    $beneficiario["paterno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['PATERNO'];
                    $beneficiario["materno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['MATERNO'];
                    $beneficiario["carne"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['CARNE'];
                    $beneficiario["grado"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar'][0]['GRADO'];
                }
                else
                {
                    $beneficiario["dni"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['DNI'];
                    $beneficiario["nombre"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['NOMBRES'];
                    $beneficiario["paterno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['PATERNO'];
                    $beneficiario["materno"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['MATERNO'];
                    $beneficiario["carne"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['CARNE'];
                    $beneficiario["grado"]=$beneficiario_encontrado['BuscarTitularFamiliarResult']['TitularFamiliar']['GRADO'];
                }
            }   
        }

        if($beneficiario["dni"]=='Usuario no existe172.31.1.4')
            $beneficiario["dni"]='0';
        
        return $beneficiario;
        
    }

    */

    public function pdf_reclamacion($id_reclamacion, $otro)
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);
        
        $reclamacion = Reclamacione::find($id_reclamacion);

        if($reclamacion->estado!=0):
            //dd($reclamacion);
            $model_reclamaciones = new Reclamacione();
            $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
            if($otro==1){
                $reclamaciones2 = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida2($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);

                if (count($reclamaciones2)==0) {
                    Flash::error('Reclamacion no encontrado');
                    return redirect(route('reclamacionesite.index'));
                }

            }
            if (count($reclamaciones)==0) {
                Flash::error('Reclamacion no encontrado');
                return redirect(route('reclamacionesite.index'));
            }
            
            if($otro==0)
                $pdf = \PDF::loadView('site.pdf.mostrar_modal',['reclamaciones'=>$reclamaciones,'otro'=>$otro]);
            else
                $pdf = \PDF::loadView('site.pdf.mostrar_modal',['reclamaciones'=>$reclamaciones,'reclamaciones2'=>$reclamaciones2,'otro'=>$otro]);
            //$pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->set_option("enable_php", true);

            return $pdf->stream('reclamacion.pdf');
            //return view('site.pdf.mostrar_modal')->with('reclamaciones', $reclamaciones)->with('otro', $otro);
        else:
            //dd($reclamacion);
            $model_reclamaciones = new Reclamacione();
            $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_IpressInvalidada($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
            if($otro==1){
                $reclamaciones2 = $model_reclamaciones->ShowByNroReclamacionAndId_IpressInvalidada2($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);

                if (count($reclamaciones2)==0) {
                    Flash::error('Reclamacion no encontrado');
                    return redirect(route('reclamacionesite.index'));
                }

            }
            if (count($reclamaciones)==0) {
                Flash::error('Reclamacion no encontrado');
                return redirect(route('reclamacionesite.index'));
            }
            
            if($otro==0)
                $pdf = \PDF::loadView('site.pdf.mostrar_modal_invalidado',['reclamaciones'=>$reclamaciones,'otro'=>$otro]);
            else
                $pdf = \PDF::loadView('site.pdf.mostrar_modal_invalidado',['reclamaciones'=>$reclamaciones,'reclamaciones2'=>$reclamaciones2,'otro'=>$otro]);
            //$pdf->setPaper('A4', 'landscape');
            $pdf->getDomPDF()->set_option("enable_php", true);

            return $pdf->stream('reclamacion.pdf');
            //return view('site.pdf.mostrar_modal')->with('reclamaciones', $reclamaciones)->with('otro', $otro);

        endif;
        
    }    

    public function pdf_solucion($id_solucion)
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);
        
        $solucion = Solucione::find($id_solucion);
        
        $reclamacion = Reclamacione::find($solucion->id_reclamacion);

        $model_reclamaciones = new Reclamacione();
        $reclamaciones = $model_reclamaciones->ShowByNroReclamacionSolucion($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
        
        if($reclamacion->otro_usuario=='SI'){
            $reclamaciones2 = $model_reclamaciones->ShowByNroReclamacionSoluciones($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
            
            if (count($reclamaciones2)==0) {
                Flash::error('Reclamacion no encontrado');
                return redirect(route('reclamacionesite.index'));
            }
        }
        
        if (count($reclamaciones)==0) {
            Flash::error('Reclamacion no encontrado');
            return redirect(route('reclamacionesite.index'));
        }
        
        if($reclamacion->otro_usuario=='NO')
            $pdf = \PDF::loadView('site.pdf.mostrar_modal_solucion',['reclamaciones'=>$reclamaciones,'solucion'=>$solucion,'otro'=>1]);
        else
            $pdf = \PDF::loadView('site.pdf.mostrar_modal_solucion',['reclamaciones'=>$reclamaciones,'reclamaciones2'=>$reclamaciones2,'otro'=>2,'solucion'=>$solucion]);
        //$pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('reclamacion.pdf');
        //return view('site.pdf.mostrar_modal')->with('reclamaciones', $reclamaciones)->with('otro', $otro);
        
    }    
    
}
