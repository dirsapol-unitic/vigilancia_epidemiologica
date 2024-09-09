<div class="panel panel-primary filterable" >
                    <div class="panel-heading">
                        <h3 class="panel-title">LIBRO DE RECLAMACIONES </h3>
                    </div>  
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label>Trato Directo</label> 
            </div>
            <div class="col-md-2">
                {{$soluciones[0]->trato_directo}}                                
            </div>
            <div class="col-md-4">
                <label>Numero de Documento :</label> 
            </div>
            <div class="col-md-3">
                {{$soluciones[0]->nro_doc_solucion}} 
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Fecha de Solucion</label>
            </div>
            <div class="col-md-2">
                {{$soluciones[0]->fecha_solucion}} 
            </div>
            <div class="col-md-4">
                <label>Numero de Notificacion</label>
            </div>
            <div class="col-md-3">
                {{$soluciones[0]->nro_notificacion}} 
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Estado de Solucion</label>
            </div>
            <div class="col-md-2">
                <?php 
                    switch($soluciones[0]->estado_reclamo){
                        case 3: echo "En tramite"; break;
                        case 4: echo "Anulado"; break;
                        case 5: echo "Traslado a entidad competente"; break;
                        case 6: echo "Resuelto"; break;
                    }
                ?>
            </div>
            <div class="col-md-4">
                <label>Resultado de Solucion</label>
            </div>
            <div class="col-md-3">
                <?php 

                    switch($soluciones[0]->resultado_reclamo){
                        case 1: echo "Fundado"; break;
                        case 2: echo "Infundado"; break;
                        case 3: echo "Concluido Anticipado"; break;
                        case 4: echo "Improcedente"; break;
                    }

                ?>                
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <label>Solucion</label>
            </div>
            <div class="col-md-12">                
                {{$soluciones[0]->solucion_rpta}} 
                <br/>
            </div>
        </div>
    </div>
</div>
</div>
<a target="_blank" href="/descargar_solucion_pdf/{{$soluciones[0]->id}}" class="btn btn-primary">Imprimir</a>
