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
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Establecimiento;
use App\Repositories\ReclamacioneRepository;
use App\Http\Requests\CreateReclamacioneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


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

    public function index(Request $request)
    {
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {        
        
        
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
    }

    public function update($id, UpdateReclamacioneRequest $request)
    {
    }

    public function destroy($id)
    {
    }

    public function carganroreclamacion($id) {
        $model = new Reclamacione();
        $numero = $model->GetByNroReclamacion($id);
        
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

    public function pdf_reclamacion($id_reclamacion)
    {
        $establecimiento_id=Auth::user()->establecimiento_id;

        $reclamaciones = Reclamacione::find($id_reclamacion);

        if (empty($reclamaciones)) {
            Flash::error('Reclamacion no encontrado');
            return redirect(route('reclamaciones.index'));
        }
        
        $pdf = \PDF::loadView('admin.pdf.descargar_reclamacion_pdf',['reclamaciones'=>$reclamaciones]);
        //$pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream('reclamacion.pdf');
        
    } 

    public function reclamaciones_diarias($id_user = 0) {

        $id_establecimiento = Auth::user()->establecimiento_id;        

        $dni_beneficiario = "";
        $nro_reclamacion = "";        

        $estado = 3;
        $tiempo = "";

        $date = Carbon::now();
                

        //====================
        $model_reclamaciones = new Reclamacione();
        $fechaDesde = $model_reclamaciones->getFechaServidorRestaMeses(1);
        $fechaHasta = $date->format('d-m-Y');
        
        $reclamaciones = $model_reclamaciones->AllReclamacionesFechaDesdeHasta($id_establecimiento, $fechaDesde, $fechaHasta, $dni_beneficiario, $nro_reclamacion, $estado, $tiempo);
        
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();

        //====================
        return view('admin.reclamaciones.reclamaciones_diarias', compact('reclamaciones', 'id_establecimiento', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'nro_reclamacion','establecimientos','estado'));
    }


    public function todas_reclamaciones($id_user = 0) {

        $id_establecimiento = 0;

        $dni_beneficiario = "";
        $nro_reclamacion = "";
        $estado = 3;
        $tiempo = "";

        $date = Carbon::now();
        
        //====================
        $model_reclamaciones = new Reclamacione();
        
        $fechaDesde = $model_reclamaciones->getFechaServidorRestaMeses(1);
        $fechaHasta = $date->format('d-m-Y');

        $reclamaciones = $model_reclamaciones->AllReclamacionesFechaDesdeHasta($id_establecimiento, $fechaDesde, $fechaHasta, $dni_beneficiario, $nro_reclamacion, $estado, $tiempo);
        
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();

        //====================
        return view('admin.reclamaciones.all_reclamaciones_ipress', compact('reclamaciones', 'id_establecimiento', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'nro_reclamacion','establecimientos','estado'));
    }

    
    public function ver_reclamacion_atendida($tipo_repor, $id_user, $nro_reclamacion, $id_reclamacion = 0, $id_ipress=0) {        

        if($id_ipress==0)
            $id_establecimiento = Auth::user()->establecimiento_id;
        else
            $id_establecimiento = $id_ipress;
        //--------------------------------------------
        $model_reclamaciones = new Reclamacione;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');

        $valreclamacion = $model_reclamaciones->GetReclamacionByIdReclamacion($id_reclamacion);
        
        $est_reclamacion = $valreclamacion->estado;
        
        if ($est_reclamacion == 0):
            $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_IpressInvalidada($nro_reclamacion, $id_establecimiento, $id_reclamacion);
        else:
            $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida($nro_reclamacion, $id_establecimiento, $id_reclamacion);
        endif;   
        

        //--------------------------------------------
        if ($tipo_repor == "1") {
            if($reclamaciones->get(0)->otro_usuario=='SI'){
                $reclamaciones2 = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida2($nro_reclamacion, $id_establecimiento, $id_reclamacion);
                return view('admin.reclamaciones.mostrar', compact('reclamaciones', 'reclamaciones2','fecha_actual'));
            }
            else
            {
                return view('admin.reclamaciones.mostrar', compact('reclamaciones', 'fecha_actual'));
            }
            
        } else {
            if($reclamaciones->get(0)->otro_usuario=='SI'){
                $reclamaciones2 = $model_reclamaciones->ShowByNroReclamacionAndId_ipressValida2($nro_reclamacion, $id_establecimiento, $id_reclamacion);
                return view('admin.reclamaciones.mostrar_modal', compact('reclamaciones','reclamaciones2','fecha_actual'));
            }
            else
            {
                return view('admin.reclamaciones.mostrar_modal', compact('reclamaciones', 'fecha_actual'));   
            }
        }
    }

    public function listar_reclamaciones(Request $request) {
        
        if (is_null($request->dni_beneficiario))
            $dni_beneficiario="";
        else
            $dni_beneficiario=strtoupper($request->dni_beneficiario);

        if (is_null($request->nro_reclamacion))
            $nro_reclamacion="";
        else
            $nro_reclamacion=$request->nro_reclamacion;

        if($request->tipo_consulta=='D1')
            $id_establecimiento=Auth::user()->establecimiento_id;
        else
            $id_establecimiento=$request->id_ipress;
            
        
        if (is_null($request->fechaDesde))
            $fechaDesde="";
        else
            $fechaDesde=$request->fechaDesde;
        
        if (is_null($request->fechaHasta))
            $fechaHasta="";
        else
            $fechaHasta=$request->fechaHasta;

        $tiempo=$request->tiempo;        

        $estado=$request->estado;        
        
        $model_reclamaciones= new Reclamacione();
        $model_establecimientos= new Establecimiento();
        $establecimientos = $model_establecimientos->getTodosEstablecimientos();
        
        if ($estado == 0):            
            $reclamaciones = $model_reclamaciones->AllReclamacionesDiariasInvalidasFechaDesdeHasta($id_establecimiento, $fechaDesde, $fechaHasta, $dni_beneficiario, $nro_reclamacion,$tiempo);
        else:
            $reclamaciones = $model_reclamaciones->AllReclamacionesFechaDesdeHasta($id_establecimiento, $fechaDesde, $fechaHasta, $dni_beneficiario, $nro_reclamacion, $estado, $tiempo);
        endif;

        if($request->tipo_consulta=='T1'){

            return view('admin.reclamaciones.all_reclamaciones_ipress', compact('reclamaciones', 'id_establecimiento', 'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'nro_reclamacion','establecimientos','estado','tiempo'));
        }
        else
        {
            return view('admin.reclamaciones.reclamaciones_diarias', compact('reclamaciones','id_establecimiento',  'fechaDesde', 'fechaHasta', 'dni_beneficiario', 'nro_reclamacion','establecimientos','estado','tiempo'));    
        }
        
    }

    public function invalidar_reclamacion(Request $request) {        

        $id_establecimiento = $request->id_establecimiento;
        $nro_reclamacion = $request->nro_reclamacion;
        $id_user = $request->id_user;
        $id_reclamacion = $request->id_reclamacion;

        $user = User::where('id', $id_user)->first();
        $name = $user->nombres.' '.$user->apellido_paterno.' '.$user->apellido_materno;

        $reclamaciones = Reclamacione::where('id', $id_reclamacion)->first();

        //----------------------------------------------------------------------
        $date = Carbon::now();
        $fecha = $date->format('d-m-Y');
        $reclamaciones->fecha_eliminacion = $fecha;        
        $reclamaciones->usuario_invalidador = $name ;
        $reclamaciones->motivo = $request->motivo;        
        $reclamaciones->estado = 0;
        $reclamaciones->save();       
        
        
        
        Flash::success('Reclamaciones anulada.');
        return redirect('/ver_reclamacion/' . $id_user . '/' . $nro_reclamacion . '/' . $id_reclamacion);
    }

    public function ver_reclamacion($id_user, $nro_reclamacion, $id_reclamacion) {

        
        $user = User::where('id', $id_user)->first();
        $id_establecimiento = $user->establecimiento_id;
        //--------------------------------------------
        $model_reclamaciones = new Reclamacione;
        //--------------------------------------------
        $date = Carbon::now();
        $fecha_actual = $date->format('d-m-Y');
        //--------------------------------------------
        //$reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipress($nro_reclamacion, $id_establecimiento , $id_reclamacion);
        $reclamaciones = $model_reclamaciones->ShowByNroReclamacionAndId_ipress2($nro_reclamacion, $id_reclamacion);
        //---------------------------------------------------------------------            
        return view('admin.reclamaciones.mostrar', compact('reclamaciones', 'fecha_actual'));
    }

    


}
