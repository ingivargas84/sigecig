
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">Navegación
  </li>
  <!-- Optionally, you can add icons to the links -->
  <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Inicio</span></a>
  </li>

  @role("Super-Administrador|Administrador|Gerencia|JuntaDirectiva|JefeContabilidad|Compras|JefeRRHH")
  <li class="treeview {{request()->is('colaboradores*')? 'active': ''}}">
    <a href="#"><i class="fa fa-book"></i> <span>Catálogos Generales</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>

    <ul class="treeview-menu">
      @role("Super-Administrador|Administrador|JefeRRHH|RRHH|JefeContabilidad|Gerencia|Auditoria")
      <li class="{{request()->is('colaboradores')? 'active': ''}}"><a href="{{route('colaborador.index')}}">
        <i class="fa fa-eye"></i>Colaboradores</a>
      </li>
      @endrole

      @role("Super-Administrador|Administrador|JefeRRHH|RRHH|JefeContabilidad|Gerencia|Auditoria")
      <li class="{{request()->is('su')? 'active': ''}}"><a href="{{route('subsedes.index')}}">
        <i class="fa fa-eye"></i>Subsedes</a>
      </li>
      @endrole

      @role("Super-Administrador|Administrador|JefeContabilidad|Gerencia|Auditoria|Compras")
      <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('proveedores.index')}}">
        <i class="fa fa-eye"></i>Proveedores</a>
      </li>
      @endrole

      @role("Super-Administrador|Administrador")
      <li class="{{request()->is('tipo')? 'active': ''}}"><a href="{{route('tipoDePago.index')}}">
        <i class="fa fa-eye"></i>Tipo De Pago</a>
      </li>
      @endrole

    </ul>
  </li>
  @endrole


        @role("Super-Administrador|JuntaDirectiva|AsistenteJD")
        <li class="treeview {{request()->is('empleados*', 'puestos*','destinos_pedidos*','tipos_localidad*','localidades*','unidades_medida*','categorias_insumos*','insumos*', 'productos*', 'categorias_menus*', 'recetas*', 'cajas*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Gestión de Actas de JD</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          @role("Super-Administrador|JuntaDirectiva|AsistenteJD")
          <ul class="treeview-menu">
            <li class="{{request()->is('actas')? 'active': ''}}"><a href="{{route('acta.index')}}">
              <i class="fa fa-eye"></i>Registro de Actas de JD</a>
            </li>
          </ul>
          @endrole

        </li>
        @endrole


        @role("Super-Administrador|Administrador|AsistenteJD|Gerencia|JefeContabilidad|Auditoria|JefeInformatica|Asistente|JefeComisiones|JefeRRHH|TribunalHonor|TribunalElectoral|Compras|JefeCeduca|JefeTimbres")
        <li class="treeview {{request()->is('boleta*', 'solicitud*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Gestión Boletas de Taxi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          @role("Super-Administrador|Administrador|AsistenteJD|JefeContabilidad|Auditoria|JefeInformatica|Asistente|JefeComisiones|JefeRRHH|TribunalHonor|TribunalElectoral|Compras|JefeCeduca|JefeTimbres")
          <ul class="treeview-menu">
            <li class="{{request()->is('solicitud')? 'active': ''}}"><a href="{{route('solicitud.index')}}">
              <i class="fa fa-eye"></i>Solicitud de Boletas</a>
            </li>
          </ul>
          @endrole

          @role("Super-Administrador|Gerencia|Asistente")
          <ul class="treeview-menu">
            <li class="{{request()->is('boleta')? 'active': ''}}"><a href="{{route('boleta.index')}}">
              <i class="fa fa-eye"></i>Administración de Boletas</a>
            </li>
          </ul>
          @endrole

        </li>
        @endrole

        @role("Super-Administrador|Contabilidad|JefeContabilidad|Administrador")
        <li class="treeview {{request()->is('contabilidad')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Admon de Contabilidad</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endrole
          @role("Super-Administrador|Contabilidad|JefeContabilidad|Administrador")
          <ul class="treeview-menu">
            <li class="{{request()->is('timbreingenieria')? 'active': ''}}"><a href="{{route('resolucion.index')}}">
              <i class="fa fa-eye"></i>Listado de Solicitudes Firmadas</a>
            </li>
          </ul>
        @endrole

        @role("Super-Administrador|Contabilidad|JefeContabilidad|Administrador")
          <ul class="treeview-menu">
            <li class="{{request()->is('timbreingenieria')? 'active': ''}}"><a href="{{route('reporteap.reporte_ap')}}" target="_blank">
              <i class="fa fa-eye"></i>Reporte de Solicitudes Finalizadas</a>
            </li>
          </ul>
        @endrole


        @role("Super-Administrador|JefeTimbres|Timbre")
        <li class="treeview {{request()->is('')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Admon del Timbre</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          @role("Super-Administrador|JefeTimbres|Timbre")
          <ul class="treeview-menu">
            <li class="{{request()->is('timbreingenieria')? 'active': ''}}"><a href="{{route('resolucion.index')}}">
              <i class="fa fa-eye"></i>Subsidio Auxilio Póstumo</a>
            </li>
          </ul>
          @endrole

         

        </li>
        @endrole

        @role('Super-Administrador|JefeInformatica|SoporteInformatica')
        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          @role('Super-Administrador|JefeInformatica|SoporteInformatica')
          <ul class="treeview-menu">
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}">
              <i class="fa fa-eye"></i>Usuarios</a>
            </li>
          </ul>
          @endrole

        </li>
        @endrole

        @role('Super-Administrador')
        <li class="treeview {{request()->is('negocio*')? 'active': ''}}">
            <a href="#"><i class="fa fa-building"></i> <span>Mi Negocio</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu">
              <li class="{{request()->routeIs('negocio.edit')? 'active': ''}}"><a href="{{route('negocio.edit', 1)}}">
                <i class="fa fa-edit"></i>Editar Mi Negocio</a>
              </li>
            </ul>
        </li>
        @endrole



</ul>

<!-- /.sidebar-menu -->
