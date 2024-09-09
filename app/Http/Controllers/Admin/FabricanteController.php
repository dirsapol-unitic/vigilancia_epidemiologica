<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateFabricanteRequest;
use App\Http\Requests\UpdateFabricanteRequest;
use App\Repositories\FabricanteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Fabricante;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class FabricanteController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $fabricanteRepository;

    public function __construct(FabricanteRepository $pnpFabricanteRepo)
    {
        $this->fabricanteRepository = $pnpFabricanteRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->fabricanteRepository->pushCriteria(new RequestCriteria($request));
        $fabricantes = $this->fabricanteRepository->all();

        return view('admin.fabricantes.index')
            ->with('fabricantes', $fabricantes);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.fabricantes.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateFabricanteRequest $request)
    {
        $input = $request->all();

        $fabricantes = $this->fabricanteRepository->create($input);

        Flash::success('fabricantes guardado correctamente.');

        return redirect(route('fabricantes.index'));
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
        $fabricantes = $this->fabricanteRepository->findWithoutFail($id);

        if (empty($fabricantes)) {
            Flash::error('Fabricante no encontrado');

            return redirect(route('fabricantes.index'));
        }

        return view('admin.fabricantes.show')->with('fabricantes', $fabricantes);
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
        $fabricantes = $this->fabricanteRepository->findWithoutFail($id);

        if (empty($fabricantes)) {
            Flash::error('Fabricante no encontrado');

            return redirect(route('fabricantes.index'));
        }

        return view('admin.fabricantes.edit')->with('fabricantes', $fabricantes);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFabricanteRequest $request)
    {
        $fabricantes = $this->fabricanteRepository->findWithoutFail($id);

        if (empty($fabricantes)) {
            Flash::error('Fabricante no encontrado');

            return redirect(route('fabricantes.index'));
        }

        $fabricantes = $this->fabricanteRepository->update($request->all(), $id);

        Flash::success('Fabricante actualizado satisfactoriamente.');

        return redirect(route('fabricantes.index'));
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
        $fabricantes = $this->fabricanteRepository->findWithoutFail($id);

        if (empty($fabricantes)) {
            Flash::error('Fabricante no encontrado');

            return redirect(route('fabricantes.index'));
        }

        $this->fabricanteRepository->delete($id);

        Flash::success('Fabricante eliminado.');

        return redirect(route('fabricantes.index'));
    }

    public function cargarFabricante($id)
    {
        $model_categorias= new Fabricante();
        $categoria = $model_categorias->getFabricante($id);

        return $categoria;

    }    
}
