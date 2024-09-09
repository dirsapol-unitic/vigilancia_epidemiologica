<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateResultadoRequest;
use App\Http\Requests\UpdateResultadoRequest;
use App\Repositories\ResultadoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Prueba;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ResultadoController extends AppBaseController
{
    /** @var  factorriesgoRepository */
    private $resultadoRepository;

    public function __construct(ResultadoRepository $pnpResultadoRepo)
    {
        $this->resultadoRepository = $pnpResultadoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->resultadoRepository->pushCriteria(new RequestCriteria($request));
        $resultados = $this->resultadoRepository->all();

        return view('admin.resultados.index')
            ->with('resultados', $resultados);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        $prueba_id=Prueba::pluck('descripcion','id');
        
        return view('admin.resultados.create',compact(["prueba_id"]));
        
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateResultadoRequest $request)
    {
        $input = $request->all();

        $resultados = $this->resultadoRepository->create($input);

        Flash::success('Resultados guardado correctamente.');

        return redirect(route('resultados.index'));
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
        $resultados = $this->resultadoRepository->findWithoutFail($id);

        if (empty($resultados)) {
            Flash::error('Resultado no encontrado');

            return redirect(route('resultados.index'));
        }

        return view('admin.resultados.show')->with('resultados', $resultados);
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
        $resultados = $this->resultadoRepository->findWithoutFail($id);

        if (empty($resultados)) {
            Flash::error('Resultado no encontrado');

            return redirect(route('resultados.index'));
        }

        $prueba_id=Prueba::pluck('descripcion','id');

        return view('admin.resultados.edit')->with('resultados', $resultados)->with('prueba_id', $prueba_id);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResultadoRequest $request)
    {
        $resultados = $this->resultadoRepository->findWithoutFail($id);

        if (empty($resultados)) {
            Flash::error('Resultado no encontrado');

            return redirect(route('resultados.index'));
        }

        $resultados = $this->resultadoRepository->update($request->all(), $id);

        Flash::success('Resultado actualizado satisfactoriamente.');

        return redirect(route('resultados.index'));
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
        $resultados = $this->resultadoRepository->findWithoutFail($id);

        if (empty($resultados)) {
            Flash::error('Resultado no encontrado');

            return redirect(route('resultados.index'));
        }

        $this->resultadoRepository->delete($id);

        Flash::success('Resultado eliminado.');

        return redirect(route('resultados.index'));
    }

    public function cargarResultados($id)
    {
        $model_categorias= new Resultado();
        $categoria = $model_categorias->getResultado($id);

        return $categoria;

    }    
}
