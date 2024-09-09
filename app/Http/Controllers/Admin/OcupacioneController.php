<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateOcupacioneRequest;
use App\Http\Requests\UpdateOcupacioneRequest;
use App\Repositories\OcupacioneRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Ocupacione;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class OcupacioneController extends AppBaseController
{
    /** @var  OcupacioneRepository */
    private $OcupacioneRepository;

    public function __construct(OcupacioneRepository $pnpOcupacioneRepo)
    {
        $this->OcupacioneRepository = $pnpOcupacioneRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->OcupacioneRepository->pushCriteria(new RequestCriteria($request));
        $ocupaciones = $this->OcupacioneRepository->all();

        return view('admin.ocupaciones.index')
            ->with('ocupaciones', $ocupaciones);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.ocupaciones.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateOcupacioneRequest $request)
    {
        $input = $request->all();

        $ocupacione = $this->OcupacioneRepository->create($input);

        Flash::success('ocupaciones guardado correctamente.');

        return redirect(route('ocupaciones.index'));
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
        $ocupaciones = $this->OcupacioneRepository->findWithoutFail($id);

        if (empty($ocupaciones)) {
            Flash::error('Ocupaciones no encontrado');

            return redirect(route('ocupaciones.index'));
        }

        return view('admin.ocupaciones.show')->with('ocupaciones', $ocupaciones);
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
        $ocupaciones = $this->OcupacioneRepository->findWithoutFail($id);

        if (empty($ocupaciones)) {
            Flash::error('ocupaciones no encontrado');

            return redirect(route('ocupaciones.index'));
        }

        return view('admin.ocupaciones.edit')->with('ocupaciones', $ocupaciones);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOcupacioneRequest $request)
    {
        $ocupaciones = $this->OcupacioneRepository->findWithoutFail($id);

        if (empty($ocupaciones)) {
            Flash::error('Ocupacione no encontrado');

            return redirect(route('ocupaciones.index'));
        }

        $ocupaciones = $this->OcupacioneRepository->update($request->all(), $id);

        Flash::success('Ocupacione actualizado satisfactoriamente.');

        return redirect(route('ocupaciones.index'));
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
        $ocupaciones = $this->OcupacioneRepository->findWithoutFail($id);

        if (empty($ocupaciones)) {
            Flash::error('ocupaciones no encontrado');

            return redirect(route('ocupaciones.index'));
        }

        $this->OcupacioneRepository->delete($id);

        Flash::success('ocupaciones eliminado.');

        return redirect(route('ocupaciones.index'));
    }

    public function cargarOcupacione($id)
    {
        $model_categorias= new Ocupacione();
        $categoria = $model_categorias->getOcupacione($id);

        return $categoria;

    }    
}
