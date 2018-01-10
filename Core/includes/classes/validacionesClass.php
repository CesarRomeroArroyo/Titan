<?php
class validaciones
{
    public static function generarFormularioValidaciones($formulario)
    {
//        $sql="select variable, concat(orden,\". \",titulo) as nombre  from formulario where formulario = '".$formulario."' and mostrar='1' order by orden";
//        $consulta=consulta::ejecutar_consulta($sql);
        
        //$retorno = consulta::convertir_a_array($consulta);
        $ajax[0]="formulario";
        $ajax[1]="variable";
        $ajax[2]="validacion";
        $ajax[3]="criterio";
        $valor=ajax::anexar_array_ajax($ajax);
        ajax::generar_funcion_ajax('f_guardar_validaciones', STR_DIR_CLASSES_DEFAULTH.'validacionesSafeFile.php', "divresultado", $valor);

        echo Formulario::abrirformfield("", "POST", "f_validaciones");
        //$campos = Utils::preparar_datos_consulta_combo($retorno);
        $validaciones="required-Requerido-requireCombo-Combo(Select) Requerido-maxlength-Maximo Numero de Caracteres-minlength-Minimo Numero de Caracteres-min-Como Minimo-max-Como Maximo-range-Entre-email-Es Email-dateISO-Es Fecha-number-Es un Numero(Entero o Decimal '.')-digits-Es un Numero Entero-equalTo-Igual a-valueNotEquals-Valor Diferente a";

        echo "<script>
                $(function() {
                    $( \"#".$formulario."\" ).accordion();
                });
              </script>";
        
        
        echo "<div id=\"".$formulario."\">";
        echo "<h3>FORMULARIO DE CONFIGURACION DE VALIDACIONES</h3>";
        echo "<div>";
        echo "Tabla: <br />".Formulario::textboxfield('formulario', 'text',$formulario);
        echo "<br />Campos: <br />".Formulario::textboxfield('variable','text');
        echo "<br />Validacion: <br />".Formulario::comboboxfield('validacion', $validaciones);
        echo "<br />Criterio: <br />".Formulario::textboxfield('criterio', 'text');
        echo "<br /><br />".Formulario::buttonfield('btn_validaciones', 'button', 'Guardar Validacion', 'f_guardar_validaciones()');
        echo Formulario::cerrarformfield();

        echo "<br/> <font size='1'>";
        echo "*Configuracion de Validaciones VS Criterio<br />
        1. Las Validaciones Requerido, Numerico, Email, URL, Fehca, Numero Entero solo permiten criterios en Booleano (true o false)<br/>
        2. Las Validaciones Maximo Numero de Caracteres, Minimo Numero de Caracteres, Como Minimo, Como Maximo reciben criterios en numeros enteros.<br/>
        3. Las Validaciones Rango Valido de Caracteres, Entre reciben criterios en rangos de la siguiente forma [1,10] para un rango de 1 a 10<br/>
        4. Las Validaciones Igual a, Comparar contra reciben como criterio el identificador (HTML id) del campo con el que se hara la comparacion.<br/>
        5. La Validacion Combo(Select) Requerido debe llevar por Criterio el valor que sera tomado como vacio.<br/>
        6. La Validacion Valor Diferente a, recibe como criterio el valor que no puede tomar el campo.
        ";
        
        echo "</font><br/>";
        echo "<div id=\"divresultado\"></div>";
        echo "</div>";
        echo "</div>";
    }
    
    public static function generarValidacionesdesdeBD($tabla, $formulariohtml)
    {
        $sql="select variable from general_validaciones where formulario ='".$tabla."' group by variable";
        
        $consulta=consulta::ejecutar_consulta($sql);
        $campo = consulta::convertir_a_array($consulta);
        
        
        echo "<script type='text/javascript'>    
               $.validator.addMethod('requireCombo', function(value, element, arg){
                return arg != value;
               }, 'Debe Seleccionar una Opcion.');
              $.validator.addMethod('valueNotEquals', function(value, element, arg){
                return arg != value;
               }, 'El Valor no puede ser el ingresado.');             

            $(document).ready(function() {
            ";
                        echo "$('#".$formulariohtml."').validate({";
                        echo "
                            debug: true,
                            ignore : false,
                            onkeyup: false,
                            focusInvalid : true,
                            rules: {";
                        for($c=0;$c<=count($campo)-1;$c++)
                        {
                            
                            echo $campo[$c]['variable'].":{  
                                "; 
                            $sql="select * from general_validaciones where formulario ='".$tabla."' and variable='".$campo[$c]['variable']."'";
                            $consulta=consulta::ejecutar_consulta($sql);
                            $var = consulta::convertir_a_array($consulta);
                            for($i=0;$i<=count($var)-1;$i++)
                            {
                                echo $var[$i]['validacion'].":".$var[$i]['criterio'];
                                if($i!=count($var)-1)
                                {
                                    echo ",";
                                }
                            }
                            echo "} 
                                ";
                            if($c!=count($campo)-1)
                            {
                                echo ",";
                            }
                        
                            
                        }   
                        echo "} 
                            ";
                       
                        echo " 
                     
               });   
             
        }); ";
               echo "</script>";
    }
    
    public static function semana()
    {
        //        $fechaactual=date("Y-m-d");
//        $semana[0]='*';
//        $tabla='calendario';
//        $donde="desde <= '".$fechaactual."' AND hasta >= '".$fechaactual."'";
//
//        $consultasem=consulta::ejecutar_consulta(consulta::seleccionar($semana,$tabla,$donde));
//        while($rowsem=consulta::pasar_a_array($consultasem))
//        {
//            $semana=$rowsem['semana'];
//        }
        $dia =date('m');
        $date = mktime(0,0,0,(int)date('m'),(int)date('d'),(int)date('Y'));
        return  strftime("%U", $date);
        //return $semana;
    }
    
    /*
     * Validaciones Generales
     */
    
    public function porcentaje($primero, $segundo)
    {
        $porcentaje= (($primero/$segundo)*100);
        return number_format($porcentaje,1);
    }
    public function suma($primero, $segundo)
    {
        $suma = $primero + $segundo;
        return $suma;
    }

    
    public function es_vacio($var)
    {
        ///FUNCION QUE VALIDA SI LA VARIABLE ESTA VACIA
        if($var=="")
        {
            return 0;
        }else{
            return 1;
        }
    }

    public function es_email($email)
    {
       ///METODO QUE VALIDA SI ES UN MAIL VALIDO
        $mail_correcto = 0;
        //compruebo unas cosas primeras
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
           if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
              //miro si tiene caracter .
              if (substr_count($email,".")>= 1){
                 //obtengo la terminacion del dominio
                 $term_dom = substr(strrchr ($email, '.'),1);
                 //compruebo que la terminaci�n del dominio sea correcta
                 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                    //compruebo que lo de antes del dominio sea correcto
                    $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                    if ($caracter_ult != "@" && $caracter_ult != "."){
                       $mail_correcto = 1;
                    }
                 }
              }
           }
        }
        if ($mail_correcto)
           return 1;
        else
           return 0;
    }

    public function es_numero($num)
    {
        ///METODO QUE VALIDA SI LA VARIABLE ES UN NUMERO
        if(is_numeric($num))
        {
            return 1;
        }else{
            return 0;
        }
    }

    public function edad($e)
    {////METODO QUE VALIDA EL TIPO DE EDAD
        if($e==1){
                return $edad="ANIOS";
        }
        if($e==2){
                return $edad="MESES";
        }
        if($e==3){
                return $edad="DIAS";
        }
        if($e==4){
                return $edad="HORAS";
        }
        if($e==5){
                return $edad="MINUTOS";
        }
    }
    
    public static function compararFechas($primera, $segunda)
        {
        //// METODO QUE DEVUELVE EL NUMERO DE DIAS DE DIFERENCIA ENTRE DOS FECHAS
            if($primera!=""&& $segunda!=""){
            $valoresPrimera = explode ("/", $primera);
            $valoresSegunda = explode ("/", $segunda);
            $diaPrimera    = $valoresPrimera[0];
            $mesPrimera  = $valoresPrimera[1];
            $anyoPrimera   = $valoresPrimera[2];
            $diaSegunda   = $valoresSegunda[0];
            $mesSegunda = $valoresSegunda[1];
            $anyoSegunda  = $valoresSegunda[2];
            $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
            $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
            if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
             // "La fecha ".$primera." no es v�lida";
             return 0;
            }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
             // "La fecha ".$segunda." no es v�lida";
             return 0;
            }else{
             return  $diasPrimeraJuliano - $diasSegundaJuliano;
            }
            }
        }

     ///
      ///OTRAS VALIDACIONES
      ////
      

        public function area($a)
        {///METODO QUE VALIDA EL AREA
            if($a==1){
                    return $area="CABECERA MUNICIPAL";
            }

            if($a==2){
                    return $area="CENTRO POBLADO";
            }

            if($a==3){
                    return $area="RURAL DISPERSO";
            }
        }

        public static function es_fecha($var)
        {
            if(strrpos($var,"/"))
            {
                if($var[2]!="/" && $var[5]!="/" && $var[0]!="")
                {
                    return false;
                }
                if($var[2]=="/" && $var[5]=="/")
                {
                    return true;
                }
            }
            if(strrpos($var,"-"))
            {
                if($var[4]!="-" && $var[7]!="-" && $var[0]!="")
                {
                    return false;
                }
                if($var[4]=="-" && $var[7]=="-")
                {
                    return true;
                }
            }
        }

        public static function Entre_Fecha_Consulta($mes, $anio, $archivo)
        {
            switch ($mes)
            {
                 case 1:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/01/".$anio."','%d/%m/%Y')";
                    break;
                case 2:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/02/".$anio."','%d/%m/%Y') and STR_TO_DATE('29/02/".$anio."','%d/%m/%Y')";
                    break;
                case 3:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/03/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/03/".$anio."','%d/%m/%Y')";
                    break;
                case 4:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/04/".$anio."','%d/%m/%Y') and STR_TO_DATE('30/04/".$anio."','%d/%m/%Y')";
                break;
                case 5:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/05/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/05/".$anio."','%d/%m/%Y')";
                break;
                case 6:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/06/".$anio."','%d/%m/%Y') and STR_TO_DATE('30/06/".$anio."','%d/%m/%Y')";
                break;
                case 7:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/07/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/07/".$anio."','%d/%m/%Y')";
                break;
                case 8:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/08/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/08/".$anio."','%d/%m/%Y')";
                break;
                case 9:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/09/".$anio."','%d/%m/%Y') and STR_TO_DATE('30/09/".$anio."','%d/%m/%Y')";
                break;
                case 10:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/10/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/10/".$anio."','%d/%m/%Y')";
                break;
                case 11:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/11/".$anio."','%d/%m/%Y') and STR_TO_DATE('30/11/".$anio."','%d/%m/%Y')";
                break;
                case 12:
                    return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/12/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/12/".$anio."','%d/%m/%Y')";
                break;
            default:
                return "STR_TO_DATE($archivo,'%d/%m/%Y') BETWEEN STR_TO_DATE('01/01/".$anio."','%d/%m/%Y') and STR_TO_DATE('31/12/".$anio."','%d/%m/%Y')";
                break; 
            }
        }
        
        public static function valida_dato_uf8($var)
        {
            
            $var = str_replace('Ã¡', 'a', $var);
            $var = str_replace('Ã©', 'e', $var);
            $var = str_replace('Ã­', 'i', $var);
            $var = str_replace('Ã³', 'o', $var);
            $var = str_replace('Ãº', 'u', $var);

            $var = str_replace('Ã±', '&ntilde;', $var);

            return $var;
        }
        
        public static function permisos($permisos)
        {
            if($permisos==1)
            {
                return "Administrador";
            }
            else
            {
                return "Usuario";
            }
        }
        
        public static function meses($mes)
        {
            switch ($mes) {
                case 1:
                return "ENERO";
                break;
                case 2:
                return "FEBRERO";
                break;
                case 3:
                return "MARZO";
                break;
                case 4:
                return "ABRIL";
                break;
                case 5:
                return "MAYO";
                break;
                case 6:
                return "JUNIO";
                break;
                case 7:
                return "JULIO";
                break;
                case 8:
                return "AGOSTO";
                break;
                case 9:
                return "SEPTIEMBRE";
                break;
                case 10:
                return "OCTUBRE";
                break;
                case 11:
                return "NOVIEMBRE";
                break;
                case 12:
                return "DICIEMBRE";
                break;
            }
        
        }

        public static function  tiempo_transcurrido($fecha_nacimiento, $fecha_control)
        {
           $fecha_actual = $fecha_control;

           if(!strlen($fecha_actual))
           {
              $fecha_actual = date('d/m/Y');
           }

           // separamos en partes las fechas 
           $array_nacimiento = explode ( "/", $fecha_nacimiento ); 
           $array_actual = explode ( "/", $fecha_actual ); 

           $anos =  $array_actual[2] - $array_nacimiento[2]; // calculamos años 
           $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
           $dias =  $array_actual[0] - $array_nacimiento[0]; // calculamos días 

           //ajuste de posible negativo en $días 
           if ($dias < 0) 
           { 
              --$meses; 

              //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
              switch ($array_actual[1]) { 
                 case 1: 
                    $dias_mes_anterior=31;
                    break; 
                 case 2:     
                    $dias_mes_anterior=31;
                    break; 
                 case 3:  
                    if (validaciones::bisiesto($array_actual[2])) 
                    { 
                       $dias_mes_anterior=29;
                       break; 
                    } 
                    else 
                    { 
                       $dias_mes_anterior=28;
                       break; 
                    } 
                 case 4:
                    $dias_mes_anterior=31;
                    break; 
                 case 5:
                    $dias_mes_anterior=30;
                    break; 
                 case 6:
                    $dias_mes_anterior=31;
                    break; 
                 case 7:
                    $dias_mes_anterior=30;
                    break; 
                 case 8:
                    $dias_mes_anterior=31;
                    break; 
                 case 9:
                    $dias_mes_anterior=31;
                    break; 
                 case 10:
                    $dias_mes_anterior=30;
                    break; 
                 case 11:
                    $dias_mes_anterior=31;
                    break; 
                 case 12:
                    $dias_mes_anterior=30;
                    break; 
              } 

              $dias=$dias + $dias_mes_anterior;

              if ($dias < 0)
              {
                 --$meses;
                 if($dias == -1)
                 {
                    $dias = 30;
                 }
                 if($dias == -2)
                 {
                    $dias = 29;
                 }
              }
           }

           //ajuste de posible negativo en $meses 
           if ($meses < 0) 
           { 
              --$anos; 
              $meses=$meses + 12; 
           }

           $tiempo[0] = $anos;
           $tiempo[1] = $meses;
           $tiempo[2] = $dias;

           return $tiempo;
        }

        public static function bisiesto($anio_actual){ 
           $bisiesto=false; 
           //probamos si el mes de febrero del año actual tiene 29 días 
             if (checkdate(2,29,$anio_actual)) 
             { 
              $bisiesto=true; 
           } 
           return $bisiesto; 
        }
}
?>
