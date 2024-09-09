<?php

namespace App\Http\Controllers\Site;

use DB;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Aislamiento;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Establecimiento;
use App\Models\PnpCategoria;
use App\Models\Sino;
use App\Models\Sintoma;
use App\Models\InformeRiesgo;
use App\Repositories\AislamientoRepository;
//use App\Http\Requests\CreateAislamientoRequest;
use Carbon\Carbon;
use SoapClient;
use DateTime;


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

    /**
     * Display a listing of the Establecimientos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $model_aislamientos = new Aislamiento();        
        $aislamientos = $model_aislamientos->getTodasAislamientos();
        
        return view('site.aislamientos.index')
            ->with('aislamientos', $aislamientos);
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
        $model_categorias= new PnpCategoria();
        $pnpcategorias = $model_categorias->getPnpCategoria();
        $model_factor= new Sintoma();
        $Sintomas = $model_factor->getSintoma();
        //$aislamientos = Aislamiento::find(10);
        $aislamientos = new Aislamiento();
        $Sintomas=Sintoma::orderby('descripcion','asc')->get();

        $model_informe= new InformeRiesgo();
        $informeriesgos = $model_informe->getInformeRiesgo();
        $model_sino= new Sino();
        $sinos = $model_sino->getSino();
        $archivos='';
        $dni='';

        return view('site.aislamientos.index')->with('establecimientos', $establecimientos)->with('fechaServidor', $fechaServidor)->with('departamentos', $departamentos)->with('pnpcategorias', $pnpcategorias)->with('Sintomas', $Sintomas)->with('informeriesgos', $informeriesgos)->with('sinos', $sinos)->with('archivos', $archivos)->with('dni', $dni)->with('aislamientos', $aislamientos);
    }

    public function subir_informe_medico()
    {
    }

    public function store(Request $request)
    {
               
        $aislamiento = new Aislamiento;        

        $date = Carbon::now();

        $aislamiento->fecha_registro = $date->format('d-m-Y');
        $aislamiento->dni = $request->dni;
        $aislamiento->cip = $request->cip;
        $aislamiento->nombres = trim($request->name);
        $aislamiento->apellido_paterno = trim($request->paterno);
        $aislamiento->apellido_materno = trim($request->materno);
        
        if($request->sexo=='MASCULINO')
            $aislamiento->sexo = 'M';
        else
            $aislamiento->sexo = 'F';

        $aislamiento->fecha_nacimiento = $request->fecha_nacimiento;
        $fech_nac = explode("/", $request->fecha_nacimiento);                                    
        $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];                                    
        $dbDate = Carbon::parse($nacimiento);
        $diffYears = Carbon::now()->diffInYears($dbDate);        
        $aislamiento->edad = $diffYears;
        $aislamiento->grado = $request->grado;
        $aislamiento->id_departamento = $request->id_departamento;
        $aislamiento->id_provincia = $request->id_provincia;
        $aislamiento->id_distrito = $request->id_distrito;
        $aislamiento->email = $request->email;
        $aislamiento->celular = $request->telefono;
        $aislamiento->domicilio = $request->domicilio;
        $aislamiento->id_pnpcategoria = $request->id_categoria;
        //$aislamiento->id_factor = $request->id_factor;
        $aislamiento->id_factor = 0;
        $aislamiento->dj = $request->id_dj;
        $aislamiento->riesgo = $request->otro_riesgo;
        $aislamiento->atencion = $request->id_atencion;
        $aislamiento->trabajo_remoto = $request->id_trabajo;
        $aislamiento->fecha_aislamiento = $request->fecha_aislamiento;

        $aislamiento->reincorporacion = $request->id_reincorporacion;
        $aislamiento->informe = $request->id_informe;        

        $aislamiento->save();        

        $idaislamiento = $aislamiento->id;        

        $aislamiento->factoraislados()->attach($request->Sintomax);

        Flash::success('Se ha registrado correctamente, ahora continue subiendo los archivos.');
        return redirect('/mostrar_archivos/' . $idaislamiento. '/' .$request->dni);
    }

    public function mostrar_archivos($idaislamiento,$dni)
    {   
        $model_aislamientos = new Aislamiento();        
        $aislamientos = $model_aislamientos->getAislamientos($idaislamiento,$dni);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }
        
        $nombre=$aislamientos->nombres.' '. $aislamientos->apellido_paterno;


        $informes_medicos= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',1)
                    ->get();

        $certificado_medicos= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',2)
                    ->get();

        $examen_laboratorio= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',3)
                    ->get();

        $examen_imagen= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',4)
                    ->get();

        $informe_procedimiento= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('tipo_archivo',5)
                    ->where('estado',1)
                    ->get();

        $recetas_vales= DB::table('archivos')
                    ->where('dni','=',$dni)
                    ->where('aislado_id','=',$idaislamiento)
                    ->where('estado',1)
                    ->where('tipo_archivo',6)
                    ->get();
        
        return view('site.aislamientos.archivos')->with('nombre', $nombre)->with('dni', $dni)->with('informes_medicos', $informes_medicos)->with('certificado_medicos', $certificado_medicos)->with('examen_laboratorio', $examen_laboratorio)->with('examen_imagen', $examen_imagen)->with('informe_procedimiento', $informe_procedimiento)->with('recetas_vales', $recetas_vales)->with('idaislamiento', $idaislamiento);
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

    public function mostrar_agradecimiento($idaislamiento,$dni)
    {   
        $model_aislamientos = new Aislamiento();        
        $aislamientos = $model_aislamientos->getAislamientos($idaislamiento,$dni);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }
        
        $nombre=$aislamientos->nombres.' '. $aislamientos->apellido_paterno;
        
        return view('site.aislamientos.agradecimiento')->with('nombre', $nombre)->with('idaislamiento', $idaislamiento)->with('dni', $dni);
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
        $model_aislamientos = new Aislamiento();        
        $aislamientos = $model_aislamientos->getAislamientos($id);

//        $establecimientos = $this->establecimientoRepository->findWithoutFail($id);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }

        return view('site.aislamientos.show')->with('aislamientos', $aislamientos);
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
        $model_aislamientos = new Aislamiento();        
        $aislamientos = $model_aislamientos->getAislamientos($id);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }
        return view('site.aislamientos.edit')->with('aislamientos', $aislamientos);
    }

    /**
     * Update the specified Establecimientos in storage.
     *
     * @param  int              $id
     * @param UpdateEstablecimientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAislamientoRequest $request)
    {
        $aislamientos = $this->aislamientoRepository->findWithoutFail($id);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }

        $aislamientos = $this->aislamientoRepository->update($request->all(), $id);

        Flash::success('Aislamientos actualizado satisfactoriamente.');

        return redirect(route('aislamientosite.index'));
    }

    /**
     * Remove the specified Aislamientos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $aislamientos = $this->aislamientoRepository->findWithoutFail($id);

        if (empty($aislamientos)) {
            Flash::error('Aislamientos no encontrado');

            return redirect(route('aislamientosite.index'));
        }

        $this->aislamientoRepository->delete($id);

        Flash::success('Aislamientos eliminado.');

        return redirect(route('aislamiento.index'));
    }

    public function carganroreclamacion($id) {
        $model = new Aislamiento();
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
/*
    public function buscar_personal_dni($nro_doc) {
        
        $beneficiario=DB::table('bd_pnpaislados')
                    ->select('bd_pnpaislados.*')
                    ->where('dni',$nro_doc)                    
                    ->get();

        return $beneficiario;
    }  
*/
   
    public function buscar_personal_dni($nro_doc) {
        $tipodoc_beneficiario='1';
        $sw = false;
        $beneficiario = "";
        
        $client = new SoapClient("http://dev-wsdl.saludpol.gob.pe:8083/ws/WS_AfiliadoSP_Serv.php?wsdl", array('login' => 'D5p-R4v-@cci.ws.sp', 'password' => 'wS5p#cC1#D5p-'));

        $beneficiario = $client->getAseguradoValidate($tipodoc_beneficiario, $nro_doc);

        if (is_object($beneficiario)):
            $sw = true;
        endif;
        
        $array["sw"] = $sw;
        $array["beneficiario"] = $beneficiario;
        
        echo json_encode($array);
        
    }

    //public function buscar_personal_dni_dirrehum($nro_doc) {
    public function buscar_personal_dni_PNP($nro_doc) {
        $tipodoc_beneficiario='1';
        $sw = false;
        $beneficiario = "";
        
        $client = new SoapClient("http://dev-wsdl.saludpol.gob.pe:8083/ws/WS_AfiliadoSP_Serv.php?wsdl", array('login' => 'D5p-R4v-@cci.ws.sp', 'password' => 'wS5p#cC1#D5p-'));

        $beneficiario = $client->getAseguradoValidate($tipodoc_beneficiario, $nro_doc);

        if (is_object($beneficiario)):
            $sw = true;
        endif;
        
        $array["sw"] = $sw;
        $array["beneficiario"] = $beneficiario;
        
        echo json_encode($array);
        
    }

    public function buscar_personal_dni_dirrehum($nro_doc) {

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

            $busca_datos = $client->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $nro_doc,'Usuario' => 'DirSaPol','Clave' => '6hHPb','Sistema'=>'SISTEMA DE GESTION DE FARMACIA', 'Operador'=>'31081306']);
           
            $json = json_encode($busca_datos);
            $beneficiario_encontrado = json_decode($json,TRUE);
            
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
                    $ano=$fech_nac[2];
                    $mes=$fech_nac[1];
                    $dia=$fech_nac[0];
                    $Born = Carbon::create($ano,$mes,$dia);
                    $age = $Born->diff(Carbon::now())->format('%y Ano, %m meses %d dias');
                    $beneficiario->age=$age;

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
                    $beneficiario->est=1;
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
                        $ano=$fech_nac[2];
                        $mes=$fech_nac[1];
                        $dia=$fech_nac[0];
                        $Born = Carbon::create($ano,$mes,$dia);
                        $age = $Born->diff(Carbon::now())->format('%y Ano, %m meses %d dias');
                        $beneficiario->age=$age;

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
                        $beneficiario->est=1;
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
                        $ano=$fech_nac[2];
                        $mes=$fech_nac[1];
                        $dia=$fech_nac[0];                        
                        $dbDate = Carbon::parse($nacimiento);
                        $diffYears = Carbon::now()->diffInYears($dbDate);
                        $beneficiario->edadafiliado=$diffYears;                        
                        $Born = Carbon::create($ano,$mes,$dia);
                        $age = $Born->diff(Carbon::now())->format('%y Ano, %m meses %d dias');
                        $beneficiario->age=$age;
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
                        $beneficiario->est=0;
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
                            $ano=$fech_nac[2];
                            $mes=$fech_nac[1];
                            $dia=$fech_nac[0];            
                            $Born = Carbon::create($ano,$mes,$dia);
                            $age = $Born->diff(Carbon::now())->format('%y Ano, %m meses %d dias');
                            $beneficiario->age=$age;                            
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
                            $beneficiario->est=0;
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

            $respuesta = $soapClient->consultarDniMayor($parametros);
                
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
                $dia=$originalDate[8].$originalDate[9];
                $mes=$originalDate[5].$originalDate[6];
                $ano=$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];
                $fecha_nacimiento=$originalDate[8].$originalDate[9].'/'.$originalDate[5].$originalDate[6].'/'.$originalDate[0].$originalDate[1].$originalDate[2].$originalDate[3];  
                $beneficiario->fecnacafiliado=$fecha_nacimiento;
                $dbDate = Carbon::parse($nacimiento);
                $diffYears = Carbon::now()->diffInYears($dbDate);
                $Born = Carbon::create($ano,$mes,$dia);
                $age = $Born->diff(Carbon::now())->format('%y Años, %m meses %d dias');
                $beneficiario->edadafiliado=$diffYears;
                $beneficiario->age=$age;
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
                $beneficiario->est=0;
                $sw=true;

            }

        
        $array["sw"] = $sw;
        $array["beneficiario"] = $beneficiario;
        
        echo json_encode($array);

    } 

    public function buscar_personal_dni_dirrehum2($nro_doc) {

        $beneficiario = new Aislamiento;
        //$paciente = Aislamiento::Where('dni',$nro_doc)->first();

        //$aislamiento->id_clasificacion=$request->id_clasificacion;
        //$aislamiento->id_establecimiento=$request->id_establecimiento;
        
        //if($paciente->id>0){
            //return redirect('registro_paciente'.'/'.$paciente->id.'/'.$paciente->dni);
                  /*$beneficiario->nompaisdelafiliado='PER';
                    $beneficiario->nomtipdocafiliado='DNI';
                    $beneficiario->nrodocafiliado=$paciente->dni;
                    $beneficiario->apepatafiliado=$paciente->paterno;
                    $beneficiario->apematafiliado=$paciente->materno;
                    $beneficiario->apecasafiliado='';
                    $beneficiario->nomafiliado=$paciente->nombres;
                    $beneficiario->fecnacafiliado=$paciente->fecha_nacimiento;
                    $beneficiario->edadafiliado=$paciente->edad;
                    $beneficiario->nomsexo=$paciente->sexo;
                    $beneficiario->estado='ACTIVO';
                    $beneficiario->parentesco=$paciente->parentesco;
                    $beneficiario->nomtipdoctitular='DNI';
                    $beneficiario->nrodoctitular='';
                    $beneficiario->apepattitular='';
                    $beneficiario->apemattitular=''; 
                    $beneficiario->apecastitular='';
                    $beneficiario->nomtitular='';
                    $beneficiario->cip=$paciente->cip;
                    $beneficiario->ubigeo='';
                    $beneficiario->grado=$paciente->grado;
                    $beneficiario->situacion=$paciente->situacion;                    
                    $beneficiario->caducidad='';
                    $beneficiario->discapacidad=0;
                    $beneficiario->otroseguro='FONAFUN';
                    $beneficiario->unidad=$paciente->unidad;

                    $beneficiario->telefono=$paciente->telefono;
                    $beneficiario->id_categoria=$paciente->id_categoria;
                    $beneficiario->peso=$paciente->peso;
                    $beneficiario->talla=$paciente->talla;
                    $beneficiario->etnia=$paciente->etnia;
                    $beneficiario->otra_raza=$paciente->otra_raza;
                    $beneficiario->nacionalidad=$paciente->nacionalidad;
                    $beneficiario->otra_nacion=$paciente->otra_nacion;
                    $beneficiario->migrante=$paciente->migrante;
                    $beneficiario->otro_migrante=$paciente->otro_migrante;
                    $beneficiario->domicilio=$paciente->domicilio;
                    $beneficiario->id_departamento=$paciente->id_departamento;
                    $beneficiario->id_provincia=$paciente->id_provincia;
                    $beneficiario->id_distrito=$paciente->id_distrito;
                    
                    $sw = true; */
        //}
        //else
        //{
        
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

            $respuesta = $soapClient->consultarDniMayor($parametros);
                
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

        /*    $beneficiario->telefono='';
            $beneficiario->id_categoria='';
            $beneficiario->peso='';
            $beneficiario->talla='';
            $beneficiario->etnia='';
            $beneficiario->otra_raza='';
            $beneficiario->nacionalidad='';
            $beneficiario->otra_nacion='';
            $beneficiario->migrante='';
            $beneficiario->otro_migrante='';
            $beneficiario->domicilio='';
            $beneficiario->id_departamento='';
            $beneficiario->id_provincia='';
            $beneficiario->id_distrito='';
        */
        //}
        $array["sw"] = $sw;
        $array["beneficiario"] = $beneficiario;
        
        echo json_encode($array);

    } 

    public function buscar_personal_dni_reniec ($nro_doc) {
        $soapClient = new SoapClient('http://192.168.10.44:7001/ServicioReniecImpl/ServicioReniecImplService?WSDL', array('trace'=>1,"encoding"=>"ISO-8859-1"));
    /*if ($error = $soapClient->getError()){
      echo "no se pudo conectar al ws";
      die();
    }*/

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
    
    //dd($respuesta->resultadoDniMayor->gradoInstruccion);
    //dd(preg_replace('/[[:^print:]]/', '', $respuesta->resultadoDniMayor->gradoInstruccion);

    //$demo = utf8_decode($respuesta->resultadoDniMayor->gradoInstruccion);
    //dd($demo);


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

    //$gradoInstruccion = preg_replace('/[[:^print:]]/', '', $respuesta->resultadoDniMayor->gradoInstruccion);
    //$gradoInstruccion = binaryToString($binary).PHP_EOL;
    $gradoInstruccion = utf8_encode($respuesta->resultadoDniMayor->gradoInstruccion);
    $foto = base64_encode($respuesta->resultadoDniMayor->foto);
    //dd($foto);
    
    $datos_rinec = array(
      "dni" => $respuesta->resultadoDniMayor->dni,
      "paterno" => $respuesta->resultadoDniMayor->paterno,
      "materno" => $respuesta->resultadoDniMayor->materno,
      "nombres" => $respuesta->resultadoDniMayor->nombres,
      "departamentoDomicilio" => $respuesta->resultadoDniMayor->departamentoDomicilio,
      "provinciaDomicilio" => $respuesta->resultadoDniMayor->provinciaDomicilio,
      "distritoDomicilio" => $respuesta->resultadoDniMayor->distritoDomicilio,
      "localidadDomicilio" => $respuesta->resultadoDniMayor->localidadDomicilio,
      "direccionDomicilio" => $respuesta->resultadoDniMayor->direccionDomicilio,
      "estadoCivil" => $respuesta->resultadoDniMayor->estadoCivil,
      "gradoInstruccion" => $gradoInstruccion,
      "estatura" => $respuesta->resultadoDniMayor->estatura,
      "sexo" => $respuesta->resultadoDniMayor->sexo,
      "departamentoNacimiento" => $respuesta->resultadoDniMayor->departamentoNacimiento,
      "provinciaNacimiento" => $respuesta->resultadoDniMayor->provinciaNacimiento,
      "distritoNacimiento" => utf8_encode($respuesta->resultadoDniMayor->distritoNacimiento),
      "fechaNacimiento" => $respuesta->resultadoDniMayor->fechaNacimiento,
      "nombrePadre" => $respuesta->resultadoDniMayor->nombrePadre,
      "nombreMadre" => $respuesta->resultadoDniMayor->nombreMadre,
      "fechaInscripcion" => $respuesta->resultadoDniMayor->fechaInscripcion,
      "fechaExpedicion" => $respuesta->resultadoDniMayor->fechaExpedicion,
      "constanciaVotacion" => $respuesta->resultadoDniMayor->constanciaVotacion,
      "restricciones" => $respuesta->resultadoDniMayor->restricciones,
      "caducidad" => $respuesta->resultadoDniMayor->caducidad,
      "codigoMensaje" => $respuesta->resultadoDniMayor->codigoMensaje,
      "descripcionMensaje" => $respuesta->resultadoDniMayor->descripcionMensaje,
      "foto" => $foto
    );

    dd($datos_rinec);

    $json = json_encode($datos_rinec, TRUE);    
    
    dd($json);

    return $json;

  }
    

    public function pdf_descarga($idaislamiento, $dni,$opt)
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

        $riesgos = DB::table('aislados')
                    ->join('aislamiento_factor_riesgo', 'aislamiento_factor_riesgo.aislamiento_id', '=', 'aislados.id')
                    ->join('sintomas', 'aislamiento_factor_riesgo.factor_riesgo_id', '=', 'sintomas.id')
                    ->where('aislamiento_factor_riesgo.aislamiento_id',$idaislamiento)                    
                    ->get();
        //$riesgos=$aislamientos->riesgos;
        $cip=$aislamientos->cip;
        $edad=$aislamientos->edad;
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

        if($opt==1):
            $pdf = \PDF::loadView('site.pdf.mostrar_modal',['fecha_registro'=>$fecha_registro,'idaislamiento'=>$idaislamiento,'dni'=>$dni,'cip'=>$cip,'nombres'=>$nombres,'apellido_paterno'=>$apellido_paterno,'apellido_materno'=>$apellido_materno,'sexo'=>$sexo,'fecha_nacimiento'=>$fecha_nacimiento,'grado'=>$grado,'email'=>$email,'celular'=>$celular,'domicilio'=>$domicilio,'nombre_dpto'=>$nombre_dpto,'categoriapnp'=>$categoriapnp,'riesgos'=>$riesgos,'fecha_aislamiento'=>$fecha_aislamiento,'reincorporacion'=>$reincorporacion,'dj'=>$dj,'atencion'=>$atencion,'trabajo_remoto'=>$trabajo_remoto,'nombre_prov'=>$nombre_prov,'nombre_dist'=>$nombre_dist,'informes_medicos'=>$informes_medicos,'certificado_medicos'=>$certificado_medicos,'examen_laboratorio'=>$examen_laboratorio,'examen_imagen'=>$examen_imagen, 'informe_procedimiento'=>$informe_procedimiento,'recetas_vales'=>$recetas_vales,'idaislamiento'=>$idaislamiento,'contar_im'=>$contar_im,'contar_cm'=>$contar_cm,'contar_el'=>$contar_el,'contar_ei'=>$contar_ei,'contar_ip'=>$contar_ip,'contar_rv'=>$contar_rv,'cip'=>$cip,'edad'=>$edad]);        
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->stream('reclamacion.pdf');
        else:
            return view('site.pdf.print_mostrar_modal', compact('fecha_registro','idaislamiento','dni','cip','nombres','apellido_paterno','apellido_materno','sexo','fecha_nacimiento','grado','email','celular','domicilio','nombre_dpto','categoriapnp','riesgos','fecha_aislamiento','reincorporacion','dj','atencion','trabajo_remoto','nombre_prov','nombre_dist','informes_medicos','certificado_medicos','examen_laboratorio','examen_imagen', 'informe_procedimiento','recetas_vales','idaislamiento','contar_im','contar_cm','contar_el','contar_ei','contar_ip','contar_rv','cip','edad'));
        endif;
    }    

    public function pdf_solucion($id_solucion)
    {
        ini_set('max_execution_time', '300');
        set_time_limit(300);
        
        $solucion = Solucione::find($id_solucion);
        
        $reclamacion = Aislamiento::find($solucion->id_reclamacion);

        $model_aislamientos = new Aislamiento();
        $aislamientos = $model_aislamientos->ShowByNroReclamacionSolucion($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
        
        if($reclamacion->otro_usuario=='SI'){
            $aislamientos2 = $model_aislamientos->ShowByNroReclamacionSoluciones($reclamacion->nro_reclamacion, $reclamacion->id_establecimiento, $reclamacion->id);
            
            if (count($aislamientos2)==0) {
                Flash::error('Reclamacion no encontrado');
                return redirect(route('aislamientosite.index'));
            }
        }
        
        if (count($aislamientos)==0) {
            Flash::error('Reclamacion no encontrado');
            return redirect(route('aislamientosite.index'));
        }
        
        if($reclamacion->otro_usuario=='NO')
            $pdf = \PDF::loadView('site.pdf.mostrar_modal_solucion',['aislamientos'=>$aislamientos,'solucion'=>$solucion,'otro'=>1]);
        else
            $pdf = \PDF::loadView('site.pdf.mostrar_modal_solucion',['aislamientos'=>$aislamientos,'aislamientos2'=>$aislamientos2,'otro'=>2,'solucion'=>$solucion]);
        //$pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('reclamacion.pdf');
        //return view('site.pdf.mostrar_modal')->with('aislamientos', $aislamientos)->with('otro', $otro);
        
    }    
    
}
