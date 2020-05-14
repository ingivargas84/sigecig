@extends('administracion.layoutadministracion')

@section('header')
    <section class="content-header">
        <h1>
          COLABORADORES
          <small>Ingresar Colaborador</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colaborador.index')}}"><i class="fa fa-list"></i> Colaboradores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ColaboradorForm"  action="{{route('colaborador.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre:" name="nombre" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="dpi">Dpi:</label>
                                <input type="text" class="form-control" placeholder="Dpi:" name="dpi" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="puesto">Puesto:</label>
                                <select name="puesto" class="form-control">
                                <option value="">-- Escoja el puesto --</option>
                                    @foreach ($puestos as $puesto)
                                        <option value="{{ $puesto['id'] }}">{{ $puesto['puesto'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="departamento">Departamento:</label>
                                <select name="departamento" class="form-control">
                                <option value="">-- Escoja el departamento --</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento['id'] }}">{{ $departamento['nombre_departamento'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="su">Subsedes:</label>
                                <select name="subsedes" class="form-control">
                                <option value="">-- Escoja la subsedes del empleado --</option>
                                    @foreach ($sub as $su)
                                        <option value="{{ $su['id'] }}">{{ $su['nombre_sede'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" placeholder="Telefono:" name="telefono">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('colaborador.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonColaborador" name="ButtonColaborador">Guardar</button>
                        </div>



                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">

                          <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                              <!-- Menu Toggle Button -->
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                {{--<img src="{{ auth()->user()->url }}" class="user-image" alt="User Image">--}}
                                <span class="fa fa-user"></span>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"> {{ auth()->user()->name }} -- {{ optional(auth()->user()->roles->first())->name }} </span>
                              </a>
                              <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                  {{--<img src="{{ auth()->user()->url }}" class="img-circle" alt="User Image">--}}
                                  <span class="fa fa-user"></span>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')
<script src="{{asset('js/colaboradores/create.js')}}"></script>
@endpush
