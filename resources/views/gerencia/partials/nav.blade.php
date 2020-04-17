    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Menú Principal</span></a></li>
               
        <li class="treeview {{request()->is('boleta*', 'solicitud*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Gestión de Boletas de Taxi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('solicitud')? 'active': ''}}"><a href="{{route('solicitud.index')}}"> 
              <i class="fa fa-eye"></i>Solicitud de Boletas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('boleta')? 'active': ''}}"><a href="{{route('boleta.index')}}"> 
              <i class="fa fa-eye"></i>Administración de Boletas</a>
            </li>  
          </ul>

        </li> 
        
    </ul>

    <!-- /.sidebar-menu -->