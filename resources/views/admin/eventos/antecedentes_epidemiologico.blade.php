@extends('layouts.master_ficha')
@section('content')
<div class="content">
    <div class="row">
    <div class="col-md-2">
      <div class="box box-primary">
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
                    default : $clasificacion="Sin registro"; $color="#000000";break;
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
      <div class="box box-primary">
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
          <li class="active"><a href="#antecedentes" data-toggle="tab">Antecedentes Epidemiologica</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="antecedentes">
                <div class="box-header">
                  <a class="btn btn-app pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('aislamientos.create_antecedente',[$id, $dni]) !!}"><i class="glyphicon glyphicon-file"></i>Nuevo </a>
                </div>
              <div class="content">
                  <div class="clearfix"></div>
                  @include('flash::message')        
                  <div class="clearfix"></div>
                  <div class="box box-primary">
                      <div class="box-body">
                        @include('admin.aislamientos.table_antecedentes_epidemiologico')
                      </div>
                  </div>
                  <div class="text-center">
                  </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

