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
          <li class="active">Editar</li>
        </ol>
    </section>
@stop

@section('content')
<form method="POST" id="ColaboradorUpdateForm1"  action="{{route('colaborador.update', $colaborador, $puestos, $departamentos, $user)}}">

    {{csrf_field()}} {{ method_field('PUT') }}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" style="display: none;" name="id" id="id" value="{{$colaborador->id}}">
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
                        <label for="departamentoDPI">Departamento donde se extendió DPI:</label>
                        <select id="departamentoDPI" name="departamentoDPI" class="selectpicker form-control" data-live-search="true">
                        <option value="">-- Escoja el Departamento --</option>
                            @foreach ($deptosG as $dep)
                                <option value="{{ $dep['iddepartamento'] }}">{{ $dep['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="municipioDPI">Municipio donde se extendió DPI:</label>
                        <select id="municipioDPI" name="municipioDPI" class="selectpicker form-control" data-live-search="true">
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                            <label for="puesto">Puesto:</label>
                            <select name="puesto" class="form-control">
                                @foreach ($puestos as $puesto)
                                    @if ($puesto->id==$colaborador->puesto)
                                        <option value="{{$puesto['id']}}" selected>{{ $puesto['puesto'] }}</option>
                                    @else
                                        <option value="{{ $puesto['id'] }}">{{ $puesto['puesto'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="departamento">Departamento:</label>
                            <select name="departamento" class="form-control">
                                @foreach ($departamentos as $departamento)
                                    @if ($departamento->id==$colaborador->departamento)
                                        <option value="{{$departamento['id']}}" selected>{{ $departamento['nombre_departamento'] }}</option>
                                    @else
                                        <option value="{{ $departamento['id'] }}">{{ $departamento['nombre_departamento'] }}</option>
                                    @endif
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
                                            @if ($su->id==$colaborador->subsede)
                                                <option value="{{ $su['id'] }}" selected>{{ $su['nombre_sede'] }}</option>
                                            @else
                                                <option value="{{ $su->id }}">{{ $su->nombre_sede}}</option>
                                            @endif
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="usuario">Seleccione un Usuario:</label>
                                <select name="usuario" class="form-control" id="usuario">
                                    <option value="{{$userExist[0]->id}}">{{$userExist[0]->username}}</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}">{{ $users->username}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Telefono:" name="telefono" value="{{$colaborador->telefono}}">
                            </div>
                    </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-danger form-button' href="{{ route('colaborador.index') }}">Regresar</a>
                    <button class="btn btn-primary edit" id="ButtonColaboradorUpdate1">Actualizar</button>
                </div>

            </div>
        </div>
    </div>
</form>

    <div class="loader loader-bar"></div>

@stop


@push('styles')
<link rel="stylesheet" href="{{ asset('css/auxilio-postumo/bootstrap-select1.13.css') }}">
@endpush


@push('scripts')
<script src="{{asset('js/colaboradores/edit.js')}}"></script>
<script src="{{asset('js/auxilio-postumo/bootstrap-select1.13.js')}}"></script>
@endpush
