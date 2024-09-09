<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSignoRequest;
use App\Http\Requests\UpdateSignoRequest;
use App\Repositories\SignoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Signo;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SignoController extends AppBaseController
{
    /** @var  SignoRepository */
    private $SignoRepository;

    public function __construct(SignoRepository $pnpSignoRepo)
    {
        $this->SignoRepository = $pnpSignoRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->SignoRepository->pushCriteria(new RequestCriteria($request));
        $signos = $this->SignoRepository->all();

        return view('admin.signos.index')
            ->with('signos', $signos);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.signos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateSignoRequest $request)
    {
        $input = $request->all();

        $signo = $this->SignoRepository->create($input);

        Flash::success('signos guardado correctamente.');

        return redirect(route('signos.index'));
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
        $signos = $this->SignoRepository->findWithoutFail($id);

        if (empty($signos)) {
            Flash::error('Signos no encontrado');

            return redirect(route('signos.index'));
        }

        return view('admin.signos.show')->with('signos', $signos);
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
        $signos = $this->SignoRepository->findWithoutFail($id);

        if (empty($signos)) {
            Flash::error('Signos no encontrado');

            return redirect(route('signos.index'));
        }

        return view('admin.signos.edit')->with('signos', $signos);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSignoRequest $request)
    {
        $signos = $this->SignoRepository->findWithoutFail($id);

        if (empty($signos)) {
            Flash::error('Signo no encontrado');

            return redirect(route('signos.index'));
        }

        $signos = $this->SignoRepository->update($request->all(), $id);

        Flash::success('Signo actualizado satisfactoriamente.');

        return redirect(route('signos.index'));
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
        $signos = $this->SignoRepository->findWithoutFail($id);

        if (empty($signos)) {
            Flash::error('signos no encontrado');

            return redirect(route('signos.index'));
        }

        $this->SignoRepository->delete($id);

        Flash::success('signos eliminado.');

        return redirect(route('signos.index'));
    }

    public function cargarSigno($id)
    {
        $model_categorias= new Signo();
        $categoria = $model_categorias->getSigno($id);

        return $categoria;

    }    
}
