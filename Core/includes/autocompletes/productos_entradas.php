<?php @session_start();
require_once '../classes/consultaClass.php';

//$dato=$_POST['nombre_texbox'];

$data=$_GET['term'];

    //$SQL= consulta::seleccionar($producto, 'general_products_services', $donde);

    $SQL="SELECT gps.id as id, CONCAT(gps.codigo, \" | \" , gps.nombre) as nombre 
          FROM general_products_services gps          
          WHERE CONCAT( gps.codigo, \" \", gps.nombre) LIKE '%" .$data. "%'";
    
    $consulta=consulta::ejecutar_consulta($SQL);
$retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","label":"'.$retorno[$i]['nombre'].'|'.str_replace("\"", "", $retorno[$i]['id']).'","value":"'.$retorno[$i]['nombre'].'|'.str_replace("\"", "", $retorno[$i]['id']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    echo $cadena;    
?>

