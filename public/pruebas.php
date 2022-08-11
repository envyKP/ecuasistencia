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

$json = "{\"password\":\"abc123fo\"}";
$mydata = json_decode($json,true);
echo  "variable null : ".(isset($mydata['user_id'])? $mydata['user_id'] : 'no hay');
 //echo ((float) $float_val);
?>
