<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function readFile()
    {
        $ruta_archivo="insertaDocumento/";
        $nombre_archivo = "CPdescarga.txt";
        $direccion_completa=$ruta_archivo.$nombre_archivo;


        
        
        //try {
        $lines = file($direccion_completa);
        $resultado=[];
        //file in to an array echo $lines[1]; //line 2
        foreach ($lines as $key) {
            $key=$this->quitTildes(utf8_encode($key)); //pa que tenga las tildes
            

            $str=explode('|',strtoupper($key));
            
            if ($str[0] == '01210') { //encontramos nuestra linea
                //echo "<br>Leído: " . ($key);
                $resultado['zip_code']=$str[0];
                $resultado['locality']=$str[5];
                
                $resultado['federal_entity']['key']=intval($str[7]);
                $resultado['federal_entity']['name']=$str[4];
                $resultado['federal_entity']['code']=(!$str[9])?null:$str[9];
                
                $resultado['settlements']['key']=intval($str[12]);
                $resultado['settlements']['name']=strtoupper($str[1]);
                $resultado['settlements']['zone_type']=$str[13];
                $resultado['settlements']['settlement_type']['name']=ucfirst(strtolower($str[2]));
                
                $resultado['municipality']['key']=intval($str[11]);
                $resultado['municipality']['name']=$str[3];
                
                break;    
            }
            
            
        }
        /* echo "<br>resultado final:<br>";
        print("<pre>".print_r($resultado,true)."<pre>");
        echo "<br>tipo:<br>";
        echo gettype($resultado);
        echo "<br>json:<br>"; */
        echo json_encode($resultado);
        
/* 
        } catch (\Throwable $th) {
            echo "Tuvimos un problema al intentar leer el archivo";
        } */

        
        //01000|San Ángel|Colonia|Álvaro Obregón|Ciudad de México|Ciudad de México|01001|09|01001||09|010|0001|Urbano|01
        
            

    }

    public function quitTildes( $var = null)
    {

        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        
        $key = strtr(utf8_decode($var), utf8_decode($originales), $modificadas);
        
        return utf8_encode($key);
    }
}
