@extends('layouts.master_ficha')
@section('content')
<div class="content">
    <div class="row">
    <div class="col-md-2">
      <div class="box box-warning">
        <div class="box-body box-profile">     

          <img class="profile-user-img img-responsive img-circle" src="data:image/png;base64,{{$foto}}" alt="User profile picture">
          <h3 class="profile-username text-center">{{$paciente->paterno}} {{$paciente->materno}}</h3>
          <p class="text-muted text-center">{{$paciente->nombres}}</p>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Caso: </b>
              <?php  
                  switch($paciente->id_clasificacion){
                    case '1': $clasificacion="Confirmado"; $color="#FF0000";break;
                    case '2': $clasificacion="Probable"; $color="#00FF00"; break;
                    case '3': $clasificacion="Sospechoso"; $color="#0000FF";break;
                  }
              ?><span style="color:<?php echo $color?>"><b><?php echo $clasificacion;?></b></span>
            </li>
            <li class="list-group-item">
              <b>Fecha registro: </b> {{$paciente->fecha_registro}}
            </li>
            <li class="list-group-item">
              <b>Parentesco: </b> {{$paciente->parentesco}}
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <!-- About Me Box -->
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Resumen</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <a href="{!! route('aislamientos.editar_paciente',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Datos del Paciente</strong></a>
          <hr>
          <a href="{!! route('aislamientos.listar_antecedentes',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Antecedentes Epidemiologico</strong></a>
          <hr>
          <a href="{!! route('aislamientos.editar_hospitalizacion',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Hospitalizacion</strong></a>
          <hr>
          <a href="{!! route('aislamientos.editar_evolucion',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Evolucion</strong></a>
          <hr>
          <a href="{!! route('aislamientos.editar_laboratorio',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Laboratorio</strong></a>
          <hr>
          <a href="{!! route('aislamientos.editar_contacto',[$id,$dni]) !!}"><strong><i class="fa fa-book margin-r-5"></i> Contacto</strong></a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-10">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#contacto" data-toggle="tab">Contacto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="contacto">
              {!! Form::open(['id'=>'frm_aislamientos','name'=>'frm_aislamientos','route' => 'aislamientos.store_contacto']) !!}
                @include('admin.aislamientos.contacto')
              {!! Form::close() !!}
            </div>
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection

