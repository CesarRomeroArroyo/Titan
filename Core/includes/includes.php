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
require_once 'classes/webServiceClass.php';
?>
