<?php

use Illuminate\Database\Seeder;
use App\CatalogoErrores;

class CatalogoErroresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $error=new CatalogoErrores();
        $error->codigo="SUSS001";
        $error->descripcion="Consulta Exitosa";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR002";
        $error->descripcion="Colegiado no existe";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR003";
        $error->descripcion="Rubro a pagar no existe";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR004";
        $error->descripcion="Monto excede el máximo permitido ";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR005";
        $error->descripcion="Colegiado inactivo";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR006";
        $error->descripcion="Cantidad de cuotas excede el máximo permitido";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR007";
        $error->descripcion="Cantidad invalida";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR008";
        $error->descripcion="Colegiado debe ser de tipo numérico";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR009";
        $error->descripcion="No. de Colegiado excede la cantidad de caracteres permitidos";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR0010";
        $error->descripcion="Tipo de rubro a pagar excede la cantidad de caracteres permitidos";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR011";
        $error->descripcion="Rubro a pagar invalido ";
        $error->estado=1;
        $error->save();
        
        $error=new CatalogoErrores();
        $error->codigo="ERR012";
        $error->descripcion="Cantidad de cuotas excede el numero de caracteres permitidos";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR013";
        $error->descripcion="El campo cantidad a pagar es requerido";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR014";
        $error->descripcion="El campo colegiado es requerido";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR015";
        $error->descripcion="El campo tipo de pago es requerido";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR016";
        $error->descripcion="El campo tipo de pago excede la cantidad de caracteres permitidos";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR017";
        $error->descripcion="El campo tipo de pago debe ser de tipo string";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR018";
        $error->descripcion="El campo tipo de pago no puede ser valor 0";
        $error->estado=1;
        $error->save();
        
        $error=new CatalogoErrores();
        $error->codigo="ERR019";
        $error->descripcion="Cantidad no puede ser valor 0";
        $error->estado=1;
        $error->save();
 
        $error=new CatalogoErrores();
        $error->codigo="ERR020";
        $error->descripcion="El campo colegiado debe ser un dato entero";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR021";
        $error->descripcion="El campo cantidad debe ser un dato entero";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR022";
        $error->descripcion="El campo cantidad debe ser un dato numérico";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR023";
        $error->descripcion="El campo colegiado  no puede ser valor 0";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR024";
        $error->descripcion="El campo cantidad no puede ser valor 0";
        $error->estado=1;
        $error->save();

        $error=new CatalogoErrores();
        $error->codigo="ERR025";
        $error->descripcion="El monto total excede al máximo permitido";
        $error->estado=1;
        $error->save();
 
        
    }
}
