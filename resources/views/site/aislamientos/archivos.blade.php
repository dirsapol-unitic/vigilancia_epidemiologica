@extends('layouts.template')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{!!$dni!!}-{!!$nombre!!}</h1>
        <br/><br/>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            @include('site.aislamientos.table_archivos')
        <div class="text-center">
        
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).on('change','input[type="file"]',function(){
    // this.files[0].size recupera el tamaño del archivo
    // alert(this.files[0].size);
    
    var fileName = this.files[0].name;
    var fileSize = this.files[0].size;

    if(fileSize > 5000000){
        alert('El archivo no debe superar los 5MB');
        this.value = '';
        this.files[0].name = '';
    }else{
        // recuperamos la extensión del archivo
        var ext = fileName.split('.').pop();

        // console.log(ext);
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'pdf': break;
            default:
                alert('El archivo no tiene la extensión adecuada');
                this.value = ''; // reset del valor
                this.files[0].name = '';
        }
    }
});
</script>
@stop