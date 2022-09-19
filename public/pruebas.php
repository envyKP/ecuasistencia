<?php

require __DIR__ . '/../vendor/autoload.php';
//require 'vendor/autoload.php';

use Carbon\Carbon;

printf("Now: %s", Carbon::now());
$date1 = Carbon::createFromFormat('m/d/Y H:i:s', '12/01/2019 00:00:00');
        $date2 = Carbon::createFromFormat('m/d/Y H:i:s', '12/01/2020 10:20:00');
  
        $result = $date1->gt($date2);
        var_dump($result);

/** comparacion de fecha con carbon , existe por defecto en laravel*/


/*$str = 'Kevin / Johan ++ Perez *@ Macias'; // cadena nombre
$name = explode(' ', $str); // separar
dd($name);*/
$time = strtotime(date("Ym"));
$num = 1;
$final = date("Ym", strtotime("-" . $num . " month ", $time));

dd($final);

$input = '20220805';
$date = strtotime($input);
echo date('Y-m-d', $date);

//echo date('Ymd')."\n";
//$float_val = "1";
//echo "numero : ";
//$reemplazos1 = 0;
//str_replace( ".", "", $float_val, $reemplazos1 );
//echo (str_replace( ".", "", $float_val ));
//$individual = array(
//    'user_id' => 'Big',
//);
//$json = "{\"campo_1\":\"user_id\"}";
//$mydata = json_decode($json,true);
//echo  "variable null : ".(isset($mydata['campo_1'])? $mydata['campo_1'] : 'no hay');
//
//echo  "pruebas con float  : ".$individual[$mydata['campo_1']];
//echo ((float) $float_val);

echo 'final-';
//bloque transformar texto cadena ordenar y sacar la primera pala de cada cadena
$time = strtotime(date("Y-m-d"));
$num = 75;
//2016 04 20  - 2016-05-17
$num2 = 13;
// 2022 10 09  -  2022 07 23 
$final = date("Y-m-d", strtotime("-" . $num . " month -" . $num2 . " day", $time));
//$final = date("Y-m-d", strtotime("- ".$num." month -".$num2." day", $time));
echo $time . '-';
echo $final;
echo '-final';


$time = strtotime(date("Ym"));
$num = 1;
$final = date("Y-m-d", strtotime("-" . $num . " month ", $time));



$str = 'Kevin / Johan ++ Perez *@ Macias'; // cadena nombre

//$re = '/\b(\w)[^\s]*\s*/m'; // expresion regular 
/*$subst = '$1'; // 1 caracter
$name = explode(' ', $str); // separar
sort($name); // ordenar 
$rename_order = implode(" ", $name); //unir 
$result = preg_replace($re, $subst, $rename_order); // procesar para sacar la primera palabra
echo $result;
*/
$res = preg_replace('([^A-Za-z0-9 ])', '', $str);
echo $res;
die();

$pila = array(["hola", "como", "estas"]);
array_push($pila, ["hola", "como", "estas"]);
print_r($pila);

// experimental
$data = [
    ['user_id' => 'Coder 1', 'subject_id' => 4096],
    ['user_id' => 'Coder 2', 'subject_id' => 2048],
];

//Model::insert($data); // Eloquent approach
//DB::table('table')->insert($data); // Query Builder approach

//estructura insertar multiple
$count = 1;
$total = 995;
$resta = $total;
for ($i = 1; $i <= $total; $i++) {
    if ($count == 200) {
        echo ("**************");
        echo ("entra en condicion:");
        echo ("inserta :" . $count);
        $count = 1;
        $resta = $resta - 200;
        echo ("**************");
        //echo ($i);
        //echo ();
    } elseif ($count == $resta) {
        echo ("---------------------");
        echo ("inserta :" . $count);
        echo ("---------------------");
    }
    //echo "--".$count."--";
    $count++;
}

echo date('Y-m-d h i s', '1660838482.5864');
echo date('Y-m-d h i s', '1660834793.0605');




/*
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia","fecha_actualizacion":"","valor_debitado":"total"}


{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"876406","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888671","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888669","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888670","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873134","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"872876","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873130","num_validacion":"1"}
{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873134","num_validacion":"1"}

function updateList(idpafi) {
    var input = document.getElementById('archivo');
    let filelist = "fileList"+idpafi;
    var output = document.getElementById(filelist);
    for (var i = 0; i < input.files.length; ++i) {
        output.innerHTML = input.files.item(i).name;
    }
}$(document).ready(function() {
    $("#cliente").change(function() {
        $.ajax({
            url: "{{ route('EaSubproductoController.getSubproductoNoAMA') }}?cliente=" +
                $(this).val(),
            method: "get",
            success: function(data) {
                $("#producto").html(data.htmlProducto);
                $("#opciones_data").html(data.htmlProducto);
            }
        });
    });
    
       $("#producto").change(function() {
        $.ajax({
            url: "{{ route('EaDetalleDebitoController.getDetalleDebitoOpciones') }}?subproducto=" +
                $(this).val(),
            method: "get",
            success: function(data) {
                $("#opciones_data").html(data.htmlProducto);
            }
        });
    });
    $("#btn_genera").change(function() {        $.ajax({
            success: function(data) {
                alert("okay");
            }
        });
    });
    $("#filtro_cliente").click(function() {
        if ($("#filtro_cliente").is(":checked")) {
            $("#cliente").css('display', 'block');
            $("#btn_genera").prop("disabled", false);
        } else {
            $("#cliente").css('display', 'none');
            $("#producto").css('display', 'none');
            $(this).prop("checked", false)
            $("#filtro_producto").prop("checked", false);
            $("#btn_genera").prop("disabled", true);
            document.getElementById("processCargaDetalle").style.display = "none";        }
    });    $("#filtro_producto").click(function() {
        if ($("#filtro_producto").is(":checked")) {
            $("#cliente").css('display', 'block');
            $("#producto").css('display', 'block');
            $("#filtro_cliente").prop("checked", true);
            $("#btn_genera").prop("disabled", false);
            $("#filtro_producto").prop("checked", true);
        } else {
            $("#producto").css("display", "none");
            $("#filtro_producto").prop("checked", false);
            $("#btn_genera").prop("disabled", true);        }
    });    $("#filtro_genera").click(function() {
        if ($("#filtro_genera").is(":checked")) {
            if ($("#filtro_cliente").is(":checked")) {
                if ($("#filtro_producto").is(":checked")) {
                    $("#btn_genera").css("display", "block");
                    $("#btn_genera").prop("disabled", false);
                }
            }        } else {
            $("#subproducto").css("display", "none");
            $("#btn_genera").css("display", "none");
            $("#btn_genera").prop("disabled", true);
        }
    });
    $("#filtro_estado").click(function() {
        if ($("#filtro_estado").is(":checked")) {
            $("#state").css("display", "block");
        } else {
            $("#state").css("display", "none");        }
    });    $("#bloqueo_subida").click(function() {
        if ($("#bloqueo_subida").is(":checked")) {        } else {
            $("#btn_genera").prop("disabled", true);
        }
    });
    $("#btn_genera").click(function() {
        document.getElementById("processCargaDetalle").style.display = "block";
        $(':button').prop('disabled', false);
    });
});function updateList() {
    var input = document.getElementById('archivo');
    var output = document.getElementById('fileList');
    for (var i = 0; i < input.files.length; ++i) {
        output.innerHTML = input.files.item(i).name;
    }
}function evgenera() {
    document.getElementById("processCargaDetalle").style.display = "block";
}function procesar_function(cod_carga, cliente, producto, desc_producto, estado_cabecera, idbar) {
    //document.getElementById("demo").innerHTML = "Frame Pruebas function , intentemos ajax .";
    //var form = $("#form-uploadArchivos");
    //var url = form.attr('action');
    let url = '<?php echo url('/recepcion/archivo/cargaIndividual/procesar/'); ?>';
    // $("div").text(form.serialize());
    let form = JSON.stringify({
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'cod_carga': cod_carga,
        'cliente': cliente,
        'producto': producto,
        'desc_producto': desc_producto,
        'estado_cabecera': estado_cabecera
    });    var procesbarId = "processCargaDetalle" + idbar;
    //document.getElementById("processCargaDetalle").style.display = "block";
    document.getElementById(procesbarId).style.display = "block";
    $.ajax({
        type: "POST",
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: form,
        success: function(response) {
            var parsed_data = JSON.parse(JSON.stringify(response));
            let msg_response = parsed_data.msg;
            document.getElementById(procesbarId).style.display = "none";
            alert(msg_response);
            $('.progress .progress-bar').css("width", "0%");
        },
        error: function(response) {            document.getElementById(procesbarId).style.display = "none";
            alert("Error " + response.error);
        }
    });}function upload_function(form, idbar) {
    let url = '<?php echo url('recepcion/archivo/cargaIndividual/subirArchivo'); ?>';
    let formulario = new FormData($(form)[0]);
    //let idbar = 1;
    var procesbarId = "processCargaDetalle" + idbar;
    //document.getElementById("processCargaDetalle1").style.display = "block";
    document.getElementById(procesbarId).style.display = "block";
    //var refButton = document.getElementById("processCargaDetalle");
    //refButton.style.display = "none";    $.ajax({
        type: "POST",
        url: url,
        data: formulario,
        async: false,
        processData: false,
        contentType: false,
        dataType: "json",        success: function(response) {
            var parsed_data = JSON.parse(JSON.stringify(response));
            let msg_response = parsed_data.mensaje;
            document.getElementById(procesbarId).style.display = "none";
            alert(msg_response);
            var percentVal = 'Wait, Saving';
            $('.progress .progress-bar').css("width", "0%");        },
        error: function(response) {
            document.getElementById(procesbarId).style.display = "none";
            alert("Error " + response.error);
        }
    });}
window.onload = function() {
    var generacionVal = "{{ session('generacionVal') }}";
    if (generacionVal == '200') {
        document.getElementById("onloadForm").submit();
        //$("#testForm").submit();
    }
}function validate(formData, jqForm, options) {
    var form = jqForm[0];
}

*/

// EX
// CEDULA	CEDULA_NUM	NOMBRES	COD_SEXO	
//0850217647	850217647	REYES AYALA JOYCE SOANY	2	FEMENINO	0	CIUDADANO	07/12/1993	85605335	239	ECUATORIANA	1	SOLTERO	4	BACHILLER	E30	ESTUDIANTE				0	REYES DELGADO JOSE STALIN	239	0800661084	AYALA CARMELA CRISTINA	239	0801236589		0	0	85605600	BARRIO EL PANECILLO		16/01/2012	16/01/2012

//ABUELO
// CEDULA	CEDULA_NUM	NOMBRES	COD_SEXO	DES_SEXO	COD_CIUDADANIA	DES_CIUDADANIA	FECH_NAC	LUG_NAC	COD_NACIONALIDAD	DES_NACIONALID	COD_ESTAD_CIVIL	DES_ESTADO_CIVIL	COD_NIV_ESTUD	DESC_NIV_EST	COD_PROFESION	DES_PROFESION	NOM_CONYUG	CED_CONYUG	FECHA_MAT	LUG_MAT	NOM_PAD	NAC_PAD	CED_PAD	NOM_MAD	NAC_MAD	CED_MAD	FECH_DEF	LUG_DEF	LUG_INSC	COD_DOMIC	CALLE	NUM	FECHA_ACTUAL	FECHA_EXPED
//1000401560	1000401560	PEREZ HUMBERTO	1	MASCULINO	7	FALLECIDO	24/11/1931	40056165	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C36	COMERCIANTE	LAURA MOSQUERA			0	**********	0		MARIA PEREZ	239		16/12/2006	100305915	100305915	100305960	CD BLANCA	00005	12/01/2007	08/01/1999


//NOM_PAD	NAC_PAD	CED_PAD	NOM_MAD
//DE LA CRUZ BRAVO CARLOS ALBERTO	239	1306877158	RUIZ MARTINEZ JESSICA CECIBEL






//// limitar por un cliente , al menos el filtra

//cambiar estado en vez de borrado // a cancelado 

// poner un campo de descripcion par ala accion de cancelado 
//detrest = cancelado
//detestado = cancelado
//codestado = C