$.validator.addMethod("ntelc", function (value, element ){
    var valor = value.length;
    if(valor == 8)
    {
        return true;
    }
    else
    {
    return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos");// validacion de telefono

$.validator.addMethod("ntelc1", function (value, element ){
    var valor = value.length;
    if(valor == 8)
    {
        return true;
    }
    else
    {
    return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos");// validacion de telefono


    function cuiIsValid(cui){
        var console = window.console;
        if (!cui) {
            console.log("CUI vacío");
            return true;
        }
        var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;
        if (!cuiRegExp.test(cui)) {
            console.log("CUI con formato inválido");
            return false;
        }
        cui = cui.replace(/\s/, '');
        var depto = parseInt(cui.substring(9, 11), 10);
        var muni = parseInt(cui.substring(11, 13));
        var numero = cui.substring(0, 8);
        var verificador = parseInt(cui.substring(8, 9));
        // Se asume que la codificación de Municipios y
        // departamentos es la misma que esta publicada en
        // http://goo.gl/EsxN1a
        // Listado de municipios actualizado segun:
        // http://goo.gl/QLNglm
        // Este listado contiene la cantidad de municipios
        // existentes en cada departamento para poder
        // determinar el código máximo aceptado por cada
        // uno de los departamentos.
        var munisPorDepto = [
            /* 01 - Guatemala tiene:      */ 17 /* municipios. */,
            /* 02 - El Progreso tiene:    */  8 /* municipios. */,
            /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */,
            /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */,
            /* 05 - Escuintla tiene:      */ 13 /* municipios. */,
            /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */,
            /* 07 - Sololá tiene:         */ 19 /* municipios. */,
            /* 08 - Totonicapán tiene:    */  8 /* municipios. */,
            /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */,
            /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */,
            /* 11 - Retalhuleu tiene:     */  9 /* municipios. */,
            /* 12 - San Marcos tiene:     */ 30 /* municipios. */,
            /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */,
            /* 14 - Quiché tiene:         */ 21 /* municipios. */,
            /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */,
            /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */,
            /* 17 - Petén tiene:          */ 14 /* municipios. */,
            /* 18 - Izabal tiene:         */  5 /* municipios. */,
            /* 19 - Zacapa tiene:         */ 11 /* municipios. */,
            /* 20 - Chiquimula tiene:     */ 11 /* municipios. */,
            /* 21 - Jalapa tiene:         */  7 /* municipios. */,
            /* 22 - Jutiapa tiene:        */ 17 /* municipios. */
        ];
        if (depto === 0 || muni === 0)
        {
            console.log("CUI con código de municipio o departamento inválido.");
            return false;
        }
        if (depto > munisPorDepto.length)
        {
            console.log("CUI con código de departamento inválido.");
            return false;
        }
        if (muni > munisPorDepto[depto -1])
        {
            console.log("CUI con código de municipio inválido.");
            return false;
        }
        // Se verifica el correlativo con base
        // en el algoritmo del complemento 11.
        var total = 0;
        for (var i = 0; i < numero.length; i++)
        {
            total += numero[i] * (i + 2);
        }
        var modulo = (total % 11);
        console.log("CUI con módulo: " + modulo);
        return modulo === verificador;
    }

    $.validator.addMethod("dpi", function(value, element) {
        var valor = value;
        if (cuiIsValid(valor) == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }, "El CUI/DPI ingresado está incorrecto");


    $.validator.addMethod("dpiunico", function(value, element){
        var valid = false;
        var urlActual = $("input[name='urlActual']").val();
        $.ajax({
            type: "GET",
            async: false,
            url: "/colaborador/dpiDisponible/",
            data:"dpi=" + value,
            dataType: "json",
            success: function (msg) {
                valid=!msg;
            }
        });
        return valid;
        }, "El CUI/DPI ya esta registrado en el sistema");

var validator = $("#colegiadosForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre:{
            required: true,
        },
        apellidos:{
            required: true,
		},
		puesto: {
			required : true
        },
        telefono: {
            required : true,
            numero : true
        },
        dpi: {
            required : true,
            dpi : true,
            dpiunico : true
        },
		departamento: {
			required: true
        },
        subsede: {
			required: true
        },
        fechanac: {
			required: true
        },
        municipio: {
			required: true
        },
        pais: {
			required: true
        },
        nacionalidad: {
			required: true
        },
        correo_electronico: {
			required: true
        },
        estadocivil: {
			required: true
        },
        direccion: {
			required: true
        },
        zona: {
			required: true
        },
        municipioc: {
			required: true
        },
        fechagrad: {
			required: true
        },
        nombreemergencia: {
			required: true
        },
        numeroemergencia: {
			required: true
		},
		telefono:{
            required: true,
            ntelc : true
        },
        telefonotrabajo:{
            required : true,
            numero : true
        },
        telefonotrabajo:{
            required: true,
            ntelc1: true
        }
	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el nombre"
        },
        apellidos: {
			required: "Por favor, ingrese el nombre"
		},
		puesto: {
			required: "Por favor, seleccione un puesto"
        },
        dpi: {
			required: "Por favor, ingrese un número de CUI/DPI"
		},
		departamento: {
			required: "Por favor, seleccione un departamento"
        },
        sexo: {
			required: "Por favor, seleccione un sexo"
		},
		telefono: {
			required: "Por favor, ingrese el teléfono"
        },
        telefonotrabajo: {
			required: "Por favor, ingrese el teléfono"
        },
        municipio: {
			required: "Por favor, ingrese un municipio"
        },
        pais: {
			required: "Por favor, ingrese un pais"
        },
        nacionalidad: {
			required: "Por favor, ingrese una nacionalidad"
        },
        correo_electronico: {
			required: "Por favor, ingrese un corre electrónico"
        },
        estadocivil: {
			required: "Por favor, ingrese el estado civil"
        },
        direccion: {
			required: "Por favor, ingrese una dirección"
        },
        zona: {
			required: "Por favor, ingrese una zona"
        },
        municipioc: {
			required: "Por favor, ingrese un municipio"
        },
        nombreemergencia: {
			required: "Por favor, ingrese nombre"
        },
        numeroemergencia: {
			required: "Por favor, ingrese número"
        },
        fechagrad: {
			required: "Por favor, ingrese fecha"
        },
        fechanac: {
			required: "Por favor, ingrese la fecha de nacimiento"
        }
	}
});

$("#ButtonColegiado").click(function(event) {
	if ($('#colegiadosForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
