<div class="box box-success">
  <div class="box-body">
    <p>
      <a href="{!! route('esavis.editar_esavis', [$id_esavi,$dni, $id]) !!}" class="btn bg-olive btn-flat margin" role="button" aria-pressed="true">Editar ESAVI</a>
      <a href="{!! route('esavis.editar_vacunacion', [$id_esavi,$dni, $id]) !!}" class="btn btn-danger btn-flat margin" role="button" aria-pressed="true">Vacunacion</a>
      <a href="{!! route('esavis.create_antecedente', [$id_esavi,$dni, $id]) !!}" class="btn bg-orange btn-flat margin" role="button" aria-pressed="true">Antecedentes</a>
      <a href="{!! route('esavis.create_signo_sintomas', [$id_esavi,$dni, $id]) !!}" class="btn bg-navy btn-flat margin" role="button" aria-pressed="true">Signo/Sintomas</a>
      <a href="{!! route('esavis.create_hospitalizado_esavi', [$id_esavi,$dni, $id]) !!}" class="btn bg-primary btn-flat margin" role="button" aria-pressed="true">Hospitalizacion</a>
      <a href="{!! route('esavis.create_cuadro_clinicos', [$id_esavi,$dni, $id]) !!}" class="btn bg-maroon btn-flat margin" role="button" aria-pressed="true">Cuadro Clinico</a>
      <a href="{!! route('esavis.create_seguimiento_esavi', [$id_esavi,$dni, $id]) !!}" class="btn bg-purple btn-flat margin" role="button" aria-pressed="true">Seguimiento</a>
    </p>  
  </div>
</div>