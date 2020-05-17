    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegación</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Menú Principal</span></a></li>
               
        <li class="treeview {{request()->is('proveedores*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Catálogos Generales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('proveedores.index')}}"> 
              <i class="fa fa-eye"></i>Proveedores</a>
            </li>  
          </ul>

        </li>

    </ul>

    <!-- /.sidebar-menu -->