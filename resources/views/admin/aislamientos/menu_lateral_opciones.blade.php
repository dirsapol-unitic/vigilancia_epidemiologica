<div class="box box-widget widget-user">
  <div class="widget-user-header bg-aqua-active">
  </div>
  <div class="widget-user-image">
    <?php $ruta2='/images/anonimo.png';?>
    <img class="profile-user-img img-responsive img-circle" src="{!!url($ruta2)!!}" alt="User profile picture">
  </div>
  <br/><br/><br/>
  <h3 class="profile-username text-center">{{$paciente->paterno}} {{$paciente->materno}}</h3>
    <p class="text-muted text-center"><a href="{!! route('aislamientos.editar_paciente',[$id,$dni]) !!}">{{$paciente->nombres}}</a></p>
    <br/>
</div>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Datos Covid-19</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <ul class="list-group list-group-unbordered">
      <li class="list-group-item">
        <a href="{!! route('aislamientos.listar_fichas',[$id,$dni]) !!}"><b><i class="fa fa-book margin-r-5"></i>Fichas</b></a>
      </li>
      <li class="list-group-item">
        <a href="{!! route('aislamientos.editar_antecedentes_epidemiologico',[$ficha->id,$dni,$id]) !!}"><b><i class="fa fa-book margin-r-5"></i>Antecedentes</b></a>
      </li>
      @if($ficha->hospitalizado=='SI')
        @if($nro_hosp>0)
          <li class="list-group-item">
            <a href="{!! route('aislamientos.editar_hospitalizacion',[$id_hospitalizacion, $dni, $id,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Hospitalizacion</b></a>
          </li>
          <li class="list-group-item">
            <a href="{!! route('aislamientos.listar_evolucion',[$id,$dni,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Evolucion</b></a>
          </li>
        @else
          <li class="list-group-item">
            <a href="{!! route('aislamientos.create_hospitalizacion',[$dni, $id,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Hospitalizacion</b></a>
          </li>
        @endif
      @endif
      @if($existe_ficha_contacto=='SI')
        <li class="list-group-item">
          <a href="{!! route('aislamientos.listar_contacto',[$id,$dni,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Contacto</b></a>
        </li>
        <li class="list-group-item">
          <a href="{!! route('aislamientos.editar_laboratorio',[$id,$dni,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Examen de Apoyo al Diagnostico</b></a>
        </li>
      @else
        <li class="list-group-item">
          <a href="{!! route('aislamientos.editar_laboratorio',[$id,$dni,$idficha]) !!}"><b><i class="fa fa-book margin-r-5"></i> Examen de Apoyo al Diagnostico</b></a>
        </li>
      @endif
    </ul>  
  </div>
  <!-- /.box-body -->
</div>


    

