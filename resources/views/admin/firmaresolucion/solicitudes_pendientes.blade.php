<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Solicitudes Pendientes de Aprobación</title>
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

	<h1><center>Solicitudes Subsidio de Auxilio Póstumo </center></h1>
	<h2><center>Pendientes de Aprobación </center></h2>
	</div>
	<table style="width:100%">
		<tr>
			<th>Colegiado </th>
			<th>Nombre Completo</th>
			<th>DPI</th>
			<th>Profesión</th>
			<th>Teléfono </th>
			<th>Fecha de Nacimiento</th>
			<th>Colegio Pagado hasta</th>
			<th>Timbre Pagado hasta</th>
			<th>Fecha de solicitud</th>



		</tr>
		@if ($result != 0)
		@foreach($result as $a1)
		<tr>
			<td>{{  $a1->cliente }}</td>
			<td>{{  $a1->n_cliente }}</td>
			<td>{{  $a1->registro }}</td>
			<td>{{  $a1->n_profesion }}</td>
			<td>{{  $a1->telefono }}</td>
			<td>{{  \Carbon\Carbon::parse($a1->fecha_nac)->format('d-m-Y') }}</td>
			<td>{{  \Carbon\Carbon::parse($a1->f_ult_pago)->format('d-m-Y') }}</td>
			<td>{{  \Carbon\Carbon::parse($a1->f_ult_timbre)->format('d-m-Y') }}</td>
			<td>{{  \Carbon\Carbon::parse($ap[$loop->iteration-1]->fecha_solicitud)->format('d-m-Y') }}</td>

		</tr>
		@endforeach
			
		@endif


	</table>
	<strong>Fecha y hora de impresión: </strong>{{$mytime}}

</body>

</html>