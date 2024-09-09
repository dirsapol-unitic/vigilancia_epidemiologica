<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Requests\CreateEstablecimientoRequest;
use App\Http\Requests\UpdateEstablecimientoRequest;
use App\Repositories\EstablecimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Distrito;
use App\Models\Provincia;
use App\Models\Departamento;
use App\Models\Region;
use App\Models\Nivel;
use App\Models\Categoria;
use App\Models\Establecimiento;

use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EstablecimientoController extends AppBaseController
{
    /** @var  EstablecimientosRepository */
    private $establecimientoRepository;

    public function __construct(EstablecimientoRepository $establecimientoRepo)
    {
        $this->establecimientoRepository = $establecimientoRepo;
    }

    public function index(Request $request)
    {
        $model_establecimientos = new Establecimiento();        
        $establecimientos = $model_establecimientos->getListarEstablecimientos();
        
        return view('admin.establecimientos.index')
            ->with('establecimientos', $establecimientos);
    }

    public function create()
    {
        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $model_regions= new Region();
        $region = $model_regions->getTodosRegiones();
        $model_nivel= new Nivel();
        $nivel = $model_nivel->getTodosNiveles();
        $model_categoria= new Categoria();
        $categoria = $model_categoria->getTodasCategorias();

        $id_departamento=0;
        $id_region=0;
        $id_provincia=0;
        $id_distrito=0;
        $id_nivel=0;
        $id_categoria=0;

        $model_departamentos= new Provincia();
        $provincias = $model_departamentos->getProvincia($id_departamento);
        $model_departamentos= new Distrito();
        $distritos = $model_departamentos->getDistrito($id_departamento,$id_provincia);
        

        return view('admin.establecimientos.create')->with('departamentos', $departamentos)->with('provincias', $provincias)->with('distritos', $distritos)->with('region', $region)->with('nivel', $nivel)->with('id_region', $id_region)->with('id_departamento', $id_departamento)->with('id_provincia', $id_provincia)->with('id_distrito', $id_distrito)->with('id_nivel', $id_nivel)->with('id_categoria', $id_categoria)->with('categoria', $categoria);    
    }

    public function store(CreateEstablecimientoRequest $request)
    {
        $input = $request->all();

        $establecimientos = $this->establecimientoRepository->create($input);

        Flash::success('Establecimientos guardado correctamente.');

        return redirect(route('establecimientos.index'));
    }

    public function show($id)
    {
        $model_establecimientos = new Establecimiento();        
        $establecimientos = $model_establecimientos->getEstablecimientos($id);

        if (empty($establecimientos)) {
            Flash::error('Establecimientos no encontrado');

            return redirect(route('establecimientos.index'));
        }

        return view('admin.establecimientos.show')->with('establecimientos', $establecimientos);
    }

    public function edit($id)
    {
        $model_establecimientos = new Establecimiento();        
        $establecimientos = $model_establecimientos->getEstablecimientos($id);

        $id_departamento=$establecimientos->departamento;
        $id_region=$establecimientos->region;
        $id_provincia=$establecimientos->provincia;
        $id_distrito=$establecimientos->distrito;
        $id_nivel=$establecimientos->nivel;
        $id_categoria=$establecimientos->categoria;

        $model_departamentos= new Departamento();
        $departamentos = $model_departamentos->getDepartamento();
        $model_departamentos= new Provincia();
        $provincias = $model_departamentos->getProvincia($id_departamento);
        $model_departamentos= new Distrito();
        $distritos = $model_departamentos->getDistrito($id_departamento,$id_provincia);
        $model_regions= new Region();
        $region = $model_regions->getTodosRegiones();
        $model_nivel= new Nivel();
        $nivel = $model_nivel->getTodosNiveles();
        $model_categoria= new Categoria();
        $categoria = $model_categoria->getTodasCategorias();

        

        if (empty($establecimientos)) {
            Flash::error('Establecimientos no encontrado');

            return redirect(route('establecimientos.index'));
        }
        
        return view('admin.establecimientos.edit')->with('establecimientos', $establecimientos)->with('departamentos', $departamentos)->with('provincias', $provincias)->with('distritos', $distritos)->with('id_departamento', $id_departamento)->with('id_region', $id_region)->with('id_provincia', $id_provincia)->with('id_distrito', $id_distrito)->with('id_nivel', $id_nivel)->with('id_categoria', $id_categoria)->with('region', $region)->with('nivel', $nivel)->with('categoria', $categoria);    


    }

    public function update($id, UpdateEstablecimientoRequest $request)
    {
        $establecimientos = $this->establecimientoRepository->findWithoutFail($id);

        if (empty($establecimientos)) {
            Flash::error('Establecimientos no encontrado');

            return redirect(route('establecimientos.index'));
        }

        $establecimientos = $this->establecimientoRepository->update($request->all(), $id);

        Flash::success('Establecimientos actualizado satisfactoriamente.');

        return redirect(route('establecimientos.index'));
    }

    public function destroy($id)
    {
        $establecimiento = $this->establecimientoRepository->findWithoutFail($id);

        if (empty($establecimiento)) {
            Flash::error('Establecimientos no encontrado');

            return redirect(route('establecimientos.index'));
        }

        $this->establecimientoRepository->delete($id);

        Flash::success('Establecimientos eliminado.');

        return redirect(route('establecimientos.index'));
    }

    public function cargadireccion($id) {
        $model = new Establecimiento();
        $direccion = $model->GetByDireccion($id);
        
        return $direccion;
    }
}
