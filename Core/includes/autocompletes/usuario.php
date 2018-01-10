<?php require_once '../classes/consultaClass.php';


    $datos="*";
    $idUsuario = $_SESSION['datos_usuario']['iduser'];
    $donde="iduser =".$idUsuario;
    $sql = consulta::seleccionar($datos, "general_perfil_usuario",$donde);
    $consulta = consulta::ejecutar_consulta($sql);
    $usuario= consulta::convertir_a_array($consulta);

    $cie[0]='gu.num_ide';
    $cie[1]='CONCAT(gu.nombre, " ",gu.apellido)as nombre';
    
    if($usuario[0]['idperfil']==1)
    {          
          $donde="tipo='1' AND ".'CONCAT(gu.num_ide, " ",gu.nombre, " ", gu.apellido)'. "LIKE '%". $_GET['term']. "%'";
          $tabla="general_usuarios gu";
    }
    else
    {        
        $grado = $_SESSION['datos_usuario']['grado'];
        $grupo = $_SESSION['datos_usuario']['grupo'];        
        $tabla="general_usuarios as gu LEFT JOIN general_grupo as gp ON  gp.id_usuario = gu.num_ide ";
        $donde="gu.tipo='1' AND ";
        $donde.=' CONCAT(gu.num_ide, " ",gu.nombre, " ", gu.apellido)'. "LIKE '%". $_GET['term']. "%' AND (";
        
        for($i=0;$i<count($_SESSION['datos_usuario']["gradogrupo"]);$i++)
        {
            $donde .= "  (gp.grado = ";
            $donde.="'".$_SESSION['datos_usuario']["gradogrupo"][$i]["grado"]."'";
            $donde .=" AND gp.grupo = ";
            $donde.="'".$_SESSION['datos_usuario']["gradogrupo"][$i]["grupo"]."')";
            if($i<count($_SESSION['datos_usuario']["gradogrupo"])-1)
            {
                $donde.=" OR ";
            }
        }
        
        $donde .=")";
        
    }
    
    $SQL= consulta::seleccionar($cie, $tabla, $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"num_ide":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","label":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","value":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>

