<?php @session_start();
(isset($_GET['text']))?$_SESSION['text']=$_GET['text']:$_SESSION['text']=$_SESSION['text'];
        (isset($_GET['idcontroller']))?$_SESSION['idcontroller']=$_GET['idcontroller']:$_SESSION['idcontroller']=$_SESSION['idcontroller'];
/*
 *      INCLUDES
 */
require_once 'classes/consultaClass.php';
require_once 'classes/utilsClass.php';
require_once 'classes/formBuilderClass.php';
require_once 'classes/validacionesClass.php';
require_once 'classes/ajaxClass.php';
require_once 'classes/zipClass.php';
require_once 'classes/reportesClass.php';
require_once 'classes/gridClass.php';
require_once 'language/lang_es.php';
require_once 'classes/formClass.php';
require_once 'classes/chartsClass.php';
require_once 'classes/pdfClass.php';
require_once 'classes/webServiceClass.php';


function get_pagina()
{
//    $tam_pag= count($_SESSION['pagina']);
//    echo "Usted esta aqui: -> ";
//    for($i=1;$i<=$tam_pag; $i++)
//    {
//        echo Formulario::linkfield($_SESSION['pagina'][$i]['nombre'], $_SESSION['pagina'][$i]['url']);
//        if($i<$tam_pag)
//        {
//            echo " -> ";
//        }
//    }
}
function pagina_padre($nombre)
{
    unset($_SESSION['pagina']);
    $_SESSION['pagina'][0]['nombre']= $nombre;
    $_SESSION['pagina'][0]['url']=$_SERVER['REQUEST_URI'];
}
function pagina_hija($nombre, $nivel, $url)
{
    $tam = count($_SESSION['pagina']);
    if($nivel >= $tam)
    {
        $_SESSION['pagina'][$nivel]['nombre']= $nombre;
        $_SESSION['pagina'][$nivel]['url']=$url;
    }else
    {
        for($i=$nivel+1;$i<=$tam;$i++)
        {
            unset($_SESSION['pagina'][$i]);
        }
    }
}
?>
