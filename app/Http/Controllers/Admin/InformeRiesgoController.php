<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateInformeRiesgoRequest;
use App\Http\Requests\UpdateInformeRiesgoRequest;
use App\Repositories\InformeRiesgoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\InformeRiesgo;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class InformeRiesgoController extends AppBaseController
{
    /** @var  informeriesgoRepository */
    private $informeriesgoRepository;

    public function __construct(InformeRiesgoRepository $pnpInformeRiesgoRepo)
    {
        $this->informeriesgoRepository = $pnpInformeRiesgoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->informeriesgoRepository->pushCriteria(new RequestCriteria($request));
        $informeriesgos = $this->informeriesgoRepository->all();

        return view('admin.informe_riesgos.index')
            ->with('informeriesgos', $informeriesgos);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.informe_riesgos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateInformeRiesgoRequest $request)
    {
        $input = $request->all();

        $informeriesgo = $this->informeriesgoRepository->create($input);

        Flash::success('Informe de Riesgo guardado correctamente.');

        return redirect(route('informeriesgos.index'));
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
        $informeriesgos = $this->informeriesgoRepository->findWithoutFail($id);

        if (empty($informeriesgos)) {
            Flash::error('Informe de Riesgo no encontrado');

            return redirect(route('departamentos.index'));
        }

        return view('admin.informe_riesgos.show')->with('informeriesgos', $informeriesgos);
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
        $informeriesgos = $this->informeriesgoRepository->findWithoutFail($id);

        if (empty($informeriesgos)) {
            Flash::error('Informe de Riesgo no encontrado');

            return redirect(route('informeriesgos.index'));
        }

        return view('admin.informe_riesgos.edit')->with('informeriesgos', $informeriesgos);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInformeRiesgoRequest $request)
    {
        $informeriesgos = $this->informeriesgoRepository->findWithoutFail($id);

        if (empty($informeriesgos)) {
            Flash::error('Informe de Riesgo no encontrado');

            return redirect(route('informeriesgos.index'));
        }

        $informeriesgos = $this->informeriesgoRepository->update($request->all(), $id);

        Flash::success('Informe de Riesgo actualizado satisinformeiamente.');

        return redirect(route('informeriesgos.index'));
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
        $informeriesgos = $this->informeriesgoRepository->findWithoutFail($id);

        if (empty($informeriesgos)) {
            Flash::error('Informe de Riesgo no encontrado');

            return redirect(route('informeriesgos.index'));
        }

        $this->informeriesgoRepository->delete($id);

        Flash::success('Informe de Riesgo eliminado.');

        return redirect(route('informeriesgos.index'));
    }

    public function cargarInformeRiesgo($id)
    {
        $model_categorias= new InformeRiesgo();
        $categoria = $model_categorias->getInformeRiesgo($id);

        return $categoria;

    }    
}
