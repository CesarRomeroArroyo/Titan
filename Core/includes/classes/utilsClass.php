<?php
require_once 'directions.php';

class Utils
{
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
    
        public static function formato_fecha_sql_a_normal($fecha)
        {
        ///METODO QUE DA FORMATO DE UNA FECHA EN FORMATO SQL (2010-01-10) A UNA FECHA EN FORMATO NORMAL(10/01/2010)
                        if($fecha!=""){
                        $anosql=$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        $messql=$fecha[5].$fecha[6];
                        $diasql=$fecha[8].$fecha[9];
                        $normal=$diasql."/".$messql."/".$anosql;
                        if($normal=="00/00/0000")
                        {
                            $normal="";
                        }
                        return $normal;
                        }
        }
        
        
        public static function formato_direccion($direccion){
            ///METODO QUE DA FORMATO DE UNA DIRECCION A FORMATO NORMAL
          $cont=0;
               for ($index = 0; $index < count($direccion); $index++) {
                
                    if(strpos( key($direccion), "address-") !== false){
                         

                          $resultado = $resultado." ".$direccion[key($direccion)];

                            $cont++;
                     }
                next($direccion);
                if($cont>4){
                    $res[]=$resultado;
                    $cont=0;
                    $resultado="";
                }
                
           }
          
            return $res;
        }

        public static function formato_fecha_normal_a_sql($fecha){
            ///METODO QUE DA FORMATO DE UNA FECHA EN FORMATO NORMAL(10/01/2010) A UNA FECHA EN FORMATO SQL (2010-01-10)
                            if($fecha!=""){
                            $anosql=$fecha[6].$fecha[7].$fecha[8].$fecha[9];
                            $messql=$fecha[3].$fecha[4];
                            $diasql=$fecha[0].$fecha[1];
                            $sql=$anosql."-".$messql."-".$diasql;
                            if($sql=="0000-00-00")
                            {
                                $sql="";
                            }
                            return $sql;
                            }
        }

        public static function  cambiarFormatoFecha($fecha){
              list($dia,$mes,$anio)=explode("-",$fecha);
              return $mes."/".$dia."/".$anio;
        }

        public static function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0)
        {///FUNCION QUE SUMA DETERMINADO TIEMPO A UNA FECHA RECIBE, FECHA A LA QUE SE LE VA A SUMAR EL TIEMPO(dd/mm/YYYY), DIAS A SUMAR,
         ///MESES A SUMAR, A�OS A SUMAR, HORAS A SUMAR, MINUTOS A SUMAR Y SEGUNDOS A SUMAR
            $date_r = getdate(strtotime($date));
            $date_result = date("m/d/Y h:i:s", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
            return $date_result;
        }
        
//        public static function calcular_edad($fecha)
//        {
//            $dias = explode('/', $fecha, 3);
//            $dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
//            $edad = (int)((time()-$dias)/31556926 );
//            return $edad;
//        }
        
        public static function calcular_edad($fechanacimiento){
            list($mes,$dia,$ano) = explode("/",$fechanacimiento);
            $dia_diferencia = date("d") - $dia;
            $mes_diferencia = date("m") - $mes;
            $ano_diferencia = date("Y") - $ano;
            if ($dia_diferencia < 0 && $mes_diferencia <= 0)
            $ano_diferencia--;
            return $ano_diferencia;
         }
        
        public static function imprimir($div)
        {
            ?>
            <script language="javascript">
            function imprimir() {
                var ventana = window.open("", "", "");
                var contenido = "<html><body onload='window.print();window.close();'><link id='theme' rel='stylesheet' type='text/css' href='../../style.css' title='theme' /><div align='center'>" + document.getElementById('<?php echo $div;?>').innerHTML + "</div></body></html>";
                ventana.document.open();
                ventana.document.write(contenido);
                ventana.document.close();
            }
            </script>
            <?php
        }
        
        public static function UserBrowser()
        {
            if((@ereg("Nav", $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Gold",
            $_SERVER["HTTP_USER_AGENT"])) || (@ereg("X11",
            $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Mozilla",
            $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Netscape",
            $_SERVER["HTTP_USER_AGENT"])) AND (!@ereg("MSIE",
            $_SERVER["HTTP_USER_AGENT"]) AND (!@ereg("Konqueror",
            $_SERVER["HTTP_USER_AGENT"])))) $browser = "Netscape";
              elseif(@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) $browser = "MSIE";
              elseif(@ereg("Lynx", $_SERVER["HTTP_USER_AGENT"])) $browser = "Lynx";
              elseif(@ereg("Opera", $_SERVER["HTTP_USER_AGENT"])) $browser = "Opera";
              elseif(@ereg("Netscape", $_SERVER["HTTP_USER_AGENT"])) $browser = "Netscape";
              elseif(@ereg("Konqueror", $_SERVER["HTTP_USER_AGENT"])) $browser = "Konqueror";
              elseif((@eregi("bot", $_SERVER["HTTP_USER_AGENT"])) ||
              (ereg("Google", $_SERVER["HTTP_USER_AGENT"])) || (ereg("Slurp",
              $_SERVER["HTTP_USER_AGENT"])) || (@ereg("Scooter",
              $_SERVER["HTTP_USER_AGENT"])) || (@eregi("Spider",
              $_SERVER["HTTP_USER_AGENT"])) || (@eregi("Infoseek",
              $_SERVER["HTTP_USER_AGENT"]))) $browser = "Bot";

              else $browser = "Other";
              return $browser;
          }
          
          public static function generar_datos_combo_anios()
            {
                $aniob= date('Y')-5;
                $retorno=$aniob."-".$aniob;
                for($i=1;$i<10;$i++)
                {
                    $retorno.="-".(int)($aniob+$i)."-".(int)($aniob+$i);
                }
                return $retorno;
            }
      
         

        public static function  preparar_datos_consulta_combo($array)
        {
            $retorno = "";
            for($i=0;$i<=count($array)-1;$i++)
            {
                $retorno.=$array[$i][0].'-'.$array[$i][1];
                if($i<=count($array)-2)
                {
                    $retorno.="-";
                }
            }
            return $retorno;
        }
        
        public static function crear_carpeta($ruta)
        {
            @mkdir($ruta, 0700);
        }
        
        public static function subir_archivo($nombreTemp, $nombreReal, $carpeta)
        {               
            @mkdir($carpeta, 0700);
            @copy($nombreTemp, $carpeta."/".$nombreReal);         
            return true;
        }

        public static function subir_archivo_zip($nombreTemp, $nombreReal)
        {
                require_once 'zipClass.php';
                copy($nombreTemp, 'view/repositorio/'.date('d').date('m').date('Y').$_SESSION['datos_usuario']['codigo']."/".$nombreReal); 

                zipper::Descomprime('./view/repositorio/'.date('d').date('m').date('Y').$_SESSION['datos_usuario']['codigo'],$nombreReal);
                return true;
        }


        public static function eliminarDir($directorio) 
        {
            foreach(glob($directorio."/*") as $archivos_carpeta) 
            {             
                if(is_dir($archivos_carpeta)) 
                    eliminarDir($archivos_carpeta); 
                else unlink($archivos_carpeta);             
             } 

        }

        /*
         * Metodo para cargar un archivo y leerlo separado por comas
         * Retorna un array con los datos contenidos en el archivo
         * @param string $archivo -> Nombre del Archivo a abrir
         */
        public static function cargar_archivo($archivo)
        {
            $i=0;
            $fp= fopen($archivo, "r");
            while($linea = fgets($fp))
            {            
                $return[$i] = explode(",", $linea);            
                $i++;
            }
            return $return;
        }

            /*
         * Metodo que Redirecciona a una direccion especificada por el usuario
         * @param string $pagina -> Direccion a la que se redireccionara con el Control
         */
        public static function  redirecciona($pagina, $time='0')
        {
            return "<meta http-equiv='refresh' content='$time; URL=".$pagina."'>";
        }
        
        
    /*
         * Metodo que Muestra un mensaje en pantalla estandar 
         * @param string $mensaje Mensaje a Mostrar
         */
        public static function mensaje($mensaje)
        {     
            return "<b><font color='black'>".utf8_decode($mensaje)."</font></b>";
        }

        /*
         * Metodo que Genera un mesaje de error (letras rojas) estandar
         * @param string $mensaje Mensaje a Mostrar
         */
        public static  function mensaje_error($mensaje)
        {     
            return "<font color='#FF0000'><b>".utf8_decode($mensaje)."</b></font>";
        }
        
        public static function sino($sino)
        {
            if($sino==1)
            {
                return "SI";
            }
            else
            {
                return "NO";
            }
        }
        
        public function causaNoVacunacion($cnv)
        {
            switch ($cnv) {
                case '1':
                    return'Reacción adversa a dosis previas (leve, moderada o grave)';
                break;
                case '2':
                    return'El médico dijo que tenía las vacunas completas';
                break;
                case '3':
                    return'Peso menor a 2000 gr';
                break;
                case '4':
                    return'Anafilaxia a dosis previas (reacción alérgica grave que compromete la vida del niño)';
                break;
                case '5':
                    return'Falta de tiempo del cuidador';
                break;
                case '6':
                    return'Rechazo de la vacuna';
                break;
                case '7':
                    return'Porque tiene las vacunas completas';
                break;
                case '8':
                    return'No Aplica';
                break;

            }
        }
        
        public static function municipio($mun)
        {
            require_once 'consultaClass.php';
            $sql="select CONCAT(cod_mun, \" - \", nom_mun) as mun from general_municipios where cod_mun='".$mun."'";
            $consulta= consulta::ejecutar_consulta($sql);
            $retorno = consulta::convertir_a_array($consulta);
            return $retorno[0]['mun'];
        }
        
        public static function redimensionar_imagen($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad)
        {
                // crear una imagen desde el original
                $img = ImageCreateFromJPEG($img_original);
                // crear una imagen nueva
                $thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
                // redimensiona la imagen original copiandola en la imagen
                ImageCopyResized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
                // guardar la nueva imagen redimensionada donde indicia $img_nueva
                ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
                
                ImageDestroy($img);
        }
}
?>
