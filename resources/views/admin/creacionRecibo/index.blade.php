@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1><center>Creción de Recibos</center></h1>
  </section>

  @endsection

@section('content')


<form method="POST" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body"  id="app">

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipoCliente" class="control-label">Tipo de cliente</label>
                                    <div>
                                        <label class="radio-inline">
                                            <input checked="checked" name="tipoCliente" type="radio" value="c">
                                            Colegiado
                                        </label>
                                        <label class="radio-inline">
                                            <input name="tipoCliente" type="radio" value="p">
                                            Particular
                                        </label>
                                        <label class="radio-inline">
                                            <input name="tipoCliente" type="radio" value="e">
                                            Empresa
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="c" class="desc">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="c_cliente" class="control-label">Colegiado</label>
                                        <div>
                                            <input type="text" id="c_cliente" name="c_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_cliente" class="control-label">Nombres</label>
                                        <div>
                                            <input type="text" id="n_cliente" name="n_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divStatus" style="display: block;">
                                    <div class="form-group">
                                        <label for="status" class="control-label">Status</label>
                                        <div>
                                            <input id="status" disabled type="text" class="form-control" name="status" style="color: rgb(0, 128, 0)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divMontoTimbre" style="display: block;">
                                    <div class="form-group">
                                        <label for="montotimbre" class="control-label">Pago Timbre</label>
                                        <div>
                                            <input id="montotimbre" disabled type="text" class="form-control" name="montotimbre" style="color: rgb(0, 128, 0)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="e" class="desc">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="c_cliente" class="control-label">Nit</label>
                                        <div>
                                            <input type="text" id="c_cliente" name="c_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="n_cliente" class="control-label">Nombres</label>
                                        <div>
                                            <input type="text" id="n_cliente" name="n_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</form>
    <div class="loader loader-bar"></div>

<script>
    $(document).ready(function() {
        $("div.desc").hide();
        $("input[name$='tipoCliente']").click(function() {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
    });
});
</script>

@endsection
