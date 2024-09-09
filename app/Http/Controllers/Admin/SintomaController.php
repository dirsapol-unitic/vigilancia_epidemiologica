<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSintomaRequest;
use App\Http\Requests\UpdateSintomaRequest;
use App\Repositories\SintomaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Sintoma;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SintomaController extends AppBaseController
{
    /** @var  SintomaRepository */
    private $SintomaRepository;

    public function __construct(SintomaRepository $pnpSintomaRepo)
    {
        $this->SintomaRepository = $pnpSintomaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->SintomaRepository->pushCriteria(new RequestCriteria($request));
        $sintomas = $this->SintomaRepository->all();

        return view('admin.sintomas.index')
            ->with('sintomas', $sintomas);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.sintomas.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateSintomaRequest $request)
    {
        $input = $request->all();

        $sintoma = $this->SintomaRepository->create($input);

        Flash::success('sintomas guardado correctamente.');

        return redirect(route('sintomas.index'));
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
        $sintomas = $this->SintomaRepository->findWithoutFail($id);

        if (empty($sintomas)) {
            Flash::error('Sintomas no encontrado');

            return redirect(route('sintomas.index'));
        }

        return view('admin.sintomas.show')->with('sintomas', $sintomas);
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
        $sintomas = $this->SintomaRepository->findWithoutFail($id);

        if (empty($sintomas)) {
            Flash::error('Sintomas no encontrado');

            return redirect(route('sintomas.index'));
        }

        return view('admin.sintomas.edit')->with('sintomas', $sintomas);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSintomaRequest $request)
    {
        $sintomas = $this->SintomaRepository->findWithoutFail($id);

        if (empty($sintomas)) {
            Flash::error('Sintoma no encontrado');

            return redirect(route('sintomas.index'));
        }

        $sintomas = $this->SintomaRepository->update($request->all(), $id);

        Flash::success('Sintoma actualizado satisfactoriamente.');

        return redirect(route('sintomas.index'));
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
        $sintomas = $this->SintomaRepository->findWithoutFail($id);

        if (empty($sintomas)) {
            Flash::error('sintomas no encontrado');

            return redirect(route('sintomas.index'));
        }

        $this->SintomaRepository->delete($id);

        Flash::success('sintomas eliminado.');

        return redirect(route('sintomas.index'));
    }

    public function cargarSintoma($id)
    {
        $model_categorias= new Sintoma();
        $categoria = $model_categorias->getSintoma($id);

        return $categoria;

    }    
}
