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
    </ul>  
  </div>
</div>


    

