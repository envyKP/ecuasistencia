<?php

require __DIR__.'/../vendor/autoload.php';


$input = 'sdsdsdsds';
$date = strtotime($input);
echo date('Y-m-d', $date);
?>
