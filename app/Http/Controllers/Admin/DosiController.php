<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateDosiRequest;
use App\Http\Requests\UpdateDosiRequest;
use App\Repositories\DosiRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Dosi;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DosiController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $dosiRepository;

    public function __construct(DosiRepository $pnpDosiRepo)
    {
        $this->dosiRepository = $pnpDosiRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->dosiRepository->pushCriteria(new RequestCriteria($request));
        $dosis = $this->dosiRepository->all();

        return view('admin.dosis.index')
            ->with('dosis', $dosis);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.dosis.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateDosiRequest $request)
    {
        $input = $request->all();

        $dosi = $this->dosiRepository->create($input);

        Flash::success('Dosis guardado correctamente.');

        return redirect(route('dosis.index'));
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
        $dosis = $this->dosiRepository->findWithoutFail($id);

        if (empty($dosis)) {
            Flash::error('Dosis no encontrado');

            return redirect(route('dosis.index'));
        }

        return view('admin.dosis.show')->with('dosis', $dosis);
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
        $dosis = $this->dosiRepository->findWithoutFail($id);

        if (empty($dosis)) {
            Flash::error('Dosis no encontrado');

            return redirect(route('dosis.index'));
        }

        return view('admin.dosis.edit')->with('dosis', $dosis);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDosiRequest $request)
    {
        $dosis = $this->dosiRepository->findWithoutFail($id);

        if (empty($dosis)) {
            Flash::error('Dosis no encontrado');

            return redirect(route('dosis.index'));
        }

        $dosis = $this->dosiRepository->update($request->all(), $id);

        Flash::success('Dosis actualizado satisfactoriamente.');

        return redirect(route('dosis.index'));
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
        $dosis = $this->dosiRepository->findWithoutFail($id);

        if (empty($dosis)) {
            Flash::error('Dosis no encontrado');

            return redirect(route('dosis.index'));
        }

        $this->dosiRepository->delete($id);

        Flash::success('Dosis eliminado.');

        return redirect(route('dosis.index'));
    }

    public function cargarDosi($id)
    {
        $model_categorias= new Dosi();
        $categoria = $model_categorias->getDosi($id);

        return $categoria;

    }    
}
