<?php @session_start();
require_once '../classes/consultaClass.php';

//$dato=$_POST['nombre_texbox'];

$data=$_GET['term'];

    //$SQL= consulta::seleccionar($producto, 'general_products_services', $donde);

    $SQL="SELECT id, CONCAT(producto, \" - LABORATORIO: \",titular, \" - PRESENTACION: \", descripcionpresentacioncomercial, \" - VIA DE ADMINISTRACION: \",viaadministracion,\" - CONCENTRACION: \",cantidad_concentra,\" \",unidad) as nombre FROM general_medicamentos WHERE producto LIKE '%" .$data. "%'";
    
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

