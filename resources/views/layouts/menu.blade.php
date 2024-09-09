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
            <i class="fa fa-fw fa-list-alt"></i><span>Fichas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (Request::is('bu*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.buscar_paciente') !!}"><i class="fa fa-fw fa-edit"></i><span>Nueva Ficha</span></a>
            </li>
            <li class="{{ (Request::is('todos_registros*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros') !!}"><i class="fa fa-fw fa-list"></i><span>Todos los registros</span></a>
            </li>
            <li class="{{ (Request::is('todos_registros_hospitalizacion*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros_hospitalizacion') !!}"><i class="fa fa-fw  fa-h-square"></i><span>Todos Hospitalizados</span></a>
            </li>
        </ul>
    </li>
    <li class=" treeview 
        <?php if (Request::is('reportes*') ||Request::is('reporte_departamentos*') ||Request::is('reporte_departamento_hospitalizados*') ||Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ||Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ||Request::is('reporte_departamento_hospitalizado_familiares*')||Request::is('reporte_fallecido_departamentos*')){ echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-list-alt"></i><span>Reportes</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (Request::is('reportes*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_general') !!}"><i class="fa fa-fw fa-list"></i><span>Reporte</span></a>
            </li>
            <li class="{{ (Request::is('reporte_departamentos*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Aislados por Departamentos</span></a>
            </li>
            <li class="{{ (Request::is('reporte_pruebas_covid*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_pruebas_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Pruebas Covid por Departamentos</span></a>
            </li>
            <li class="{{ (Request::is('reporte_casos_covid*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_casos_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Covid por Departamentos</span></a>
            </li>
            <li class="{{ (Request::is('reporte_positivos*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_positivos') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Positivos</span></a>
            </li>
            <li class="{{ (Request::is('reporte_departamento_hospitalizados*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_departamento_hospitalizados') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado por Departamentos</span></a>
            </li>
            <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_actividad') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Actividad</span></a>
            </li>
            <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_retiro') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Retiro</span></a>
            </li>
            <li class="{{ (Request::is('reporte_departamento_hospitalizado_familiares*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_familiares') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado Familiares</span></a>
            </li>
            <li class="{{ (Request::is('reporte_fallecido_departamentos*') ) ? 'active' : '' }}">
                <a href="{!! route('aislamientos.reporte_fallecido_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Fallecidos</span></a>
            </li>
        </ul>
    </li>
    <li class=" treeview 
        <?php if (Request::is('establecimientosaluds*')||Request::is('pnpcategorias*')||Request::is('sintomas*') ||Request::is('signos*') ||Request::is('factorriesgos*')||Request::is('ocupaciones*')||Request::is('lugares*')||Request::is('informeriesgos*')||Request::is('cuadropatologico*')||Request::is('enfermedadregione*')||Request::is('seguimiento*')||Request::is('clasificacion*')||Request::is('pregunta*')||Request::is('muestra*')||Request::is('prueba*')||Request::is('resultado*')){ echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-cog"></i><span>Mantenimiento</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
                <li class="{{ Request::is('establecimientosaluds*') ? 'active' : '' }}">
                <a href="{!! route('establecimientosaluds.index') !!}">
                    <i class="fa fa-fw fa-hospital-o"></i>
                    <span><small>Establecimiento Salud</small></span>
                </a>    
                </li> 
                <li class="{{ Request::is('pnpcategorias*') ? 'active' : '' }}">
                <a href="{!! route('pnpcategorias.index') !!}">
                    <i class="fa fa-fw fa-user"></i>
                    <span><small>Categorias PNP</small></span>
                </a>    
                </li> 
                <li class="{{ Request::is('sintomas*') ? 'active' : '' }}">
                <a href="{!! route('sintomas.index') !!}">
                    <i class="fa fa-fw fa-frown-o"></i>
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
                    <i class="fa fa-fw fa-heartbeat"></i>
                    <span><small>Factor de Riesgo</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('cuadropatologico*') ? 'active' : '' }}">
                    <a href="{!! route('cuadropatologicos.index') !!}">
                        <i class="fa fa-fw fa-book"></i>
                        <span><small>Cuadro Patologicos</small></span>
                    </a>
                </li>
                <li class="{{ Request::is('enfermedad*') ? 'active' : '' }}">
                    <a href="{!! route('enfermedadregiones.index') !!}">
                        <i class="fa fa-fw fa-bed"></i>
                        <span><small>Enfermedad Regiones</small></span>
                    </a>
                </li>
                <li class="{{ Request::is('ocupaciones*') ? 'active' : '' }}">
                <a href="{!! route('ocupaciones.index') !!}">
                    <i class="fa fa-fw fa-mortar-board"></i>
                    <span><small>Ocupaciones</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('lugares*') ? 'active' : '' }}">
                <a href="{!! route('lugares.index') !!}">
                    <i class="fa fa-fw fa-building"></i>
                    <span><small>Lugares</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('clasificacion*') ? 'active' : '' }}">
                <a href="{!! route('clasificaciones.index') !!}">
                    <i class="fa fa-fw fa-list-ul"></i>
                    <span><small>Clasificaciones</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('seguimientos*') ? 'active' : '' }}">
                <a href="{!! route('seguimientos.index') !!}">
                    <i class="fa fa-fw fa-location-arrow"></i>
                    <span><small>Seguimientos</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('pregunta*') ? 'active' : '' }}">
                <a href="{!! route('preguntas.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Preguntas</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('muestra*') ? 'active' : '' }}">
                <a href="{!! route('muestras.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Muestras</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('prueba*') ? 'active' : '' }}">
                <a href="{!! route('pruebas.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Pruebas</small></span>
                </a>    
                </li>
                <li class="{{ Request::is('resultado*') ? 'active' : '' }}">
                <a href="{!! route('resultados.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Resultados</small></span>
                </a>    
                </li>
        </ul>
    </li>
    <li class=" treeview 
        <?php if (Request::is('dosi*')||Request::is('via*')||Request::is('fabricante*')||Request::is('vacuna*')||Request::is('sitio*')){ echo 'active'; } else { echo ''; }
        ?>
        ">
        <a href="#">
            <i class="fa fa-fw fa-cog"></i><span>Esavi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('dosi*') ? 'active' : '' }}">
                <a href="{!! route('dosis.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Dosis</small></span>
                </a>    
            </li>
            <li class="{{ Request::is('fabricante*') ? 'active' : '' }}">
                <a href="{!! route('fabricantes.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Fabricante</small></span>
                </a>
            </li>
            <li class="{{ Request::is('sitio*') ? 'active' : '' }}">
                <a href="{!! route('sitios.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Sitios</small></span>
                </a>
            </li>
            <li class="{{ Request::is('vacuna*') ? 'active' : '' }}">
                <a href="{!! route('vacunas.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Vacunas</small></span>
                </a>
            </li>
            <li class="{{ Request::is('via*') ? 'active' : '' }}">
                <a href="{!! route('vias.index') !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Vias</small></span>
                </a>
            </li>
        </ul>
    </li>       
    <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}">
            <i class="fa fa-fw fa-group"></i>
            <span><small>Usuarios</small></span>
        </a>
    </li>  
    <li class=" treeview 
        <?php if (Request::is('manual*')){ echo 'active'; } else { echo ''; } ?> ">
        <a href="#">
            <i class="fa fa-fw fa-cog"></i><span>Manual</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('manual*') ? 'active' : '' }}">
                <a href="{!! route('users.manual',1) !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Registros</small></span>
                </a>    
            </li>
            <li class="{{ Request::is('manual*') ? 'active' : '' }}">
                <a href="{!! route('users.manual',2) !!}">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span><small>Usuarios</small></span>
                </a>
            </li>
        </ul>
    </li>     
</ul>
@else
    @if (Auth::user()->rol==2)
        <ul class="sidebar-menu">    
            <li class="header">MENU</li>
            <li class="{{ Request::is('home*') ? 'active' : '' }}">
                <a href="{{ url('/home') }}">
                    <i class="fa fa-fw fa-home "></i>
                    <span><small>Inicio</small></span>
                </a>    
            </li>
            <li class="{{ Request::is('bu*') ? 'active' : '' }}">
                <a href="{!! route('aislamientos.buscar_paciente') !!}">
                    <i class="fa fa-fw fa-edit "></i>
                    <span><small>Registrar Fichas</small></span>
                </a>    
            </li>
            <li class="{{ Request::is('todos_registros*') ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros') !!}">
                    <i class="fa fa-fw fa-list "></i>
                    <span><small>Todos los registros</small></span>
                </a>    
            </li>
            <li class="{{ Request::is('todos_registros_hospitalizacion*') ? 'active' : '' }}">
                <a href="{!! route('aislamientos.todos_registros_hospitalizacion') !!}">
                    <i class="fa fa-fw fa-bed "></i>
                    <span><small>Todos Hospitalizados</small></span>
                </a>    
            </li>
            <li class=" treeview 
            <?php if (Request::is('reportes*') ||Request::is('reporte_departamentos*') ||Request::is('reporte_departamento_hospitalizados*') ||Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ||Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ||Request::is('reporte_departamento_hospitalizado_familiares*')||Request::is('reporte_fallecido_departamentos*')){ echo 'active'; } else { echo ''; }
            ?>
            ">
            <a href="#">
                <i class="fa fa-fw fa-list-alt"></i><span>Reportes</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ (Request::is('reportes*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_general') !!}"><i class="fa fa-fw fa-list"></i><span>Reporte</span></a>
                </li>
                <li class="{{ (Request::is('reporte_departamentos*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Aislados</span></a>
                </li>
                <li class="{{ (Request::is('reporte_pruebas_covid*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_pruebas_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Pruebas Covid</span></a>
                </li>
                <li class="{{ (Request::is('reporte_casos_covid*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_casos_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Covid</span></a>
                </li>
                <li class="{{ (Request::is('reporte_positivos*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_positivos') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Positivos</span></a>
                </li>
                <li class="{{ (Request::is('reporte_departamento_hospitalizados*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_departamento_hospitalizados') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado</span></a>
                </li>
                <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_actividad') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Actividad</span></a>
                </li>
                <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_retiro') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Retiro</span></a>
                </li>
                <li class="{{ (Request::is('reporte_departamento_hospitalizado_familiares*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_familiares') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado Familiares</span></a>
                </li>
                <li class="{{ (Request::is('reporte_fallecido_departamentos*') ) ? 'active' : '' }}">
                    <a href="{!! route('aislamientos.reporte_fallecido_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Fallecidos</span></a>
                </li>
            </ul>
            <li class="{{ Request::is('manual*') ? 'active' : '' }}">
                <a href="{!! route('users.manual',1) !!}">
                    <i class="fa fa-fw fa-book"></i>
                    <span><small>Manual</small></span>
                </a>    
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
            <li class=" treeview 
                <?php if (Request::is('reportes*') ||Request::is('reporte_departamentos*') ||Request::is('reporte_departamento_hospitalizados*') ||Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ||Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ||Request::is('reporte_departamento_hospitalizado_familiares*')||Request::is('reporte_fallecido_departamentos*')){ echo 'active'; } else { echo ''; }
                ?>
                ">
                <a href="#">
                    <i class="fa fa-fw fa-list-alt"></i><span>Reportes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ (Request::is('reporte_todos_registros*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_todos_registros') !!}"><i class="fa fa-fw fa-list"></i><span>Todos los registros</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_todos_registros_hospitalizacion*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_todos_registros_hospitalizacion') !!}"><i class="fa fa-fw  fa-h-square"></i><span>Todos Hospitalizados</span></a>
                    </li>
                    <li class="{{ (Request::is('reportes*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_general') !!}"><i class="fa fa-fw fa-list"></i><span>Reporte</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_departamentos*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Aislados por Departamentos</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_pruebas_covid*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_pruebas_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Pruebas Covid por Departamentos</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_casos_covid*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_casos_covid') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Covid por Departamentos</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_positivos*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_positivos') !!}"><i class="fa fa-fw fa-list"></i><span>Casos Positivos</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_departamento_hospitalizados*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_departamento_hospitalizados') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado por Departamentos</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_actividad*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_actividad') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Actividad</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_departamento_hospitalizado_titulares_retiro*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_titulares_retiro') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado en Retiro</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_departamento_hospitalizado_familiares*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_departamento_hospitalizado_familiares') !!}"><i class="fa fa-fw fa-list"></i><span>Hospitalizado Familiares</span></a>
                    </li>
                    <li class="{{ (Request::is('reporte_fallecido_departamentos*') ) ? 'active' : '' }}">
                        <a href="{!! route('aislamientos.reporte_fallecido_departamentos') !!}"><i class="fa fa-fw fa-list"></i><span>Fallecidos</span></a>
                    </li>
                </ul>



            </li>
        </ul>
    @endif

@endif





