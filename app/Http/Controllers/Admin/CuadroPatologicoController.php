<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCuadroPatologicoRequest;
use App\Http\Requests\UpdateCuadroPatologicoRequest;
use App\Repositories\CuadroPatologicoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\CuadroPatologico;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CuadroPatologicoController extends AppBaseController
{
    /** @var  CuadroPatologicoRepository */
    private $CuadroPatologicoRepository;

    public function __construct(CuadroPatologicoRepository $pnpCuadroPatologicoRepo)
    {
        $this->CuadroPatologicoRepository = $pnpCuadroPatologicoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->CuadroPatologicoRepository->pushCriteria(new RequestCriteria($request));
        $CuadroPatologicos = $this->CuadroPatologicoRepository->all();

        return view('admin.cuadro_patologicos.index')
            ->with('cuadropatologicos', $CuadroPatologicos);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.cuadro_patologicos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateCuadroPatologicoRequest $request)
    {
        $input = $request->all();

        $CuadroPatologico = $this->CuadroPatologicoRepository->create($input);

        Flash::success('Cuadro Patologicos guardado correctamente.');

        return redirect(route('cuadropatologicos.index'));
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
        $CuadroPatologicos = $this->CuadroPatologicoRepository->findWithoutFail($id);

        if (empty($CuadroPatologicos)) {
            Flash::error('Cuadro Patologicos no encontrado');

            return redirect(route('cuadropatologicos.index'));
        }

        return view('admin.cuadro_patologicos.show')->with('cuadropatologicos', $CuadroPatologicos);
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
        $CuadroPatologicos = $this->CuadroPatologicoRepository->findWithoutFail($id);

        if (empty($CuadroPatologicos)) {
            Flash::error('CuadroPatologicos no encontrado');

            return redirect(route('cuadropatologicos.index'));
        }

        return view('admin.cuadro_patologicos.edit')->with('cuadropatologicos', $CuadroPatologicos);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCuadroPatologicoRequest $request)
    {
        $CuadroPatologicos = $this->CuadroPatologicoRepository->findWithoutFail($id);

        if (empty($CuadroPatologicos)) {
            Flash::error('CuadroPatologico no encontrado');

            return redirect(route('cuadropatologicos.index'));
        }

        $CuadroPatologicos = $this->CuadroPatologicoRepository->update($request->all(), $id);

        Flash::success('CuadroPatologico actualizado satisfactoriamente.');

        return redirect(route('cuadropatologicos.index'));
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
        $CuadroPatologicos = $this->CuadroPatologicoRepository->findWithoutFail($id);

        if (empty($CuadroPatologicos)) {
            Flash::error('CuadroPatologicos no encontrado');

            return redirect(route('cuadropatologicos.index'));
        }

        $this->CuadroPatologicoRepository->delete($id);

        Flash::success('CuadroPatologicos eliminado.');

        return redirect(route('cuadropatologicos.index'));
    }

    public function cargarCuadroPatologico($id)
    {
        $model_categorias= new CuadroPatologico();
        $categoria = $model_categorias->getCuadroPatologico($id);

        return $categoria;

    }    
}
