<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateFactorRiesgoRequest;
use App\Http\Requests\UpdateFactorRiesgoRequest;
use App\Repositories\FactorRiesgoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\FactorRiesgo;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class FactorRiesgoController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $factorriesgoRepository;

    public function __construct(FactorRiesgoRepository $pnpFactorRiesgoRepo)
    {
        $this->factorriesgoRepository = $pnpFactorRiesgoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->factorriesgoRepository->pushCriteria(new RequestCriteria($request));
        $factorriesgos = $this->factorriesgoRepository->all();

        return view('admin.factor_riesgos.index')
            ->with('factorriesgos', $factorriesgos);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.factor_riesgos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateFactorRiesgoRequest $request)
    {
        $input = $request->all();

        $factorriesgo = $this->factorriesgoRepository->create($input);

        Flash::success('Factor de Riesgo guardado correctamente.');

        return redirect(route('factorriesgos.index'));
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
        $factorriesgos = $this->factorriesgoRepository->findWithoutFail($id);

        if (empty($factorriesgos)) {
            Flash::error('Factor de Riesgo no encontrado');

            return redirect(route('departamentos.index'));
        }

        return view('admin.factor_riesgos.show')->with('factorriesgos', $factorriesgos);
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
        $factorriesgos = $this->factorriesgoRepository->findWithoutFail($id);

        if (empty($factorriesgos)) {
            Flash::error('Factor de Riesgo no encontrado');

            return redirect(route('factorriesgos.index'));
        }

        return view('admin.factor_riesgos.edit')->with('factorriesgos', $factorriesgos);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFactorRiesgoRequest $request)
    {
        $factorriesgos = $this->factorriesgoRepository->findWithoutFail($id);

        if (empty($factorriesgos)) {
            Flash::error('Factor de Riesgo no encontrado');

            return redirect(route('factorriesgos.index'));
        }

        $factorriesgos = $this->factorriesgoRepository->update($request->all(), $id);

        Flash::success('Factor de Riesgo actualizado satisfactoriamente.');

        return redirect(route('factorriesgos.index'));
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
        $factorriesgos = $this->factorriesgoRepository->findWithoutFail($id);

        if (empty($factorriesgos)) {
            Flash::error('Factor de Riesgo no encontrado');

            return redirect(route('factorriesgos.index'));
        }

        $this->factorriesgoRepository->delete($id);

        Flash::success('Factor de Riesgo eliminado.');

        return redirect(route('factorriesgos.index'));
    }

    public function cargarFactorRiesgo($id)
    {
        $model_categorias= new FactorRiesgo();
        $categoria = $model_categorias->getFactorRiesgo($id);

        return $categoria;

    }    
}
