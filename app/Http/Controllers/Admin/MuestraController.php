<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateMuestraRequest;
use App\Http\Requests\UpdateMuestraRequest;
use App\Repositories\MuestraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Muestra;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MuestraController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $muestraRepository;

    public function __construct(MuestraRepository $pnpMuestraRepo)
    {
        $this->muestraRepository = $pnpMuestraRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->muestraRepository->pushCriteria(new RequestCriteria($request));
        $muestras = $this->muestraRepository->all();

        return view('admin.muestras.index')
            ->with('muestras', $muestras);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.muestras.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateMuestraRequest $request)
    {
        $input = $request->all();

        $muestras = $this->muestraRepository->create($input);

        Flash::success('Muestras guardado correctamente.');

        return redirect(route('muestras.index'));
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
        $muestras = $this->muestraRepository->findWithoutFail($id);

        if (empty($muestras)) {
            Flash::error('Muestra no encontrado');

            return redirect(route('muestras.index'));
        }

        return view('admin.muestras.show')->with('muestras', $muestras);
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
        $muestras = $this->muestraRepository->findWithoutFail($id);

        if (empty($muestras)) {
            Flash::error('Muestra no encontrado');

            return redirect(route('muestras.index'));
        }

        return view('admin.muestras.edit')->with('muestras', $muestras);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMuestraRequest $request)
    {
        $muestras = $this->muestraRepository->findWithoutFail($id);

        if (empty($muestras)) {
            Flash::error('Muestra no encontrado');

            return redirect(route('muestras.index'));
        }

        $muestras = $this->muestraRepository->update($request->all(), $id);

        Flash::success('Muestra actualizado satisfactoriamente.');

        return redirect(route('muestras.index'));
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
        $muestras = $this->muestraRepository->findWithoutFail($id);

        if (empty($muestras)) {
            Flash::error('Muestra no encontrado');

            return redirect(route('muestras.index'));
        }

        $this->muestraRepository->delete($id);

        Flash::success('Muestra eliminado.');

        return redirect(route('muestras.index'));
    }

    public function cargarMuestras($id)
    {
        $model_categorias= new Muestra();
        $categoria = $model_categorias->getMuestra($id);

        return $categoria;

    }    
}
