@extends('layouts.app')
@section('css')
    <style type="text/css">
        th, td { font-size: 10px;}
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }        

        .form-control {
            font-size: 10px;
        }
    </style>
@stop
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Establecimientos</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('establecimientos.create') !!}">Nuevo <i class="glyphicon glyphicon-file"></i></a>
        </h1>
        <br/><br/>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    @include('admin.establecimientos.table')
                </div>    
            </div>
        </div>
        <div class="text-center">
        
        </div>
        
    </div>
@endsection
@section('scripts')
<script>
  
  $(document).ready( function () {
  
  var table = $('#example').DataTable({
        "responsive": true,
        "order": [[ 1, "asc" ]],
    });

    $("#example thead th").each( function ( i ) {
        
        if ($(this).text() !== '') {
            var isStatusColumn = (($(this).text() == 'Status') ? true : false);
            var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(this).empty() )
                .on( 'change', function () {
                    var val = $(this).val();
                    
                    table.column( i )
                        .search( val ? '^'+$(this).val()+'$' : val, true, false )
                        .draw();
                } );
            
            // Get the Status values a specific way since the status is a anchor/image
            if (isStatusColumn) {
                var statusItems = [];
                
                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### */
                table.column( i ).nodes().to$().each( function(d, j){
                    var thisStatus = $(j).attr("data-filter");
                    if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
                } );
                
                statusItems.sort();
                                
                $.each( statusItems, function(i, item){
                    select.append( '<option value="'+item+'">'+item+'</option>' );
                });

            }
            // All other non-Status columns (like the example)
            else {
                table.column( i ).data().unique().sort().each( function ( d, j ) {  
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                } );    
            }
            
        }
    } );
} );
</script>
@stop