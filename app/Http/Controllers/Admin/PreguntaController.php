<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePreguntaRequest;
use App\Http\Requests\UpdatePreguntaRequest;
use App\Repositories\PreguntaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PreguntaController extends AppBaseController
{
    private $preguntaRepository;

    public function __construct(PreguntaRepository $preguntaRepo)
    {
        $this->preguntaRepository = $preguntaRepo;
    }

    /**
     * Display a listing of the Departamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->preguntaRepository->pushCriteria(new RequestCriteria($request));
        $preguntas = $this->preguntaRepository->all();

        return view('admin.preguntas.index')
            ->with('preguntas', $preguntas);
    }

    /**
     * Show the form for creating a new Departamento.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.preguntas.create');
    }

    public function create_rpta($id_pregunta)
    {
        $contar = 0;
        $respuestas = Respuesta::Where('pregunta_id',$id_pregunta)->get();

        if(is_object($respuestas))
            $contar = 1; 
        
        $pregunta = $this->preguntaRepository->findWithoutFail($id_pregunta);
        
        return view('admin.preguntas.create_rpta')->with('id_pregunta', $id_pregunta)->with('pregunta', $pregunta)->with('respuestas', $respuestas)->with('contar', $contar);
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param CreateDepartamentoRequest $request
     *
     * @return Response
     */
    public function store(CreatePreguntaRequest $request)
    {
        $input = $request->all();

        $pregunta = $this->preguntaRepository->create($input);

        Flash::success('Pregunta guardado correctamente.');

        return redirect(route('preguntas.index'));
    }

    public function store_rpta(Request $request)
    {
        $rpta = new Respuesta();

        $rpta->descripcion = $request->respuesta;
        $rpta->pregunta_id = $request->id_pregunta;

        $rpta-> save();

        Flash::success('Respuesta guardado correctamente.');

        return redirect('/preguntas/rpta_new/'.$request->id_pregunta);
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
        $pregunta = $this->preguntaRepository->findWithoutFail($id);

        if (empty($pregunta)) {
            Flash::error('Pregunta no encontrado');

            return redirect(route('preguntas.index'));
        }

        return view('admin.preguntas.show')->with('pregunta', $pregunta);
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
        $pregunta = $this->preguntaRepository->findWithoutFail($id);

        if (empty($pregunta)) {
            Flash::error('Pregunta no encontrado');

            return redirect(route('preguntas.index'));
        }

        return view('admin.preguntas.edit')->with('pregunta', $pregunta);
    }

    public function edit_rpta($id)
    {
        $pregunta = $this->preguntaRepository->findWithoutFail($id);

        if (empty($pregunta)) {
            Flash::error('Pregunta no encontrado');

            return redirect(route('preguntas.index'));
        }

        return view('admin.preguntas.edit')->with('pregunta', $pregunta);
    }

    /**
     * Update the specified Departamento in storage.
     *
     * @param  int              $id
     * @param UpdateDepartamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePreguntaRequest $request)
    {
        $pregunta = $this->preguntaRepository->findWithoutFail($id);

        if (empty($pregunta)) {
            Flash::error('Pregunta no encontrado');

            return redirect(route('preguntas.index'));
        }

        $pregunta = $this->preguntaRepository->update($request->all(), $id);

        Flash::success('Pregunta actualizado satisfactoriamente.');

        return redirect(route('preguntas.index'));
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
        $pregunta = $this->preguntaRepository->findWithoutFail($id);

        if (empty($pregunta)) {
            Flash::error('Pregunta no encontrado');

            return redirect(route('preguntas.index'));
        }

        $this->preguntaRepository->delete($id);

        Flash::success('Pregunta eliminado.');

        return redirect(route('preguntas.index'));
    }

    public function cargarrespuestas($id)
    {
        $model_respuesta= new Respuesta();
        $rpta = $model_respuesta->getRespuesta($id);

        return $rpta;

    }    
}
