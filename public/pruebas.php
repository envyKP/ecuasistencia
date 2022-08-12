<?php

require __DIR__.'/../vendor/autoload.php';


$input = 'sdsdsdsds';
$date = strtotime($input);
echo date('Y-m-d', $date);
echo date('Ymd')."\n";
$float_val = "1";
echo "numero : ";
$reemplazos1 = 0;
str_replace( ".", "", $float_val, $reemplazos1 );
echo (str_replace( ".", "", $float_val ));
$individual = array(
    'user_id' => 'Big',
);
$json = "{\"campo_1\":\"user_id\"}";
$mydata = json_decode($json,true);
echo  "variable null : ".(isset($mydata['campo_1'])? $mydata['campo_1'] : 'no hay');

echo  "pruebas con float  : ".$individual[$mydata['campo_1']];
 //echo ((float) $float_val);
