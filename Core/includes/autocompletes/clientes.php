<?php require_once '../classes/consultaClass.php';

$data=$_GET['term'];
$SQL="SELECT num_ide as id, CONCAT(nombres, \" \",apellidos) as nombre FROM general_customer WHERE CONCAT(num_ide, \" \",nombres, \" \",apellidos) LIKE '%" .$data. "%'";
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

