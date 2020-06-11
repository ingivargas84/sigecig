<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Solicitudes Finalizadas de Auxilio Póstumo</title>
</head>
<style type="text/css">
	.head {
		padding: 10px;
	}

	table {
		border: 1px solid black;
		border-radius: 10px;
		padding: 10px;
		width: 100%;
		margin-bottom: 7px;
	}

	th {
		text-align: left;
	}


</style>
<body>
    <div style="display: inline-block;">
	<img src="{{$base64}}" width="150" height="150">
	</div>
	<div style="display: inline-block; margin-left: -180px">

	<h1><center>Solicitudes Finalizadas de Auxilio Póstumo </center></h1>
	</div>
	<table style="width:100%">
		<tr>
			<th>Colegiado </th>
			<th>Nombre Completo</th>
			<th>No. Solicitud</th>
			<th>Cuenta</th>
			<th>Fecha de transacción</th>
		</tr>

		@foreach($cuenta1 as $a1)
		<tr>
			<td>{{  $a1->c_cliente }}</td>
            <td>{{  $a1->n_cliente }}</td>
            <td>{{  ($ap[$loop->iteration-1]->no_solicitud) }} </td>
            <td>{{  ($ap[$loop->iteration-1]->no_cuenta) }}</td>
            <td>{{  \Carbon\Carbon::parse($ap[$loop->iteration-1]->fecha_pago_ap)->format('d-m-Y') }}</td>

		</tr>
		@endforeach

	</table>
	<strong>Fecha y hora de impresión: </strong>{{$mytime}}

</body>

</html>