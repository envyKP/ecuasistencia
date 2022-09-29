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

//editplus+ descargar luego 


//oracle database online https://dbfiddle.uk/89q8306G




if (isset($request->cliente) || isset($request->desc_subproducto)) {

    //                dd($request);
    /**  +request: Symfony\Component\HttpFoundation\InputBag {#51
        #parameters: array:10 [
         "_token" => "meOHofO5Gi7oEzizF02P2tCb1T7aMJypdTAgj4pJ"
        "usuario_registra" => "sgavela"
        "filtro_cliente" => "cliente"
        "cliente" => "BBOLIVARIANO"
        "filtro_producto" => "producto"
        "producto" => "1"
        "opciones_data" => null
        "filtro_genera" => "filtroGenera"
        "btn_genera" => "Generar"
        "state" => "PENDIENTE"
          ]
        } */
    //\Log::info('funcion exporta clase EaCargaIndividualExport');
    //\Log::warning('usuario que realiza la orden: ' . \Auth::user()->username);
    // \Log::warning('Something could be going wrong.');
    // \Log::error('Something is really going wrong.');

    $this->detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
    if (!isset($request->carga_resp)) {
        $this->op_client = EaOpcionesCargaCliente::where('cliente', $request->cliente)->where('subproducto', $request->producto)->first();
        $this->opciones_fijas = json_decode($this->op_client->opciones_fijas, true);
        $this->campos_export = json_decode($this->op_client->campos_export, true);
        $this->campoC = json_decode($this->op_client->campoc, true);
        $this->campo0 = json_decode($this->op_client->campo0, true);
        $textoPlano = ""; // Inicia la varibale que debera cambiar dependiendo de lo que venga entre el contador , o normal
        // existen 2 posibles rutas 
        // usa solo un subproducto 
        // usa todos los subproductos de un tipo , en este caso bolivariano , o produbanco 
        $this->cont = 0; // el contador es para uso general siempre funcionara y calculara la secuencia, 
        // posible ruta en caso de un subproducto mostrara la secuencia de elementos del  0 en adelante 1,2,3 ...
        // en caso se que se repita un bucle deberia seguir teniendo o seguir la secuencia 
        // es nesesaria aki el $op_client['subproducto'] ??? puedo omitirlo y que todo entre dentro del for y dentro lo valido ?
        // de echo si existe 2 id es hasta nescesario validarlo 
        echo "antes de isset op_client";
        //dd($this->op_client);
        if (isset($this->op_client['subproducto'])) {
            $prod_id = explode(',', $this->op_client['subproducto']);
            //-- el texto plano inicializa, tal vez?
            foreach ($prod_id as $producto) {
                $objEXPORT = new EaGenCamExport($request->cliente, $this->detalle_subproducto->desc_subproducto, (isset($request->carga_resp) ? strval($request->carga_resp) : null), $producto, $this->detalle_subproducto->tipo_subproducto);
                $generacion_txt = $this->genera_cadena_subproducto($objEXPORT, $request,  $textoPlano);
                //$textoPlano = $textoPlano . $generacion_txt['textoPlano'];
                $textoPlano = $generacion_txt['textoPlano'];
            }
            //-- se arma lo que es el texto plano o se almacena el resultado de texto plano 
            //$contador_bgr, -- alguna variable que permita entrar en la condicion de bgr o de secuencia,({{secuencia_unida}})
            if (isset($campoC["frase"])) {
                // CAMPOS CALCULADOS.
                //{{date}} --> fecha actual
                //{{date-N}} -->fecha menos N mes
                //{{total_recaudado}}--> sumatoria del cobor del valor total en validacion con el campo del mes o date, tiene que tener ese disparador
                // en caso de llamar a a json de validacion en base
                /*for ($i = 0; $i < strlen($campoC["frase"]); $i++) {
                }*/
                switch ($request->cliente) {
                    case 'BGR':
                        // toda esta seccion debe intentar implementarse antes que este metodo interno
                        $contador_bgr = 1;
                        $time = strtotime(date("Y-m-d"));
                        $num2 = 30; // añadir validacion a extraer 
                        $final = date("Y-m-d", strtotime(" -" . $num2 . " day ", $time));
                        $primera_linea = str_replace("{{date}}", $final, $this->campoC["frase"]);
                        //$primera_linea .= "     " . $secuencia_unida; // probablemente para una validacion , reemplazado con el foreach, no existe nescesidad 
                        // de que exista ya la variable se la deja por la estructura que respresenta dentro de el codigo
                        $primera_linea .= "\n";
                        $primera_linea = $primera_linea . $textoPlano;
                        $textoPlano = $primera_linea;
                        break;
                    case 'PRODUBANCO':
                        if (isset($campoC["fraseF"])) {
                        } else {
                            //frase = TREC02210000000
                            // aki vienen calculos globales. pero como añadir la sumantoria tendria que recorrer todo una vez y luego sumarlo o si tengo el total de registros
                            // multiplicarlo por el subtotal total o impuestos y mostrar eso .....
                            $aproximado_calculo = $generacion_txt['count_recorrido'] * $this->detalle_subproducto['valortotal'];
                            //$cont = 1; // los datos que deberian ser el total de registros -- consultar si es la global o una normal -- en caso practico por ahora la global
                            $textoPlano .= $campoC["frase"] . $this->cont . " " . $aproximado_calculo . " "; //CALCULO
                            $textoPlano .= "\n";
                        }
                        break;
                    default:
                        //$textoPlano .= $campoC["frase"];
                        break;
                }
            }
            // probablemente para una validacion , reemplazado con el foreach, no existe nescesidad 
            // de que exista ya la variable se la deja por la estructura que respresenta dentro de el codigo
            /*
            if (isset($secuencia_unida)) {
                switch ($request->cliente) {
                    case 'BGR':
                       
                        break;
                    case 'BBOLIVARIANO':
                        break;
                    case 'PRODUBANCO':
                        break;
                    default:
                        dd("no implementado , no deberia haber llegado a esta condicion -9432 ");
                        break;
                }
            }*/
            //$textoPlano =  str_replace("{{secuencia}}", $cont,  $textoPlano);
            $tiempo_final = microtime(true);
            \Log::info('tiempo que termina : ' . $tiempo_final);
            $extension_file = ".";
            if (isset($this->campoC["extension"])) {
                $extension_file .= $this->campoC["extension"];
            } else {
                $extension_file .= "txt";
            }
            $this->ultima_carga = $objEXPORT->is_carga_older(); //agarrara el ultimo objExport que genere ,
            $id_carga = (isset($this->ultima_carga->id_carga) ? $this->ultima_carga->id_carga : 0);
            $fecha_generacion = (isset($this->ultima_carga->fecha_generacion) ? $this->ultima_carga->fecha_generacion : 0);
            $file_reg_carga = array();
            $file_reg_carga['cod_carga'] = $id_carga;
            $file_reg_carga['cliente'] = $request->clinte;
            $file_reg_carga['producto'] = $request->producto;
            $file_reg_carga['fecha_registro'] = date('d/m/Y H:i:s');
            $file_reg_carga['fec_carga'] = $fecha_generacion;
            $file_reg_carga['usuario'] = \Auth::user()->username;
            $fileName = ($id_carga + 1) . $extension_file;
            $success = 'se genero exitosamente , se procede a realizar la descarga ';
            Storage::disk('public')->makeDirectory('generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y'));
            file_put_contents(public_path('storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName), $textoPlano);
            $file_reg_carga['ruta_gen_debito'] = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName;
            $objEXPORT->registro_cargas($file_reg_carga);

            return redirect()->route('EaCargaIndividualImport.index')->with([
                'success' => isset($generacion_txt['success']) ? $generacion_txt['success'] : '',
                'generacionVal' => isset($generacion_txt['success']) ? '200' : '',
                'carga_resp' => ($generacion_txt['id_carga'] + 1),
                'producto' => isset($request->producto) ? $request->producto : '',
                'cliente' => isset($request->cliente) ? $request->cliente : '',
                'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
            ]);
            //return response()->json(['success' => $import->detalle_proceso['msg']]);
        } else {
            dd("KPE MARCADOR INCOMPLETO 1");
        }
    } else {
        $objEXPORT = new EaGenCamExport($request->cliente, $this->detalle_subproducto->desc_subproducto, (isset($request->carga_resp) ? strval($request->carga_resp) : null), $request->producto, $this->detalle_subproducto->tipo_subproducto);
        $file_reg_carga = array();
        $file_reg_carga['cod_carga'] = strval($request->carga_resp);
        $file_reg_carga['cliente'] = $request->clinte;
        $file_reg_carga['producto'] = $request->producto;
        $extension_file = ".";
        if (isset($campoC["extension"])) {
            $extension_file .= $campoC["extension"];
        } else {
            $extension_file .= "txt";
        }
        $ruta =  $objEXPORT->ruta_carga();
        //$this->detalle_subproducto cambiar al campo personalizado que proviene directamente de opciones, opciones debe ser gol
        $res = preg_replace('([^A-Za-z0-9 ])', ' ', $this->detalle_subproducto->desc_subproducto);
        //$detalle_subproducto->desc_subproducto
        $fileName = $request->cliente . "-" . $res . "-" . date("d-m-Y") . "-" . strval($request->carga_resp) . $extension_file;
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
        ];
        $file = public_path() . '/' . $ruta->ruta_gen_debito;
        return Response::download($file, $fileName, $headers);
        //https://www.adictosaltrabajo.com/2015/01/29/regexsam/
    }
} else {
    return redirect()->route('EaCargaIndividualImport.index')->with([
        'success' => isset($success) ? $success : '',
        'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : 'Disculpe los inconvenientes puede que usted no selecciono el cliente o subproducto',
        'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
    ]);
}




// EaGenCamExport //// campos borrados en caso de nescesitar personalizacion

 //en caso que exista algo que no se incluya en las consultas

        // bloque de validacion para campos personalizados 
        //pendiente nombr usare el de camposC en caso de combinar
        //$campoC modificable por llamar otro elemnto para consultas
        $campo_1 = 'ea_detalle_debito.subproducto_id';
        $campo_2 = 'ea_detalle_debito.id_carga';
        $campo_3 = 'ea_base_activa.cliente';

        $campo_4 = 'tipresp';
        $campo_5 = 'codresp';
        $campo_6 = 'detresp';
        $campo_7 = 'ea_base_activa.estado';
        $campo_8 = 'ea_base_activa.codestado';
        $campo_9 = 'ea_detalle_debito.estado';

        $valor_1 = $this->id_subproducto; //quemado
        $valor_2 = $carga_secuencia; // quemado
        $valor_3 = $this->cliente; // quemado

        $valor_4 = '1';
        $valor_5 = '100';
        $valor_6 = 'ACEPTA SERVICIO'; // quemado ?
        $valor_7 = 'Z';
        $valor_8 = 'A';
        $valor_9 = '0';


        
        if (isset($campoC["existe"])) {
            //manejado por si existe desde el primer campo
            /*
                            'ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            'ea_detalle_debito.id_carga', $carga_secuencia)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'codresp', '100')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'ea_base_activa.codestado', 'A')
                            'ea_detalle_debito.estado', '0')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO'; // quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';
            /*
                            'ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            'ea_detalle_debito.id_carga', $carga_secuencia)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'codresp', '100')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.codestado', 'A')
                            'ea_base_activa.estado', 'Z')
                            'ea_detalle_debito.estado', '0')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO'; // quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';


            /*              
                            'ea_subproductos.desc_subproducto', $this->producto)
                            'ea_base_activa.subproducto', $this->producto)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'codresp', '100')
                            'ea_base_activa.codestado', 'A')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO'; // quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';
            /*
                            'ea_subproductos.desc_subproducto', $this->producto)
                            'ea_base_activa.subproducto', $this->producto)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'codresp', '100')
                            'ea_base_activa.codestado', 'A')

            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO'; // quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';
        }

// clase de EaGenCamExport.php 
// antes de modificaciones
<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use App\Models\EaSubproducto;
use App\Models\EaDetalleDebito;
use App\Models\EaCabeceraDetalleCarga;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
//use Illuminate\Support\ServiceProvider;
Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class EaGenCamExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithEvents, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{


    /**
     * @return \Illuminate\Support\Collection
     */
    public function generar($campoC)
    {
        if (!isset($this->cliente)) {
            $this->cliente = "";
        }
        $detalles = $this->is_carga_older();
        $carga_secuencia = "";
        $generar_return = null;
        switch ($this->cliente) {
            case 'disable':
                break;
            default:
                $fecha_generacion = (isset($detalles->fecha_generacion) ? $detalles->fecha_generacion : 0);
                if (($fecha_generacion) == date('mY')) {
                    // echo ($detalles->fecha_generacion) . ($detalles->id_sec) . " se encuentra dentro del mes";
                    if (isset($this->cod_carga_corp)) {
                        $carga_secuencia = $this->cod_carga_corp;
                    } else {
                        $carga_secuencia = $detalles->id_carga;
                    }
                    $this->cod_carga_corp = $carga_secuencia;
                    //puedo usar un nuevo campo en caso que venga vacio {} nada comportamiento normal. se tiene que configurar numero de elemento , valor en base
                    $base_op = array();
                    //limite 4
                    //$base_op['camp_ba_1'] = ;
                    if ($this->tipo_subproducto == 'TC') {
                        \Log::info('$carga_secuencia : ' . $carga_secuencia);
                        \Log::info('condicion - secuencia - mes - Cliente : INTER CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                            ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_base_activa.tarjeta',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_base_activa.cuenta',
                                'ea_detalle_debito.id_carga',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.direccion',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                                'ea_base_activa.fecha',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('ea_base_activa.codestado', 'A')
                            ->where('ea_detalle_debito.estado', '0')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //dd($generar_return);
                    } elseif ($this->tipo_subproducto == 'CTAS') {
                        //inicio condigo cuentas KPE
                        \Log::info('$carga_secuencia : ' . $carga_secuencia);
                        \Log::info('condicion - secuencia - mes - Cliente : INTER CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                            ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_detalle_debito.id_carga',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                                'ea_base_activa.fecha',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.codestado', 'A')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('ea_detalle_debito.estado', '0')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //dd($generar_return);
                    } else {
                        \Log::error('Error interno conexion a base o problema con sql.');
                        dd('Error interno conexion a base o problema con sql.');
                    }
                } else {
                    //existe una validacion que es un mes atras no se cobra 
                    //un filtro que solo se use una vez
                    //puede ser para 2 objetivos 
                    // púedo usar el filtro/opciones pero eso solo influiria en el mes (¿habra nescesidad de dia o años ?)
                    //Produbanco ---------
                    // existe asistencia total y asistencia total plus
                    // lo del 15 y el 30 practicamente puedo clasificarlo como producto del subproducto
                    // entonces puedo añadirlo como un subproducto , 
                    //evitaria malavares en la consulta , el problema no es cambiarla el problema es saber cuando la cambio
                    // adicional abria que anidar algo al nombre en caso que sea el 15 o el 30
                    // un subquery para identificar esa diferencia ?
                    // puedo utilizar un combobox. pero el manejo del encabezado 
                    // añadir un campo detalle ?
                    /**
                     * como internamente se podria manejar por el detalle , sin afectar tanto la consultas.
                     * lo tiene que manejar o interpretar como si fuera otro subproducto 
                     * un for afuera 
                     * 
                     * pero como lo diferencia detalle_debito??
                     *  usa la cabezera pero , internamente eso cambia la estructura de las cargas
                     *  deberia manejar otras cargas?
                     * 
                     * proceso ALF:
                     *  ingresa el post con el corte 15 , corte 30
                     *      modifico en eaGenCamExport , para que incluya validacion , y en caso de existir llamo al dato.
                     *          y lo incluyo en la consulta
                     *              se realiza la generacion, se asigna la carga dependiendo del subproducto(revision)
                     *  lectura de la respuesta , toma las validaciones de la base lo lee cambia esta a aceptado.
                     *              cambia el estado de la tabla debito.
                     * 
                     * la siguiente vez aplico el proceso de arriba pero al existir una entra a la comparativa si se 
                     * encuentra dentro del mismo mes y existe una generacion anterior,
                     *           existe , toma los que no han sido debitados(estos por ejemplo corte 15 y seleccione 30),
                     *              al consultar entre estos datos no existe "corte 30"  me devuelve un  archivo sin registro
                     *          termina()
                     * 
                     * añadir un campo detalle si existe campo adicional. (se pondria el valor y el campo en base va en cabezera)
                     * 
                     * añado una nueva condicion a la consulta , en caso si concuerda el campo adicional
                     * 
                     * en la vista apareceria como si se repítieran 2 veces el mismo subproducto.(deberia distinguir en la vista)
                     * 
                     * 
                     * / 
                    /**
                     * bolivariano solo tiene actualmente la identificacion por tarjeta , 
                     * como activar identificacion en par,(cambiar el campo ?)
                     * 
                     * 
                     */
                    /**
                     * 
                     * pendientes , identificacion por par opcional, para identificar respuesta de banco
                     * añadir campo de consulta personalizada , variable adicional o de reemplazo { esto puede ser un campo nuevo o usar el existente}
                     * {manejo de produbanco como hacer los de corte el 15 y corte 30} - en teoria se manejaria como 2 subproductos distintos.
                     * 
                     * ¿añadir un campo de opciones por fecha? no tan fiable , legalemente solo exiten unos cuantos campos para ello, 
                     */
                    /** crear el campo personalizado para cambio en la consulta (principal)
                     *  que exista por defecto lo que ya existe
                         no seria nescesario el for , unicamente se le asignaria un orden y que todo valla 

                     */

                    for ($k = 0; $k < 4; $k++) {
                        if (isset($base_op['var_cam_' . $k])) {
                            // $base_op['var_cam_' . $k] = "dettipcic";
                            //$base_op['var_val_' . $k] = "CORTE EL 15";
                            //$var_val_1 = "CORTE EL 30";
                            // {"var_val_1":"CORTE EL 15","var_val_2":"CORTE EL 30","camp_ba":"dettipcic"}
                            $base_op['camp_ba_' . ($k + 1)] = $base_op['camp_ba'];
                            $base_op['var_val_' . ($k + 1)] = '1';
                        } else {
                            $base_op['camp_ba_' . ($k + 1)] = 'tipresp';
                            $base_op['var_val_' . ($k + 1)] = '1';
                        }
                    }

                    /*
                    ->where($base_op['camp_ba_1'], $base_op['var_val_1'])
                    ->where($base_op['camp_ba_2'], $base_op['var_val_2'])
                    ->where($base_op['camp_ba_3'], $base_op['var_val_3'])
                    ->where($base_op['camp_ba_4'], $base_op['var_val_4'])
                    */

                    /*
                    tipcta
                    AHO = 03
                    CTE = 04
                    */

                    if ($this->tipo_subproducto == 'TC') {
                        \Log::info('condicion - Inicio - mes - CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_base_activa.tarjeta',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                                'ea_base_activa.fecha',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('codresp', '100')
                            ->where('ea_base_activa.codestado', 'A')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                    } elseif ($this->tipo_subproducto == 'CTAS') {
                        \Log::info('condicion - Inicio - mes - CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                            ->select(
                                'ea_base_activa.id_sec',

                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',

                                'ea_base_activa.cedula_id',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                                'ea_base_activa.fecha',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('codresp', '100')
                            ->where('ea_base_activa.codestado', 'A')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //pymes todo esta como acepta , en mi base le cambiare a acepta servicio.
                    } else {
                        \Log::error('Error interno conexion a base o problema con sql.');
                        dd('Error interno conexion a base o problema con sql.');
                    }
                }

                return $generar_return;
                break;
        }
    }

    use Exportable;

    /**
     * @param array $rows
     * @param  \Illuminate\Http\Request  $request
     * */
    public function view_reg_state(array $rows)
    {
        try {
            EaDetalleDebito::insert($rows); // Eloquent approach

        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            dd("error fatal:" . $e->getMessage());
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function destroy_cab_detalle($cod_carga, $cliente, $producto)
    {
        \Log::warning('funcion destroy_cab_detalle class EaGenCamExport by user ' . \Auth::user()->username);
        try {
            /*
            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');
            */

            EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->delete();
            /*
            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');
            */

            EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('producto', $producto)
                ->delete();
        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function destroy_cab($cod_carga, $cliente, $producto)
    {
        \Log::warning('funcion destroy_cab_detalle class EaGenCamExport by user ' . \Auth::user()->username);
        try {

            EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('producto', $producto)
                ->delete();
        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function registro_cargas(array $rows)
    {
        //$validoacion_par
        try {

            EaCabeceraDetalleCarga::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] + 1 : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' =>  isset($rows['producto']) ? trim($rows['producto']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'producto' => $this->id_subproducto,
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => isset($rows['usuario']) ? trim($rows['usuario']) : null,
                'estado' => 'PENDIENTE',
                'is_det_debito' => '1',
                'ruta_gen_debito' => isset($rows['ruta_gen_debito']) ? trim($rows['ruta_gen_debito']) : null,
            ]);
            //'opciones_validacion' => $validoacion_par,
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }
    public function ruta_carga()
    {

        #$this->cliente = $cliente;
        #$this->cod_carga_corp = $cod_carga_corp;
        #$this->producto = $producto; //usanddo la desc
        #$this->id_subproducto = $sub_producto_id;
        #$this->tipo_subproducto = $tipo_subproducto;

        try {
            return EaCabeceraDetalleCarga::where('cod_carga', $this->cod_carga_corp)->where('producto', $this->id_subproducto)->where('cliente', $this->cliente)->get()->first();
        } catch (\Exception $e) {
            $this->errorTecnico = $e->getMessage();
        }
    }


    public function is_carga_older()
    {
        return EaDetalleDebito::where('cliente', $this->cliente)
            ->where('subproducto_id', $this->id_subproducto)
            ->orderbydesc('id_carga')
            ->first();
    }

    public function collection()
    {
        $temporal = null;
        $temporal2 = null;
        $temporal3 = null;
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();

        $opciones_factura = null;
        if (isset($op_client->opciones_factura)) {
            $opciones_factura = json_decode($op_client->campos_import, true);
            if (isset($opciones_factura['direccion'])) {
                $temporal = '';
            } else {
                $temporal = EaBaseActiva::raw("'S/N' as 'Dirección Cliente'");
            }
            if (isset($opciones_factura['correo'])) {
                $temporal2 = 'ea_base_activa.mail';
            } else {
                $temporal2 = EaBaseActiva::raw("'S/N' as 'Correo Cliente'");
            }
        } else {
            $temporal = EaBaseActiva::raw("'S/N' as 'Dirección Cliente'");
            $temporal2 = EaBaseActiva::raw("'S/N' as 'Correo Cliente'");
            $temporal3 = EaBaseActiva::raw("'0' as 'Cta / TC'");
        }
        //$temporal3 = 'ea_base_activa.cuenta';
        //$this->tipo_subproducto = 'CTAS';
        $this->collection =  EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
            ->select(
                'ea_base_activa.cedula_id',
                'ea_base_activa.nombre',
                $temporal,
                $temporal2,
                EaBaseActiva::raw("'0' as 'Cta / TC'"),
                'ea_detalle_debito.fecha_actualizacion',
                'ea_detalle_debito.valor_debitado'
            )
            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
            ->where('ea_detalle_debito.id_carga', $this->cod_carga_corp)
            ->where('ea_base_activa.cliente', $this->cliente)
            ->where('ea_detalle_debito.estado', '1')
            ->orderby('ea_base_activa.cedula_id')
            ->get();
        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);
        foreach ($this->collection as $individual) {
            $input =  $individual->fecha_actualizacion;
            $date = strtotime($input);
            $individual->fecha_actualizacion = date('Y-m-d', $date);

            if ($individual->fecha_actualizacion == '1970-01-01') {
                $individual->fecha_actualizacion = 'Date Parse Error , fecha registrada = ' . $input;
            }
        }
        return $this->collection;
    }


    public function headings(): array
    {
        return ["ID Cliente", "Nombres Clientes", "Dirección Cliente", "Correo Cliente", "Cta / TC", "Fecha Débito", "Valor Debitado"];
    }
    /*
    public function registerEvents(): array
    {
        return [
            
            
            AfterSheet::class    => function(AfterSheet $event) {
                $event->writer->setCreator('EnvyKP');
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    'A1:W1',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
    }*/

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . 'G' . ($this->collection->count() + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('C1:E1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '008001',
                        ]
                    ],
                ]);
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF01',
                        ]
                    ],
                ]);
                $event->sheet->getStyle('F1:G1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF01',
                        ]
                    ],
                ]);
                /*              $event->sheet->styleCells(
                    'A1:A1',
                    [
                        //Set border Style
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '00000000'],
                            ],
                        ],
                        //Set font style
                         'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                            'color' => ['argb' => 'EB2B02'],
                        ],
                        
                        //Set background style
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'FFFF01',
                            ]
                        ],
                    ]
                    {"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}
                    {"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}
                    {"secuencia":"vale","fecha_actualizacion":"","valor_debitado":"VALOR","detalle":"estado","validacion_campo_1":"Establecimiento","validacion_valor_1":"876406","num_validacion":"1"}
                    {"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}
                    {"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}

                   subproducto = desc_subproducto

                    {"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}
                    {"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}
                    {"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}
                    {"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}
                );*/
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null, string $sub_producto_id, $tipo_subproducto)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto; //usanddo la desc
        $this->id_subproducto = $sub_producto_id;
        $this->tipo_subproducto = $tipo_subproducto;
        $this->collection = null;
    }
}





//////////////////////////////////////////////////////////

{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"FAMILIA","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"876406","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"ENFERMEDADES GRAVES TITULAR FAMILIA","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888671","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"HOGAR","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888669","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"PYMES","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"888670","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
{"validacion_campo_1":"tip_afecta","validacion_valor_1":"0","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"BZDET","6":"C","11":"CUE","13": "0013404","17" : "1" ,"20": "Servicio 24 Asistencia" ,"27":"" ,"30":"REC","34": "" ,"36": "01761","38": "  ","40": ""}	{"4":"cuenta","7":"cuenta","9":"nombre","14": "cedula_id","19": "valortotal","24":"valortotal","37": "valortotal"}	40	{"cedula_id":"cliente","fecha_actual":"fec_mov","detalle":"desc_error"}	{ "campoC_2":"contador_secuencia","identificador":"cedula_id","extension":"BIZ"}	{"campo0_2":"6","campoED_4":"18","campoED_7":"14","campoED_9":"60","campoE_17": "11","campoED_20":"60","campoE_27": "165","campo0_19": "15","campo0_24": "30","campoE_34": "31","campo0_37": "15","campo0_40": "91"}	
{"validacion_campo_1":"tip_afecta","validacion_valor_1":"0","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"BZDET","6":"C","11":"CUE","13": "0013404","17" : "1" ,"20": "Servicio 24 Asistencia" ,"27":"" ,"30":"REC","34": "" ,"36": "01761","38": "  ","40": ""}	{"4":"cuenta","7":"cuenta","9":"nombre","14": "cedula_id","19": "valortotal","24":"valortotal","37": "valortotal"}	40	{"cedula_id":"cliente","fecha_actual":"fec_mov","detalle":"desc_error"}	{ "campoC_2":"contador_secuencia","identificador":"cedula_id","extension":"BIZ"}	{"campo0_2":"6","campoED_4":"18","campoED_7":"14","campoED_9":"60","campoE_17": "11","campoED_20":"60","campoE_27": "165","campo0_19": "15","campo0_24": "30","campoE_34": "31","campo0_37": "15","campo0_40": "91"}	
{"validacion_campo_1":"error","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"cuenta"}	{"2":"836086","5":"","7":"20200","9":"0000", "14":"00D0" ,"16":""}	{"1":"cuenta","4":"subtotal","8":"cuenta","11":"deduccion_impuesto","15":"subtotal"}	16	{"cuenta":"tarjeta","fecha_actualizacion":"fecha_de_autorizacion","valor_debitado":"total","detalle":"error"}	{"campoC_3":"Ymd","espacios":"","campoC_10":"Ym"}	{"campo0_1":"18","campo0_8":"18","campo0_4":"17","campo0_5":"17","campo0_11":"17","campo0_15":"17","campo0_16":"12"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873134","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
{"formato":"txt"}	{"5":"0000","12":"101" }	{"2":"tarjeta","9":"valortotal"}	12		{"campoC_1":"contador_secuencia" ,"campoC_7":"Ymd","frase":"TREC02210000000"}	{"campo0_1":"6","campoED_12":"53"}	{"var_val_1":"CORTE EL 15","var_val_2":"CORTE EL 30","camp_ba":"dettipcic"}
{"formato":"txt"}	{"5":"0000","12":"101" }	{"2":"tarjeta","9":"valortotal"}	12		{"campoC_1":"contador_secuencia" ,"campoC_7":"Ymd","frase":"TREC02210000000"}	{"campo0_1":"6","campoED_12":"53"}	{"var_val_1":"CORTE EL 15","var_val_2":"CORTE EL 30","camp_ba":"dettipcic"}
	{"1":"CO","2":"02005112032","5":"","6":"","8":"USD","10":"CTA","11":"0036","20":"QUITO","25":"DEBITO DEL insert_date_25","26":"","27":"","28":"NA","30":"","32":"NA","33":"","34":"NA","35":"","36":"NA","37":"","38":""}	{"7":"cedula_id","9":"valortotal","12":"tipcta","13":"cuenta","14":"tipide","15":"cedula_id","16":"nombre","17":"direccion","18":"ciudadet","19":"cuenta"}	38		{"campoC_3":"contador_secuencia","insert_date_25":"Ymd","espacios":"\t"}	{"campo0_3":"7","campoE_25":"200","campo0_27":"13","campoED_28":"20","campo0_30":"13","campoED_32":"20","campo0_33":"13","campoED_34":"20","campo0_35":"13","campoED_36":"20","campo0_37":"13","campo0_38":"13"}	{"var_val_1":"CORTE EL 15","var_val_2":"CORTE EL 30","camp_ba":"dettipcic"}
{"validacion_campo_1":"cod_rechazo","validacion_valor_1":"0","num_validacion":"1","identificador_secuencia":"tarjeta"}	{"2":"0","3":"1259854","6":"","8":"202","10":"","19":"00D","20":"00000","25":"" }	{"1": "tarjeta","5": "valortotal" ,"12":"tarjeta","16":"deduccion_impuesto" ,"22":"subtotal" }	25	{"tarjeta":"tarjeta","valor_debitado":"total","detalle":"descripcion"}	{"campoC_4":"Ymd","bin_12":"1","campoC_14":"Ym","frase":"BGRVISA  Fecha de Corte: {{date}} Registros:"}	{"campo0_5": "17","campo0_6":"17","campo0_10":"14","campo0_16": "17","campo0_22": "14","campo0_25": "28"}	
{"validacion_campo_1":"estado","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"CO","2":"8020000304","6":"USD","8":"CTA","9":"42","15":"","16":"","17":"","18":"","19":"ESTUDIANTE SEGURO_insert_date_18","20":"","21":"0","22":"","24":"","24":"","26":"","28":"","29":"","30":"","32":"","33":"8"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","22":"valortotal","25":"subtotal","27":"valortotal","31":"deduccion_impuesto"}	33	{"cedula_id":"contrapartida","valor_debitado":"valor","detalle":"estado"}	{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}		
{"validacion_campo_1":"estado","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"CO","2":"8020000304","6":"USD","8":"CTA","9":"42","15":"","16":"","17":"","18":"","19":"ASISTENCIA TARJETA PROTEGIDA_insert_date_18","20":"","21":"0","22":"","24":"","24":"","26":"","28":"","29":"","30":"","32":"","33":"8"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","22":"valortotal","25":"subtotal","27":"valortotal","31":"deduccion_impuesto"}	33	{"cedula_id":"contrapartida","valor_debitado":"valor","detalle":"estado"}	{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}		
{"validacion_campo_1":"estado","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"CO","2":"8020000304","6":"USD","8":"CTA","9":"42","15":"","16":"","17":"","18":"","19":"TELEMEDICINA BLACK_insert_date_18","20":"","21":"0","22":"","24":"","24":"","26":"","28":"","29":"","30":"","32":"","33":"8"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","22":"valortotal","25":"subtotal","27":"valortotal","31":"deduccion_impuesto"}	33	{"cedula_id":"contrapartida","valor_debitado":"valor","detalle":"estado"}	{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}		
{"validacion_campo_1":"estado","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"CO","2":"8020000304","6":"USD","8":"CTA","9":"42","15":"","16":"","17":"","18":"","19":"TELEMEDICINA GOLD_insert_date_18","20":"","21":"0","22":"","24":"","24":"","26":"","28":"","29":"","30":"","32":"","33":"8"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","22":"valortotal","25":"subtotal","27":"valortotal","31":"deduccion_impuesto"}	33	{"cedula_id":"contrapartida","valor_debitado":"valor","detalle":"estado"}	{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}		
{"validacion_campo_1":"estado","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"CO","2":"8020000304","6":"USD","8":"CTA","9":"42","15":"","16":"","17":"","18":"","19":"TELEMEDICINA SILVER_insert_date_18","20":"","21":"0","22":"","24":"","24":"","26":"","28":"","29":"","30":"","32":"","33":"8"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","22":"valortotal","25":"subtotal","27":"valortotal","31":"deduccion_impuesto"}	33	{"cedula_id":"contrapartida","valor_debitado":"valor","detalle":"estado"}	{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}		
							
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"HOMBRE","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
							
							
							
							
{"validacion_campo_1":"tip_afecta","validacion_valor_1":"0","num_validacion":"1","identificador_secuencia":"cedula_id"}	{"1":"BZDET","6":"C","11":"CUE","13": "0013404","17" : "1" ,"20": "Servicio 24 Asistencia" ,"27":"" ,"30":"REC","34": "" ,"36": "01761","38": "  ","40": ""}	{"4":"cuenta","7":"cuenta","9":"nombre","14": "cedula_id","19": "valortotal","24":"valortotal","37": "valortotal"}	40	{"cedula_id":"cliente","fecha_actual":"fec_mov","detalle":"desc_error"}	{ "campoC_2":"contador_secuencia","identificador":"cedula_id","extension":"BIZ"}	{"campo0_2":"6","campoED_4":"18","campoED_7":"14","campoED_9":"60","campoE_17": "11","campoED_20":"60","campoE_27": "165","campo0_19": "15","campo0_24": "30","campoE_34": "31","campo0_37": "15","campo0_40": "91"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"872876","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"MUJER","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873130","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"ANTIFRAUDES","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	
{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1","identificador_secuencia":"secuencia"}	{"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}	{"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}	17	{"secuencia":"vale","fecha_actualizacion":"fecha_autorizacion","valor_debitado":"total","detalle":"descripcion","validacion_campo_1":"establecimiento","validacion_valor_1":"873134","num_validacion":"1"}	{"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}	{"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}	
	{"1":"CO","2":"632575","6":"USD","8":"CTA","9":"32","15":"","16":"","17":"","18":"","19":"ENFEREMEDADES GRAVES TITULAR","20":"","21":"NA","22":"NA","25":"NA","26":"NA","27":"NA"}	{"5":"cedula_id","7":"valortotal","10":"tipcta","11":"cuenta","12":"tipide","13":"cedula_id","14":"nombre","23":"subtotal","24":"deduccion_impuesto"}	27		{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","identificador":"cedula_id"}	{"campo0_1":"0"}	

    
/*
    CEDULA	CEDULA_NUM	NOMBRES
0600330195	600330195	AVILES ALARCON NICOLAS
1757633464	1757633464	CHAVEZ OLMEDO RAFAEL ANTONIO
0500129481	500129481	REINOSO TOVAR JOSE DAVID
0600512990	600512990	ZAPATER BOLAÑOS FLORINDA
0250323086	250323086	PRADO MANUEL
0100218361	100218361	LOYOLA LOYOLA JAVIERA JESUS
1300093794	1300093794	BARRERAN MERA FRANCISCA ANTONIA
1702265974	1702265974	ERAZO FLORES ALEJANDRINA
0601692981	601692981	SAMBONINO GARZON ZOILA ROSA
0900178690	900178690	LOPEZ CARVALLO SEGUNDO ISIDRORO
1703231942	1703231942	BARRAGAN MURILLO
0100692342	100692342	OCHOA GOMEZ ZOILA JUDITH
0101515625	101515625	REGALADO DURAN MARIA MERCEDES
1700376534	1700376534	MONCAYO VITERI MANUEL CESAR ENRIQUE


CEDULA	CEDULA_NUM	NOMBRES	COD_SEXO	DES_SEXO	COD_CIUDADANIA	DES_CIUDADANIA	FECH_NAC	LUG_NAC	COD_NACIONALIDAD	DES_NACIONALID	COD_ESTAD_CIVIL	DES_ESTADO_CIVIL	COD_NIV_ESTUD	DESC_NIV_EST	COD_PROFESION	DES_PROFESION	NOM_CONYUG	CED_CONYUG	FECHA_MAT	LUG_MAT	NOM_PAD	NAC_PAD	CED_PAD	NOM_MAD	NAC_MAD	CED_MAD	FECH_DEF	LUG_DEF	LUG_INSC	COD_DOMIC	CALLE	NUM	FECHA_ACTUAL	FECHA_EXPED
1201779830	1201779830	ALVAREZ ALVARADO CLOTILDE MARIA	2	FEMENINO	7	FALLECIDO	01/01/1950	129466695	239	ECUATORIANA	2	CASADO	2	INICIAL	Q05	QUEHACER. DOMESTICOS	CARRILLO CASTRO ENRIQUE LEONARDO	1200725800	11/05/1984	181505105	ALVAREZ OCTAVIO	239	0	ALVARADO MARIA	239	0	06/12/2016	93906265	93906265	125406115	NOVENA SN LOS CHAPULOS	00	07/12/2016	08/11/2016
0300368016	300368016	VERDUGO MARTINEZ FRANCISCO	1	MASCULINO	7	FALLECIDO	01/01/1950	32416715	239	ECUATORIANA	2	CASADO	10	PRIMARIA	E13	EMPLEADO	IRLANDA GARATE			0	PABLO VERDUGO	239		AMADA MARTINEZ	239		05/08/1989	12605905	12605930	32355065	MALO Y VINTIMILLA	00432	21/12/2004	27/12/1989
1202040133	1202040133	GILCE CALDERON JESUS MARIA	1	MASCULINO	7	FALLECIDO	01/01/1950	125456235	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	J05	JORNALERO				0	MEDARDO GILCE	239		ANA CALDERON	239		29/11/1998	125256245	125256245	125456235	RCTO HIGUERON	00000	20/07/2002	23/03/1999
0600735302	600735302	TIERRA RAMIREZ JULIO CESAR	1	MASCULINO	7	FALLECIDO	01/01/1950	61955630	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	TERESA GUSQUI			0	MANUEL TIERRA	239		LUZ RAMIREZ	239		15/12/1990	61956230	61955590	61956220	ANEJO SAN ANTONIO	00000	28/05/2013	28/10/1991
1706305339	1706305339	CUALCHI CAMPOS ROSA	2	FEMENINO	7	FALLECIDO	01/01/1950	170655190	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	FRANCISCO CUALCHI	239		SAVINA CAMPOS O	239		18/05/2010	51005465	51005555	170655190	CUBA	00000	25/05/2010	20/09/2004
0600736235	600736235	RUIZ ORTIZ ESTUARDO VICENTE	1	MASCULINO	7	FALLECIDO	01/01/1950	61955590	239	ECUATORIANA	2	CASADO	30	SUPERIOR	L12	LICENCIADO	ANA NARANJO	0958396145		0	ESTUARDO A RUIZ	239	0	ANA V ORTIZ	239	0	16/07/1989	61955590	61955590	170605015	TUNGURAHUA	00535	29/05/2013	02/06/1982
1000624245	1000624245	PINEDA COTACACHI JOSE SEGUNDO	1	MASCULINO	7	FALLECIDO	01/01/1950	100355490	239	ECUATORIANA	2	CASADO	0	NINGUNA	C36	COMERCIANTE	MARIA PERUGACHI			0	JOSE PINEDA	239		JOSEFINA COTACACHI	239		30/08/1991	100305915	100355490	100355980	SUCRE	00517	29/07/2002	03/10/1991
0600818835	600818835	AGUIRRE JORGE ENRIQUE	1	MASCULINO	7	FALLECIDO	01/01/1950	61955590	239	ECUATORIANA	2	CASADO	30	SUPERIOR	T18	TOPOGRAFO	ISABEL VELOZ			0	**********	0		ROSA ELISA AGUIRRE	239		12/04/2003	61955590	61955590	61955590	COLOMBIA	03135	19/04/2004	11/02/2000
1000653764	1000653764	CHICANGO ALVEAR FABIAN EDMUNDO	1	MASCULINO	7	FALLECIDO	01/01/1950	40105405	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C36	COMERCIANTE	ELSA MARIA IBARRA			0	BUENAVENTURA CHICANGO	239		CLARUA AURORA ALVEAR	239		23/01/1990	100305915	100305915	100355980	9 DE OCTUBRE	00000	28/07/2002	25/01/1990
0600855233	600855233	SALAZAR VILLACRES TERESA LEONOR	2	FEMENINO	7	FALLECIDO	01/01/1950	61953095	239	ECUATORIANA	4	VIUDO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	CASTELO CARGUA DIMAS MARCOS			0	CRUZ ALEJANDRO SALAZAR	239		ROSA VICTORIA VILLACRES	239		24/11/2011	170605410	181350190	181355605	CENTRO	00000	05/12/2011	22/03/2010
1101080768	1101080768	CAMPOVERDE SALINAS ROSA EFIGENIA	2	FEMENINO	7	FALLECIDO	01/01/1950	113155195	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	MARCIAL CAMPOVERDE	239		MARIA SALINAS	239			0	0	113006100		00000		29/03/1993
0600863229	600863229	CHOTO CHOTO MANUEL MESIAS	1	MASCULINO	7	FALLECIDO	01/01/1950	61905475	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A28	ALBANIL	TERESA DE JESUS YASACA	0		0	JUAN MANUEL CHOTO	239	0	MARIA NICOLASA CHOTO	239	0	21/03/2004	61955590	61905475	61905475	BR SAN JUAN	0	19/02/2015	09/01/1998
1100454345	1100454345	BENITEZ JARAMILLO LUIS ALFREDO	1	MASCULINO	7	FALLECIDO	01/01/1950	112905270	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	N07	NEGOCIANTE				0	MANUEL BENITEZ	239		DOLORES JARAMILLO	239		19/03/1998	170605235	170606020	112905270	CATAMAYO	00000	11/06/2004	12/11/1992
0100806660	100806660	REYES MERCHAN MANUEL PLACIDO	1	MASCULINO	7	FALLECIDO	01/01/1950	15555690	239	ECUATORIANA	2	CASADO	10	PRIMARIA	J05	JORNALERO	MARIA GERARDINA VILLEGAS G			0	URBANO REYES	239		CLOTILDE MERCHAN	239		19/05/1996	15555690	15555690	15555690	PUCARA	00000	29/07/2002	05/12/1996
1200468781	1200468781	VERA ZAMORA EUFRASINO FILIBERTO	1	MASCULINO	7	FALLECIDO	01/01/1950	125405855	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	INTRIAGO ROMERO BRISEIDA AMARILIS	1303718678		0	VERA SAMUEL	239	0	ZAMORA GAVINA	239	0	20/08/1995	129456465	129456465	125405855	RCTO MACULLILLO	00000	19/09/2013	05/01/1996
0100970789	100970789	SUCONOTA SUCONOTA SEGUNDO MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1950	12603105	239	ECUATORIANA	2	CASADO	0	NINGUNA	A24	AGRICULTOR	MARIA R QUITUISACA			0	MANUEL R SUCONOTA	239		MA FRANCISCA SUCONOTA	239		30/06/2004	12603105	12603105	12603105	QUINGEO	00000	26/09/2005	07/04/1994
1101186904	1101186904	ROSALES NELSON	1	MASCULINO	7	FALLECIDO	01/01/1950	117406260	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	MONICA ESMERALDA CORREA JARAMILLO		15/09/1995	113006015	**********	0		USULINA ROSALES	239		28/07/2001	113201230	113201230	216255710	P	00000	17/09/2013	13/05/1998
0200340545	200340545	COLINA NAJERA NILO EDGAR	1	MASCULINO	7	FALLECIDO	01/01/1950	21755995	239	ECUATORIANA	3	DIVORCIADO	3	BASICA	R03	RADIOTECNICO		0	23/01/1982	21803500	COLINA ENERIO	239	0	NAJERA ELIZA	239	0	12/02/2017	93906150	93906150	21803500	AV. PRINCIPAL 00	00	13/02/2017	02/06/2016
1101197208	1101197208	BETANCOURT CHAMBA GRACILIANO RODRIGO	1	MASCULINO	7	FALLECIDO	01/01/1950	113355400	239	ECUATORIANA	2	CASADO	10	PRIMARIA	E13	EMPLEADO	GLORIA AZUCENA FERNANDEZ		27/09/1976	170605410	URBANO BETANCOURT	239		JUANA CHAMBA	239		30/11/2007	170605110	170606020	170605015	JUAN BURGONON	00482	04/12/2007	05/07/2002
0901349043	901349043	MOROCHO SANGURIMA JUAN ALEJANDRO	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	3	BASICA	C36	COMERCIANTE		0		0	MOROCHO JOSE DAVID	239	0	SANGURIMA MARIA	239	0	21/03/2017	93905170	93906150	93906150	2DA CALLE E/ LA 7MA N	N	22/03/2017	19/09/2014
1101663969	1101663969	MIRANDA FLORES AMABILIA	2	FEMENINO	7	FALLECIDO	01/01/1950	112956320	239	ECUATORIANA	2	CASADO	1	ELEMENTAL	Q05	QUEHACER. DOMESTICOS	JOSE MIRANDA			0	HELIODORO MIRANDA	239		FEDINA FLORES	239		15/12/1991	112950290	112956320	112956320	BR GARZAGUACHANA	00000	20/07/2002	13/02/1992
0901086975	901086975	BASTIDAS SALTOS MARIA ANTONIETA	2	FEMENINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	E18	ENFERMERA/O	HECTOR MANUEL SERRANO PRIETO		22/09/1978	99406460	ALFONSO BASTIDAS	239		JUANA SALTOS	239		11/04/2006	93905170	93905170	93905355	LA 33 AVA Y SEDALANA0700839251	01808	18/05/2006	03/07/1992
1101768560	1101768560	CUENCA HONORINA MERCEDES	2	FEMENINO	7	FALLECIDO	01/01/1950	118156530	239	ECUATORIANA	1	SOLTERO	3	BASICA	Q05	QUEHACER. DOMESTICOS		0		0	**************** ****************	0	0	CUENCA DOMINGA	239	0702908674	05/06/2017	73606310	73606310	76905850	EL OSORIO		05/06/2017	01/12/2011
0901665877	901665877	CEDEÑO TOVAR MAXIMO FAUSTINO	1	MASCULINO	7	FALLECIDO	01/01/1950	94155100	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR				0	JUAN CEDENO	239		NINFA TOVAR	239		01/04/2004	93905170	94155100	94155100		00000	02/07/2004	31/08/1999
0802631689	802631689	MINA CASTILLO EVERGITO	1	MASCULINO	7	FALLECIDO	01/01/1950	85806130	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	N00	NINGUNA				0	************	0		FRANCISCA MINA CASTILLO	239		21/01/2001	85806130	85806130	85806130	SAN LORENZO		13/07/2004	16/12/1999
0700658883	700658883	COELLO ROMERO EDMUNDO VICENTE	1	MASCULINO	7	FALLECIDO	01/01/1950	73601655	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E13	EMPLEADO				0	DAVID COELLO	239		ROSA ROMERO	239		21/12/1990	73505625	73505625	73505625	15 OESTE Y 1 NORTE	00000	01/08/2002	04/03/1991
0802213272	802213272	CORTEZ CASTILLO GERMANIA DEYANIRE	2	FEMENINO	7	FALLECIDO	01/01/1950	87856380	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS				0	**************	0		*************	0		18/11/2010	85605335	85604240	87856380	TONSUPA	00000	10/05/2011	01/12/2003
0700267214	700267214	MORALES FRANKLIN VICENTE	1	MASCULINO	7	FALLECIDO	01/01/1950	62205255	239	ECUATORIANA	2	CASADO	30	SUPERIOR	I12	INGENIERO COMERCIAL	LOAIZA ROMERO JUANA DE LOS ANGELES	0701352890	05/10/1984	73505625	********************	0	0	MORALES ANA LUCIA	239	0600205686	30/06/2013	73505625	73505625	73505625	JUAN MONTALVO	0	01/07/2013	04/02/2013
0918400813	918400813	HERRERA PIGUAVE JOSE ESTEBAN	1	MASCULINO	7	FALLECIDO	01/01/1950	94155100	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	A24	AGRICULTOR				0	*********	0		********	0		03/03/2006	94155100	94155100	94155100	RTO SAN JACINTO	00000	12/04/2006	22/08/1995
0910296649	910296649	GOYA BAJANA TITO GREGORIO	1	MASCULINO	7	FALLECIDO	01/01/1950	94305155	239	ECUATORIANA	1	SOLTERO	2	INICIAL	O01	OBRERO		0		0	GOYA MARIO	239	0	BAJANA LUCIA	239	0	01/07/2014	93906265	94305200	94305155	SALITRE		03/07/2014	01/02/2010
0917461261	917461261	CHIRIGUAYA VERGARA ADALBERTO MARIANO	1	MASCULINO	7	FALLECIDO	01/01/1950	98706580	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	BONIFACIO CHIRIGUAYA	239		FRANCISCA VERGARA	239		31/12/1995	98706580	98706580	98706580	RTO CABUYAL	00000	31/07/2002	09/01/1996
0914966767	914966767	ESTRADA ZAMBRANO ROSA ARGENTINA	2	FEMENINO	7	FALLECIDO	01/01/1950	93956285	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS				0	LEOPOLDO ESTRADA	239		LIBIA ZAMBRANO	239		03/09/2011	93951915	93951915	93956285	RCTO BUENOS AIRES	00000	31/10/2011	05/10/2004
0602793275	602793275	NAIGUA GUAMAN MARIA FELICIANA	2	FEMENINO	7	FALLECIDO	01/01/1950	61952165	239	ECUATORIANA	2	CASADO	0	NINGUNA	A05	ACROBATA	JOSE GREGORIO MOROCHO CUJILEMA			0	VICENTE NAIGUA	239		ROSA GUAMAN	239		06/06/2007	68306540	68306540	61953515	XX	00000	14/05/2013	02/01/1992
0913102802	913102802	RIVAS RONQUILLO ELISA PIEDAD	2	FEMENINO	7	FALLECIDO	01/01/1950	94005275	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	FELIBERTO RIVAS	239		LUZMILA RONQUILLO	239		06/08/2002	94005275	94005275	94005275	JIGUAL	00000	12/09/2003	11/04/1987
0603223678	603223678	GUACHILEMA GUACHILEMA MARIA	2	FEMENINO	7	FALLECIDO	01/01/1950	61955630	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS				0	********************	0		********************	0		08/01/2008	68306540	68306540	61955630	ARGENTINOS CDLA SAN JUAN	04934	09/02/2008	10/06/2003
1300724703	1300724703	DONOSO PEREZ MELANIA ESPERANZA	2	FEMENINO	7	FALLECIDO	01/01/1950	134606105	239	ECUATORIANA	2	CASADO	2	INICIAL	Q05	QUEHACER. DOMESTICOS	SOZA CRISTOBAL ALEJANDRO	1300724448	19/05/1966	134606105	DONOSO MENDOZA PALATINO	239		PEREZ CATAGUA IGNACIA	239		12/04/2013	134606105	134606105	134606105	00		03/07/2013	31/01/2013
0800146979	800146979	MONTESUMA PRADO EUGENIO	1	MASCULINO	7	FALLECIDO	01/01/1950	85605335	239	ECUATORIANA	2	CASADO	10	PRIMARIA	E04	ELECTRICISTA	ELENA CHARCOPA CHILA			0	ROMELIO MONTESUMA	239		JOBA PRADO	239		19/02/2001	85605335	85605335	85605210	QUITO Y AV SEPTIMA	00000	10/09/2012	01/07/1991
1301423107	1301423107	ROLDAN DELGADO TERESA MATILDE	2	FEMENINO	7	FALLECIDO	01/01/1950	134405795	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C42	CONTADOR				0	AGUSTIN ROLDAN	239		CLEMENCIA DELGADO	239		05/08/1980	134505635	134505635	134505635	AV 24 DE MAYO	00802	18/11/2004	15/01/1996
0951098169	951098169	JACOME CEREZO JULIO	1	MASCULINO	7	FALLECIDO	01/01/1950	93906095	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	N00	NINGUNA		0		0	******************************	0	0	******************************	0	0	23/07/2013	93905585	93906150	93906095	SUCRE	PEDRO PABL	24/07/2013	14/09/2010
1301342414	1301342414	ZAMBRANO ZAMBRANO JUDITH	2	FEMENINO	7	FALLECIDO	01/01/1950	134805250	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	P37	PROFESOR EN GENERAL	DIAZ CESAR	1703565745	22/02/1978	93905170	JUAN DE DIOS ZAMBRANO	239	0	JOSEFA ZAMBRANO	239	0	16/10/2013	93906150	93906150	93905720	C NAJERA	00409	30/10/2013	12/09/2005
0200448843	200448843	SOLANO VALVERDE JOSE AGNELIO	1	MASCULINO	7	FALLECIDO	01/01/1950	21703655	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR				0	SEGUNDO SOLANO	239		JACINTA VALVERDE	239		15/11/2006	21655035	21705975	21705975	EL PLACER	00000	19/01/2009	26/08/1999
0903644300	903644300	HUACON PRECIADO VICENTE EUGENIO	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A28	ALBANIL	ZENEIDA FRANCO UYAGUARE		28/07/1988	93905170	DOMINGO HUACON	239		LUCRECIA PRECIADO	239		23/12/1998	93905170	93905170	93906265	GUASMO SUR	00000	18/07/2002	04/01/1999
0200453611	200453611	TIXILEMA PAUCAR SEGUNDO JUAN	1	MASCULINO	7	FALLECIDO	01/01/1950	21653860	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	CAMBO PAUCAR ANA LUISA	1801732700	08/05/1982	21655035	TIXILEMA SEGUNDO JUAN	239	0	PAUCAR MARIA MARTINA	239	0	06/09/2013	181355545	181355455	21653860	CENTRO	00000	27/02/2014	15/03/2010
0903831600	903831600	CORONEL ROCA MANUEL DE JESUS	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	E13	EMPLEADO				0	ENRIQUE SANTIAGO CORONEL	239		LUZ MARIA ROCA	239		02/09/1971	93905170	93905170	93905355	FEBRES CORDERO	00000	21/08/2012	28/09/1985
0601007594	601007594	LLANGA CHAVEZ LUIS ANGEL	1	MASCULINO	7	FALLECIDO	01/01/1950	61952160	239	ECUATORIANA	2	CASADO	0	NINGUNA	A28	ALBANIL	ROSA INES MOROCHO MAYAY		10/02/1993	61952165	VELISARIO LLANGA	239		JOSEFINA CHAVEZ	239		10/02/1993	61952165	61952165	61952160	PRIN	00000	20/06/2013	19/02/1993
0903423192	903423192	RAMIREZ MARTINEZ LUIS EDUARDO	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	3	BASICA	E13	EMPLEADO		0		0	RAMIREZ PEDRO	239	0	MARTINEZ ROSA V	239	0	08/05/2016	93906265	93906265	93906265	PRADERA 3 MZ 87D N	V 7	09/05/2016	04/09/2014
0601241193	601241193	PILATAXI GUAMAN MARIA INES	2	FEMENINO	7	FALLECIDO	01/01/1950	61955590	239	ECUATORIANA	4	VIUDO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	ANTONIO RAMIREZ			0	JOSE PILATAXI	239		MARIA FRANCISCA GUAMAN	239		02/10/2002	61952165	61952165	61952165	LICTO	0000000	22/05/2013	22/07/1996
0903456754	903456754	PEREZ GIHA ELIZABETH MARIA	2	FEMENINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	2	CASADO	30	SUPERIOR	Q05	QUEHACER. DOMESTICOS	EDUARDO TORBAY			0	JORGE PEREZ	239		LILLY GIHA	239		07/11/1995	93906150	93905170	93906150	BALSAMOS Y EBANOS	00415	16/07/2002	10/01/1996
0500635305	500635305	QUISHPE QUISHPE MARIA ISABEL	2	FEMENINO	7	FALLECIDO	01/01/1950	51055820	239	ECUATORIANA	4	VIUDO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	DANIEL VARGAS CHANGO		10/04/1997	51055820	CAMILO QUISHPE	239		MARIA SALOME QUISHPE	239		17/10/2009	51055820	51055820	51055820	BR ALPAMALAG DE SAN VICENTE	00000	19/10/2009	14/01/2004
0901993949	901993949	AGUIÑO OLMEDO DANIEL ENRIQUE	1	MASCULINO	7	FALLECIDO	01/01/1950	94355675	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A28	ALBANIL	EMERITA ANGULO		12/06/1973	85605335	VISITACION AGUIÑO	239		UBERTA OLMEDO	239		31/05/2001	139106430	139106430	85605335	ESMERALDAS	00000	03/03/2005	20/03/2000
0500321005	500321005	PILA SANTO ROSA ELVIRA	2	FEMENINO	7	FALLECIDO	01/01/1950	51005555	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	JOSE A GUANOLUISA			0	JOSE FRANCISCO PILA	239		MARIA AGUSTINA SANTO	239		21/01/1989	0	51005555	51005310	S RODRIGUEZ Y GUATEMALA	00000		09/05/1991
0905958203	905958203	SILVA MARCILLO MARTHA BEATRIZ	2	FEMENINO	7	FALLECIDO	01/01/1950	170605410	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E13	EMPLEADO				0	SILVA LUIS FELIPE	239		MARCILLO LUZ AMERICA	239		30/06/2010	93905880	93906150	93905355	35AVA Y SAN MARTIN	00000	19/12/2012	25/10/2004
0400374906	400374906	ORTIZ VILLARREAL LUIS FABIAN	1	MASCULINO	7	FALLECIDO	01/01/1950	40105405	239	ECUATORIANA	2	CASADO	0	NINGUNA	J05	JORNALERO	FLORES PROAÑO MARTHA AZUCENA	1001407111	01/09/2015	100355490	ORTIZ TOBIAS	239	0	VILLARREAL CLEMENTINA	239	0	06/12/2016	100353590	100355490	100353590	ARAQUE LA UNION	S/N	08/12/2016	19/10/2016
0907161699	907161699	MENDOZA MECIAS FRANCISCO VICTORIANO	1	MASCULINO	7	FALLECIDO	01/01/1950	134800495	239	ECUATORIANA	2	CASADO	1	ELEMENTAL	D97	DISCAPACITADO	ANDRADE MONCAYO ROSA DEVORA	1303348005	07/12/1989	249656610	MENDOZA ISAAC	239	0	MECIAS FLORINDA	239	0	03/03/2014	93905355	249656610	249656610	SN 00	00	18/03/2014	20/03/2013
0400391413	400391413	LAGOS CEVALLOS ANCELMO BENJAMIN	1	MASCULINO	7	FALLECIDO	01/01/1950	40105405	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR		0		0	LAGOS JORGE ALBERTO	239	0	CEVALLOS CARMEN AURELLA	239	0	12/06/1990	40106930	40106930	40105970	CD MONTUFAR	00000	27/09/2017	02/06/1982
0904154143	904154143	ROSALES CABEZA ANDRES VICENTE	1	MASCULINO	7	FALLECIDO	01/01/1950	85605335	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	S13	SOLDADOR	JENNY LEYES NAZARENO			0	PEDRO ROSALES	239		ELINA CABEZA	239		12/03/2008	85605335	85605335	85605210	QUITO Y 6 DE DICIEMBRE	00000	27/05/2008	09/07/2003
0400556346	400556346	ESTRADA PEREZ CARMEN AMELIA	2	FEMENINO	7	FALLECIDO	01/01/1950	40153435	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	SEGUNDO ALFONSO LOPEZ P			0	JUAN ESTRADA	239		MARIA PEREZ	239		07/12/1997	100305915	40153435	40155295		00000	24/07/2002	19/01/1998
0904074630	904074630	SUCLA GOMEZ JUAN SILVIO	1	MASCULINO	7	FALLECIDO	01/01/1950	12606090	239	ECUATORIANA	1	SOLTERO	30	SUPERIOR	C27	CHOFER PROFESIONAL				0	ANTONIO SUCLA	239		EVANGELINA GOMEZ	239		20/06/1998	93905170	93905170	93905355	13 Y CALICUCHIMA	00000	15/07/2002	12/08/1998
1800920520	1800920520	BOSSANO ROSALES VICTOR MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	P05	PANADERO				0	VICTOR BOSSANO	239		LUZ AMERICA ROSALES	239		04/08/1994	249656610	249656610	181355445	AV OLIMPICA Y SAN MATEO	00000	11/07/2002	27/02/1996
0904378171	904378171	JIMENEZ CARRION MAXIMO ENRIQUE	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	3	BASICA	E13	EMPLEADO				0	******************************	0		******************************	0		03/05/2013	93906150	93906150	93905585	VIA A DAULE KM 7		07/05/2013	04/08/2011
1800599803	1800599803	ACOSTA ACOSTA GLORIA EDELINA	2	FEMENINO	7	FALLECIDO	01/01/1950	181355455	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	ANIBAL ESTUARDO SOLIS			0	LUIS AMABLE ACOSTA	239		ROSA MARIA ACOSTA	239		16/01/1987	181352830	181352830	181355455	CASERIO TERREMOTO	00000	19/04/2004	02/06/1982
0904401080	904401080	CHALEN CRESPIN PABLO	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	3	BASICA	C36	COMERCIANTE		0		0	CHALEN FRANCISCO	239	0	CRESPIN FLORINDA	239	0	11/03/2016	93905170	93906150	93905380	FCO SEGURA Y MACHALA		14/03/2016	01/08/2012
1900036342	1900036342	CHIRIAPO JAMBAY CARMEN	2	FEMENINO	7	FALLECIDO	01/01/1950	196550720	239	ECUATORIANA	1	SOLTERO	1	ELEMENTAL	Q05	QUEHACER. DOMESTICOS				0	CHIRIAPO	239		ROSARIO JIMBAY	239		13/08/2002	197756355	197756355	196550720	CUMBARATZA	00000	03/06/2004	14/09/1994
0904941093	904941093	LEON OLIVO LETY LOURDES	2	FEMENINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C47	COSTURERA/O		0		0	LEON LUIS	239	0	OLIVO PAULA	239	0	25/07/2013	98206525	98206525	98206525	16 DE OCTUBRE Y ABEL GILBERT		25/07/2013	15/09/2011
1900128693	1900128693	CUMBICUS HILDA	2	FEMENINO	7	FALLECIDO	01/01/1950	113405020	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS		0		0	MEDARDO CUMBICUS CALVA	239	0	************	0	0	24/11/2010	113006100	196556305	196556305	ZAMORA	00000	26/06/2014	05/01/2004
0905124608	905124608	CARVACHE TREJO OLGA EMPERATRIZ	2	FEMENINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E13	EMPLEADO		0		0	TEMISTOCLES CARVACHE	239	0	BELLA TREJO	239	0	01/12/2016	213	213	93906150	ALBORADA 4TA ETPA MZ DF	1	07/03/2017	04/10/2010
1800943217	1800943217	IZURIETA RAMOS EUDOFILO MELQUICEDEC	1	MASCULINO	7	FALLECIDO	01/01/1950	181504135	239	ECUATORIANA	3	DIVORCIADO	10	PRIMARIA	A24	AGRICULTOR				0	PEDRO OVIDIO IZURIETA	239		MARIA RAMOS	239		24/07/2007	181504135	181504135	181504135	CENTRO	00000	13/12/2012	24/01/2007
0904619145	904619145	VASQUEZ BECERRIL MANUEL LUCIANO	1	MASCULINO	7	FALLECIDO	01/01/1950	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	O01	OBRERO				0	LUCIANO VASQUEZ	239		ROSARIO BECERRIL	239		23/08/2003	93905170	93905170	93905355	45 Y LA A	06007	11/05/2004	18/09/1995
1801450360	1801450360	SANCHEZ FREIRE MANUEL MESIAS	1	MASCULINO	7	FALLECIDO	01/01/1950	181605835	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	A24	AGRICULTOR				0	SEGUNDO SANCHEZ	239		MARIA FREIRE	239		08/07/2002	181355545	181605835	181605835	CASERIO SAN VICENTE	00000	23/04/2004	02/06/1982
1703062107	1703062107	EGAS HUALCHI MANUEL MARIA	1	MASCULINO	7	FALLECIDO	01/01/1950	170602980	239	ECUATORIANA	3	DIVORCIADO	10	PRIMARIA	C16	CARPINTERO				0	SEGUNDO EGAS	239		CARMELINA HUALCHI	239		04/03/2009	230856065	230856065	230850075	ALLURIQUIN	00000	11/03/2009	04/01/2006
1702845957	1702845957	GONZALEZ GARCES VICTOR MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1950	188456555	239	ECUATORIANA	2	CASADO	3	BASICA	M12	MECANICO AUTOMOTRIZ	REINOSO GLORIA	1703354702		0	GONZALEZ VICTOR	239	0	GARCES MARIA	239	0	21/07/2014	170606240	170607250	170605015	BR FERROVIARIA BAJA		22/07/2014	04/10/2011
1702914118	1702914118	GUAÑUNA QUINGA OSWALDO FABIAN	1	MASCULINO	7	FALLECIDO	01/01/1950	170605410	239	ECUATORIANA	2	CASADO	30	SUPERIOR	M14	MEDICO	MUÑOZ G ROCIO DEL PILAR	0	26/03/1971	170805965	GUAÑUNA PEDRO	239	0	QUINGA ROSARIO	239	0	30/07/2012	170607140	170607140	170605985	ROCAFUERTE Y PONTON	E2-66	31/07/2012	12/06/2008
1702524677	1702524677	PEREZ CARRERA JORGE ERNESTO	1	MASCULINO	7	FALLECIDO	01/01/1950	170604085	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C27	CHOFER PROFESIONAL	MARTHA SUSANA PEREZ CADENA	0	06/10/1986	170605410	ELISEO PEREZ	239	0	VIRGINIA CARRERA	239	0	27/06/2017	170604085	170607250	170604085	VIA INTERAMERICANA.	00000	28/06/2017	10/09/2010
1702716208	1702716208	NARVAEZ GUERRA ZOILA AMABLE	2	FEMENINO	7	FALLECIDO	01/01/1950	40155295	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	E38	EMPLEADO PRIVADO	GUERRA MESIAS	0		0	NARVAEZ GONZALO	239	0	GUERRA LUZ	239	0	14/04/2011	170607170	170607170	170605235	6 DE DICIEMBRE Y EL INCA	00000	14/04/2011	26/12/2006
1702722065	1702722065	GUAMAN MOLINA GUILLERMO LEONARDO	1	MASCULINO	7	FALLECIDO	01/01/1950	170601400	239	ECUATORIANA	2	CASADO	3	BASICA	M44	MILITAR SERV. PASIVO	GUZMAN REBELO GULNARA SILVIA	0		0	GUAMAN PACHECO LUIS ALFONSO	239	0	MOLINA SOLARTE MARIA LEONOR	239	0	13/06/2012	170607175	170607170	170601400	ANEJO SANTA ELENA  NR		13/06/2012	25/08/2010
1702637420	1702637420	PAREDES CUICHAN MANUEL MESIAS	1	MASCULINO	7	FALLECIDO	01/01/1950	170605220	239	ECUATORIANA	2	CASADO	2	INICIAL	A28	ALBANIL	CAGUANA MARIA ESPERANZA	1702637404		0	PAREDES ANGEL MARIA	239	0	CUICHAN MARIA EUFEMIA	239	0	28/12/2013	170605220	170607230	170605220	SANTA ROSA DE SINGU¥A CALLE A		04/07/2014	15/02/2013
1702627934	1702627934	GUERRA PINO JAIME MARCELO	1	MASCULINO	7	FALLECIDO	01/01/1950	170605410	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	J09	JUBILADO	GRACIELA ISABEL SANTANA V			0	GUERRA MARCOS CRISTOBAL	239		PINO AIDA	239		16/02/2004	51005555	51005555	51106000	SUCRE	01844	18/12/2012	09/02/2004
1702434745	1702434745	ROCA ESPINOZA GLORIA EVA	2	FEMENINO	7	FALLECIDO	01/01/1950	21705975	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	MANUEL RIVAS			0	MANUEL ROCA	239		NATIVIDAD ESPINOZA	239		28/12/2001	134405795	134405795	134405280	VIA A CRUCITA	00000	04/05/2004	25/08/1994
1703203941	1703203941	NICOLALDE MANUEL MESIAS	1	MASCULINO	7	FALLECIDO	01/01/1950	170602980	239	ECUATORIANA	2	CASADO	10	PRIMARIA	J05	JORNALERO	BELLA MARIA FLORES LEON		15/01/1983	170602980	**********	0		DOMITILA NICOLALDE	239		17/02/1999	170602980	170602980	170602980	ANEJO COYAGAL	00000	24/07/2002	14/12/1994
1703361525	1703361525	FARINANGO CHAVEZ LUIS ALFONSO	1	MASCULINO	7	FALLECIDO	01/01/1950	170605410	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A28	ALBANIL	ROSA GUALA			0	FARINANGO PEDRO	239		CHAVEZ MARIA JUANA	239		05/01/2008	170605110	170606020	170605220	COMITE DEL PUEBLO ZONA 5	20	21/12/2012	23/03/2006
1703306447	1703306447	QUELAL ARMAS LAURO LIZARDO	1	MASCULINO	7	FALLECIDO	01/01/1950	40256520	239	ECUATORIANA	3	DIVORCIADO	4	BACHILLER	A24	AGRICULTOR		0		0	QUELAL LIZARDO	239	1702418458	ARMAS ROSA L	239	1706234919	26/09/2013	230856065	230856065	230856180	SN	SN	27/09/2013	03/05/2012
1703622926	1703622926	GAONA QUEVEDO FRANCISCO ROGELIO	1	MASCULINO	7	FALLECIDO	01/01/1950	117406260	239	ECUATORIANA	2	CASADO	0	NINGUNA	A24	AGRICULTOR	EVA VICENTE			0	EMILIANO GAONA	239		MATILDE QUEVEDO	239		09/04/2001	216251330	216251330	216255710		00000	01/08/2002	19/11/1993
1703647626	1703647626	VIRACOCHA YANEZ CARLOS HUMBERTO	1	MASCULINO	7	FALLECIDO	01/01/1950	51003530	239	ECUATORIANA	2	CASADO	10	PRIMARIA	E13	EMPLEADO	GARCIA MARIANA MARIA	1705417861	07/03/1979	170605410	VIRACOCHA ABELARDO	239	0	YANEZ ROSA ZOILA	239	0	01/06/2010	170605235	170605235	170605220	CDLA RUMINAHUI	00000	16/11/2012	24/10/2000
1703454122	1703454122	NOBOA NELSON EDMUNDO	1	MASCULINO	7	FALLECIDO	01/01/1950	170605410	239	ECUATORIANA	2	CASADO	3	BASICA	E13	EMPLEADO	SIMBA ROSA ELVIRA	1702509900		0	********************	0	0	NOBOA MARIA	239	0	27/04/2016	170605260	170607230	170607255	TURUBAMBA		28/04/2016	07/05/2011
1400071153	1400071153	PUANCHERA YANAPI MARIA	2	FEMENINO	7	FALLECIDO	01/01/1950	146150155	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	MANUEL TANGAMASH			0	NATALE PUANCHERA	239		NUNGAIME YANAPI	239		10/06/2011	147956390	147956390	146150155	ARAPICOS	00000	14/03/2013	13/02/2006
1309398996	1309398996	DIAZ ROSERO LEONIDAS OLMEDO	1	MASCULINO	7	FALLECIDO	01/01/1950	132305480	239	ECUATORIANA	2	CASADO	0	NINGUNA	J05	JORNALERO	QUIROZ ROSA MATILDE	0	30/11/2005	135005300	******************************	0	0	******************************	0	0	14/10/2013	135005300	135005300	135005300	ST RIO DE ORO	00000	22/10/2013	20/09/2005
1600072704	1600072704	PAVON AGUAYO LUIS ENRIQUE	1	MASCULINO	7	FALLECIDO	01/01/1950	145905615	239	ECUATORIANA	2	CASADO	10	PRIMARIA	M44	MILITAR SERV. PASIVO	MARIA EMMA SAGUAY GUAMAN	0	05/09/1985	166805825	SERGIO OLMEDO PAVON	239	0	AIDA MARIA AGUAYO	239	0	29/12/2015	170607175	170607250	166805825	COTOPAXI Y A VALLADARES	00000	30/12/2015	19/05/2011
1302013949	1302013949	BARCIA RODRIGUEZ CONSUELO AMADA	2	FEMENINO	7	FALLECIDO	01/01/1950	134555485	239	ECUATORIANA	2	CASADO	30	SUPERIOR	E30	ESTUDIANTE	VICENTE LOPEZ	1151252887		0	ULBANCE D BARCIA	239	0	CLORINDA RODRIGUEZ	239	0	20/06/2011	134405795	134405795	134405280	VILLAS DEL IESS 3RA TRANS	00010	04/08/2011	29/09/2000
1302336860	1302336860	ESPINALES LOZADA MANUEL EUGENIO	1	MASCULINO	7	FALLECIDO	01/01/1950	134505635	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	E01	EBANISTA	MARGARITA LOPEZ			0	JOSE ESPINALES	239		BLANCA LOZADA	239		26/03/1993	134505635	134505635	134505635	CORDOVA	00000	02/08/2002	25/05/1993
1301896195	1301896195	SOLORZANO CASANOVA VICENTE JOSE	1	MASCULINO	7	FALLECIDO	01/01/1950	134400010	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A28	ALBANIL				0	JOSE SOLORZANO	239		ROSA CASANOVA	239		18/01/2001	134400010	134400010	134400010	ST PIMPIGUASI	00000	28/07/2004	15/11/1991
1302772031	1302772031	SANCHEZ JESUS GONZALO	1	MASCULINO	7	FALLECIDO	01/01/1950	134550105	239	ECUATORIANA	1	SOLTERO	1	ELEMENTAL	A24	AGRICULTOR				0	NICANOR SANCHEZ	239		**********	0		02/10/2010	230856065	230856065	129456465	BUENA FE	00000	08/10/2010	26/09/2008
1302932940	1302932940	HIDROVO UBILLUS LUIS UDALGO	1	MASCULINO	7	FALLECIDO	01/01/1950	134655885	239	ECUATORIANA	1	SOLTERO	3	BASICA	A24	AGRICULTOR		0		0	HIDROVO LUIS	239	0	UBILLUS ROSA	239	0	05/09/2016	129450150	129456465	230855730	PATRICIA PILAR		06/09/2016	24/08/2012
1302869183	1302869183	MARCILLO PIN LUZ AMERICA	2	FEMENINO	7	FALLECIDO	01/01/1950	134803350	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	C47	COSTURERA/O				0	ADOLFO MARCILLO	239		ROSA PIN	239		28/05/2012	134805250	134805250	134805250	X	00000	29/05/2012	27/02/2003
1303714818	1303714818	FIGUEROA CEDENO JOSEFA LUISA	2	FEMENINO	7	FALLECIDO	01/01/1950	134805250	239	ECUATORIANA	2	CASADO	1	ELEMENTAL	Q05	QUEHACER. DOMESTICOS	OLMEDO CESILIO SOLORZANO V		10/03/1983	134805250	JULIO FIGUEROA	239		MARIA CEDENO	239		11/07/2012	134805250	134805250	134805250	PICHINCHA Y ROCAFUERTE	00000	12/07/2012	25/07/2005
1304191693	1304191693	GARCIA MOREIRA TITO NELO	1	MASCULINO	7	FALLECIDO	01/01/1950	134905505	239	ECUATORIANA	1	SOLTERO	1	ELEMENTAL	J05	JORNALERO				0	ALEJANDRO GARCIA	239		CELINDA MOREIRA	239		21/07/2002	93856225	93856225	134905505	10 DE AGOSTO	00000	12/09/2003	20/04/2000
0400379970	400379970	ERAZO LUNA SEGUNDO LUIS	1	MASCULINO	7	FALLECIDO	01/01/1951	40056165	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	C27	CHOFER PROFESIONAL	JUDITH VILLARREAL	0		0	SEGUNDO ERAZO	239	0	BLANCA LUNA	239	0	25/11/1992	40056165	40056165	40055415	VENEZUELA	00020	11/09/2014	09/02/1993
0904659059	904659059	MORA ZAMBRANO MANUEL MELSIADE	1	MASCULINO	7	FALLECIDO	01/01/1951	134855150	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR				0	AGUSTIN MORA	239		LORENZA ZAMBRANO	239		25/03/1987	0	93856225	94155100	BALZAR	00000		15/02/1990
0500593348	500593348	LASINQUIZA PASTUÑA CESAR	1	MASCULINO	7	FALLECIDO	01/01/1951	51052865	239	ECUATORIANA	4	VIUDO	1	ELEMENTAL	A24	AGRICULTOR	MARIA JUANA GUANOTUÑA	0500593355	15/02/1976	51055820	JOSE LASINQUIZA	239	0	MARIA ROSA PASTUÑA	239	0	04/10/2014	51054365	51054365	51052865	CENTRO	00000	15/10/2014	19/11/2012
0904672110	904672110	VALVERDE ESPINOZA EUGENIO	1	MASCULINO	7	FALLECIDO	01/01/1951	134755095	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C36	COMERCIANTE				0	FELIX VALVERDE	239		FANNY ESPINOZA	239		31/10/1997	125405855	125405855	85605335	JUAN MONTALVO Y SUCRE	00000	25/07/2002	25/07/1996
0601237365	601237365	SAYAY LEMA MARIA SALVADORA	2	FEMENINO	7	FALLECIDO	01/01/1951	62105430	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	PEDRO NAULA			0	TORIBIO SAYAY	239		MANUELA LEMA	239		09/11/1993	62154030	62154030	62154030	ANEJO SHACON	00000	30/07/2002	22/11/1993
0904571155	904571155	QUIÑONEZ SIMISTERRA ELBA CENOVA	2	FEMENINO	7	FALLECIDO	01/01/1951	32356845	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C47	COSTURERA/O				0	EUDOFILIO QUIÑONEZ	239		EDITH SIMISTERRA	239		13/05/2010	93905170	93906150	93905585	CRISTOBAL COLON	02419	14/05/2010	02/06/1982
0601318140	601318140	YUPA PADILLA MARIA ALCIRA	2	FEMENINO	7	FALLECIDO	01/01/1951	62205255	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	LUIS ALFREDO GUEVARA			0	RUBEN YUPA	239		MARIA ROSA PADILLA	239		27/06/2010	61955590	68306540	68306540	ASC OLIVO	00000	19/11/2011	11/10/2006
0904574480	904574480	VELEZ CEDEÑO GLADYS MONSERRATE	2	FEMENINO	7	FALLECIDO	01/01/1951	134655885	239	ECUATORIANA	3	DIVORCIADO	3	BASICA	Q05	QUEHACER. DOMESTICOS			17/02/1977	93905170	ISIDRO VELEZ	239		HERMINIA CEDEÑO	239		02/09/2013	93906265	93906150	93905125	6 DE MARZO Y BRASIL	15	03/09/2013	10/12/2012
0601489958	601489958	QUISHPI GUASHPA JOSE MARIA	1	MASCULINO	7	FALLECIDO	01/01/1951	61952165	239	ECUATORIANA	2	CASADO	0	NINGUNA	A24	AGRICULTOR	MARIA NAULA	0		0	RAFAEL QUISHPI	239	0	MARIA GUASHPA	239	0	07/10/2014	61956230	61955590	61952165	COMUNA BANDERAS	00000	08/10/2014	08/03/2010
0904575263	904575263	ARANA NAVAS CARMEN ROSA	2	FEMENINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	4	VIUDO	4	BACHILLER	M22	MODISTA	PINTO BERMEO DANCIEL VICENTE	0	19/06/1979	93905170	ARANA JOSE	239	0	NAVAS MARIA	239	0	22/12/2014	93905170	93906150	93905380	MARACAIBO Y TULCAN	02023	24/12/2014	02/04/2014
0500664354	500664354	VILCA TOAPANTA ROSA	2	FEMENINO	7	FALLECIDO	01/01/1951	51001485	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	MANUEL ALMACHI PUCO	0	08/04/1972	51001485	BASILIO VILCA	239	0	RAMONA TOAPANTA	239	0	03/10/2017	51001485	51005555	51001485	BR CENTRO	00000	04/10/2017	03/09/2009
0904567559	904567559	VALVERDE ALEJANDRO	1	MASCULINO	7	FALLECIDO	01/01/1951	91255365	239	ECUATORIANA	1	SOLTERO	3	BASICA	C36	COMERCIANTE		0		0	******************************	0	0	VALVERDE PETITA	239	0	16/10/2015	93905355	93906150	93905355	LA 29 Y M		19/10/2015	05/05/2011
0951006303	951006303	COLOMA MORAN NELSON ODILON	1	MASCULINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	N00	NINGUNA				0	LUIS FELIPE COLOMA MACIAS	239	0902077759	LOLA MORAN BANCHON	239		26/08/2012	93906150	93906150	93905380	MACHALA Y MARACAIBO	115	27/08/2012	12/08/2010
0904521366	904521366	GRANDA RAMOS AMANDINO	1	MASCULINO	7	FALLECIDO	01/01/1951	97900660	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR		0		0	JOSE MANUEL GRANDA	239	0	EUFEMIA RAMOS	239	0	25/11/2014	94205660	94205660	97900660	PRINCIPAL	00000	26/11/2014	23/01/2012
1000453850	1000453850	CACUANGO TORRES JUAN MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1951	100353590	239	ECUATORIANA	2	CASADO	0	NINGUNA	J05	JORNALERO	MARIA OLIMPIA CACUANGO			0	VIDAL CACUANGO	239		ROSARIO TORRES	239		12/06/2008	170605235	100353590	100353590	PUNTO ANGLA UCSHA PAMBA	00000	03/07/2008	20/12/1976
0904748506	904748506	GONZALEZ BALON MARTHA ESTHER	2	FEMENINO	7	FALLECIDO	01/01/1951	244055920	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	GONZALEZ PANCHANA DAVID CESAR	239		BALON PANCHANA ARMANDA ESTHER	239		17/07/2000	94353740	244055920	244055920	CENTRAL	00000	31/10/2012	17/01/1999
1000566404	1000566404	CABASCANGO TOCAGON JULIO AUGUSTO	1	MASCULINO	7	FALLECIDO	01/01/1951	100351360	239	ECUATORIANA	2	CASADO	10	PRIMARIA	J05	JORNALERO	MARIA JUANA ANRANGO			0	RAIMUNDO CABASCANGO	239		MARIA ALEGRIA TOCAGON	239		31/03/1991	100351360	100351360	100351360	PUNTO GUALACATA	00000	28/07/2002	22/04/1991
0905167771	905167771	CAÑARTE CASTRO CARLOS ALFREDO	1	MASCULINO	7	FALLECIDO	01/01/1951	134555485	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	P05	PANADERO				0	JORGE CAÑARTE	239		ISABEL CASTRO	239		25/05/2012	93906150	93906150	93906265	GUASMO	00132	26/05/2012	13/10/2008
0602081101	602081101	PUCHA PUCHA ELENA	2	FEMENINO	7	FALLECIDO	01/01/1951	62056080	239	ECUATORIANA	4	VIUDO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	NICOLAS ASACATA			0	DAMACIO PUCHA	239		JOSEFA PUCHA	239		18/12/2004	62055145	62055145	62056080	COMUNA CUYUSTUS	00000	27/09/2005	22/12/1999
0904031044	904031044	ROMERO BUESTAN JAIME ENRIQUE	1	MASCULINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	M12	MECANICO AUTOMOTRIZ				0	JAIME ROMERO	239		LUISA BUESTAN	239		13/11/2010	93905695	93906150	93905380	SN	00000	14/11/2010	09/02/2001
0918292970	918292970	ALEJANDRO QUINDE MARTINIANO PEDRO	1	MASCULINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	ISIDRO ALEJANDRO	239		ALEJANDRINA QUINDE	239		09/11/2004	93905170	93902470	93902470	BARRIO SAN PEDRO	00000	06/10/2005	30/06/1995
0904155496	904155496	RIVERA ERAZO ANGELA DE JESUS	2	FEMENINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS		0		0	**********	0	0	**********	0	0	22/04/2011	93906150	93906150	93906265	ESMERALDAS CHIQUITA MZ B10	00012	24/04/2011	10/09/2008
0800649261	800649261	MOSQUERA CEDENO MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1951	138406550	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	**********	0		EMILIANA CEDENO	239		09/09/1997	230856065	85755895	230856065	RCTO LA VIRGENCITA RIO QUININD	00000	22/07/2002	06/11/1997
0904142262	904142262	SANCHEZ AVILEZ DORA EUFROCINA	2	FEMENINO	7	FALLECIDO	01/01/1951	125305800	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS		0		0	SERAFIN SANCHEZ	239	0	FIDELA AVILEZ	239	0	27/07/2013	97155735	97155735	93906265	CHILE Y BOLIVIA	03113	02/08/2013	20/09/2006
0800331647	800331647	CASTILLO MORALES MADIS MARTINA	2	FEMENINO	7	FALLECIDO	01/01/1951	85603940	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C47	COSTURERA/O		0		0	ALBERTO CASTILLO	239	0	ANITA MORALES	239	0	01/01/2013	85605210	85605335	85605210	BR LAS AMERICAS	00000	02/01/2013	07/11/2000
0903918571	903918571	CARREÑO ARAUJO WALTER HUGO	1	MASCULINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	M12	MECANICO AUTOMOTRIZ				0	MIGUEL CARRENO	239		TERESA ARAUJO	239		11/09/2000	230856065	230856065	93905170	PIEDRAHITA	00000	29/07/2004	29/11/1993
0800495707	800495707	SARANGO JAPON JOSE NELSON	1	MASCULINO	7	FALLECIDO	01/01/1951	113305005	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	C27	CHOFER PROFESIONAL				0	LIODOMIRO SARANGO	239		ROSA JAPON	239		14/11/2007	230856065	230856065	230856180	COOP 30 DE JULIO SECTOR N 2	00000	24/10/2008	09/02/2004
0906836093	906836093	SALAZAR MORAN CARLOS ALBERTO	1	MASCULINO	7	FALLECIDO	01/01/1951	134455665	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR				0	FROILAN SALAZAR	239		ERNESTINA MORAN	239		19/04/2012	93905170	97155735	97155735	P CARBO	00000	15/05/2012	18/09/2007
0800458937	800458937	REINA COTERA FRANCISCO TEODORO	1	MASCULINO	7	FALLECIDO	01/01/1951	85700355	239	ECUATORIANA	2	CASADO	10	PRIMARIA	P19	PESCADOR	EDIT VICTORIA GONZALEZ GUAGUA		03/11/1975	85705670	FRANCISCO REINA	239		LICENIA COTERA	239		09/01/2008	85705670	85705670	85705670	BR STA ROSA	00000	20/07/2012	09/09/2004
0903362408	903362408	BANCHON YAMUCA JACINTO GENARO	1	MASCULINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C36	COMERCIANTE	MUÑOZ GALIS			0	BANCHON REMIGIO	239		YAMUCA MARIA	239		01/01/2007	93905355	93906150	93905355	34 Y FEBRES CORDERO	00000	16/01/2007	25/11/2003
1200491429	1200491429	VERA MORAN JESUS GUADALUPE	2	FEMENINO	7	FALLECIDO	01/01/1951	125456235	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	RICARDO VERA	239		HERACLIA MORAN	239		20/06/1991	93905170	93905170	125456235	RCTO MONTES DE AGUA	00000	20/12/2004	22/10/1991
1301475545	1301475545	VINCES SANTANA CARLOS LEONIDAS	1	MASCULINO	7	FALLECIDO	01/01/1951	134405795	239	ECUATORIANA	2	CASADO	4	BACHILLER	E13	EMPLEADO	CAMPOVERDE YOLANDA	0101537918		0	VINCES ALEJANDRO	239	1300137856	SANTANA AURA	239	1301147383	22/09/2014	12606090	12605930	12605140	AV GONZALEZ SUSAREZ AV AMERICA	SN	22/09/2014	09/06/2014
1200574927	1200574927	MARTINEZ CEPEDA MARTINIANO NARCISO	1	MASCULINO	7	FALLECIDO	01/01/1951	93956285	239	ECUATORIANA	1	SOLTERO	1	ELEMENTAL	A24	AGRICULTOR				0	FROILAN MARTINEZ	239		VICTORIA CEPEDA	239		29/08/1981	0	98356545	98356545	HDA NAUZA	00000		27/11/1996
1301598684	1301598684	GUILLEN GARCIA AUGUSTA SOLEDAD	2	FEMENINO	7	FALLECIDO	01/01/1951	134405795	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	Q05	QUEHACER. DOMESTICOS	RAMON GILBERTO MACIAS MOREIRA	0	11/01/1971	134405795	MIGUEL GUILLEN	239	0	MARTINA GARCIA	239	0	06/09/1999	134405795	134405795	134506155	VIA MANTA PORTOVIEJO	00000	19/05/2014	07/10/1999
1101081360	1101081360	CHAMBA DIAZ ELVIA MARIA	2	FEMENINO	7	FALLECIDO	01/01/1951	113105180	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	M22	MODISTA				0	MANUEL I CHAMBA	239		ROSA A DIAZ	239		14/12/2001	113105180	113105180	113105180	COTOGCHOA	00000	22/07/2002	01/11/1983
0700709470	700709470	POLO SOLANO BLANCA ESTELA	2	FEMENINO	7	FALLECIDO	01/01/1951	73655770	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	C47	COSTURERA/O	ERNESTO VERA	0		0	CESAR POLO	239	0	BLANCA SOLANO	239	0	23/06/2016	93905355	93905890	93905355	LA 23 AVA Y COLOMBIA	00000	28/06/2016	29/05/2003
1101087417	1101087417	CHAMBA DIAZ NATIVIDAD	2	FEMENINO	7	FALLECIDO	01/01/1951	113100485	239	ECUATORIANA	2	CASADO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS	ELIO VILLAFUERTE			0	BENITO CHAMBA	239		DOMINGA DIAZ	239		09/10/1983	113100485	113100485	113100485		00000	21/05/2004	02/06/1982
0700753171	700753171	FERNANDEZ CHAMBA GABRIELA NOEMI	2	FEMENINO	7	FALLECIDO	01/01/1951	112903610	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C47	COSTURERA/O	PEDRO AGUILAR			0	ARSENIO FERNANDEZ	239		ROSARIO CHAMBA	239		18/02/2011	73505625	73505625	73505625	COLON Y JOSE MADERO VARGAS	00000	20/05/2011	02/07/2007
1101044285	1101044285	JUMBO CALDERON MARTINA YOLANDA	2	FEMENINO	7	FALLECIDO	01/01/1951	113153535	239	ECUATORIANA	2	CASADO	10	PRIMARIA	M22	MODISTA	SANTOS SERVILIO ERIQUE CHAMBA	0		0	MEDARDO JUMBO	239	0	EULALIA CALDERON	239	0	08/02/2016	113305005	61955590	113153535	BR MISAMA	00000	20/02/2016	18/07/2003
0901809905	901809905	ALCIVAR MAGALLANES VIENTE A	1	MASCULINO	7	FALLECIDO	01/01/1951	125456235	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E13	EMPLEADO				0	GREGORIO ORTIZ	239		ESTHER LOOR	239		27/07/1967	93905170	93905170	93905890	C BALLEN	00821	17/06/2004	15/01/1982
1100601002	1100601002	JAPON GUALAN MANUEL MARIA	1	MASCULINO	7	FALLECIDO	01/01/1951	113053600	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	MARIA ALEGRIA AMBULUDI L			0	JOSE MARIA JAPON	239		CLEMENTINA GUALAN	239		01/07/1999	113006015	113006015	113053600	TENTA SARAGURO	00000	12/01/2009	28/09/1999
0901082438	901082438	PEREZ CASTILLO ZENEN ISMAEL	1	MASCULINO	7	FALLECIDO	01/01/1951	91255365	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	C36	COMERCIANTE				0	ANGEL PEREZ	239		GREGORIA CASTILLO	239		24/02/1999	93905170	93905170	93905355	37 Y R AVILES	00000	19/07/2002	06/03/1999
1100653409	1100653409	RODRIGUEZ HIDALGO FAVIAN HUMBERTO	1	MASCULINO	7	FALLECIDO	01/01/1951	113255680	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E30	ESTUDIANTE				0	FRANCISCO RODRIGUEZ	239		CARMEN HIDALGO	239			0	0	113255385	BR SAN SEBASTIAN	00000		02/06/1982
0901123018	901123018	VERA LINDAO MARTIN	1	MASCULINO	7	FALLECIDO	01/01/1951	97356255	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A28	ALBANIL				0	FELIX JULIAN VERA	239		SOFIA LINDAO	239		16/08/2010	93906150	93906150	97356255	PLAYAS	00180	17/08/2010	07/07/2006
1000646685	1000646685	AGUIRRE AGUIRRE JORGE RODRIGO	1	MASCULINO	7	FALLECIDO	01/01/1951	100305915	239	ECUATORIANA	2	CASADO	4	BACHILLER	C27	CHOFER PROFESIONAL	QUINTANA MARIA HORTENCIA	1001013968	02/08/1976	100305915	AGUIRRE ALONSO	239	1000017903	AGUIRRE MARIA LUCILA	239	1000351641	17/11/2015	170607130	170607250	100305165	BARTOLOME GARCIA	825	17/11/2015	16/09/2015
0901293563	901293563	SIERRA MORENO JOSEFINA SARA	2	FEMENINO	7	FALLECIDO	01/01/1951	93905170	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS				0	CARLOS SIERRA	239		SARA MORENO	239		20/01/2004	93906265	93905170	93905585	LA 11 Y LA B	00000	02/06/2004	21/04/1999
1705404992	1705404992	GUACHILEMA COBA LOURDES EUFEMIA	2	FEMENINO	7	FALLECIDO	01/01/1951	62003295	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	C47	COSTURERA/O				0	VICTOR GUACHILEMA	239		AMELIA COBA	239		10/05/2006	170605220	170605110	170605220	AV MARISCAL SUCRE Y LEGARA N	345	15/05/2006	29/04/2004
0200384907	200384907	GAIBOR GAIBOR MARGOTH SULEMA	2	FEMENINO	7	FALLECIDO	01/01/1951	21755995	239	ECUATORIANA	1	SOLTERO	30	SUPERIOR	P78	PROFESOR EDUC.PRIMAR				0	ABRAHAM GAIBOR	239		CARMEN GAIBOR	239		09/06/2007	170605410	21755995	21755995	AV DEL HOSPITAL	00000	29/06/2007	27/09/2002
1202354690	1202354690	MORALES UGARDO APOLINAR	1	MASCULINO	7	FALLECIDO	01/01/1951	134706030	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	LIZARDO MORALES	239		************	0		27/02/2010	94155100	94155100	125405855	CAMILO AREVALO	00000	14/04/2010	28/08/1984
0100946490	100946490	CARRION ALVAREZ JAIME MARCELO	1	MASCULINO	7	FALLECIDO	01/01/1951	12605905	239	ECUATORIANA	2	CASADO	30	SUPERIOR	E30	ESTUDIANTE	MARTHA ISABEL ASTUDILLO COBOS		23/09/1976	12605905	ENRIQUE CARRION	239		LUZ N ALVAREZ	239		06/01/1993	12605450	12605905	12605875	TARQUI	06107	29/06/2002	20/01/1993
1801385228	1801385228	SUPE PALATE JUAN AGUSTIN	1	MASCULINO	7	FALLECIDO	01/01/1951	181352830	239	ECUATORIANA	2	CASADO	0	NINGUNA	A24	AGRICULTOR	MARIA TRANSITO CHACHA MORETA		07/05/1976	181352830	JOSE SUPE	239		ROSARIO PALATE	239		11/03/2008	181352775	181352830	181352830	CR SAN JUAN	00000	15/09/2012	02/10/1991
0101026987	101026987	MEJIA CHICAIZA MANUEL EUGENIO	1	MASCULINO	7	FALLECIDO	01/01/1951	12606090	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	C27	CHOFER PROFESIONAL	MARIA JESUS CRESPO CRIOLLO	0	17/06/1976	12605905	ALFONSO MEJIA	239	0	MERCEDES CHICAIZA	239	0	20/11/2013	12606090	12605930	12606090	AV DON BOSCO	00000	22/11/2013	30/12/2008
1800994822	1800994822	CHACHA MORETA JUAN SERAFIN	1	MASCULINO	7	FALLECIDO	01/01/1951	181351745	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	MARIA CAGUANA			0	LEONARDO CHACHA	239		ROSA MORETA	239		25/10/1998	181351745	181351745	181351745	CAMPO DE AVIACION	00000	01/08/2002	11/12/1998
0101326783	101326783	TORRES PESANTEZ JOSE MIGUEL	1	MASCULINO	7	FALLECIDO	01/01/1951	12603105	239	ECUATORIANA	4	VIUDO	10	PRIMARIA	J05	JORNALERO	LUZ MARIA MORA ORDOÑEZ	0	21/08/1978	12605905	VICENTE TORRES	239	0	JOSEFINA PESANTEZ	239	0	14/09/2014	12605450	12605450	12605330	TOMAS ORDO¥EZ	04185	15/09/2014	10/04/2007
1800847095	1800847095	GOMEZ ZAMORA JORGE HUMBERTO	1	MASCULINO	7	FALLECIDO	01/01/1951	181405780	239	ECUATORIANA	2	CASADO	30	SUPERIOR	MU1	MAG.DER.PENAL.CRIMIN	YOLANDA CONSUELO FIORAVANTI AVILA	0905608915		0	HUMBERTO GOMEZ	239	0	MARIA ZAMORA	239	0	12/09/2013	93905170	93906150	93905380	CHAMBERS		13/09/2013	20/08/2011
0600855589	600855589	AUCANCELA SORIA LUIS ALBERTO	1	MASCULINO	7	FALLECIDO	01/01/1951	61952165	239	ECUATORIANA	2	CASADO	10	PRIMARIA	S03	SASTRE	YAMBAY BONIFAZ CARMEN ELVIRA	0601121197	16/07/1973	61952165	ANGEL AUCANCELA	239	0	MARGARITA SORIA	239	0	04/03/2014	93905355	93906150	61952165	PRIN	00000	13/03/2014	17/02/2013
1800161125	1800161125	VARGAS MAYORGA MARIO ALBERTO	1	MASCULINO	7	FALLECIDO	01/01/1951	181355545	239	ECUATORIANA	2	CASADO	30	SUPERIOR	A39	ARQUITECTO	ANA FABIOLA MANILLA			0	CARLOS LEON VARGAS	239		ROSANA MAYORGA	239		19/03/1996	181355545	181355545	181355945	MARIETA DE VEINTIMILLA	00752	21/07/2002	19/03/1996
0600818330	600818330	TENEMAZA CASTILLO LUIS ANIBAL	1	MASCULINO	7	FALLECIDO	01/01/1951	61953035	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	C27	CHOFER PROFESIONAL	MARIA PONCE			0	MARCO TENEMAZA	239		ROSA CASTILLO	239		13/03/1995	61953035	61953035	61953035	PUNGALA	00000	29/07/2002	05/05/1995
0600816185	600816185	RODRIGUEZ CHILUIZA EDGAR FAUSTO	1	MASCULINO	7	FALLECIDO	01/01/1951	61955590	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	J06	JOYERO				0	BENJAMIN RODRIGUEZ	239		CRISTINA CHILUIZA	239		13/12/1995	61955590	61955590	62051865	NUEVA YORK	02908	29/07/2002	03/01/1996
0600223838	600223838	CARRASCO TIERRA DANIEL	1	MASCULINO	7	FALLECIDO	01/01/1951	62005550	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Z01	ZAPATERO	MARTHA GUILCAPI	0		0	DAVID CARRASCO	239	0	CARMEN TIERRA	239	0	13/01/2007	61955630	61955590	62005550	GUANO	00000	21/02/2015	20/10/2004
0300516622	300516622	MOROCHO ROSA MAGDALENA	2	FEMENINO	7	FALLECIDO	01/01/1951	32352220	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	CARLOS HORACIO CALLE QUIZHPI		20/07/1982	32355065	**********	0		BLANCA MOROCHO	239		22/07/1997	145905615	145905615	145903440	SAN ISIDRO	00000	26/07/2002	06/08/1997
1306088913	1306088913	VENTURA CALDERON MARTINA OFROCINA	2	FEMENINO	7	FALLECIDO	01/01/1951	134552810	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	OSWALDO JOEL MARCILLO F		11/11/1951	134552810	JOSE VENTURA	239		VIRGINIA CALDERON	239		07/09/1990	0	134552810	134552810	SAN JACINTO	00000		11/10/1990
1301653430	1301653430	LOPEZ TUBAY JOASE MARIA DE LOURDES	1	MASCULINO	7	FALLECIDO	01/01/1951	134606105	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	M22	MODISTA				0	RUFINO LOPEZ	239		NATALIA TUBAY	239		20/10/2011	456	170605235	134606105	COMERCIO	00000	17/05/2012	06/09/2002
1302542483	1302542483	MEZA RENDON CARMEN DALINDA	2	FEMENINO	7	FALLECIDO	01/01/1951	134855150	239	ECUATORIANA	2	CASADO	1	ELEMENTAL	Q05	QUEHACER. DOMESTICOS	VELASQUEZ C OMAR JUVENTINO	0	22/12/1976	138406550	MEZA JOSE	239	0	RENDON JUANA	239	0	27/01/2014	94155100	94155100	93856225	RCTO SANTA TERESA		28/01/2014	24/11/2009
1302134877	1302134877	MENDOZA ZAMBRANO JOSE JACINTO	1	MASCULINO	7	FALLECIDO	01/01/1951	134400050	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A28	ALBANIL		0		0	JESUS MENDOZA	239	0	LUZ ZAMBRANO	239	0	21/09/2015	93856225	93856225	93856225	SALOME ESQUINA	00000	21/09/2015	04/10/2002
1600064552	1600064552	VILLACIS ESCOBAR MARIANA DE JESUS	2	FEMENINO	7	FALLECIDO	01/01/1951	166805825	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	P37	PROFESOR EN GENERAL	LUIS ANIBAL CARDENAS GRANDA		14/08/1982	166805825	VICTOR VILLACIS	239		MARIA ESCOBAR	239		26/10/2008	181355545	166805825	166805825	BR LA MERCED	00000	28/10/2008	03/01/1997
1600064941	1600064941	BASANTES HERRERA BOLIVAR SEGUNDO	1	MASCULINO	7	FALLECIDO	01/01/1951	166855650	239	ECUATORIANA	4	VIUDO	30	SUPERIOR	A26	AGRONOMO	MARTHA COLOMA DIAZ	0	15/03/1989	96755725	MAXIMILIANO BASANTES	239	0	MATILDE HERRERA	239	0	05/11/2014	93905055	93905890	166805825	BRR INTIPUNGO	00000	06/11/2014	27/10/2010
1703324705	1703324705	MOSQUERA RAMOS LUIS ALFREDO	1	MASCULINO	7	FALLECIDO	01/01/1951	170605220	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C27	CHOFER PROFESIONAL	CHASILIQUIN LOZA MARIA ADELA	1703687192	07/01/1972	170602925	REINALDO MOSQUERA	239	0	MARIA RAMOS	239	0	01/07/1995	170605220	170605410	170605220	MACHALA	00665	30/11/2012	03/02/1996
1703381895	1703381895	TOAZA CASTRO MANUEL ANTONIO	1	MASCULINO	7	FALLECIDO	01/01/1951	170605410	239	ECUATORIANA	2	CASADO	1	ELEMENTAL	A28	ALBANIL	ROSA E DIAZ			0	TOAZA JOSE	239		CASTRO MARIA	239		26/11/1986	170605410	170605410	170606050	LA GASCA	00390	11/03/2013	02/06/1982
1703331585	1703331585	REY LEON FRANCISCO ARTEMAN	1	MASCULINO	7	FALLECIDO	01/01/1951	113305005	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	M12	MECANICO AUTOMOTRIZ				0	ANGEL REY	239		CARMEN LEON	239		24/03/1994	100355490	170605410	170605260	.ENA 2 MZ D	00000	08/10/2004	04/03/1996
1703714285	1703714285	MOROCHO CHAMBA ELIVERIO	1	MASCULINO	7	FALLECIDO	01/01/1951	113153535	239	ECUATORIANA	2	CASADO	10	PRIMARIA	P30	POLICIA	PINTADO CABRERA GLADYS LEONOR	0701182131	02/01/1977	73650390	SEGUNDO MOROCHO	239	0	LINDOLFA CHAMBA	239	0	08/11/1992	73650390	73650390	73650390	BOLIVAR	00000	11/07/2014	17/12/1992
1703986487	1703986487	CHOLANGO JOSE MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1951	170650480	239	ECUATORIANA	2	CASADO	0	NINGUNA	J05	JORNALERO	MARIA AGUSTINA CAIZA		07/06/1983	170650480	**********	0		MARIA CHOLANGO	239		13/02/2009	170605410	170650480	170650480	CANGAHUA	00000	20/08/2010	11/10/2002
1705018107	1705018107	VALLADARES VINUEZA MARIANA CECILIA	2	FEMENINO	7	FALLECIDO	01/01/1951	170605410	239	ECUATORIANA	4	VIUDO	20	SECUNDARIA	E39	EMPLEADO PUBLICO	HUGO VICENTE LOAIZA OCAMPO	0		0	JORGE VALLADARES	239	0	ANA VINUEZA	239	0	03/08/2015	170607250	170607250	170606240	MALDONADO Y NAPO	00410	03/08/2015	20/09/2005
1705110656	1705110656	CEDEÑO CEDENO JOSE ELI	1	MASCULINO	7	FALLECIDO	01/01/1951	132305480	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	M12	MECANICO AUTOMOTRIZ				0	JOSE CEDENO	239		DALVA CEDENO	239		23/01/2004	230856065	230856065	85605210	BR RIO ESMERALDAS	00000	03/02/2004	03/01/1996
1703064210	1703064210	ALBUJA PEREZ VICTOR MANUEL	1	MASCULINO	7	FALLECIDO	01/01/1951	170705620	239	ECUATORIANA	2	CASADO	10	PRIMARIA	E13	EMPLEADO	ELIZABET M DE J RIVADENEIRA		03/04/1979	170605410	SEGUNDO ALBUJA	239		CARMEN PEREZ	239		05/03/2009	170606050	170606020	170606050	AMERICA Y RIO DE JANEIRO	17-31	13/03/2009	20/12/2007
1703037539	1703037539	TIPAN PULLUPAXI MARIA MAGDALENA	2	FEMENINO	7	FALLECIDO	01/01/1951	170605410	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	MELCHOR LEMA SANGUCHO			0	SEGUNDO S TIPAN	239		MARIA R PULLUPAXI	239		24/12/1989	170605410	170605410	170606240	SAN BARTOLO	00000	08/12/2004	20/05/1987
1202073399	1202073399	MARQUEZ GILER EVA MARGARITA	2	FEMENINO	7	FALLECIDO	01/01/1952	134655885	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	JULIO SEVERINO MARQUEZ			0	SEGUNDO MARQUEZ	239		MARY GILER	239		02/10/2003	129456465	129456465	125405855	RCTO PAMBILAR	0000	27/01/2014	10/12/1982
0300484003	300484003	TENEZACA BUNAY PEDRO MARIA	1	MASCULINO	7	FALLECIDO	01/01/1952	32405160	239	ECUATORIANA	2	CASADO	10	PRIMARIA	A24	AGRICULTOR	MARIA CAIZAN			0	ANTONIO TENEZACA	239		MARIA BUNAY	239		17/01/1990	32405160	32405160	32405160		00000	02/12/2004	05/03/1990
1202178479	1202178479	ELAJE MUNOZ ELADIO MARCOS	1	MASCULINO	7	FALLECIDO	01/01/1952	125156830	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	J05	JORNALERO				0	AMADO ELAJE	239		ANGELA MUNOZ	239		11/09/1988	0	125456235	125456235	CD 10 DE NOVIEMBRE	00000		30/11/1990
0300400736	300400736	SINCHE BARRIONUEVO INES VICTORIA	2	FEMENINO	7	FALLECIDO	01/01/1952	39056425	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	AGUSTIN MEDINA		04/05/1976	32355065	JULIO SINCHE	239		TRANSITO BARRIONUEVO	239		24/05/2002	12605450	12605905	32355065	LUIS CORDERO	00000	12/10/2010	02/06/1982
1201761887	1201761887	MENDOZA VILLACRES ANGEL ABEL	1	MASCULINO	7	FALLECIDO	01/01/1952	97900660	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	ANGEL MENDOZA	239		FLORA VILLACRES  PP DE NAC	239		21/07/1994	93905170	97906385	97906385	RCTO LIMONAL	00000	10/07/2002	11/03/1996
0600231393	600231393	CARRASCO GUAMAN JACINTO RICARDO	1	MASCULINO	7	FALLECIDO	01/01/1952	62005550	239	ECUATORIANA	2	CASADO	20	SECUNDARIA	C36	COMERCIANTE	PIEDAD MARIA LARA ISA		04/01/1974	62005550	ANTONIO CARRASCO	239		CARMEN GUAMAN	239		05/02/2005	62005550	62005550	62005550	SUCRE Y TCRONEL GENARO RICAURT	00779	18/01/2013	07/10/1996
1201463930	1201463930	PACHECO FAUSTO GERARDO	1	MASCULINO	7	FALLECIDO	01/01/1952	127105640	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	********	0		LEOBA PACHECO MOSQUERA	239		29/09/1989	127105640	127105640	127105640	MONTALVO	00000	22/09/2004	12/04/1991
0101046977	101046977	ALVAREZ GUERRERO SEGUNDO ALFONSO	1	MASCULINO	7	FALLECIDO	01/01/1952	12856045	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	A24	AGRICULTOR				0	ALFONSO ALVAREZ	239		ANA GUERRERO	239		05/06/1996	12605450	12605905	12856045		00000	29/07/2002	03/07/1996
1706306162	1706306162	BELTRAN RAMIREZ MANUELA	2	FEMENINO	7	FALLECIDO	01/01/1952	170605260	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	Q05	QUEHACER. DOMESTICOS		0		0	BELTRAN RAFAEL	239	0	RAMIREZ JOSEFINA	239	0	27/11/2010	170605260	170607170	170605260	BR EL ESPEJO	00000	29/11/2010	17/04/2007
0101013753	101013753	BERMEO BARBECHO MANUEL RIGOBERTO	1	MASCULINO	7	FALLECIDO	01/01/1952	12603870	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	J05	JORNALERO				0	JULIO CESAR BERMEO	239		JAVIERA MARIA BARBECHO	239		23/04/1988	93905170	93905170	12603870		00000	05/05/2004	05/05/1988
1709987729	1709987729	MONTENEGRO ENRIQUEZ MANUEL LEONIDAS	1	MASCULINO	7	FALLECIDO	01/01/1952	170601400	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	N00	NINGUNA				0	SEGUNDO R MONTENEGRO MEJIA	239		LUZ ENRIQUEZ	239		31/07/2000	40051885	40051885	40051885	JULIO ANDRADE	00000	30/07/2004	19/02/1986
0101932309	101932309	FAJARDO DURAZNO MARIA LAURA	2	FEMENINO	7	FALLECIDO	01/01/1952	12602430	239	ECUATORIANA	1	SOLTERO	0	NINGUNA	J05	JORNALERO				0	CRISTOBAL FAJARDO	239		MARIA DURAZNO	239		21/12/1989	12602430	12602430	12602430		00000	30/07/2002	21/02/1990
1000729796	1000729796	HERRERA ESPINOZA FAUSTO AURELIO	1	MASCULINO	7	FALLECIDO	01/01/1952	100404185	239	ECUATORIANA	2	CASADO	0	NINGUNA	A24	AGRICULTOR	MARIA ELOISA CHALA			0	SEFUNDO HERRERA	239		MARIA ESPINOZA	239		13/07/1981	170605410	170605410	170605220	SAN JOSE DE TEJAR	00000	09/08/2004	02/06/1982
0901092122	901092122	CRESPIN GONZABAY NATALIA YOLANDA	2	FEMENINO	7	FALLECIDO	01/01/1952	93905170	239	ECUATORIANA	2	CASADO	10	PRIMARIA	C47	COSTURERA/O	SAMUEL CRESPIN	0		0	PEDRO CRESPIN	239	0	ANA GONZABAY	239	0	12/05/2014	93905125	97356255	97356255	RCTO ARENAL	00000	12/05/2014	13/11/1984
1000728608	1000728608	HERRERIA ESPINOSA JORGE ANIBAL	1	MASCULINO	7	FALLECIDO	01/01/1952	100405910	239	ECUATORIANA	1	SOLTERO	10	PRIMARIA	J05	JORNALERO				0	SEGUNDO HERRERIA	239		MARIA ESPINOSA	239		27/11/2002	170600440	170605110	170605220	SAN CARLOS	00000	12/05/2004	29/04/1991
0901761528	901761528	SORIANO MENDOZA ADRIANA MARLENE	2	FEMENINO	7	FALLECIDO	01/01/1952	94355675	239	ECUATORIANA	2	CASADO	10	PRIMARIA	Q05	QUEHACER. DOMESTICOS	JOSE VALLADARES			0	NICOLAS SORIANO	239		ANGELA MENDOZA	239		22/03/1981	125405855	125405855	94353740	NARANJAL	00000	23/11/2004	02/06/1982
1000699999	1000699999	SANCHEZ FERNANDEZ DIGNA MARIA	2	FEMENINO	7	FALLECIDO	01/01/1952	100554080	239	ECUATORIANA	2	CASADO	3	BASICA	Q05	QUEHACER. DOMESTICOS	OBANDO LIZANDRO CONSTANTINO			0	SANCHEZ LUIS	239		FERNANDEZ ENCARNACION	239		12/11/2012	100303315	100303315	100303315	BARRIO LOS SOLES		14/12/2012	27/06/2011
0901494781	901494781	FLORES NAVARRO GREGORIA NATIVIDAD	2	FEMENINO	7	FALLECIDO	01/01/1952	97900660	239	ECUATORIANA	1	SOLTERO	1	ELEMENTAL	Q05	QUEHACER. DOMESTICOS				0	PEDRO FLORES	239		ESTHER NAVARRO	239		10/03/1978	0	97900660	98906410	HDA LA PACIENCIA	00000		19/02/1997
1000742179	1000742179	BURGA BURGA JOSE FERNANDO	1	MASCULINO	7	FALLECIDO	01/01/1952	100355490	239	ECUATORIANA	2	CASADO	10	PRIMARIA	J05	JORNALERO	MARIA BLANCA TABANGO		07/10/1980	100355490	JOSE MANUEL BURGA	239		ANGELA BURGA	239		01/09/1995	100453640	100355490	100355980	ATAHUALPA	00409	27/07/2002	11/01/1996
0700760366	700760366	PINEDA BARRIGA SEGUNDO GALO	1	MASCULINO	7	FALLECIDO	01/01/1952	76905850	239	ECUATORIANA	1	SOLTERO	20	SECUNDARIA	E30	ESTUDIANTE		0		0	JUAN PINEDA	239	0	ROSA BARRIGA	239	0	23/07/1970	113006100	113005320	76905850		00000	08/08/2017	28/02/1970
1000785525	1000785525	PILLAJO PURUNCAJAS JOSE MARIA	1	MASCULINO	7	FALLECIDO	01/01/1952	170655190	239	ECUATORIANA	2	CASADO	10	PRIMARIA	J05	JORNALERO	MARIA TIPANLUISA			0	ANDRES PILLAJO	239		JOAQUINA PURUNCAJAS	239		28/06/1993	170650480	170650480	170650480		00000	25/07/2002	20/05/1994
0700740384	700740384	MORENO ORTEGA CARMEN VICTORIA	2	FEMENINO	7	FALLECIDO	01/01/1952	73606310	239	ECUATORIANA	2	CASADO	30	SUPERIOR	L12	LICENCIADO	DIEGO GONZALO GALARZA			0	POLIBIO MORENO	239		MARIA ORTEGA	239		05/05/1977	170606050	170606050	170605220	URB SAN CARLOS	00000	19/03/2004	30/05/1977

*/




//https://trabajarporelmundo.org/7-trabajos-online-que-requieren-poca-o-ninguna-experiencia/
// apunters numeros 
//53 90 34 19 73 45 