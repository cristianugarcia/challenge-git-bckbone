<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodePostalController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function get($code=null)
    {

        $ruta_archivo = "insertaDocumento/";
        $nombre_archivo = "CPdescarga.txt";
        $direccion_completa = $ruta_archivo . $nombre_archivo;
        try {
            $lines = file($direccion_completa);
            $resultado = [];
            foreach ($lines as $key) {
                $key = $this->deleteTildes(utf8_encode($key)); 
                $str = explode('|', strtoupper($key));

                if ($str[0] == $code) { 
                    $resultado['zip_code'] = $str[0];
                    $resultado['locality'] = $str[5];

                    $resultado['federal_entity']['key'] = intval($str[7]);
                    $resultado['federal_entity']['name'] = $str[4];
                    $resultado['federal_entity']['code'] = (!$str[9])?null:$str[9];

                    $resultado['settlements']['key'] = intval($str[12]);
                    $resultado['settlements']['name'] = $str[1];
                    $resultado['settlements']['zone_type'] = $str[13];
                    $resultado['settlements']['settlement_type']['name'] = ucfirst(strtolower($str[2]));

                    $resultado['municipality']['key'] = intval($str[11]);
                    $resultado['municipality']['name'] = $str[3];

                    break;
                }
            }
            return json_encode($resultado);
        } catch (\Throwable $th) {
            echo "Tuvimos un problema al proporcionarte el servicio";
        }
    }

    public function deleteTildes($var = null)
    {

        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

        $key = strtr(utf8_decode($var), utf8_decode($originales), $modificadas);

        return utf8_encode($key);
    }
}
