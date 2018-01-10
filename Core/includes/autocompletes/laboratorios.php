<?php @session_start();
require_once '../classes/consultaClass.php';

//$dato=$_POST['nombre_texbox'];

$data=$_GET['term'];

    //$SQL= consulta::seleccionar($producto, 'general_products_services', $donde);

    $SQL="SELECT id, CONCAT(examen, \" - MUESTRA: \",muestra) as nombre FROM general_laboratorios WHERE examen LIKE '%" .$data. "%'";
    
    $consulta=consulta::ejecutar_consulta($SQL);
$retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","label":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","value":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    echo $cadena;    
?>

