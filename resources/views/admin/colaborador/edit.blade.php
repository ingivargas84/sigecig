@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          COLABORADORES
          <small>Editar Colaborador</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colaborador.index')}}"><i class="fa fa-list"></i> Colaboradores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
<form method="POST" id="ColaboradorUpdateForm"  action="{{route('colaborador.update', $colaborador, $puestos, $departamentos)}}">

    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" value="{{$colaborador->nombre}}">
                    </div>
                <div class="col-sm-4">
                    <label for="dpi">Dpi:</label>
                    <input type="text" class="form-control" name="dpi" value="{{$colaborador->dpi}}">
                   </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                            <label for="puesto">Puesto:</label>
                            <select name="puesto" class="form-control">
                                @foreach ($puestos as $puesto)
                                    <option value="{{ $puesto['id'] }}">{{ $puesto['puesto'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="departamento">Departamento:</label>
                            <select name="departamento" class="form-control">
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento['id'] }}">{{ $departamento['nombre_departamento'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="subsede">Subsedes:</label>
                                <select name="subsede" class="form-control">
                                        @foreach ($sub as $su)
                                            <option value="{{ $su['id'] }}">{{ $su['nombre_sede'] }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="usuario">Seleccione un Usuario:</label>
                                <select name="usuario" class="form-control">
                                        @foreach ($user as $users)
                                            <option value="{{ $users['id'] }}">{{ $users['username'] }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" placeholder="Telefono:" name="telefono" value="{{$colaborador->telefono}}">
                            </div>
                    </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('colaborador.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonColaboradorUpdate">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>

    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')
<script src="{{asset('js/colaboradores/edit.js')}}"></script>
@endpush
