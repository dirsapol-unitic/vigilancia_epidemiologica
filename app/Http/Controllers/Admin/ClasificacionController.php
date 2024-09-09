<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateClasificacionRequest;
use App\Http\Requests\UpdateClasificacionRequest;
use App\Repositories\ClasificacionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Clasificacion;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ClasificacionController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $clasificacionRepository;

    public function __construct(ClasificacionRepository $pnpClasificacionRepo)
    {
        $this->clasificacionRepository = $pnpClasificacionRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->clasificacionRepository->pushCriteria(new RequestCriteria($request));
        $clasificaciones = $this->clasificacionRepository->all();

        return view('admin.clasificaciones.index')
            ->with('clasificaciones', $clasificaciones);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.clasificaciones.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateClasificacionRequest $request)
    {
        $input = $request->all();

        $clasificacion = $this->clasificacionRepository->create($input);

        Flash::success('Clasificacion guardado correctamente.');

        return redirect(route('clasificaciones.index'));
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
        $clasificaciones = $this->clasificacionRepository->findWithoutFail($id);

        if (empty($clasificaciones)) {
            Flash::error('Clasificacion no encontrado');

            return redirect(route('clasificaciones.index'));
        }

        return view('admin.clasificaciones.show')->with('clasificaciones', $clasificaciones);
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
        $clasificaciones = $this->clasificacionRepository->findWithoutFail($id);

        if (empty($clasificaciones)) {
            Flash::error('Clasificacion no encontrado');

            return redirect(route('clasificaciones.index'));
        }

        return view('admin.clasificaciones.edit')->with('clasificaciones', $clasificaciones);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClasificacionRequest $request)
    {
        $clasificaciones = $this->clasificacionRepository->findWithoutFail($id);

        if (empty($clasificaciones)) {
            Flash::error('Clasificacion no encontrado');

            return redirect(route('clasificaciones.index'));
        }

        $clasificaciones = $this->clasificacionRepository->update($request->all(), $id);

        Flash::success('Clasificacion actualizado satisfactoriamente.');

        return redirect(route('clasificaciones.index'));
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
        $clasificaciones = $this->clasificacionRepository->findWithoutFail($id);

        if (empty($clasificaciones)) {
            Flash::error('Clasificacion no encontrado');

            return redirect(route('clasificaciones.index'));
        }

        $this->clasificacionRepository->delete($id);

        Flash::success('Clasificacion eliminado.');

        return redirect(route('clasificaciones.index'));
    }
    
}
