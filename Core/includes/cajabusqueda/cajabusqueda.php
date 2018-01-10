<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<?php require_once '../includes.php';


Formulario::abrirformfield('#', 'POST', 'formbusqueda');
echo "<table border='1'>";
echo "<tr>";
echo "<td>";
echo Formulario::textboxfield('id_origen', 'hidden', $_GET["id_origen"]);
echo Formulario::textboxfield('busqueda', 'hidden', $_GET["busqueda"]);
echo "Buscar:";
echo "</td>";
echo "<td>";
echo Formulario::textboxfield('user', 'text');
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2'>";
echo Formulario::buttonfield('btn_buscar', 'submit', 'Buscar');
echo "</td>";
echo "</tr>";
echo "</table>";
Formulario::cerrarformfield();

if(!is_null($_POST['user']))
{
    switch ($_POST['busqueda']) {
        case 'medicamentos':
            $sql = "SELECT * FROM general_medicamentos WHERE producto LIKE '%" . $_POST['user'] . "%' ";
            $consulta= consulta::ejecutar_consulta($sql);
            echo "Resultados de la Busqueda";
            while($row = consulta::pasar_a_array($consulta))
            {
            ?>
              <table width="250" border="1">
                <tr>
                  <td width="70"> <a href="javascript:void(0)" onClick="window.opener.document.getElementById('<?php echo $_GET["id_origen"]; ?>').value = '<?php echo $row["id"];?>'; window.opener.document.getElementById('<?php echo $_GET["id_origen"]; ?>').focus();window.opener.document.getElementById('<?php echo $_GET["id_origen"]."lbl"; ?>').value = '<?php echo $row["producto"];?>'; window.close(); return false; ">
                      <?php echo $row["cod_cie"];?></a></td>
                  <td width="180"><?php echo $row["producto"];?></td>
                </tr>
              </table>
            <?php
            }
            break;


        default:
            echo "Ocurrio Un error en la busqueda por favor ingrese nuevamente al Sistema, Comuniquese con el Administrador del Sistema ya que puede ser Posible que no se haya Administrado este Item";
            break;
    }
}


