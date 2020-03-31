    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Inicio</span></a></li>
               
        <li class="treeview {{request()->is('empleados*', 'puestos*','destinos_pedidos*','tipos_localidad*','localidades*','unidades_medida*','categorias_insumos*','insumos*', 'productos*', 'categorias_menus*', 'recetas*', 'cajas*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Catalogos Generales</span>
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

        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}"> 
              <i class="fa fa-eye"></i>Usuarios</a>
            </li>
            <li>
                <a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fa fa-lock-open"></i>Cambiar contraseña</a>             
            </li>

          </ul>          
        </li>
        
        
    </ul>

    <!-- /.sidebar-menu -->