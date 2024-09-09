<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePruebaRequest;
use App\Http\Requests\UpdatePruebaRequest;
use App\Repositories\PruebaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Prueba;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PruebaController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $pruebaRepository;

    public function __construct(PruebaRepository $pnpPruebaRepo)
    {
        $this->pruebaRepository = $pnpPruebaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pruebaRepository->pushCriteria(new RequestCriteria($request));
        $pruebas = $this->pruebaRepository->all();

        return view('admin.pruebas.index')
            ->with('pruebas', $pruebas);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pruebas.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreatePruebaRequest $request)
    {
        $input = $request->all();

        $pruebas = $this->pruebaRepository->create($input);

        Flash::success('Muestras guardado correctamente.');

        return redirect(route('pruebas.index'));
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
        $pruebas = $this->pruebaRepository->findWithoutFail($id);

        if (empty($pruebas)) {
            Flash::error('Pruebaa no encontrado');

            return redirect(route('pruebas.index'));
        }

        return view('admin.pruebas.show')->with('pruebas', $pruebas);
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
        $pruebas = $this->pruebaRepository->findWithoutFail($id);

        if (empty($pruebas)) {
            Flash::error('Prueba no encontrado');

            return redirect(route('pruebas.index'));
        }

        return view('admin.pruebas.edit')->with('pruebas', $pruebas);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePruebaRequest $request)
    {
        $pruebas = $this->pruebaRepository->findWithoutFail($id);

        if (empty($pruebas)) {
            Flash::error('Prueba no encontrado');

            return redirect(route('pruebas.index'));
        }

        $pruebas = $this->pruebaRepository->update($request->all(), $id);

        Flash::success('Prueba actualizado satisfactoriamente.');

        return redirect(route('pruebas.index'));
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
        $pruebas = $this->pruebaRepository->findWithoutFail($id);

        if (empty($pruebas)) {
            Flash::error('Prueba no encontrado');

            return redirect(route('pruebas.index'));
        }

        $this->pruebaRepository->delete($id);

        Flash::success('Prueba eliminado.');

        return redirect(route('pruebas.index'));
    }

    public function cargarPruebas($id)
    {
        $model_categorias= new Prueba();
        $categoria = $model_categorias->getPrueba($id);

        return $categoria;

    }    
}
