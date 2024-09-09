@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            Establecimientos
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['id'=>'frm_establecimiento','name'=>'frm_establecimiento','route' => 'establecimientos.store']) !!}

                        @include('admin.establecimientos.fields')

                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">  
    $cmbid_departamento = $("#frm_establecimiento").find("#departamento");
    $cmbid_provincia = $("#frm_establecimiento").find("#provincia");
    $cmbid_distrito = $("#frm_establecimiento").find("#distrito");
    

    $cmbid_departamento.change(function () {
            
        $this = $(this); 
        cmbid_departamento = $cmbid_departamento.val();

        $cmbid_provincia.html('');
            option = {
                url: '/cargarprovincias/' + cmbid_departamento,
                type: 'GET',
                dataType: 'json',
                data: {}
            };
            $.ajax(option).done(function (data) {  
                cargarComboDestino($cmbid_provincia, data);
                $cmbid_provincia.val(null).trigger("change");                                           
            });
    });        
    $cmbid_provincia.change(function () {
            
        $this = $(this); 
        cmbid_provincia = $cmbid_provincia.val();
        cmbid_departamento = $cmbid_departamento.val();

        $cmbid_distrito.html('');
            option = {
                url: '/cargardistrito/'+ cmbid_departamento + '/' + cmbid_provincia,
                type: 'GET',
                dataType: 'json',
                data: {}
            };
            $.ajax(option).done(function (data) {  
                cargarComboDestino($cmbid_distrito, data);
                $cmbid_distrito.val(null).trigger("change");                                           
            });
    });

    
    function cargarComboDestino($select, data) {
        $select.html('');
        $(data).each(function (ii, oo) {
            $select.append('<option value="' + oo.id + '">' + oo.nombre + '</option>')
        });
    }   
</script>
@stop

