<?php

require __DIR__ . '/../vendor/autoload.php';


//$input = 'sdsdsdsds';
//$date = strtotime($input);
//echo date('Y-m-d', $date);
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


//bloque transformar texto cadena ordenar y sacar la primera pala de cada cadena
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
    ['user_id'=>'Coder 1', 'subject_id'=> 4096],
    ['user_id'=>'Coder 2', 'subject_id'=> 2048],
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


