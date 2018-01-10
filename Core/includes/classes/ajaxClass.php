<?php

class ajax
{
    
    public static function generar_funcion_ajax($nombre_funcion, $destino, $div, $datos, $mensajeCarga="Cargando...")
    {
       
        echo " <script type='text/javascript'>               
        function ".$nombre_funcion."()
        {                    
	     $(\"#$div\").html(\"$mensajeCarga\");
            $.post(\"".$destino."\",$datos,function(data){
                $(\"#$div\").html(data);
            }).done(function() { });
        }
        </script>";
    }
    
    static function generar_funcion_ajax_segunda_funcion($nombre_funcion, $destino, $div, $datos, $segfuncion='', $mensaje="Cargando...")
        {
            echo " <script type='text/javascript'>               
            function ".$nombre_funcion."()
            {                    
                 $(\"#$div\").html(\"$mensajeCarga\");
                $.post(\"".$destino."\",$datos,function(data){
                    $(\"#$div\").html(data);
                }).done(function() { $segfuncion; });
            }
            </script>";
//            $imagen='<img src="loader.gif" width="20" height="20">';
//            $funcion="function ".$nomfun."(){
//                var miAleatorio=parseInt(Math.random()*99999999);
//                ajax=objetoAjax();
//                ajax.open('POST', '".$destino."' + '?rand=' + miAleatorio,true);
//                ajax.onreadystatechange=function() {
//                    if (ajax.readyState==4) {
//                        document.getElementById('".$div."').innerHTML = ajax.responseText;
//                            ".$segfuncion."
//                    }
//                    else{
//                        if (ajax.readyState==1)
//                            {
//                                document.getElementById('".$div."').innerHTML = '".$imagen." ".$mensaje."';
//                                
//                            }
//                    }
//                   }
//                 ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//                 ajax.send(".$valor.");
//                  }";
//            echo "<script type='text/javascript'>  ".  $funcion. "  </script>";
        }
    
    public static function anexar_array_ajax($ajax)
    {
        $retorno="{";
        for($i=0;$i<=count($ajax)-1;$i++)
        {
            //{nombre:“Pepe”, apellido:“Grillo”}

            $retorno.="$ajax[$i]:$('#$ajax[$i]').val()";
            if($i!=count($ajax)-1)
            {
                $retorno.=",";
            }
        }
        $retorno.="}";
        return $retorno;
    }
    
    public static function anexar_array_ajax_valor($ajax)
    {
        $retorno="{";
        for($i=0;$i<=count($ajax)-1;$i++)
        {
            //{nombre:“Pepe”, apellido:“Grillo”}

            $retorno.="$ajax[$i]:$ajax[$i]";
            if($i!=count($ajax)-1)
            {
                $retorno.=",";
            }
        }
        $retorno.="}";
        return $retorno;
    }

    
}
?>
