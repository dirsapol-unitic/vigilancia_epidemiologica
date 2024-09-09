<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateEstablecimientoSaludRequest;
use App\Http\Requests\UpdateEstablecimientoSaludRequest;
use App\Repositories\EstablecimientoSaludRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\EstablecimientoSalud;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EstablecimientoSaludController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $establecimientosaludRepository;

    public function __construct(EstablecimientoSaludRepository $EstablecimientoSaludRepo)
    {
        $this->establecimientosaludRepository = $EstablecimientoSaludRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->establecimientosaludRepository->pushCriteria(new RequestCriteria($request));
        $establecimientosalud = $this->establecimientosaludRepository->all();

        return view('admin.establecimiento_saluds.index')
            ->with('establecimientosalud', $establecimientosalud);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.establecimiento_saluds.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateEstablecimientoSaludRequest $request)
    {
        $input = $request->all();

        $establecimientosalud = $this->establecimientosaludRepository->create($input);

        Flash::success('Establecimiento salud guardado correctamente.');

        return redirect(route('establecimientosaluds.index'));
    }

    /**
     * Display the specified Departamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $establecimientosalud = $this->establecimientosaludRepository->findWithoutFail($id);

        if (empty($establecimientosalud)) {
            Flash::error('Establecimiento salud no encontrado');

            return redirect(route('establecimientosaluds.index'));
        }

        return view('admin.establecimiento_saluds.show')->with('establecimientosalud', $establecimientosalud);
    }

    /**
     * Show the form for editing the specified Departamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $establecimientosalud = $this->establecimientosaludRepository->findWithoutFail($id);

        if (empty($establecimientosalud)) {
            Flash::error('Establecimiento salud no encontrado');

            return redirect(route('establecimientosaluds.index'));
        }

        return view('admin.establecimiento_saluds.edit')->with('establecimientosalud', $establecimientosalud);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstablecimientoSaludRequest $request)
    {
        $establecimientosalud = $this->establecimientosaludRepository->findWithoutFail($id);

        if (empty($establecimientosalud)) {
            Flash::error('Establecimiento salud no encontrado');

            return redirect(route('establecimientosaluds.index'));
        }

        $factorriesgos = $this->establecimientosaludRepository->update($request->all(), $id);

        Flash::success('Establecimiento salud actualizado satisfactoriamente.');

        return redirect(route('establecimientosaluds.index'));
    }

    /**
     * Remove the specified Departamento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $establecimientosalud = $this->establecimientosaludRepository->findWithoutFail($id);

        if (empty($establecimientosalud)) {
            Flash::error('Establecimiento salud no encontrado');

            return redirect(route('establecimientosaluds.index'));
        }

        $this->establecimientosaludRepository->delete($id);

        Flash::success('Establecimiento salud eliminado.');

        return redirect(route('establecimientosaluds.index'));
    }

    public function cargarEstablecimientoSalud($id)
    {
        $model_categorias= new EstablecimientoSalud();
        $categoria = $model_categorias->getEstablecimientoSalud($id);

        return $categoria;

    }    
}
