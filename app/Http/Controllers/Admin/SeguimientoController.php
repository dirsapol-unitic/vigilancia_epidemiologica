<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSeguimientoRequest;
use App\Http\Requests\UpdateSeguimientoRequest;
use App\Repositories\SeguimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Seguimiento;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SeguimientoController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $seguimientoRepository;

    public function __construct(SeguimientoRepository $pnpSeguimientoRepo)
    {
        $this->seguimientoRepository = $pnpSeguimientoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->seguimientoRepository->pushCriteria(new RequestCriteria($request));
        $seguimientos = $this->seguimientoRepository->all();

        return view('admin.seguimientos.index')
            ->with('seguimientos', $seguimientos);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.seguimientos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguimientoRequest $request)
    {
        $input = $request->all();

        $seguimiento = $this->seguimientoRepository->create($input);

        Flash::success('Seguimiento guardado correctamente.');

        return redirect(route('seguimientos.index'));
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
        $seguimientos = $this->seguimientoRepository->findWithoutFail($id);

        if (empty($seguimientos)) {
            Flash::error('Seguimiento no encontrado');

            return redirect(route('seguimientos.index'));
        }

        return view('admin.seguimientos.show')->with('seguimientos', $seguimientos);
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
        $seguimientos = $this->seguimientoRepository->findWithoutFail($id);

        if (empty($seguimientos)) {
            Flash::error('Seguimiento no encontrado');

            return redirect(route('seguimientos.index'));
        }

        return view('admin.seguimientos.edit')->with('seguimientos', $seguimientos);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguimientoRequest $request)
    {
        $seguimientos = $this->seguimientoRepository->findWithoutFail($id);

        if (empty($seguimientos)) {
            Flash::error('Seguimiento no encontrado');

            return redirect(route('seguimientos.index'));
        }

        $seguimientos = $this->seguimientoRepository->update($request->all(), $id);

        Flash::success('Seguimiento actualizado satisfactoriamente.');

        return redirect(route('seguimientos.index'));
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
        $seguimientos = $this->seguimientoRepository->findWithoutFail($id);

        if (empty($seguimientos)) {
            Flash::error('Seguimiento no encontrado');

            return redirect(route('seguimientos.index'));
        }

        $this->seguimientoRepository->delete($id);

        Flash::success('Seguimiento eliminado.');

        return redirect(route('seguimientos.index'));
    }
    
}
