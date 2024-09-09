<?php
namespace App\Http\Controllers\Admin;
use App\Models\Importacione;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;
use App\Models\Carga_importaciones;
use Illuminate\Validation;
use App\Models\Establecimiento;
use App\Models\Carga;
use App;
use Auth;
use Flash;

class SoapController extends BaseSoapController
{
    private $service;

    public function buscar_personal_dni($nro_doc, $ntipo_doc) {
        
      self::setWsdl('https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc?Wsdl');
      
      $this->service = InstanceSoapClient::init();

      switch ($ntipo_doc) {
        case 'DNI': $tipo_doc=1; break;
        case 'PAS': $tipo_doc=2; break;
        case 'CE': $tipo_doc=3; break;
      }

      $cities = $this->service->BuscarTitularFamiliar(['TipoBusqueda' => $tipo_doc,'Documento' => $nro_doc,'Usuario' => '32089474','Clave' => '47498023']);
      $json = json_encode($cities);
      $beneficiarios = json_decode($json,TRUE);
      dd($beneficiarios);

      if(count($beneficiarios['BuscarTitularFamiliarResult'])>0){
                      $beneficiario = array();
                      $beneficiario[0]['dni'] = $nro_doc;
                      $beneficiario[0]['nombres'] = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['NOMBRES'];
                      $beneficiario[0]['apellido_paterno'] = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['PATERNO'];
                      $beneficiario[0]['apellido_materno'] = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['MATERNO'];
                      /*$beneficiario[0]['cip'] = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['CARNE'];     
                      $fecha_nacimiento = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['NACIMIENTO'];                     
                      $beneficiario[0]['fecha_nacimiento'] = $fecha_nacimiento ;                    
                      $fech_nac = explode("/", $fecha_nacimiento);
                      $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];                      
                      $dbDate = Carbon::parse($nacimiento);
                      $diffYears = Carbon::now()->diffInYears($dbDate);                      
                      $$beneficiario[0]['edad'] = $diffYears;
                      if($beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['SEXO']=='FEMENINO') $sexo='F';
                      else
                        $sexo='M';
                      
                      $beneficiario[0]['sexo'] = $sexo;
                      $beneficiario[0]['id_carga_importacion'] = $id_carga_inicial;
                      $beneficiario[0]['id_establecimiento'] = $id_establecimiento;
                      $beneficiario[0]['grado'] = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['GRADO'];  */
      }

/*        $beneficiario=DB::connection('pgsql2')
                    ->table('beneficiarios')
                    ->select('beneficiarios.*')
                    ->where('nrodocafiliado',$nro_doc)
                    ->where('nomtipdocafiliado',$tipo_doc)
                    ->get();
*/      
        dd($beneficiario[0]);
        return $beneficiario;
    } 
    
    public function add_importacion_dni($id, $id_user) {
        
        $id_establecimiento = Auth::user()->establecimiento_id;
        $id_carga_inicial = 0;
        //----------------------------------------------------------------------
        $date = Carbon::now();
        $fecha = $date->format('d-m-Y');
        $importar = Importacione::find($id);
        $url_data = $importar->url_data;
        //----------------------------------------------------------------------
        Excel::load('storage/app/' . $url_data, function($reader) use($id, $id_establecimiento, $fecha, $id_user, &$id_carga_inicial) {
            $n=0;
            foreach ($reader->get() as $book) {
                $validator = Validator::make($book->all(), [
                            'dni' => 'max:8'
                ]);
                if ($validator->fails()) {
                    $n=$n+1;
                    if($n>1){
                        Flash::success('flash_message', 'Solo se importó algunos dni, revise el archivo excel que ha importado que probablemente tenga dni con datos menodes de 8 digitos');
                        return redirect('/mostrar_carga_beneficiarios/' . $id_user);
                    }else{
                        Flash::success('flash_message', 'No se importó ningún dni, los datos de los dni son incorrectos, revise el archivo excel que ha importado');
                        return redirect('/mostrar_carga_beneficiarios/' . $id_user);
                    }
                    
                } else {
                    $n=$n+1;
                    if($n == 1):
                      $cabecera_carga = new Carga_importaciones();
                      $cabecera_carga->id_establecimiento = $id_establecimiento;
                      $cabecera_carga->id_user = $id_user;
                      $cabecera_carga->estado = 1;
                      $cabecera_carga->fecha_subida = $fecha;
                      $cabecera_carga->save();
                      $id_carga_inicial = $cabecera_carga->id;
                    endif;                               

                    self::setWsdl('https://sigcp.policia.gob.pe:7071/TitularFamiliarWS.svc?Wsdl');
                    
                    $this->service = InstanceSoapClient::init();

                    $cities = $this->service->BuscarTitularFamiliar(['TipoBusqueda' => 1,'Documento' => $book->dni,'Usuario' => '32089474','Clave' => '47498023']);
                    $json = json_encode($cities);
                    $beneficiario = json_decode($json,TRUE);

                    if(count($beneficiario['BuscarTitularFamiliarResult'])>0){
                      $insert_carga = new Carga();
                      $insert_carga->dni = $book->dni;
                      $insert_carga->nombres = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['NOMBRES'];
                      $insert_carga->apellido_paterno = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['PATERNO'];
                      $insert_carga->apellido_materno = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['MATERNO'];                                  
                      $insert_carga->cip = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['CARNE'];     
                      $fecha_nacimiento = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['NACIMIENTO'];                     
                      $insert_carga->fecha_nacimiento = $fecha_nacimiento ;
                    
                      $fech_nac = explode("/", $fecha_nacimiento);
                      $nacimiento=$fech_nac[2].'-'.$fech_nac[1].'-'.$fech_nac[0];
                      
                      $dbDate = Carbon::parse($nacimiento);
                      $diffYears = Carbon::now()->diffInYears($dbDate);
                      
                      $insert_carga->edad = $diffYears;

                      if($beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['SEXO']=='FEMENINO') $sexo='F';
                      else
                        $sexo='M';
                      
                      $insert_carga->sexo = $sexo;
                      $insert_carga->id_carga_importacion = $id_carga_inicial;
                      $insert_carga->id_establecimiento = $id_establecimiento;
                      $insert_carga->grado = $beneficiario['BuscarTitularFamiliarResult']['TitularFamiliar']['GRADO'];                                  
                      $insert_carga->estado = 1;
                      $insert_carga->created_at = Carbon::now();
                      $insert_carga->updated_at = Carbon::now();                                  
                      $insert_carga->save();
                    }
                    else
                    {
                      $insert_carga = new Carga();
                      $insert_carga->dni = $book->dni;
                      $insert_carga->nombres = '';
                      $insert_carga->apellido_paterno = '';
                      $insert_carga->apellido_materno = '';
                      $insert_carga->cip = '';                                  
                      $insert_carga->fecha_nacimiento = '1900-01-01 01:01:01';
                      $insert_carga->edad = 0;
                      $insert_carga->grado = '';
                      $insert_carga->sexo = '';
                      $insert_carga->id_carga_importacion = $id_carga_inicial;
                      $insert_carga->id_establecimiento = $id_establecimiento;
                      $insert_carga->estado = 1;
                      $insert_carga->created_at = Carbon::now();
                      $insert_carga->updated_at = Carbon::now();
                      $insert_carga->save(); 
                    }
                    //----------------------------------------------
                    $update_importacion = Importacione::find($id);
                    $update_importacion->estado = 1;
                    $update_importacion->fecha_importacion = $fecha;
                    $update_importacion->save();
                }
            }
        });        
        //echo $id_carga_inicial; exit();
        Flash::success('flash_message', 'Se Agrego correctamente todos los dni, proceda a revisar los datos para luego ..!!');
        return redirect('/mostrar_carga_beneficiarios/' . $id_establecimiento);
        
    }
}