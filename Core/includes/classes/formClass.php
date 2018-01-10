<?php 
require_once 'utilsClass.php';

class Formulario
{
    
    /*
     * Metodo que genera una caja de texto.
     * @param string $name -> Nombre e Id del TextBoxField     
     * @param string $tipo -> Tipo de TextBox a pintar (text, file, hidden)
     * @param string $valor -> Valor por defecto que se pintara en el TextBoxField
     * @param bool $readonly -> Indica si el TextBoxFiel es de solo lectura o no (Por defecto false)
     */
    public static function textboxfield($name, $tipo, $valor="",$tam="200px", $readonly=false, $otros="")
    {
        ($readonly==false)?$readonly="":$readonly="readonly";
        return "<input name='".$name."' id='".$name."' x-webkit-speech class=\"form-control\" type='".$tipo."' value='".$valor."' ".$readonly." ".$otros." />";
    }

    public static function checkboxfield($name, $checked="", $labelSI="SI", $labelNO="NO",$funcion="")
    {        
        return '<span class="checkbox">
                    <input type="checkbox" id="'.$name.'" name="'.$name.'" '.$checked.' onclick="'.$funcion.'">
                    <label data-on="'.$labelSI.'" data-off="'.$labelNO.'"></label>
                </span>';
        
//        return '<div class="make-switch" data-on="primary" data-off="info">
//                    <input type="checkbox" checked id="'.$name.'" name="'.$name.'" '.$checked.'>
//                </div>';        
    }
    /*
     * Metodo que genera un area de texto
     * @param string $name -> Nombre e Id del Control
     * @param string $cols -> Columnas del Control
     * @param string $rows -> Filas del Control
     * @param string $valor -> Valor por defecto del control
     */
    public static function textareafield($name,$valor="",$cols="3", $rows="3", $readonly=false)
    {
        $ro = "";
        if($readonly == true)
        {
            $ro = "readonly";
        }
        return "<textarea name='".$name."' id='".$name."' cols='".$cols."' rows='".$rows."' $ro  class=\"wysihtml5 form-control\">".$valor."</textarea>";
    }
    
    /*
     * Metodo que genera un comobobox.
     * @param string $name -> Nombre e ID del Combobox 
     * @param string $data -> Informacion que servira de alimento para el ComboBox (1-OPCION1-2-OPCION2-3-OPCION3)
     * @param string $selected -> Opcion que se seleccionara.
     * @param string $tam -> Tamaño del Control
     */
    public static function comboboxfield($name, $data, $selected="", $tam="200px", $otros="")
    {
        $combo = "<select name='".$name."' id='".$name."' class=\"form-control\"  ".$otros.">";
        $combo .="<option value ='0'>Seleccione una Opcion</option>";
        $opciones = explode("-",$data);
        $topciones= count($opciones);
        $k=0;
        while($k<=$topciones-1)
        {
            /* @var $selected type */
            if($opciones[$k]==$selected)
                $seleccionado='selected';
            else
                $seleccionado='';
            $combo .="<option $seleccionado value = '".$opciones[$k]."'>".$opciones[$k+1]."</option>";
            $k= $k+2;
        }
        $combo .= "</select>";
        return $combo;
    }
    
    public static function buttonfield($name, $tipo, $texto, $click="", $form="", $mensaje="")
    {
        $retorno="";
        if($tipo=="submit")
        {
            $retorno.= "                      
                <input name='".$name."' class='btn btn-primary' type='submit' value='".$texto."' onclick='$click' id='".$name."' />
                    ";        
        }
        if($tipo=="button")
        {
            $retorno.= "                       
                <input name='".$name."' type='button' class='btn btn-primary' value='".$texto."' onclick='".$click."' id='".$name."' />
                    ";        
        }
        if($tipo=="submitconfirm")
        {
            $mensaje_ventana='VENTANA DE CONFIRMACION';
            $imagen='question.png';
            $retorno.= "
              <script type='text/javascript'>
                
                 function submitForm".$form."()
                 {                    
                      
                            $(\"#".$form."\").submit();
                       
                 }
                </script>";
            $retorno.= "
            <div id='divFormConfrim".$form."' class='modal modal-styled fade'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h3 class='modal-title'>Ventana de Confirmacion</h3>
                        </div>
                <div class='modal-body'>        
                <table width='100%' border='0' align='center' >
                  <tr>
                    <td rowspan='2'>".  Formulario::imagenfield($imagen, 40, 40)."</td>
                    <td>".Utils::mensaje_error($mensaje)."</td>
                  </tr>                  
                </table>
                </div>
                <div class='modal-footer'>
                    <button type='button' onclick='submitForm".$form."()' class='btn btn-primary'>Aceptar</button>&nbsp;
                    <button type='button' class='btn btn-tertiary' data-dismiss='modal'>Cancelar</button>
                  </div>
            </div></div></div>";
            
            $retorno.= "<a data-toggle='modal' href='#divFormConfrim".$form."' class='btn btn-primary' >Aceptar</a>
                
                    ";                    
        }
        
        return $retorno;
    }

    public static function modal($id, $mensaje_ventana, $contenidoHtml, $anchoModal="550",$botones="")
    {
        echo "
          <script type='text/javascript'>
            function show".$id."()
                {
                    $(\"#".$id."\").dialog({                   
                    modal: true,
                    title: \"".$mensaje_ventana."\", 
                    width: $anchoModal,
                    resizable: false, 
                    show: \"fold\"
                    });
                    $(\"#".$id."\").dialog(\"open\");

                 }
            </script>";
        echo "
        <div id='".$id."' width='100%' title='".$mensaje_ventana."' style='display: none;'>
           ".$contenidoHtml."
        </div>";
    }
    
    public static function modalInfo($mensaje,$id,$tipo,$accion="")
    {
        switch ($tipo)
        {
            case 'CONFIRM':
            {
                $mensaje_ventana='MENSAJE DE CONFIRMACION';
                $imagen='success.png';                
                $boton="Aceptar: function() {
					$( this ).dialog( \"close\" );
				}";
                break;
            }
            case 'QUESTION':
            {
                $mensaje_ventana='MENSAJE DE CONSULTA';
                $imagen='question.png';
                $boton="Aceptar: function() {
					".$accion."
				},
                        Cancelar: function() {
					$( this ).dialog( \"close\" );
				}";
                break;
            }
            case 'ERROR':
            {
                $mensaje_ventana='MENSAJE DE ERROR';
                $imagen='error.png';
                $boton="Aceptar: function() {
					$( this ).dialog( \"close\" );
				}";
                break;
            }
            case 'MESSAGE':
            {
                $mensaje_ventana='MENSAJE DE AVISO';
                $imagen='advertencia.png';
                $boton="Aceptar: function() {
					$( this ).dialog( \"close\" );
				}";
                break;
            }
        }
        echo "
          <script type='text/javascript'>
            function show".$id."()
                {
                    $(\"#".$id."\").dialog({                   
                    modal: true, 
                    buttons: {
                             ".$boton."   
			},

                    title: \"".$mensaje_ventana."\", 
                    
                    resizable: false, 
                    show: \"fold\"
                    });
                    $(\"#".$id."\").dialog(\"open\");

                 }
            </script>";
        echo "
        <div id='".$id."' title='".$mensaje_ventana."' style='display: none;'>
            <table width='100%' border='0' align='center' >
                
              <tr>
                <td rowspan='2'>".  Formulario::imagenfield($imagen, 40, 40)."</td>
                <td>".Utils::mensaje_error($mensaje)."</td>
              </tr>             
            </table>
        </div>";
      

    }
    
    public static function datefield($name, $valor="")
    {        
        ($valor!="")?$val=  Utils::formato_fecha_sql_a_normal($valor):$val="";
        return '
                <script>
                $(function() {                
                $(\'#'.$name.'div\').datepicker ();
                    });
                </script>
                <div id="'.$name.'div" class="input-group date" data-auto-close="true" data-date-format="dd/mm/yyyy" data-date-autoclose="true">
                    <input class="form-control" type="text" id="'.$name.'" name="'.$name.'" value="'.$val.'" >
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>';
        
        //<input type='text' id='".$name."' name='".$name."' class=\"form-control\" value='".$valor."' />
    }
    
    public static function autocompletefield($nombre, $destino, $valor="", $tam="200px",$otros="", $onSelectOption="")
    {
        return "
        <script>
            $(function() {
                    $( \"#".$nombre."\" ).autocomplete({
                            source: \"".STR_DIR_AUTO_COMPLETE_DEFAULTH.$destino.".php\",
                            minLength: 3,
                            close: function (event, ui){                            
                            ".$onSelectOption."
                            }
                    });
            });
	</script>
        <div class=\"input-group\">
         <input type='text' id='".$nombre."' name='".$nombre."' class=\"form-control\" value='".Formulario::searchautocompletevalue($valor,$destino)."' $otros   />
         <span onclick=\"document.getElementById('".$nombre."').value='';document.getElementById('".$nombre."').focus()\" class=\"input-group-addon\"><i class=\"fa fa-search\"></i></span>       
        </div>        ";
    }
       
        
    private static function searchautocompletevalue($valor, $destino)
    {
        switch ($destino) {
            case 'barrios':
                return $valor;
            break;
            case 'categorias':
                $municipio[0]='id';
                $municipio[1]='nombre';
                $donde="id='".$valor."'";

                $SQL= consulta::seleccionar($municipio, 'general_category', $donde);
                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["id"].'|'.$retorno[0]["nombre"];
                }
                else
                {
                    return "";
                }
            break;
            case 'conductores':
                $SQL="SELECT id, CONCAT(pri_nom, \" \", seg_nom , \" \", pri_ape,\" \", seg_ape,\"|\",tip_ide,\"|\",num_ide) as nombre 
                    FROM logistic_drivers 
                    WHERE id = '" .$valor. "'";

                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["id"]."|".$retorno[0]["nombre"];
                }
                else
                {
                    return "";
                }
            break;
            case 'vehiculos':
                $SQL="SELECT id, CONCAT(placa, \" \", marca, \" \", linea) as nombre 
                    FROM logistic_vehicles 
                    WHERE id = '" .$valor. "'";

                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["id"]."|".$retorno[0]["nombre"];
                }
                else
                {
                    return "";
                }
            break;
            case 'rutas':
                $municipio[0]='id';
                $municipio[1]='nom_ruta';
                $donde="id = '".$valor."'";

                $SQL= consulta::seleccionar($municipio, 'logistic_route', $donde);
                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["id"].'|'.$retorno[0]["nom_ruta"];
                }
                else
                {
                    return "";
                }
            break;
            case 'municipios':
                $municipio[0]='cod_mun';
                $municipio[1]='nom_mun';
                $donde="cod_mun = '".$valor."'";

                $SQL= consulta::seleccionar($municipio, 'general_municipios', $donde);
                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["cod_mun"].'|'.$retorno[0]["nom_mun"];
                }
                else
                {
                    return "";
                }
            break;
            case 'aseguradoras':
                $municipio[0]='cod_ase';
                $municipio[1]='nom_ase';
                $donde="cod_ase = '".$valor."'";

                $SQL= consulta::seleccionar($municipio, 'general_aseguradoras', $donde);
                $consulta=consulta::ejecutar_consulta($SQL);
                $retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
                    return $retorno[0]["cod_ase"].'|'.$retorno[0]["nom_ase"];
                }
                else
                {
                    return "";
                }
            break;
           
            default:
                return "";
            break;
        } 
    }
    
    /*
     * Metodo  que genera una imagen, el usuario solo especifica el nombre de la imagen
     * @param string $name -> Nombre de la imagen que se buscara en el directorio unico de imagenes
     * @param string $width y $height -> Controlan el ancho y largo de la imagen 
     * @param string $title -> Titulo que se mostrara cuando el usuario coloque el mouse sobre la imagen
     * @param string $click -> Metodo que se ejecutara cuando se haga click en la imagen
     */
    public static  function imagenfield($name, $width="20", $height="20", $title="", $click="")
    {        
        return "<img src='".STR_DIR_IMAGE_DEFAULTH.$name."' width='".$width."' height='".$height."' title='".$title."' onclick='".$click."' border='0' style='border-color: white'/>";
    }
    
    public static  function imagenfieldgeneral($name, $dir, $width="20", $height="20", $title="", $click="")
    {        
        return "<img src='".$dir.$name."' width='".$width."' height='".$height."' title='".$title."' onclick='".$click."' border='0' style='border-color: white'/>";
    }
    
    /*
     * Metodo  que genera una imagen, el usuario solo especifica el nombre de la imagen
     * @param string $name -> Nombre de la imagen que se buscara en el directorio unico de imagenes
     * @param string $width y $height -> Controlan el ancho y largo de la imagen 
     * @param string $title -> Titulo que se mostrara cuando el usuario coloque el mouse sobre la imagen
     * @param string $click -> Metodo que se ejecutara cuando se haga click en la imagen
     */
    public static  function direccionfield($name,$value="")
    {        
        $arreglo = explode(' ', $value);
        
        return
        Formulario::comboboxparams("address-".$name[0],'direccion',$arreglo[1],'90px')."".Formulario::textboxfield("address-".$name[1], 'text',$arreglo[2],'40px')." ".Formulario::comboboxparams("address-".$name[2],'direccion',$arreglo[3],'90px')."".Formulario::textboxfield("address-".$name[3], 'text',$arreglo[4],'40px')." - ".Formulario::textboxfield("address-".$name[4], 'text',$arreglo[5],'40px');
        

    }
    
        
        /*
     * Metodo que muestra un Link a una direccion especificada por el usuario 
     * el usuario puede especificar la accion del link y el target del mismo
     * @param string $mensaje -> Mensaje que mostrara el Link 
     * @param string $pagina -> Direccion a la que se redireccionara al hacer click 
     * @param string $click -> Metodo Javascript que ejecutara al hacer Click en el link
     * @param string target -> Target que tendra como destino la invocacion del link
     */
    public static  function linkfield($mensaje, $pagina='#', $click="", $target="")
    {
        return "<a href='".$pagina."' onclick='".$click."' target='".$target."'>".$mensaje."</a>";
    }
    
    
    /*
     * Metodo que genera un comobobox.
     * @param string $name -> Nombre e ID del Combobox      
     * @param string $grupo -> Grupo de datos parametrizados en la tabla params.
     * @param string $tam -> Tamaño del Control    
     */
    public static function comboboxparams($name,$grupo,$selected="",$tam="200px")
    {
        $datos[0]="value";
        $datos[1]="text";
        $donde="grupo='".$grupo."'";
        
        $sql=consulta::seleccionar($datos, 'general_params', $donde);
        $consulta=consulta::ejecutar_consulta($sql);
        $combo = "<select name='".$name."' id='".$name."' class=\"form-control\" >";
        $combo.= "<option value ='0'>Seleccione una Opcion</option>";
        while($row=consulta::pasar_a_array_asociativo($consulta))
        {
            if($row['value']==$selected)
                $seleccionado='selected';
            else
                $seleccionado='';
            $combo.= "<option $seleccionado value = '".$row['value']."'>".$row['text']."</option>";
        }
        $combo.= "</select>";
        return $combo;
    }
    
    
    /*
     * Metodo que Genera un TextBox de Busqueda puede mostrar el Id o el Texto
     * @param string $nombre -> Nombre del Control
     * @param string $busqueda -> Indicar de la Busqueda en el archivo CajaBusqueda
     * @param bool $iddisplay -> Define si se muestra o no el TextBox que tiene el ID
     * @param bool $lbldisplay -> Define si se muestra o no el TextBox que tiene el Texto
     */
    public static function textfieldsearch($nombre, $busqueda,$iddisplay=false,$lbldisplay=true, $required=false)
    {
        ($iddisplay==true)?$iddisplay='block':$iddisplay='none';
        ($lbldisplay==true)?$lbldisplay='block':$lbldisplay='none';
        echo "<input name='".$nombre."' id='".$nombre."' type='text' readonly='readonly' size='9' onkeydown='Ent(this, event)' value='' style='display:".$iddisplay."' />
              <input name='".$nombre."lbl' id='".$nombre."lbl' readonly='readonly' style='display:".$lbldisplay."' >
              <a href=\"javascript:void(0)\"  onClick=\"hija=window.open('".STR_DIR_FRAMEWORK_DEFAULTH."cajabusqueda/cajabusqueda.php?id_origen=".$nombre."&busqueda=".$busqueda."','','top=0, left=0, scrollbars=yes,location=no, resizable=no, width=270,height=326');\"><img src=\"".STR_DIR_IMAGE_DEFAULTH."buscar.png\" width=\"16\" height=\"16\" border=\"0\" style=\"border-color:#FFF\"/></a></td>";
        return ($required==true)?Formulario::mensaje_error("*"):"";
    }
    
    public static function checklistfield($opciones, $id)
    {
        echo "<ul class=\"checklist\">";
        for($i=0;$i<=count($opciones)-1;$i++)
        {
            echo "<li>";
            echo "<input name=\"".$id."\" value=\"".$opciones[$i]."\" type=\"checkbox\" id=\"".$id."choice_a".$i."\"/>";
            echo "<label for=\"".$id."choice_a".$i."\">".$opciones[$i]."</label>";
            echo "<a class=\"checkbox-select\" href=\"#\">Seleccionar</a>";
            echo "<a class=\"checkbox-deselect\" href=\"#\">Cancelar</a>";
            echo "</li>";
        }
        echo "</ul>";
    }
    public static function checklistfieldNormal($label,$opciones, $id)
    {
                echo'<br><label for="select-input">'.$label.'</label><br>';

        echo "<ul class=\"checklist\">";

        for($i=0;$i<=count($opciones)-1;$i++)
        {   
            echo "<input name=\"".$id."\" value=\"".$i."\" type=\"checkbox\" id=\"".$id."choice_a".$i."\"/>";
            echo " ";
            echo "<label for=\"".$id."choice_a".$i."\">".$opciones[$i]."</label>";
            echo " ";

        }
        echo "</ul>";
    }
    
    /*
     * Metodo que genera la etiqueta de apertura de un formulario
     * @param string $action -> Indica el destino del Formulario
     * @param string $method -> Metodo que utilizara el formulario para enviar la informacion (POST, GET)
     * @param string $name -> Nombre del Formulario 
     * @param string $target -> Define el Target del Formulario (Ej target a un iframe
     */
    public static function abrirformfield($action="", $method="POST", $name="", $target="", $files=false)
    {
        $enct=($files)?"enctype='multipart/form-data'":" ";
        return "<form action='$action' method='$method' name='".$name."' id='".$name."' target='".$target."' $enct>";
    }

    /*
     * Metodo que imprime la etiqueta de cierre de formulario
     */
    public static function cerrarformfield()
    {
        return "</form>";
    }

    /*
     * Metodo que abre el Fieldset
     * @param string $titulo -> Titulo que tendra el FieldSet 
     */
    public static function abrirfieldsetfield($titulo)
    {
        return "<fieldset class='mws-form-inline'><legend class='wizard-label'><font color='black'>".$titulo."</font></legend><br/>";
    }

    /*
     * Metodo que cierra el Fielset
     */
    public static function cerrarfieldsetfield()
    {
        return "</fieldset>";
    }
    
        
    /*
     * Metodo que crea la cabecera de una Tabla
     * @param int $borde -> Tamano del borde de la tabla
     * @param int tam -> Tamano de la tabla
     */
    public static function abrir_tabla($borde, $tam='500'){
        return "<table width='".$tam."' border='".$borde."'>";
    }
    
    public static function abrir_tabla_grilla($titulos, $aplica=false){
        
        $tabla.= '<div class="table-responsive">
            <table id="gridTable" class="table table-striped table-bordered table-hover">';
        $tabla.="<thead><tr>";
        for($i=0;$i<count($titulos);$i++)
        {
            $tabla.="<th>".$titulos[$i]."</th>";
        }
        if($aplica)
        {
            $tabla.="<th>";
            $tabla.="OPCIONES";
            $tabla.="</th>"; 
        }
        $tabla.="</tr></thead>";
        return $tabla;
    }

    /*
     * Metodo que genera el Cierre de una Tabla
     */
    public static function cerrar_tabla()
    {
        return "</table>";
    }
    
    /*
     * Metodo que genera una o varias Columnas de una Tabla
     * @param string $dato -> Dato que se mostrara en la Columna
     * @param int $col -> Reliza el ColSpan de la Columna
     */
    public static function crear_columna($dato="", $col=1, $align="justify")
    {
        return "<td colspan='".$col."' align='".$align."'>".$dato."</td>";
    }

    /*
     * Metodo que abre una fila para una o varia columnas
     * @param bool $color -> Indica si la fila tendra un color distinto al blanco 
     */
    public static function abrir_fila($color =false, $align='justify')
    {
        
        if($color ==true){
            $col="<tr  align='".$align."' id=\"ui-accordion-Array-header-0\" class=\"ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons\" role=\"tab\" aria-controls=\"ui-accordion-Array-panel-0\" aria-selected=\"true\">";
        }else{
            $col="<tr>";
        }

        return $col;
    }
    
    /*
     * Metodo que genera el cierre de una fila
     */
    public static function cerrar_fila()
    {
        return "</tr>";
    }
    
    
    public static function abrir_div_row()
    {
        return "<div class='row'>";
    }
    
    public static function abrir_div_col($tam)
    {
        return '<div class="col-sm-'.$tam.'">';
    }
    
    public static function abrir_div_grupo()
    {
        return '<div class="form-group">';
    }

    public static function cerrar_div()
    {
        return "</div>";
    }
    
    public static function labelfor($label, $id)
    {
        return '<label for="'.$id.'">'.$label.'</label>';
    }

    public static function crear_columna_div($label="", $componente, $tam=3)
    {
        return '
        <div class="col-sm-'.$tam.'">
            <div class="form-group">
              <b><label for="select-input">'.$label.'</label></b>
                '.$componente.'                          
            </div>
            
        </div>  '; 
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
        
           /*
         * Metodo que Redirecciona a una direccion especificada por el usuario
         * @param string $pagina -> Direccion a la que se redireccionara con el Control
         */
        public static function  redirecciona($pagina, $time='0')
        {
            return "<meta http-equiv='refresh' content='$time; URL=".$pagina."'>";
        }
        
        public static function mensajeUI($mensaje, $tipo)
        {
            switch ($tipo) {
                case 'info':
                    echo '<div class="alert alert-block alert-info fade in no-margin">                      
                      <h4 class="alert-heading">
                        Informacion!
                      </h4>
                      <p>
                        '.$mensaje.'
                      </p>
                    </div>';
                break;
                case 'exito':
                    echo '<div class="alert alert-block alert-success fade in">                      
                      <h4 class="alert-heading">
                        Exito!
                      </h4>
                      <p>
                        '.$mensaje.'
                      </p>                      
                    </div>';
                break;
                case 'alerta':
                    echo '<div class="alert alert-block alert-warning fade in">                      
                      <h4 class="alert-heading">
                        Alerta!
                      </h4>
                      <p>
                        '.$mensaje.'
                      </p>
                    </div>';
                break;
                case 'error':
                    echo '<div class="alert alert-block alert alert-danger fade in">                      
                      <h4 class="alert-heading">
                        Error!
                      </h4>
                      <p>
                        '.$mensaje.'
                      </p>                      
                    </div>';
                break;

                default:
                    break;
            }
        }
        
        public static function division($titulo, $icono)
        {
            $retorno ='<div class="wizard-nav wizard-nav-horizontal">
            <ul>
            <li class="current" data-wzd-id="wzd_17r6ds5cv1ihj1e74100t_0">
            <span>
            <i class="'.$icono.'"></i><FONT FACE="arial" SIZE=2 COLOR=#3187bf>'.$titulo.'</FONT></span>
             
            </li>
            </ul></div>';
            
            return $retorno;
        }
        
        public static function barcode($id, $codigo, $mostrarTexto="false")
        {
            echo "<script type=\"text/javascript\">                
            $(document).ready(function(){
               $(\"#bc$id\").barcode(\"".$codigo."\", \"code39\",{fontSize:15,showHRI:".$mostrarTexto.",moduleSize:10});   
            });
            </script>
            <div id=\"bc$id\"></div>";
        }
        
        public static function barcodeTd($id, $codigo, $mostrarTexto="false")
        {
            echo "<td><script type=\"text/javascript\">                
            $(document).ready(function(){
               $(\"#bc$id\").barcode(\"".$codigo."\", \"code39\",{fontSize:15,showHRI:".$mostrarTexto.",moduleSize:10});   
            });
            </script>
            <div id=\"bc$id\"></div>";
        }
        
        public static function genera_grilla_simple($titulo_grilla,$titulos,$consulta)
        {
            $titulos= explode(",",$titulos);
            $num_campos= count($titulos);

            echo "<table border='1'>
            <tr bgcolor='#CCCCCC'>
                <td colspan='".$num_campos."' align='center'>".$titulo_grilla."<b></b></td>
            </tr>";
            echo "<tr bgcolor='#CCCCCC' align='center'>";

            for($i=0;$i<=count($titulos)-1;$i++)
            {
                echo "<td>".$titulos[$i]."</td>";
            }
            $i=0;
            while($row=consulta::pasar_a_array($consulta))
            {

                if($i%2==0)
                {
                    echo "<tr bgcolor='#CCCCFF'>";
                }
                else
                {
                    echo "<tr bgcolor='white'>";
                }
                ++$i;
                for($j=0;$j<$num_campos;$j++)
                {
                    echo "<td>". utf8_encode($row[$j])."</td>";
                }
                echo "</tr>";

            }

            echo "</table>";
        }
        
        public static function genera_grilla($titulo_grilla,$titulos,$consulta)
        {

            $consultaGnrl=str_replace("LIMIT 0 , 10"," ",$consulta);            
            $consultaParcial = $consulta;
            $consulta= consulta::ejecutar_consulta($consulta);
            $titulos= explode(",",$titulos);
            $num_campos= count($titulos);

            echo "<table border='1' style='width: 100%; height: 100%'>
            <tr bgcolor='#CCCCCC'>
                <td colspan='".$num_campos."' align='center'>".$titulo_grilla."<b></b></td>
            </tr>";
            echo "<tr bgcolor='#CCCCCC' align='center'>";

            for($i=0;$i<=count($titulos)-1;$i++)
            {
                echo "<td>".$titulos[$i]."</td>";
            }
            $i=0;
            while($row=consulta::pasar_a_array($consulta))
            {

                if($i%2==0)
                {
                    echo "<tr bgcolor='#CCCCFF'>";
                }
                else
                {
                    echo "<tr bgcolor='white'>";
                }
                ++$i;
                for($j=0;$j<$num_campos;$j++)
                {           
                    echo "<td>". utf8_decode($row[$j])."</td>";           
                }
                echo "</tr>";

            }
            echo "</table>";
        }
        
        public static function cabeceraFormulario($mensaje,$nombres="",$controladores="")
        {
            if($nombres==""){
                return '<div class="span12">
                                <div class="widget">
                                  <div class="widget-header">
                                    <div class="title">
                                      '.$mensaje.'
                                    </div>
                                    </div>
                                    
                                       
                                   <div class="widget-body">
                <div align="center">
                 
                    <br />';
            }else{
            
            return '<div class="span12" >
                                <div class="widget">
                                  <div class="widget-header">
                                    <div class="title">
                                      '.$mensaje.'
                                    </div>
                                  
                                    <span class="tools">
                                    
                                    <a class="btn btn-info btn-small" href='."$controladores".' data-original-title="">'."$nombres".'</a>

                                  </span>
                  
                                    </div> 
                                  <div class="widget-body">
                <div align="center">
                

                 <br />   ';
        }
        }
        public static function fomularioModal($controller, $action)
        {
           //return 'window.showModalDialog("sgi.php?controller='.$controller.'&action='.$action.'", "", "dialogHeight: 600px; dialogWidth: 800px; dialogTop: 100px; dialogLeft: 100px; center: on; resizable: off; status: off; location:off")';
           return 'window.open("sgi.php?controller='.$controller.'&action='.$action.'","ServiMedical","scrollbars=yes,fullscreen=yes,center=no,help=no,status=no,resizable=no")'; 
        }
        
    public static function optionButton($label,$opciones, $id,$select="")
    {  

        echo "<ul class=\"checklist\">";
                         echo '<br>';

        echo'<label for="select-input"> <b>'.$label.'</b></label>';

        echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

        for($i=0;$i<=count($opciones)-1;$i++)
        {   
            echo "<input name=\"".$id."\" value=\"".$i."\"  type=\"radio\" id=\"".$id.$i."\"/>";
            echo "<label for=\"".$id."choice_a".$i."\">".$opciones[$i]."</label>";
            
        }
                echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        
        echo "</ul>";
        
        if(isset($select))
        {
            $data = explode("-",$select);
        ?>
        <script>
            $('input:radio[name=<?php echo $data[0] ?>]:nth(<?php echo $data[1]  ?>)').attr('checked',true);

        </script>
                
        <?php
      }
    }
    
    public static function camara($nombre)
    {
         echo '<iframe frameborder="0" height="300px" scrolling="no" width="100%" src="'.STR_DIR_DEFAULTH.'camara/camara.php?codigo='.$nombre.'"></iframe>';
    }
    
}
?>
