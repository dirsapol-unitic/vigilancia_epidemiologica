<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateVacunaRequest;
use App\Http\Requests\UpdateVacunaRequest;
use App\Repositories\VacunaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Vacuna;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class VacunaController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $vacunaRepository;

    public function __construct(VacunaRepository $pnpVacunaRepo)
    {
        $this->vacunaRepository = $pnpVacunaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->vacunaRepository->pushCriteria(new RequestCriteria($request));
        $vacunas = $this->vacunaRepository->all();

        return view('admin.vacunas.index')
            ->with('vacunas', $vacunas);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.vacunas.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateVacunaRequest $request)
    {
        $input = $request->all();

        $vacunas = $this->vacunaRepository->create($input);

        Flash::success('Vacunas guardado correctamente.');

        return redirect(route('vacunas.index'));
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
        $vacunas = $this->vacunaRepository->findWithoutFail($id);

        if (empty($vacunas)) {
            Flash::error('Vacuna no encontrado');

            return redirect(route('vacunas.index'));
        }

        return view('admin.vacunas.show')->with('vacunas', $vacunas);
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
        $vacunas = $this->vacunaRepository->findWithoutFail($id);

        if (empty($vacunas)) {
            Flash::error('Vacuna no encontrado');

            return redirect(route('vacunas.index'));
        }

        return view('admin.vacunas.edit')->with('vacunas', $vacunas);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVacunaRequest $request)
    {
        $vacunas = $this->vacunaRepository->findWithoutFail($id);

        if (empty($vacunas)) {
            Flash::error('Vacuna no encontrado');

            return redirect(route('vacunas.index'));
        }

        $vacunas = $this->vacunaRepository->update($request->all(), $id);

        Flash::success('Vacuna actualizado satisfactoriamente.');

        return redirect(route('vacunas.index'));
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
        $vacunas = $this->vacunaRepository->findWithoutFail($id);

        if (empty($vacunas)) {
            Flash::error('Vacuna no encontrado');

            return redirect(route('vacunas.index'));
        }

        $this->vacunaRepository->delete($id);

        Flash::success('Vacuna eliminado.');

        return redirect(route('vacunas.index'));
    }

    public function cargarVacunas($id)
    {
        $model_categorias= new Vacuna();
        $categoria = $model_categorias->getVacuna($id);

        return $categoria;

    }    
}
