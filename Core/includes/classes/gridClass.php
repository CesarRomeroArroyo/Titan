<?php
require_once 'utilsClass.php';
require_once 'consultaClass.php';
require_once 'formClass.php';
class Grid
{
    public static function JSFunctions($id)
    {
        echo '
                $(\'#'.$id.'\').dataTable( {                             
                "bJQueryUI": true,        
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sLengthMenu": "Mostrando _MENU_ Registros por Pagina",            
                    "sZeroRecords": "No se Encontraron Datos",            
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",            
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",            
                    "sInfoFiltered": "(Filtrado de _MAX_ Total de Registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {        
                        "sFirst": "<<",
                        "sLast": ">>",
                        "sNext": ">",
                        "sPrevious": "<"
                    }
                } 
            } );
            ';
    }
    
    public static function CreateGridFromQuerty($id, $titulos, $datos, $acciones,$tabla, $donde="1")
    {        
        echo '<div class="adv-table">
            <table class="display table table-bordered table-striped" id="dynamic-table">';
        echo "<thead><tr>";
        for($i=0;$i<=count($titulos)-1;$i++)
        {
            echo "<th data-filterable='true' data-sortable='true'>";
            echo $titulos[$i];
            echo "</th>";            
        }
        if($acciones['aplica']==true)
        {
            echo "<th>";
            echo "OPCIONES";
            echo "</th>";            
        }
        echo "</tr></thead>";
        $sql=  consulta::seleccionar($datos, $tabla, $donde);
        $consulta = consulta::ejecutar_consulta($sql);
        $retorno = consulta::convertir_a_array($consulta);
        
        echo "<tbody>";
        for($i=0;$i<=count($retorno)-1;$i++)
        {
            echo "<tr>";
            for($j=0;$j<=count($titulos)-1;$j++)
            {
                echo "<td>".  $retorno[$i][$j]."</td>"; 
            }
            if($acciones['aplica'] == true)
            {
                echo "<td>";                    
                for($a=0;$a<=count($acciones['accion'])-1;$a++)
                {
                    if(isset($acciones['accion'][$a]['confirma'])&&$acciones['accion'][$a]['confirma']==true)
                    {
                        echo '<script>
                                    function confirmGrid(i)
                                    {            
                                        var agree=confirm("¿'.$acciones['accion'][$a]['confirma']['mensaje'].'? ");
                                        if (agree) 
                                        {
                                            window.location.href = i;
                                        }
                                        else 
                                        {
                                            return false;
                                        }
                                    }
                                </script>';
                        echo Formulario::linkfield($acciones['accion'][$a]['mensaje'], "#","confirmGrid(\"".$acciones['accion'][$a]['pagina'].$retorno[$i][$acciones['id_unico']]."\")")."&nbsp;&nbsp;";                
                    }
                    else
                    {
                        echo Formulario::linkfield($acciones['accion'][$a]['mensaje'], $acciones['accion'][$a]['pagina'].$retorno[$i][$acciones['id_unico']])."&nbsp;&nbsp;";                
                    }
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo '</table></div>';
    }
 

    public static function CreateUsersGrid()
    {        
        echo '<div class="adv-table">
            <table class="display table table-bordered table-striped" id="dynamic-table">';
        echo "<thead><tr>";
        echo "<th data-sortable='true'>ID</th><th data-filterable='true' data-sortable='true'>USUARIO</th><th data-filterable='true' data-sortable='true'>NOMBRE</th><th data-filterable='true' data-sortable='true'>CODIGO</th><th data-filterable='true' data-sortable='true'>EMAIL</th>";
                  
        echo "<th>";
        echo "OPCIONES";
        echo "</th>";            
        
        echo "</tr></thead>";
        $datos[0]="iduser";
        $datos[1]="user";
        $datos[2]="Nombre";
        $datos[3]="codigo";        
        $datos[4]="email";
        $donde="1";
        $sql=  consulta::seleccionar($datos, "usuario", $donde);
        $consulta = consulta::ejecutar_consulta_sgi($sql);
        $retorno = consulta::convertir_a_array($consulta);
        echo "<tbody>";
        for($i=0;$i<=count($retorno)-1;$i++)
        {
            echo "<tr>";
            for($j=0;$j<=count($datos)-1;$j++)
            {
                echo "<td>".$retorno[$i][$j]."</td>"; 
            }
            
            echo "<td>";                                    
            //echo Formulario::linkfield(Formulario::imagenfield("editar.png", 20, 20, "Editar Datos de Usuario"), STR_DIR_CONTROLLER_DEFAULTH."application/editUsers/".$retorno[$i]['iduser'])."&nbsp;&nbsp;";
            echo Formulario::linkfield(Formulario::imagenfield("success.png", 20, 20, "Perfil"), STR_DIR_CONTROLLER_DEFAULTH. "application/userPerfil/".$retorno[$i]['iduser'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";                                            
            echo Formulario::linkfield(Formulario::imagenfield("pass.png", 20, 20, "Reiniciar Password"), STR_DIR_CONTROLLER_DEFAULTH."application/rebootpassadmin/".$retorno[$i]['iduser'])."&nbsp;&nbsp;";                                
                                            
            echo "</td>";

            echo "</tr>";
        }
        echo "</tbody>";
        echo '</table></div>';
    }

    public static function CreateGridFromArray($id, $titulos, $datos, $acciones)
    {        
        echo '<div id="dt_example" class="example_alt_pagination">
          <table class="table table-condensed table-striped table-hover table-bordered pull-left"  id="'.$id.'">';
        echo "<thead><tr>";
        for($i=0;$i<=count($titulos)-1;$i++)
        {
            echo "<th>";
            echo $titulos[$i];
            echo "</th>";            
        }
        if($acciones['aplica']==true)
        {
            echo "<th>";
            echo "OPCIONES";
            echo "</th>";            
        }
        echo "</tr></thead>";
        
        echo "<tbody>";
        for($i=0;$i<=count($datos)-1;$i++)
        {
            echo "<tr>";
            
            for($j=0;$j<=count($datos[$i])-1;$j++)
            {
                echo "<td>".utf8_decode($datos[$i][$j])."</td>"; 
                
            }
            if($acciones['aplica'] == true)
            {
                echo "<td>";                    
                for($a=0;$a<=count($acciones['accion'])-1;$a++)
                {
                    echo Formulario::linkfield($acciones['accion'][$a]['mensaje'], $acciones['accion'][$a]['pagina'].$retorno[$i][$acciones['id_unico']])."&nbsp;&nbsp;";                
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo '</table></div>';
    }
    
    
    
}
?>
