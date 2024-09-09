<?php
namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Reclamacione;
use App\Models\Solucione;
use App\Models\Distrito;
use App\Models\User;
use App\Models\Provincia;
use App\Models\Aislamiento;
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Establecimiento;
use App\Models\Sintoma;
use App\Repositories\ReclamacioneRepository;
use App\Http\Requests\CreateReclamacioneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SolucioneController extends AppBaseController
{
    /** @var  EstablecimientosRepository */
    private $reclamacioneRepository;

    public function __construct(ReclamacioneRepository $reclamacioneRepo)
    {
        $this->reclamacioneRepository = $reclamacioneRepo;
    }

    public function index(Request $request)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getTodasReclamaciones();

        return view('admin.reclamaciones.index')
            ->with('reclamaciones', $reclamaciones);
    }

    public function create()
    {
        //return view('site.reclamaciones.create');        
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();

        return view('admin.reclamaciones.index')->with('establecimientos', $establecimientos)->with('departamentos', $departamentos);
    }

    public function store(Request $request)
    {
        $reclamacion = new Reclamacione;
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

        if($request->selectall=='SI'){

            $reclamacion->tipo_doc2 = $request->tipo_doc_2;
            $reclamacion->nro_doc2 = trim($request->nro_doc_2);

            $reclamacion->nombres2 = trim($request->name_2);
            $reclamacion->apellido_paterno2 = trim($request->paterno_2);
            $reclamacion->apellido_materno2 = trim($request->materno_2);

            $reclamacion->id_departamento2 = $request->id_departamento_2;
            $reclamacion->id_provincia2 = $request->id_provincia_2;
            $reclamacion->id_distrito2 = $request->id_distrito_2;
            
            $reclamacion->domicilio2 = $request->domicilio2;
            $reclamacion->email2 = $request->email_2;
            $reclamacion->telefono2 = $request->telefono_2;

        }    
        
        $reclamacion->reclamo = $request->descripcion;        
        $reclamacion->autorizar_envio = $request->notificado;    
        $reclamacion->ano_reclamacion = $date->format('Y');       
        
        $reclamacion->save();        

        Flash::success('Se ha registrado correctamente su reclamacion.');

        return redirect(route('reclamaciones.index'));
    }

    public function editar_solucion(Request $request)
    {
        if($request->compara=='NUEVO'){
            $solucion = new Solucione;
            $date = Carbon::now();

            $solucion->trato_directo = 'NO';
            $solucion->fecha_registro = $request->fecha_solucion;
            $solucion->fecha_solucion = $request->fecha_solucion;
            $solucion->estado_solucion = $request->estado_reclamo;
            $solucion->resultado_solucion = $request->resultado;
            $solucion->solucion_rpta = $request->descripcion;
            $solucion->id_factor = $request->id_factor;
            $solucion->id_aislado = $request->id_aislado;                 
            $solucion->medico_solucionador = Auth::user()->name;
            $solucion->dni_medico = Auth::user()->dni;
            $solucion->save();     

            //----------------------------------------------------------------------
            $aislamientos = Aislamiento::where('id', $request->id_aislado)->where('dni', $request->dni)->first();            
            $aislamientos->estado = 3;
            $aislamientos->save();       

            Flash::success('Se ha registro la solucion.');

            return redirect(route('aislamientos.todos_registros',$request->id_factor));
        }
        else
        {
            $solucion = Solucione::where('id', $request->id)->first();
            $solucion->trato_directo = $request->id_tipo;               
            $solucion->nro_doc_solucion= $request->nro_reclamacion;
            $solucion->nro_notificacion = $request->nro_notificacion;            
            $solucion->fecha_solucion = $request->fecha_solucion;
            $solucion->estado_reclamo = $request->estado_reclamo;
            $solucion->resultado_reclamo = $request->resultado;
            $solucion->solucion_rpta = $request->descripcion;            
            $solucion->personal_solucionador = Auth::user()->name;
            $solucion->save();            

            $reclamaciones = Reclamacione::where('id', $request->id_reclamacion)->first();
            $reclamaciones->estado = $request->estado_reclamo;
            $reclamaciones->save();       

            Flash::success('Se ha actualizado la solucion de la reclamacion.');

            return redirect(route('reclamaciones.todas_reclamaciones'));

        }
    }

    public function show($id)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getReclamaciones($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacione.index'));
        }

        return view('admin.reclamaciones.show')->with('reclamaciones', $reclamaciones);
    }

    public function edit($id)
    {
        $model_reclamaciones = new Reclamacione();        
        $reclamaciones = $model_reclamaciones->getReclamaciones($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacione.index'));
        }
        return view('admin.reclamaciones.edit')->with('reclamaciones', $reclamaciones);
    }

    public function update($id, UpdateReclamacioneRequest $request)
    {
        $reclamaciones = $this->reclamacioneRepository->findWithoutFail($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacione.index'));
        }

        $reclamaciones = $this->reclamacioneRepository->update($request->all(), $id);

        Flash::success('Reclamaciones actualizado satisfactoriamente.');

        return redirect(route('reclamacione.index'));
    }

    public function destroy($id)
    {
        $reclamaciones = $this->reclamacioneRepository->findWithoutFail($id);

        if (empty($reclamaciones)) {
            Flash::error('Reclamaciones no encontrado');

            return redirect(route('reclamacione.index'));
        }

        $this->reclamacioneRepository->delete($id);

        Flash::success('Reclamaciones eliminado.');

        return redirect(route('reclamacione.index'));
    }

    public function carganrosolucion($id,$trato) {
        $model = new Solucione();
        $numero = $model->GetByNroSolucion($id,$trato);
        
        return $numero;
    }

    public function pdf_solucion($id_reclamacion)
    {
        $establecimiento_id=Auth::user()->establecimiento_id;

        $reclamaciones = Reclamacione::find($id_reclamacion);

        if (empty($reclamaciones)) {
            Flash::error('Reclamacion no encontrado');
            return redirect(route('reclamaciones.index'));
        }
        
        $pdf = \PDF::loadView('admin.pdf.descargar_reclamacion_pdf',['reclamaciones'=>$reclamaciones]);
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('reclamacion.pdf');
    }    

    
    public function ver_solucion_atendida( $dni, $id_solucion = 0, $id_riesgo=0) {        

        if($id_ipress==0)
            $id_establecimiento = Auth::user()->establecimiento_id;
        else
            $id_establecimiento = $id_ipress;
        //--------------------------------------------
        $model_soluciones = new Solucione;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');

        $soluciones = $model_soluciones->ShowByNroSolucionAndId_ipressValida($id_solucion);
        
        //--------------------------------------------
        
        return view('admin.soluciones.mostrar', compact('soluciones', 'fecha_actual'));
        
    }


    public function ver_solucion($id_user, $nro_reclamacion, $id_reclamacion) {

        $user = User::where('id', $id_user)->first();
        $id_establecimiento = $user->establecimiento_id;
        //--------------------------------------------
        $model_reclamaciones = new Reclamacion;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');
        //--------------------------------------------
        $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipress($nro_reclamacion, $id_establecimiento, $id_reclamacion);
        //---------------------------------------------------------------------            
        return view('admin.reclamaciones.mostrar', compact('reclamaciones', 'fecha_actual'));
    }

    public function expedientes_solucionados($id_factor = 0) {

        $rol=Auth::user()->rol;
        if($id_factor!=0)
            $factor_x=$id_factor;

        $factor_x=$id_factor;

        $dni_beneficiario = "";
        $nro_aislamiento = "";
        $estado = 3;
        $tiempo = "";
        $date = Carbon::now();

        if($rol==1){            
            //====================
            $model_soluciones = new Solucione();        
            $fechaDesde = $model_soluciones->getRestaMeses(1);        
            $fechaHasta = $date->format('Y-m-d');
            $aislamientos = $model_soluciones->AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde, $fechaHasta,$id_factor);
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            $model_factor= new User();
            $users = $model_factor->getUsers();
            //====================
            return view('admin.soluciones.expedientes_solucionadas', compact('aislamientos', 'id_factor', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'Sintomas','users'));
         }
        else
        {
            if($factor_x==$id_factor){
                //====================
                $model_soluciones = new Solucione();        
                $fechaDesde = $model_soluciones->getRestaMeses(1);        
                $fechaHasta = $date->format('Y-m-d');
                $aislamientos = $model_soluciones->AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde, $fechaHasta,$factor_x);
                $model_factor= new Sintoma();
                $Sintomas = $model_factor->getSintoma();
                $model_factor= new User();
                $users = $model_factor->getUsers();
                //====================
                return view('admin.soluciones.expedientes_solucionadas', compact('aislamientos', 'id_factor', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'Sintomas','users'));
            }
            else
            {
                return view('admin.soluciones.expedientes_solucionadas', compact('aislamientos', 'id_factor', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'Sintomas','users'));
            }
        }
    }

    public function listar_soluciones(Request $request) {

        
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

        if (is_null($request->f_riesgo))
            $f_riesgo="";
        else
            $f_riesgo=$request->f_riesgo;

        if (is_null($request->factor_x))
            $factor_x="";
        else
            $factor_x=$request->factor_x;

        if (is_null($request->user_id))
            $id_medico="";
        else
            $id_medico=$request->user_id;

        $date = Carbon::now();
        $model_aislamientos= new Aislamiento();
        
        if (is_null($request->estado))
            $estado="";
        else
            $estado=$request->estado;
        
        dd($id_medico);
        if($rol==1){            
            //====================
            $model_soluciones = new Solucione();        
            $fechaDesde = $model_soluciones->getRestaMeses(1);        
            $fechaHasta = $date->format('Y-m-d');
            $aislamientos = $model_soluciones->AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde, $fechaHasta,$f_riesgo,$id_medico, $dni_beneficiario, $estado);
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            $model_factor= new User();
            $users = $model_factor->getUsers();
            $id_factor=$f_riesgo;
            //====================
            return view('admin.soluciones.expedientes_solucionadas', compact('aislamientos', 'id_factor', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'Sintomas','users'));
         }
        else
        {
            $factor_x=Auth::user()->factor_id;            
            //====================
            $model_soluciones = new Solucione();        
            $fechaDesde = $model_soluciones->getRestaMeses(1);        
            $fechaHasta = $date->format('Y-m-d');
            $aislamientos = $model_soluciones->AllExpedientesSolucionadasFechaDesdeHasta($fechaDesde, $fechaHasta,$factor_x,$id_medico, $dni_beneficiario, $estado);
            $model_factor= new Sintoma();
            $Sintomas = $model_factor->getSintoma();
            $model_factor= new User();
            $users = $model_factor->getUsers();
            $id_factor=$factor_x;
            //====================
            return view('admin.soluciones.expedientes_solucionadas', compact('aislamientos', 'id_factor', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'Sintomas','users'));
        }
    }

    public function solucionar_reclamacion($id_user, $nro_reclamacion, $id_reclamacion = 0,$id_establecimiento = 0) {

        
        $id_establecimiento = Auth::user()->establecimiento_id;

        //--------------------------------------------
        $model_reclamaciones = new Reclamacione;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');

        $valreclamacion = $model_reclamaciones->GetReclamacionByIdReclamacion($id_reclamacion);
        
        $est_reclamacion = $valreclamacion->estado;
        
        $fechaServidor = $fechaHasta = $date->format('d-m-Y');

            $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida($nro_reclamacion, $id_establecimiento, $id_reclamacion);
            $reclamacion = $model_reclamaciones->GetIdReclamacionByNroReclamacionValida($nro_reclamacion, $id_establecimiento, $id_reclamacion);                 
        
            if ($est_reclamacion == 1):                
                return view('admin.soluciones.nueva_solucion', compact('reclamaciones', 'id_establecimiento','id_reclamacion','fechaServidor'));
            else:

                $model_soluciones = new Solucione;
                $soluciones = $model_soluciones->ShowByNroSolucionAndId_ipressValida($id_reclamacion);
                $solucion = $model_soluciones->GetIdSolucionByNroSolucionValida($id_reclamacion);

                $id_solucion = $solucion->id;

                return view('admin.soluciones.editar_solucion', compact('soluciones','fechaServidor','id_solucion'));
            endif;
    }

    

}
