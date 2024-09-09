<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateEnfermedadRegioneRequest;
use App\Http\Requests\UpdateEnfermedadRegioneRequest;
use App\Repositories\EnfermedadRegioneRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\EnfermedadRegione;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EnfermedadRegioneController extends AppBaseController
{
    /** @var  EnfermedadRegioneRepository */
    private $EnfermedadRegioneRepository;

    public function __construct(EnfermedadRegioneRepository $pnpEnfermedadRegioneRepo)
    {
        $this->EnfermedadRegioneRepository = $pnpEnfermedadRegioneRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->EnfermedadRegioneRepository->pushCriteria(new RequestCriteria($request));
        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->all();

        return view('admin.enfermedad_regiones.index')
            ->with('enfermedadregiones', $EnfermedadRegiones);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.enfermedad_regiones.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateEnfermedadRegioneRequest $request)
    {
        $input = $request->all();

        $EnfermedadRegione = $this->EnfermedadRegioneRepository->create($input);

        Flash::success('Cuadro Prevalente en Regiones guardado correctamente.');

        return redirect(route('enfermedadregiones.index'));
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
        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->findWithoutFail($id);

        if (empty($EnfermedadRegiones)) {
            Flash::error('Enfermedad Prevalente en Regiones no encontrado');

            return redirect(route('enfermedadregiones.index'));
        }

        return view('admin.enfermedad_regiones.show')->with('enfermedadregiones', $EnfermedadRegiones);
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
        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->findWithoutFail($id);

        if (empty($EnfermedadRegiones)) {
            Flash::error('Enfermedad Prevalente en Regiones no encontrado');

            return redirect(route('enfermedadregiones.index'));
        }

        return view('admin.enfermedad_regiones.edit')->with('enfermedadregiones', $EnfermedadRegiones);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEnfermedadRegioneRequest $request)
    {
        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->findWithoutFail($id);

        if (empty($EnfermedadRegiones)) {
            Flash::error('Enfermedad Prevalente en Regiones no encontrado');

            return redirect(route('enfermedadregiones.index'));
        }

        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->update($request->all(), $id);

        Flash::success('EnfermedadRegione actualizado satisfactoriamente.');

        return redirect(route('enfermedadregiones.index'));
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
        $EnfermedadRegiones = $this->EnfermedadRegioneRepository->findWithoutFail($id);

        if (empty($EnfermedadRegiones)) {
            Flash::error('Enfermedad Prevalente en Regiones no encontrado');

            return redirect(route('enfermedadregiones.index'));
        }

        $this->EnfermedadRegioneRepository->delete($id);

        Flash::success('Enfermedad Prevalente en Regiones eliminado.');

        return redirect(route('enfermedadregiones.index'));
    }

    public function cargarEnfermedadRegione($id)
    {
        $model_categorias= new EnfermedadRegione();
        $categoria = $model_categorias->getEnfermedadRegione($id);

        return $categoria;

    }    
}
