<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateViaRequest;
use App\Http\Requests\UpdateViaRequest;
use App\Repositories\ViaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Via;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ViaController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $viaRepository;

    public function __construct(ViaRepository $pnpViaRepo)
    {
        $this->viaRepository = $pnpViaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->viaRepository->pushCriteria(new RequestCriteria($request));
        $vias = $this->viaRepository->all();

        return view('admin.vias.index')
            ->with('vias', $vias);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.vias.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateViaRequest $request)
    {
        $input = $request->all();

        $via = $this->viaRepository->create($input);

        Flash::success('Via guardado correctamente.');

        return redirect(route('vias.index'));
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
        $vias = $this->viaRepository->findWithoutFail($id);

        if (empty($vias)) {
            Flash::error('Via no encontrado');

            return redirect(route('departamentos.index'));
        }

        return view('admin.vias.show')->with('vias', $vias);
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
        $vias = $this->viaRepository->findWithoutFail($id);

        if (empty($vias)) {
            Flash::error('Via no encontrado');

            return redirect(route('vias.index'));
        }

        return view('admin.vias.edit')->with('vias', $vias);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateViaRequest $request)
    {
        $vias = $this->viaRepository->findWithoutFail($id);

        if (empty($vias)) {
            Flash::error('Via no encontrado');

            return redirect(route('vias.index'));
        }

        $vias = $this->viaRepository->update($request->all(), $id);

        Flash::success('Via actualizado satisfactoriamente.');

        return redirect(route('vias.index'));
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
        $vias = $this->viaRepository->findWithoutFail($id);

        if (empty($vias)) {
            Flash::error('Via no encontrado');

            return redirect(route('vias.index'));
        }

        $this->viaRepository->delete($id);

        Flash::success('Via eliminado.');

        return redirect(route('vias.index'));
    }

    public function cargarVia($id)
    {
        $model_categorias= new Via();
        $categoria = $model_categorias->getVia($id);

        return $categoria;

    }    
}
