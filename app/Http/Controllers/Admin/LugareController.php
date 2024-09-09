<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateLugareRequest;
use App\Http\Requests\UpdateLugareRequest;
use App\Repositories\LugareRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Lugare;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LugareController extends AppBaseController
{
    /** @var  SignoRepository */
    private $LugareRepository;

    public function __construct(LugareRepository $pnpLugareRepo)
    {
        $this->LugareRepository = $pnpLugareRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->LugareRepository->pushCriteria(new RequestCriteria($request));
        $lugares = $this->LugareRepository->all();

        return view('admin.lugares.index')
            ->with('lugares', $lugares);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.lugares.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateLugareRequest $request)
    {
        $input = $request->all();

        $lugare = $this->LugareRepository->create($input);

        Flash::success('lugares guardado correctamente.');

        return redirect(route('lugares.index'));
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
        $lugares = $this->LugareRepository->findWithoutFail($id);

        if (empty($lugares)) {
            Flash::error('Lugares no encontrado');

            return redirect(route('lugares.index'));
        }

        return view('admin.lugares.show')->with('lugares', $lugares);
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
        $lugares = $this->LugareRepository->findWithoutFail($id);

        if (empty($lugares)) {
            Flash::error('Lugares no encontrado');

            return redirect(route('lugares.index'));
        }

        return view('admin.lugares.edit')->with('lugares', $lugares);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLugareRequest $request)
    {
        $lugares = $this->LugareRepository->findWithoutFail($id);

        if (empty($lugares)) {
            Flash::error('Lugar no encontrado');

            return redirect(route('signos.index'));
        }

        $lugares = $this->LugareRepository->update($request->all(), $id);

        Flash::success('Lugar actualizado satisfactoriamente.');

        return redirect(route('lugares.index'));
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
        $lugares = $this->LugareRepository->findWithoutFail($id);

        if (empty($lugares)) {
            Flash::error('lugares no encontrado');

            return redirect(route('lugares.index'));
        }

        $this->LugareRepository->delete($id);

        Flash::success('Lugar eliminado.');

        return redirect(route('lugares.index'));
    }

    public function cargarLugar($id)
    {
        $model_categorias= new Lugare();
        $categoria = $model_categorias->getLugar($id);

        return $categoria;

    }    
}
