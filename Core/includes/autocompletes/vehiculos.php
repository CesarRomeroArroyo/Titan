<?php require_once '../classes/consultaClass.php';
    $cie[0]='id';
    $cie[1]='CONCAT(num_interno, " ", marca, " ", linea," ",placa) as nombre';
    $donde='CONCAT(num_interno, " ", marca, " ", linea," ",placa)'. "LIKE '%". $_GET['term']. "%' AND state='1'";
      
    $SQL= consulta::seleccionar($cie, 'logistic_vehicles', $donde);
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
