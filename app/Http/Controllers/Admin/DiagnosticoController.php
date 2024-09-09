<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Farmacia;
use App\Models\Diagnostico;
use App\Models\Establecimiento;
use SoapClient;
use Session;
use DB;
use App;
use Auth;
use Illuminate\Support\Facades\Route;

class DiagnosticoController extends Controller
{
    public function update_diagnostico(Request $request) {
            
			if (!Auth::check()):
            	return redirect('/auth/login');
        	endif;

            $id_user = Auth::user()->id;
            $diagnostico = Diagnostico::where('id', '=', $request->id)->first();
            $diagnostico->codigo = $request->codigo;
            $diagnostico->nombre = $request->nombre;
            $diagnostico->save();
            
            Session::flash('flash_message', 'Actualización exitosa');
            return redirect('/listar_diagnosticos');
    }
    
    public function editar_diagnostico($id) {

        if (!Auth::check()):
            return redirect('/auth/login');
        endif;        
        $id_user = Auth::user()->id;        
        $diagnostico = DB::table('diagnosticos')->where('diagnosticos.id', '=', $id)
                        ->select('diagnosticos.*')->first();

        return view('frontend.diagnosticos.editar_diagnostico', compact('diagnostico'));
    }

    
    public function formulario_diagnostico() {        

        if (!Auth::check()):
            return redirect('/auth/login');
        endif;
        return view('frontend.diagnosticos.create_diagnostico');
    }

    public function index($id_user = 0) {

        if (!Auth::check()):
            return redirect('/auth/login');
        endif;

        $id_user = Auth::user()->id;        
        $modeldiagnostico = new Diagnostico();        
        $diagnosticos = $modeldiagnostico->getDiagnosticos();
        $ruta = Route::getCurrentRoute()->getPath();
        if (count($ruta = explode("/", $ruta)) > 1)
            ;$ruta = $ruta[0];
        $menu = \App\Models\Menu::getMenuByUsuario(Auth::user()->id, $ruta);
        $permiso = $menu[0];

        if ($permiso->lectura == "")
            return redirect('/inicio')->withFlashSuccess("No tiene Permiso para ingresar a la url ingresada");

        return view('frontend.diagnosticos.all', ['diagnosticos' => $diagnosticos, 'permiso' => $permiso]);
    }

    public function create($id_user)
    {
    
    }

    public function store(Request $request) {        
        $modeldiagnosticos= new Diagnostico();
        $diagnosticos_registrado = $modeldiagnosticos->diagnostico_yaregistrada($request->codigo);
        if(count($diagnosticos_registrado)>0){
            $dato = "El Diagnostico <b>".$diagnosticos_registrado->codigo." </b> ya se encuentra registrado, en estado ";
            $dato.= $diagnosticos_registrado->estado == "1"? "<b>ACTIVO</b>":"<b>INACTIVO</b>";
            return redirect('/listar_diagnosticos/' . $request->id_user)->withInput()->withErrors(array($dato));
        } else {            
            $diagnostico = new Diagnostico;
            $diagnostico->codigo = $request->codigo;
            $diagnostico->nombre = $request->nombre;
            $diagnostico->estado = 1;            
            $diagnostico->save();
            $id_diagnostico = $diagnostico->id;
            Session::flash('flash_message', 'Registro exitoso');
            return redirect('/listar_diagnosticos/');
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
	
	public function desactivar($id, $estado){
		
		if (!Auth::check()):
            return redirect('/auth/login');
        endif;
		
        $id_user = Auth::user()->id;
        if($estado == "1"){
            $update=Diagnostico::where('id','=',$id)->first();
            $update->estado=3;
            $update->save();                    
            Session::flash('flash_message', 'Se desactivo correctamente');
        } else {
            $update=Diagnostico::where('id','=',$id)->first();
            $update->estado=1;                    
            $update->save();
            Session::flash('flash_message', 'Se activo correctamente');
        }
	}

    public function obtener_diagnostico($buscar) {

        $model_diagnostico = new \App\Models\Diagnostico;
        $diagnostico = $model_diagnostico->getDiagnosticoByNombre($buscar);
        $array = array();
        foreach ($diagnostico as $leer) {
            $array[] = array("value" => $leer->codigo . " - " . $leer->nombre,
                "label" => $leer->codigo . " - " . $leer->nombre,
                "id" => $leer->id,
            );
        }

        echo json_encode($array);
    }	
	
}
