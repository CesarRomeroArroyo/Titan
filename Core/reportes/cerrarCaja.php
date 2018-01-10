<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm" style="font-family:arial; font-size:7pt;" format="76x797" > 
<?php
require_once 'includes/includes.php';    

$sql="SELECT * FROM invoice_head_pos WHERE uniqueid_closed='".$_GET["idunico"]."' AND estado=1";   
$invoice = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM invoice_head_pos WHERE uniqueid_closed='".$_GET["idunico"]."' AND estado=2";   
$invoiceCancel = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT forma_pago, SUM(pago) as valor FROM invoice_payment_form_pos WHERE idinvoice IN (SELECT idunico FROM invoice_head_pos WHERE uniqueid_closed='".$_GET["idunico"]."' AND estado=1) GROUP BY forma_pago";   
$formaPago = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT sum(totaltotales) as total, SUM(totaliva) as totIva FROM invoice_head_pos WHERE uniqueid_closed='".$_GET["idunico"]."' AND estado=1 GROUP BY uniqueid_closed";   
$totales = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM cashbox_moves WHERE uniqueid_closed='".$_GET["idunico"]."' AND tipo=1";
$cierre = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM cashbox_moves WHERE uniqueid_closed='".$_GET["idunico"]."' AND tipo=2";
$base = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT sum(valor) as valor FROM cashbox_moves WHERE uniqueid_closed='".$_GET["idunico"]."' AND tipo=3";
$salidas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM usuario WHERE codigo='".$cierre[0]["idvendedor"]."'";
$user = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
?>  
<div style="text-align:  center">
Cierre de Caja del <?php echo Utils::formato_fecha_sql_a_normal($cierre[0]["fecha"]) ?>, <br/>Vendedor: <?php echo  $user[0]["Nombre"]?><br/>
 Valor del Cierre: <?php echo "$ ". number_format($totales[0]["total"]-$salidas[0]["valor"]) ?> <br/>
 -------------------------- --------------------------
 <br/>Movimientos de Caja 
<table>
	<tr>
		<td> Movimiento </td>		
		<td> Valor </td>
	</tr>
	<tr>
		<td> Base de Apertura </td>		
		<td> <?php echo "$ ". number_format($base[0]["valor"]) ?> </td>
	</tr>
	<tr>
		<td> Entradas </td>		
		<td> <?php echo "$ ". number_format($totales[0]["total"]) ?> </td>
	</tr>
	<tr>
		<td> IVA </td>		
		<td> <?php echo "$ ". number_format($totales[0]["totIva"]) ?> </td>
	</tr>
	<tr>
		<td> Salidas </td>		
		<td> <?php echo "$ ". number_format($salidas[0]["valor"]) ?> </td>
	</tr>
	
</table>
 -------------------------- --------------------------<br>
 Facturas Realizadas 
<table>
	<tr>
		<td> Numero </td>
		<td> Fecha </td>
		<td> Valor </td>
	</tr>
	<?php for ($i=0; $i < count($invoice); $i++) { ?>
	<tr>
		<td><?php echo $invoice[$i]["numfactura"] ?></td>
		<td><?php echo Utils::formato_fecha_sql_a_normal($invoice[$i]["fecha"])?></td>
		<td><?php echo number_format($invoice[$i]["totaltotales"]) ?></td>		
	</tr>
	<?php } ?>
</table>
 --------------------------  --------------------------<br>
 Facturas Canceladas 
<table>
	<tr>
		<td> Numero </td>
		<td> Fecha </td>
		<td> Valor </td>
	</tr>
	<?php for ($i=0; $i < count($invoiceCancel); $i++) { ?>
	<tr>
		<td><?php echo $invoiceCancel[$i]["numfactura"] ?></td>
		<td><?php echo Utils::formato_fecha_sql_a_normal($invoiceCancel[$i]["fecha"])?></td>
		<td><?php echo number_format($invoiceCancel[$i]["totaltotales"]) ?></td>		
	</tr>
	<?php } ?>
</table>
 --------------------------  --------------------------<br>
 Formas de Pago 
<table>
	<tr>
		<td> Forma Pago </td>		
		<td> Valor </td>
	</tr>
	<?php for ($i=0; $i < count($formaPago); $i++) { ?>
	<tr>
		<td><?php echo $formaPago[$i]["forma_pago"] ?></td>
		<td><?php echo number_format($formaPago[$i]["valor"]) ?></td>		
	</tr>
	<?php } ?>
</table>
</div>
</page>     
