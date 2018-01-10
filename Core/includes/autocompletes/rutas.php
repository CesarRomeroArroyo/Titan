<?php require_once '../classes/consultaClass.php';

$ruta[0]= 'id';
$ruta[1]= 'nom_ruta';
$donde="nom_ruta LIKE '%" . $_GET['term']. "%'";

$SQL= consulta::seleccionar($ruta, 'logistic_route',$donde);

$consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nom_ruta']).'","label":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nom_ruta']).'","value":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nom_ruta']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
