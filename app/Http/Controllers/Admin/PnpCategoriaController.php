<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePnpCategoriaRequest;
use App\Http\Requests\UpdatePnpCategoriaRequest;
use App\Repositories\PnpCategoriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\PnpCategoria;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PnpCategoriaController extends AppBaseController
{
    /** @var  pnpcategoriaRepository */
    private $pnpcategoriaRepository;

    public function __construct(PnpCategoriaRepository $pnpCategoriaRepo)
    {
        $this->pnpcategoriaRepository = $pnpCategoriaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pnpcategoriaRepository->pushCriteria(new RequestCriteria($request));
        $pnpcategorias = $this->pnpcategoriaRepository->all();

        return view('admin.pnp_categorias.index')
            ->with('pnpcategorias', $pnpcategorias);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.pnp_categorias.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreatePnpCategoriaRequest $request)
    {
        $input = $request->all();

        $pnpcategoria = $this->pnpcategoriaRepository->create($input);

        Flash::success('Categoria de la PNP guardado correctamente.');

        return redirect(route('pnpcategorias.index'));
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
        $pnpcategorias = $this->pnpcategoriaRepository->findWithoutFail($id);

        if (empty($pnpcategorias)) {
            Flash::error('Categoria PNP no encontrado');

            return redirect(route('departamentos.index'));
        }

        return view('admin.pnp_categorias.show')->with('pnpcategorias', $pnpcategorias);
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
        $pnpcategorias = $this->pnpcategoriaRepository->findWithoutFail($id);

        if (empty($pnpcategorias)) {
            Flash::error('Categoria PNP no encontrado');

            return redirect(route('pnpcategorias.index'));
        }

        return view('admin.pnp_categorias.edit')->with('pnpcategorias', $pnpcategorias);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePnpCategoriaRequest $request)
    {
        $pnpcategorias = $this->pnpcategoriaRepository->findWithoutFail($id);

        if (empty($pnpcategorias)) {
            Flash::error('Categoria PNP no encontrado');

            return redirect(route('pnpcategorias.index'));
        }

        $pnpcategorias = $this->pnpcategoriaRepository->update($request->all(), $id);

        Flash::success('Categoria PNP actualizado satisfactoriamente.');

        return redirect(route('pnpcategorias.index'));
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
        $pnpcategorias = $this->pnpcategoriaRepository->findWithoutFail($id);

        if (empty($pnpcategorias)) {
            Flash::error('Categoria PNP no encontrado');

            return redirect(route('pnpcategorias.index'));
        }

        $this->pnpcategoriaRepository->delete($id);

        Flash::success('Categoria PNP eliminado.');

        return redirect(route('pnpcategorias.index'));
    }

    public function cargarCategorias($id)
    {
        $model_categorias= new PnpCategoria();
        $categoria = $model_categorias->getPnpCategoria($id);

        return $categoria;

    }    
}
