<form id="miForumulario" action="" style="display: none ">
    @csrf
    {{-- {{csrf_field() }} --}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body" style="min-height: 100px;">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="nombre">Colegiado:</label>
                        <input type="text" readonly class="form-control" placeholder="Nombre:" name="c_cliente"
                            value="">
                    </div>
                    <div class="col-sm-7">
                        <label for="nombre">Nombre Colegiado:</label>
                        <input type="text" readonly class="form-control" placeholder="Nombre:" name="n_cliente"
                            value="">
                    </div>
                    <div class="col-sm-3">
                        <label for="telefono">Fecha de Nacimiento:</label>
                        <input type="text" readonly class="form-control" placeholder="Telefono:" name="fecha_nac"
                            value="">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-9">
                        <label for="telefono">Profesión:</label>
                        <input type="text" readonly class="form-control" placeholder="Profesion:" name="n_profesion"
                            value="">
                    </div>
                    <div class="col-sm-3">
                        <label for="dpi">DPI/CUI:</label>
                        <input type="text" readonly class="form-control" placeholder="Dpi:" name="registro" value="">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <label for="telefono">Teléfono(s):</label>
                        <input type="text" class="form-control" placeholder="Telefono:" name="telefono" value="">
                    </div>
                    <div class="col-sm-4">
                        <label>Banco*</label>
                        <select id="input_banco " class="form-control borde letra1" name="id_banco" s>
                            <option selected></option>
                            @foreach($banco as $bancos)
                                <option value="{{ $bancos['id'] }}">
                                    {{ $bancos['nombre_banco'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Tipo de cuenta*</label>
                        <select id="input_tipo_cuenta" name="id_tipo_cuenta" class="form-control borde letra1">
                            <option selected></option>
                            @foreach($tipo_cuenta as $tipo_cuentas)
                                <option value="{{ $tipo_cuentas['id'] }}">
                                    {{ $tipo_cuentas['tipo_cuenta'] }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="no_cuenta">No Cuenta Bancaria:</label>
                        <input type="text" class="form-control" placeholder="Cuenta:" name="no_cuenta" value="">
                    </div>
                </div>
                <br><br><br>

            </div>
        </div>
        <div style="display: none" id="crearUsuario">
            <div>
                <h5 style="color:red">El cliente no posee una cuenta de usuario, se creará una cuenta con los siguientes
                    parámetros</h5>
                <div class="row">
                    <div class="col-sm-2">
                        <label for="">Usuario</label>
                        <input type="text" readonly class="form-control" placeholder="Nombre:" name="c_cliente"
                            value="">
                    </div>
                    <div class="col-sm-7">
                        <label for="">Nombre Colegiado</label>
                        <input type="text" readonly class="form-control" placeholder="Nombre:" name="n_cliente"
                            value="">
                    </div>
                    <div class="col-sm-3">
                        <label for="">Contraseña</label>
                        <input type="text" readonly class="form-control" placeholder=":" name="" value="Guatemala.2020">
                    </div>

                </div>
            </div>
        </div><br>
        <button class="btn btn-primary  pull-right" type="submit" id="enviar">Crear</button>
        <div class="loader loader-bar is-active" style="display: none "></div><br><br>
    </div>


</form>
