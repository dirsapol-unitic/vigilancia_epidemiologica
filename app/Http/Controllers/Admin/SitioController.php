<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSitioRequest;
use App\Http\Requests\UpdateSitioRequest;
use App\Repositories\SitioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Sitio;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SitioController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $sitioRepository;

    public function __construct(SitioRepository $pnpSitioRepo)
    {
        $this->sitioRepository = $pnpSitioRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->sitioRepository->pushCriteria(new RequestCriteria($request));
        $sitios = $this->sitioRepository->all();

        return view('admin.sitios.index')
            ->with('sitios', $sitios);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.sitios.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateSitioRequest $request)
    {
        $input = $request->all();

        $sitios = $this->sitioRepository->create($input);

        Flash::success('sitios guardado correctamente.');

        return redirect(route('sitios.index'));
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
        $sitios = $this->sitioRepository->findWithoutFail($id);

        if (empty($sitios)) {
            Flash::error('Sitios no encontrado');

            return redirect(route('sitios.index'));
        }

        return view('admin.sitios.show')->with('sitios', $sitios);
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
        $sitios = $this->sitioRepository->findWithoutFail($id);

        if (empty($sitios)) {
            Flash::error('Sitios no encontrado');

            return redirect(route('sitios.index'));
        }

        return view('admin.sitios.edit')->with('sitios', $sitios);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSitioRequest $request)
    {
        $sitios = $this->sitioRepository->findWithoutFail($id);

        if (empty($sitios)) {
            Flash::error('Sitios no encontrado');

            return redirect(route('sitios.index'));
        }

        $sitios = $this->sitioRepository->update($request->all(), $id);

        Flash::success('Sitios actualizado satisfactoriamente.');

        return redirect(route('sitios.index'));
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
        $sitios = $this->sitioRepository->findWithoutFail($id);

        if (empty($sitios)) {
            Flash::error('Sitios no encontrado');

            return redirect(route('sitios.index'));
        }

        $this->sitioRepository->delete($id);

        Flash::success('Sitios eliminado.');

        return redirect(route('sitios.index'));
    }

    public function cargarSitio($id)
    {
        $model_categorias= new Sitio();
        $categoria = $model_categorias->getSitio($id);

        return $categoria;

    }    
}
