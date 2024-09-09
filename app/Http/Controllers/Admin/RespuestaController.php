<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateRespuestaRequest;
use App\Http\Requests\UpdateRespuestaRequest;
use App\Repositories\RespuestaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RespuestaController extends AppBaseController
{
    /** @var  ProvinciaRepository */
    private $respuestaRepository;

    public function __construct(RespuestaRepository $respuestaRepo)
    {
        $this->respuestaRepository = $respuestaRepo;
    }

    /**
     * Display a listing of the Provincia.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->respuestaRepository->pushCriteria(new RequestCriteria($request));
        $respuestas = $this->respuestaRepository->all();

        return view('admin.respuestas.index')
            ->with('respuestas', $Respuestas);
    }

    /**
     * Show the form for creating a new Provincia.
     *
     * @return Response
     */
    public function create()
    {
        $pregunta_id=Pregunta::pluck('descripcion','id');
        
        return view('admin.respuestas.create',compact(["pregunta_id"]));
    }

    /**
     * Store a newly created Provincia in storage.
     *
     * @param CreateProvinciaRequest $request
     *
     * @return Response
     */
    public function store(CreateRespuestaRequest $request)
    {
        $input = $request->all();

        $respuesta = $this->respuestaRepository->create($input);

        Flash::success('Respuesta guardado correctamente.');

        return redirect(route('respuestas.index'));
    }

    /**
     * Display the specified Provincia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $respuesta = $this->respuestaRepository->findWithoutFail($id);

        if (empty($respuesta)) {
            Flash::error('Respuesta no encontrado');

            return redirect(route('respuestas.index'));
        }

        return view('admin.respuestas.show')->with('respuesta', $respuesta);
    }

    /**
     * Show the form for editing the specified Provincia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $respuesta = $this->respuestaRepository->findWithoutFail($id);

        if (empty($respuesta)) {
            Flash::error('Respuesta no encontrado');

            return redirect(route('respuestas.index'));
        }

        return view('admin.respuestas.edit')->with('respuesta', $respuesta);
    }

    /**
     * Update the specified Provincia in storage.
     *
     * @param  int              $id
     * @param UpdateProvinciaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRespuestaRequest $request)
    {
        $respuesta = $this->respuestaRepository->findWithoutFail($id);

        if (empty($respuesta)) {
            Flash::error('Respuesta no encontrado');

            return redirect(route('respuestas.index'));
        }

        $respuesta = $this->respuestaRepository->update($request->all(), $id);

        Flash::success('Respuesta actualizado satisfactoriamente.');

        return redirect('/preguntas/rpta_new/'.$request->id_pregunta);

        //return redirect(route('respuestas.index'));
    }

    /**
     * Remove the specified Provincia from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $respuesta = $this->respuestaRepository->findWithoutFail($id);

        if (empty($respuesta)) {
            Flash::error('Respuesta no encontrado');

            return redirect(route('respuestas.index'));
        }

        $this->respuestaRepository->delete($id);

        Flash::success('Respuesta eliminado.');

        return redirect(route('respuestas.index'));
    }

}