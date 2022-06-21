<?php


/*Se crea este controlador para funciones varias, de tipo utilitario */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EaBaseActiva;
use Closure;
use Batch;

require_once "../vendor/autoload.php";
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class EaUtilController extends Controller
{


    function quitar_tildes($cadena) {

        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);

        return $texto;
    }


    function is_valid_email($str)
    {
        //$result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
        //return $result;
        return (!preg_match(
            "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str))
                    ? FALSE : TRUE;

    }



    function encryptBaseActiva(){

        $userInstance = new EaBaseActiva;
        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);

       /*$coleccion = EaBaseActiva::where('id_sec', '>', 2000)
							     ->where('id_sec', '<=', 2001)
                                 ->orderBy('id_sec')
                                 ->get();

        foreach ($coleccion as $registro){

            $value = null;

            var_dump("registro: ".$registro->id_sec);

            $value = [
                [
                    'id_sec' => $registro->id_sec,
                    'tarjeta' => !empty($registro->tarjeta) ? Crypto::encrypt($registro->tarjeta, $clave) : '',
                    'cuenta' => !empty($registro->cuenta) ? Crypto::encrypt($registro->cuenta, $clave) :  '' ,
                ],

            ];


            $index = 'id_sec';
            Batch::update($userInstance, $value, $index);
        }*/


        $mensajeSecreto = "8493607700";
        $mensajeCifrado = 'def502005e0c2f1bd7aa5b1d6c2ee899d003e6b02964a693f4e0f02e2467f211e28a5b79460c789b807983e35495ddb034b4bcd0b137f699c72c95af9d6ff4794a0e0948dce20f6a75274d12ad9d3fdf0804c89ed234c481012d78b33368'; //Crypto::encrypt($mensajeSecreto, $clave);
        $mensajeOriginal = Crypto::decrypt($mensajeCifrado, $clave);
        dd($mensajeOriginal, $mensajeCifrado);

    }



}
