<?php
require_once 'formClass.php';
require_once 'utilsClass.php';
require_once 'validacionesClass.php';
require_once 'ajaxClass.php';
class formBuilder
{
    public static function generar_formulario_insercion($formulario, $tituloform='', $ajax=false, $div='', $destino='')
    {
        $i=0;
        $j=0;        
        $datosForm[0]='*';
        $tablaForm='general_formulario';
        $dondeForm="formulario= '".$formulario."' and mostrar ='1'";
        $ordenForm='ORDER BY orden';
        $sqlForm = consulta::seleccionar($datosForm, $tablaForm, $dondeForm, $ordenForm);
        $consulta=consulta::ejecutar_consulta($sqlForm);
        $numDatos=consulta::numero_col($consulta);
        
        
        //echo "<div style";
        echo "<div width='100%' id=\"".$formulario."\" >";
                
            echo "<div width='100%' style=\"display: block\" >";
                echo "<table width='200' border='0' ><tr>";
                echo "<td align='center' colspan= '4'>";
                            echo "<h3>                            
                            <b>".strtoupper($tituloform)."</b>
                            </h3>";
                            echo"</td></tr>";			
                            echo "<tr>";
                    while($rw=consulta::pasar_a_array($consulta))
                    {   
                        if($ajax==true)
                        {                                        
                           $ajaxArray[$j]= $rw['variable'];
                           $j++; 
                        }
                        if($rw['seccion']==1)//Con titulo de seccion Arriba
                        {
                            echo "<td align='center' colspan= '4'>";
                            echo "<br/><h5>                            
                            ".$rw['titulosec']."
                            </h5><hr/>";
                            echo"</td></tr>";			
                            echo "<tr>";
                        }                        
                        
                        $title=strtoupper($rw['titulo']);                        
                        echo "<td><font color='black'><b>".ucfirst(strtolower($title))."</b></font></td>";//Titulo de la variable
                        
                        switch ($rw['tipo']) {
                            case '1':
                                $i++;
                                echo "<td>". Formulario::textboxfield($rw['variable'], 'text', $rw['defecto'])."</td>";
                            break;
                            case '2':
                                $i++;
                                echo "<td>".  Formulario::comboboxfield($rw['variable'], $rw['valores'],$rw['defecto'])."</td>";
                            break;
                            case '3':
                                $i++;
                                echo "<td>".  Formulario::datefield($rw['variable'],$rw['defecto'])."</td>";
                            break;
                            case '5':
                                $i++;
                                echo "<td><br/>".  Formulario::textareafield($rw['variable'],$rw['defecto'],10,10)."</td>";
                            break;
                            case '6':
                                $i++;
                                echo "<td>".  Formulario::autocompletefield($rw['variable'], $rw['archivo'],$rw['defecto'])."</td>";
                            break;

                            default:
                                break;
                        }
                        
                        if($rw['seccion']==2)//Con titulo de seccion Abajo
                        {
                            echo "</tr><tr><td align='center' colspan= '4'>";
                            echo "<br/><h5>                            
                            ".$rw['titulosec']."
                            </h5><hr/>";
                            echo"</td></tr>";
                            $i=0;
                        }
                        if($i==2)//salto de fila se genera un nueva fila apartir de aqui
                        {
                            echo"</tr>";
                            $i=0;
                        }
                    }
                echo "</table>";
            echo "</div>";        
            $valorajax=ajax::anexar_array_ajax($ajaxArray);
        echo "</div>";  
        
        if($ajax==true)
        {
            ajax::generar_funcion_ajax("f_".$formulario, $destino, $div, $valorajax, "Procesando Datos del Formulario");
        }
        
    }
    
    public static function generar_formulario_actualizacion($formulario,$donde, $tabla, $tituloform='', $ajax=false, $div='', $destino='')
    {
        $actualform[0]='*';        
        $sql=consulta::seleccionar($actualform, $tabla, $donde);
        $query = consulta::ejecutar_consulta($sql);

        while($row=consulta::pasar_a_array($query))
        {
            $i=0;
        $j=0;        
        $datosForm[0]='*';
        $tablaForm='general_formulario';
        $dondeForm="formulario= '".$formulario."' and mostrar ='1'";
        $ordenForm='ORDER BY orden';
        $sqlForm = consulta::seleccionar($datosForm, $tablaForm, $dondeForm, $ordenForm);
        $consulta=consulta::ejecutar_consulta($sqlForm);
        $numDatos=consulta::numero_col($consulta);
        
        
        //echo "<div style";
        echo "<div width='100%' id=\"".$formulario."\" >";
                
            echo "<div width='100%' style=\"display: block\" >";
                echo "<table width='200' border='0' ><tr>";
                echo "<td align='center' colspan= '4'>";
                            echo "<h3>                            
                            <b>".strtoupper($tituloform)."</b>
                            </h3>";
                            echo"</td></tr>";			
                            echo "<tr>";
                    while($rw=consulta::pasar_a_array($consulta))
                    {   
                        if($ajax==true)
                        {                                        
                           $ajaxArray[$j]= $rw['variable'];
                           $j++; 
                        }
                        if($rw['seccion']==1)//Con titulo de seccion Arriba
                        {
                            echo "<td align='center' colspan= '4'>";
                            echo "<br/><h5>                            
                            ".$rw['titulosec']."
                            </h5><hr/>";
                            echo"</td></tr>";			
                            echo "<tr>";
                        }                        
                        
                        $title=strtoupper($rw['titulo']);                        
                        echo "<td><font color='black'><b>".ucfirst(strtolower($title))."</b></font></td>";//Titulo de la variable
                        
                        switch ($rw['tipo']) {
                            case '1':
                                $i++;
                                echo "<td>". Formulario::textboxfield($rw['variable'], 'text', $row[$rw['variable']])."</td>";
                            break;
                            case '2':
                                $i++;
                                echo "<td>".  Formulario::comboboxfield($rw['variable'], $rw['valores'],$row[$rw['variable']])."</td>";
                            break;
                            case '3':
                                $i++;
                                echo "<td>".  Formulario::datefield($rw['variable'],$row[$rw['variable']])."</td>";
                            break;
                            case '5':
                                $i++;
                                echo "<td><br/>".  Formulario::textareafield($rw['variable'],$row[$rw['variable']],10,10)."</td>";
                            break;
                            case '6':
                                $i++;
                                echo "<td>".  Formulario::autocompletefield($rw['variable'], $rw['archivo'],$row[$rw['variable']])."</td>";
                            break;

                            default:
                                break;
                        }
                        
                        if($rw['seccion']==2)//Con titulo de seccion Abajo
                        {
                            echo "</tr><tr><td align='center' colspan= '4'>";
                            echo "<br/><h5>                            
                            ".$rw['titulosec']."
                            </h5><hr/>";
                            echo"</td></tr>";
                            $i=0;
                        }
                        if($i==2)//salto de fila se genera un nueva fila apartir de aqui
                        {
                            echo"</tr>";
                            $i=0;
                        }
                    }
                echo "</table>";
            echo "</div>";        
            $valorajax=ajax::anexar_array_ajax($ajaxArray);
        echo "</div>";              
        }
        if($ajax==true)
        {
            ajax::generar_funcion_ajax("f_".$formulario, $destino, $div, $valorajax, "Procesando Datos del Formulario");
        }
    }
        
    public static function generar_formulario_preeliminar($rw)
    {        
        echo "<script>
                $(function() {
                    $( \"#formTest\" ).accordion();
                });
              </script>";
        
        echo "<div id=\"formTest\">";
       
            echo "<h3>".  strtoupper("VISTA PREELIMINAR")."</h3>";
        
            echo "<div>";
                echo "<table width='100%' border='0'></tr><tr>";
                    for($k=0;$k<=count($rw);$k++)
                    {   
                        
                        if($rw[$k]['seccion']==1 && $rw[$k]['mostrar']==1)//Con titulo de seccion Arriba
                        {
                            echo "<td align='center' colspan= '4'>";
                            echo "<h3 id=\"ui-accordion-Array-header-0\" class=\"ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons\" role=\"tab\" aria-controls=\"ui-accordion-Array-panel-0\" aria-selected=\"true\" tabindex=\"0\">
                            <span class=\"ui-accordion-header-icon ui-icon ui-icon-triangle-1-s\"></span>
                            ".$rw[$k]['titulosec']."
                            </h3>";
                            echo"</td></tr>";			
                            echo "<tr>";
                        }                        
                        if($rw[$k]['mostrar']==1)
                        {
                            $title=strtoupper($rw[$k]['titulo']);                        
                            echo "<td><font color='black'><b>".ucfirst($title)."</b></font><br>";//Titulo de la variable

                            switch ($rw[$k]['tipo']) {
                                case '1':
                                    $i++;
                                    echo Formulario::textboxfield($rw[$k]['variable'], 'text')."</td>";
                                break;
                                case '2':
                                    $i++;
                                    echo Formulario::comboboxfield($rw[$k]['variable'], $rw[$k]['valores'])."</td>";
                                break;
                                case '3':
                                    $i++;
                                    echo Formulario::datefield($rw[$k]['variable'])."</td>";
                                break;
                                case '5':
                                    $i++;
                                    echo Formulario::textareafield($rw[$k]['variable'])."</td>";
                                break;
                                case '6':
                                    $i++;
                                    echo Formulario::autocompletefield($rw[$k]['variable'], $rw[$k]['archivo'])."</td>";
                                break;

                                default:
                                    break;
                            }
                        }
                        if($rw[$k]['seccion']==2 && $rw[$k]['mostrar']==1)//Con titulo de seccion Abajo
                        {
                            echo "</tr><tr><td align='center' colspan= '4'>";
                            echo "<h3 id=\"ui-accordion-Array-header-0\" class=\"ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons\" role=\"tab\" aria-controls=\"ui-accordion-Array-panel-0\" aria-selected=\"true\" tabindex=\"0\">
                            <span class=\"ui-accordion-header-icon ui-icon ui-icon-triangle-1-s\"></span>
                            ".$rw[$k]['titulosec']."
                            </h3>";
                            echo"</td></tr>";
                            $i=0;
                        }
                        if($i==4)//salto de fila se genera un nueva fila apartir de aqui
                        {
                            echo"</tr>";
                            $i=0;
                        }
                    }
                echo "</table>";
            echo "</div>";        
        
        echo "</div>";          
    }
        
    public static function crear_configuracion_formulario($tabla)
    {
        $formulario=$tabla;
        echo "<script>
                    $(function() {
                        $( \"#".$formulario."\" ).accordion();
                    });
                  </script>";


            echo "<div width=\"100%\" id=\"".$formulario."\">";
?>
        <h3>CREAR CONFIGURACION DE FORMULARIO <?php echo strtoupper($tabla);?></h3>
        <div>
            <br /><form action="?controller=forms&action=insertconfigform" method="post" name="conf_form">

            <table width="100%" border="0">          
              <tr>
                <td width="70%"><b>FORMULARIO A CONFIGURAR</b></td>
                <td width="30%"><input name="formulario" id="formulario" readonly="true"  type="text" value="<?php echo $tabla;?>" /></td>
              </tr>
            </table>

            <br />

            *Este Valor solo es valido para Capturas por ComboBox, Ejemplo: 1-SI-2-NO-3-DESCONOCIDO<br />

            **Este Valor solo es valido para cajas de Texto con Busquedas y Texto Autocompletables<br />



            <table width='200' border='0' style="background-color: white"><tr>

            <tr align="center">

            <td><strong>Nombre de la Variable</strong></td>

            <td><strong>Titulo de la Variable</strong></td>

            <td><strong>Forma de Captura</strong></td>

            <td><strong>Valores Permitidos*</strong></td>

            <td><strong>Archivo de Busqueda**</strong></td>

            <td><strong>Posicion Titulo de Seccion?</strong></td>

            <td><strong>Titulo de Seccion</strong></td>

            <td><strong>Visible en Formulario?</strong></td>

            <td><strong>Orden</strong></td>
            
            <td><strong>Valor por Defecto</strong></td>

            </tr>
            <tr>
                <td colspan="10"><h3 id="ui-accordion-Array-header-0" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" role="tab" aria-controls="ui-accordion-Array-panel-0" aria-selected="true" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                            
                            </h3></td>
            </tr>
            <?php

                    //Funcion que devuele un string con el nombre de las columnas

                    //de una tabla, recibe el nombre de la tabla y la variable conexion

                    //generada por la funcion conectar

                    $sql="SHOW COLUMNS FROM ". $tabla;
                    $consulta=consulta::ejecutar_consulta($sql);
                    $i=0;
                    $k=0;
                    while($rw=consulta::pasar_a_array($consulta))
                    {
                        $i+=1;
                        echo"<tr align='center'>";

                        echo"<td align='center'><input style='width:100px' name='variable_".$i."' id='variable_".$i."' type='text' value=".$rw['Field']." style='width:100px' readonly='readonly'></td>";
                        $array[$k]="variable_".$i;
                        $k++;
                        echo"<td><input style='width:90px' name='titulo_".$i."' id='titulo_".$i."' type='text'/></td>";
                        $array[$k]="titulo_".$i;
                        $k++;
                        echo"<td><select style='width:90px' name='tipo_".$i."' id='tipo_".$i."'>                                
                         <option value='1'>Caja de Texto</option>

                         <option value='2'>Lista/Menu (ComboBox)</option>

                         <option value='3'>Fecha</option>

                        <option value='4'>Caja de Texto de Busqueda</option>

                         <option value='5'>Area de Texto</option>

                        <option value='6'>Caja de Texto Autocompletable</option>

                         </select></td>";
                        $array[$k]="tipo_".$i;
                        $k++;
                        echo"<td><input name='valores_".$i."' id ='valores_".$i."' style='width:120px' type='text'/></td>";
                        $array[$k]="valores_".$i;
                        $k++;
                        echo"<td><select name='archivo_".$i."' id='archivo_".$i."' style='width:120px'>

                        <option></option>

                        <option value='aseguradoras'>Aseguradoras</option>

                        <option value='categorias'>Categorias</option>

                        <option value='barrios'>Barrios</option>

                        <option value='municipio'>Municipios</option>

                        <option value='ocupaciones'>Ocupaciones</option>

                        <option value='upgd_hab'>Prestadoras</option>

                        <option value='pai_insumos'>Insumos Kardex</option>

                        <option value='pai_insumos_individual'>Insumos Individual</option>

                        <option value='cie10'>Codigo CIE10</option>

                        <option value='laboratorios'>Laboratorios</option>

                        <option value='eventos_brotes'>Eventos de Brotes</option>

                        </select></td>";
                        $array[$k]="archivo_".$i;
                        $k++;

                        echo"<td><select style='width:90px' name='seccion_".$i."' id='seccion_".$i."'>

                         <option value='0'>Sin Titulo</option>

                         <option value='1'>Arriba</option>

                         <option value='2'>Abajo</option>

                         </select></td>";
                        $array[$k]="seccion_".$i;
                        $k++;

                        echo"<td><input style='width:90px' name='titulosec_".$i."' id ='titulosec_".$i."' type='text'/></td>";
                        $array[$k]="titulosec_".$i;
                        $k++;

                        echo"<td><select style='width:70px' name='mostrar_".$i."' id='mostrar_".$i."'>

                         <option value='1'>SI</option>

                         <option value='2'>NO</option>

                         </select></td>";
                        $array[$k]="mostrar_".$i;
                        $k++;

                        echo"<td><input name='orden_".$i."' id ='orden_".$i."' style='width:22px' type='text'  value='".$i."'/></td>";
                        echo"<td><input name='defecto_".$i."' id ='defecto_".$i."' style='width:22px' type='text'  value=''/></td>";
                        $array[$k]="orden_".$i;
                        $k++;
                        echo"</tr>";
                    }             
            ?>

            </table>

            <input name="iterador" id="iterador" type="hidden" value="<?php echo $i;?>" />

            <input name="btn_conf_form" type="submit" value="Guardar Configuracion" />
            <?php echo Formulario::buttonfield('btnprevisual', 'button', 'Previsualizar Formulario', "f_preevisualiza_$tabla()");?>
             </form>
       </div>
     </div>  
     <div id="divPreConfForm"></div>
<?php
    $array[$k++]="iterador";
    $datosAjax = ajax::anexar_array_ajax($array);
    ajax::generar_funcion_ajax("f_preevisualiza_$tabla", STR_DIR_CLASSES_DEFAULTH."formBuilderPreviewFile.php", "divPreConfForm", $datosAjax);
}

    public static function  actualizar_configuracion_formulario($tabla)
    {        
        $formulario=$tabla;
        echo "<script>
                    $(function() {
                        $( \"#".$formulario."\" ).accordion();
                    });
                  </script>";


        echo "<div id=\"".$tabla."\">";
    ?>
     <h3>ACTUALIZAR CONFIGURACION DE FORMULARIO <?php echo strtoupper($tabla);?></h3>
    <div>
    <form action="?controller=forms&action=updateconfigform" method="post" name="conf_form">

        <input name="formulario" id="formulario"  type="hidden" value="<?php echo $tabla;?>" />
        <br />

        *Este Valor solo es valido para Capturas por ComboBox, Ejemplo: 1-SI-2-NO-3-DESCONOCIDO<br />

        **Este Valor solo es valido para cajas de Texto con Busquedas y Texto Autocompletables<br />



        <table width='200' border='0'><tr>

        <tr align="center">

        <td><strong>Nombre de la Variable</strong></td>

        <td><strong>Titulo de la Variable</strong></td>

        <td><strong>Forma de Captura</strong></td>

        <td><strong>Valores Permitidos*</strong></td>

        <td><strong>Archivo de Busqueda**</strong></td>

        <td><strong>Posicion Titulo de Seccion?</strong></td>

        <td><strong>Titulo de Seccion</strong></td>

        <td><strong>Visible en Formulario?</strong></td>

        <td><strong>Orden</strong></td>

        </tr>
        <tr>
                <td colspan="9"><h3 id="ui-accordion-Array-header-0" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons" role="tab" aria-controls="ui-accordion-Array-panel-0" aria-selected="true" tabindex="0">
                            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                            
                            </h3></td>
        </tr>
        <?php
        $sqlactform="SELECT * FROM general_formulario where formulario ='".$tabla."' order by orden";
        $k=0;
        
        $raw=consulta::ejecutar_consulta($sqlactform);
        while($r=consulta::pasar_a_array($raw))
        {
                $i+=1;

                echo"<tr align='center'>";

                echo"<td align='center'><input name='variable_".$i."' id='variable_".$i."' type='text' style='width:100px' value=".$r['variable']." readonly='readonly'></td>";
                $array[$k]="variable_".$i;
                        $k++;
                

                echo"<td><input name='titulo_".$i."' id='titulo_".$i."' type='text' style='width:150px' value='".$r['titulo']."'/></td>";
                $array[$k]="titulo_".$i;
                        $k++;
                
                $datostipo="1-CAJA DE TEXTO-2-LISTA / MENU (COMBOBOX)-3-FECHA-5-AREA DE TEXTO-6-CAJA DE TEXTO AUTOCOMPLETABLE";
                echo"<td>";
                //echo Formulario::combofieldarray("tipo_".$i, $aray, $r['tipo'],"120px");
                echo Formulario::comboboxfield("tipo_".$i, $datostipo, $r['tipo'],"120px");
                $array[$k]="tipo_".$i;
                        $k++;
                echo "</td>";


                echo"<td><input name='valores_".$i."' id ='valores_".$i."' type='text' style='width:120px' value='".$r['valores']."'/></td>";
                $array[$k]="valores_".$i;
                        $k++;
                
                $datosvalores="aseguradoras-ASEGURADORAS-categorias-CATEGORIAS-barrios-BARRIOS-municipios-MUNICIPIOS-ocupaciones-OCUAPCIONES-cie10-CODIGO CIE10-pruebas-PRUEBAS(LABORATORIOS)-agentes-AGENTES-upgd_hab-PRESTADORAS-pai_insumos-INSUMOS KARDEX-pai_insumos_individual-INSUMOS INDIVIDUAL-laboratorios-LABORATORIOS-eventos_brotes-EVENTOS DE BROTES";

                echo"<td>";                
                echo Formulario::comboboxfield("archivo_".$i, $datosvalores, $r['archivo'],"120px");
                $array[$k]="archivo_".$i;
                        $k++;
                echo"</td>";

                $datosseccion="0-SIN TITULO-1-ARRIBA-2-ABAJO";
                echo"<td>";
                
                echo Formulario::comboboxfield("seccion_".$i, $datosseccion, $r['seccion'],"120px");
                $array[$k]="seccion_".$i;
                        $k++;
                echo "</td>";

                echo"<td><input name='titulosec_".$i."' id ='titulosec_".$i."' type='text' style='width:120px' value='".$r['titulosec']."'/></td>";
                $array[$k]="titulosec_".$i;
                        $k++;
                
                $datossino="1-SI-2-NO";
                echo"<td>";                
                echo Formulario::comboboxfield("mostrar_".$i, $datossino, $r['mostrar'],"70px");
                echo "</td>";
                $array[$k]="mostrar_".$i;
                        $k++;


                echo"<td><input name='orden_".$i."' id ='orden_".$i."' type='text' style='width:22px' value='".$r['orden']."'/></td>";
                $array[$k]="orden_".$i;
                        $k++;
                echo"</tr>";

                }
        //}
        ?>

        </table>

            <input name="iterador" id="iterador" type="hidden" value="<?php echo $i;?>" />
            <input name="btn_conf_form" type="submit" value="Actualizar Configuracion" />
            <?php echo Formulario::buttonfield('btnprevisual', 'button', 'Previsualizar Formulario', "f_preevisualiza_$tabla()");?>
         </form>
    </div>
     </div>
     <div id="divPreConfForm"></div>
    <?php
     $array[$k++]="iterador";
    $datosAjax = ajax::anexar_array_ajax($array);
    ajax::generar_funcion_ajax("f_preevisualiza_$tabla", STR_DIR_CLASSES_DEFAULTH."formBuilderPreviewFile.php", "divPreConfForm", $datosAjax);
    }
    
    
}//fin clase formBuilder
?>
