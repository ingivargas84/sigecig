<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .container{
            margin-top: 100px;
        }
        .texto{
            text-align: justify;
            margin-left: 7%;
            margin-right: 7%;
            font-size: 17px;
        }
        .firma{
            text-indent: 100px;
        }

    </style>
    <title>PDF</title>
</head>
<body>
    <div class="container">

        <div class="row" style="text-align: center">
        <img src="{{$base64}}"  height="180"  alt="">
        </div>
        <div class="  " style="text-align: center">
            <h1 class="">AUXILIO PÓSTUMO</h1>
        
            <h2 class="">SOLICITUD DE ANTICIPO DE SEGURO DE VIDA</h2>
        
        
         </div >
        
            <div class="texto ">
                
                <p >

                    <div>
                        Yo, <b>{{ $colegiado->n_cliente}} </b><b> {{  $profesion->n_profesion}}</b>                                                  
                        Con número de colegiado  <b>{{  $colegiado->c_cliente}}</b>  ,fecha de nacimiento,  {{  $fecha}}</b>
                        No. de Documento personal de Identificacion (DPI) <b>{{  $colegiado->registro}}</b> y
                        con número de telefono <b>{{ $colegiado->telefono}}</b>. <br>
                    </div>
                    <br>
                    <br>
                  
                    <div>
                        Solicito a la Junta de Administracion del Auxilio Póstumo del Colegio de Ingenieros de Guatemala,
                        el anticipo de Q. 10,000 del Seguro de vida, aprobado en Asamblea General No. 14-2011/2013 de
                        fecha 17 de diciembre de 2012.
                    </div>
         
                    <br>
                    <br>
                    <br>
        
                    <div>
                        FIRMA
                    </div>
                    <div class="firma">
                        ______________________________
                    </div>
                    <br>
                    <br>
                    <br>
                    <div>
                    Guatemala,  <b>{{$fecha_actual}}</b>
                    </div>
        
                  
        
        
        
        
        
                   
                </p>
            
            </div>
        

    </div>

</body>
</html>