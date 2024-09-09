@if (Auth::user()->rol==1)
<ul class="sidebar-menu">
    <li class="header">MENU</li>
    <li class="{{ Request::is('home*') ? 'active' : '' }}">
        <a href="{{ url('/home') }}">
            <i class="fa fa-fw fa-home "></i>
            <span><small>Inicio</small></span>
        </a>    
    </li> 
    <li class=" treeview 
        <?php if (Request::is('aislamientos*')){ echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-medkit"></i><span>Fichas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (Request::is('index*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.create') !!}"><i class="fa fa-fw fa-medkit"></i><span>Nueva Ficha</span></a>
            </li>
            <li class="{{ (Request::is('todos_registros*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros') !!}"><i class="fa fa-fw fa-medkit"></i><span>Todos los registros</span></a>
            </li>
            <li class="{{ (Request::is('todos_registros_hospitalizacion*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros_hospitalizacion') !!}"><i class="fa fa-fw fa-medkit"></i><span>Todos Hospitalizados</span></a>
            </li>
        </ul>
    </li>
    <li class=" treeview 
        <?php if (Request::is('pnpcategorias*')||Request::is('sintomas*') ||Request::is('signos*') ||Request::is('factorriesgos*')||Request::is('ocupaciones*')||Request::is('lugares*')||Request::is('informeriesgos*')){ echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-medkit"></i><span>Mantenimiento</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
                <li class="{{ Request::is('establecimientosaluds*') ? 'active' : '' }}">
                <a href="{!! route('establecimientosaluds.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Establecimiento Salud</small></span>
                </a>    
                </li> 
                <li class="{{ Request::is('pnpcategorias*') ? 'active' : '' }}">
                <a href="{!! route('pnpcategorias.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Categorias PNP</small></span>
                </a>    
                </li> 
                <li class="{{ Request::is('sintomas*') ? 'active' : '' }}">
                <a href="{!! route('sintomas.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Sintomas</small></span>
                </a>    
                </li>  
                <li class="{{ Request::is('signo*') ? 'active' : '' }}">
                <a href="{!! route('signos.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Signos</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('factorriesgos*') ? 'active' : '' }}">
                <a href="{!! route('factorriesgos.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Factor de Riesgo</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('ocupaciones*') ? 'active' : '' }}">
                <a href="{!! route('ocupaciones.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Ocupaciones</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('lugares*') ? 'active' : '' }}">
                <a href="{!! route('lugares.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Lugares</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('informeriesgos*') ? 'active' : '' }}">
                <a href="{!! route('informeriesgos.index') !!}">
                    <i class="fa fa-fw fa-h-square"></i>
                    <span><small>Informe de Riesgo</small></span>
                </a>    
                </li>
        </ul>
    </li>
    <!--li class="treeview
        <?php if ( Request::is('e*') ||  Request::is('v*') ||  Request::is('nivels*') || Request::is('categorias*') || Request::is('reclamaciones*') || Request::is('tipoInternamientos*')  ) { echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-medkit"></i><span>Solucionadas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (Request::is('expedientes_solucionados*') || Request::is('l*') || Request::is('ver_reclamacion_atendida*') ) ? 'active' : '' }}">
                <a href="{!! route('soluciones.expedientes_solucionados') !!}"><i class="fa fa-fw fa-medkit"></i><span>Todas las soluciones</span></a>
            <?php 
                $factor= DB::table('sintomas')->get();
                $cont=count($factor);
                for($i=0;$i<$cont;$i++){ ?>
                    <li class="{{ (Request::is('todos_registros*') || Request::is('l*') || Request::is('ver_reclamacion_atendida*') ) ? 'active' : '' }}">
                        <a href="{!! route('soluciones.expedientes_solucionados',[$i+1]) !!}"><i class="fa fa-fw fa-medkit"></i><span class="small"><?php echo $factor->get($i)->descripcion; ?></span></a>
                    </li>                
            <?php
                }
            ?>
            </li>
        </ul-->
           
        <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}">
            <i class="fa fa-fw fa-user"></i>
            <span><small>Usuarios</small></span>
        </a>
        </li>  
        
    </li>
    
</ul>   
@else
<ul class="sidebar-menu">    
    <li class="header">MENU</li>
    <li class="{{ Request::is('home*') ? 'active' : '' }}">
        <a href="{{ url('/home') }}">
            <i class="fa fa-fw fa-home "></i>
            <span><small>Inicio</small></span>
        </a>    
    </li> 
    
        
    
    
    <?php 
        $x=Auth::user()->factor_id; $y=0;
        $factor= DB::table('sintomas')->get();
        $cont=count($factor);
        for($i=0;$i<$cont;$i++){ 
            $y=$i+1;
            if($y==$x){ ?>
                <li class="{{ (Request::is('todos_registros*') || Request::is('l*') || Request::is('ver_reclamacion_atendida*') ) ? 'active' : '' }}">            
                    <a href="{!! route('aislamientos.todos_registros',[$i+1]) !!}"><i class="fa fa-fw fa-medkit"></i><span class="small"><span class="small"><?php echo $factor->get($i)->descripcion; ?></span></a>
                </li>
                <li class="{{ (Request::is('reclamaciones_solucionadas*')|| Request::is('s*')) ? 'active' : '' }}">
                    <a href="{!! route('soluciones.expedientes_solucionados',[$i+1]) !!}"><i class="fa fa-handshake-o"></i><span>Solucionadas</span></a>
                </li>
    <?php
        }}
    ?>
    
</ul>   

@endif





