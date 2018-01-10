<?php
	require_once 'includes/includes.php';    
	$sql="SELECT * FROM general_movimientos_head_adjustment WHERE idunico='".$_GET["id"]."'";   
	$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

	$sql="SELECT * FROM general_movimientos WHERE idunico='".$_GET["id"]."'";   
	$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

	$sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["usuario"]."'";
	$cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

	$sql="SELECT * FROM general_params where grupo ='term_pago' AND value='".$cliente[0]["condicion_pago"]."'";
	$termPago = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

	$cantTotal=0; // total items
	$subtotal = 0; //sumatoria de netos
	$descuentoTotal = 0; // descuento total
	$totalTotales = 0; // sumatoria totales
	$ivaTotal = 0;
	for($i=0;$i<count($detalles);$i++)
	{
		$sql = "SELECT * FROM general_products_services WHERE idunico='".$detalles[$i]['id_producto']."'";
		$product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
		$sql = "SELECT * FROM general_tax WHERE id='".$product[0]['idIva']."'";
		$iva = consulta::convertir_a_array(consulta::ejecutar_consulta($sql))[0]['porc_impu'];

		$cantTotal += $detalles[$i]['cantidad'];
		$totalDetalle = $detalles[$i]['valor_total'];
		$totalTotales += $totalDetalle;

		$base = ($totalDetalle / $detalles[$i]['cantidad']) / (1 + ($iva / 100));

	    $subtotal += $base * $detalles[$i]['cantidad'];

	    $ivaTotal += (($totalDetalle / $detalles[$i]['cantidad']) - $base) * $detalles[$i]['cantidad'];
	    $descuentoTotal += ($detalles[$i]['precio_costo'] * $detalles[$i]['cantidad'])*(1 + ($iva/100)) - $totalDetalle;
	}
?>
<page backtop="45mm" backbottom="60mm" backleft="1mm" backright="5mm" format="letter" > 

<page_footer>
	<table border='0' style="font-size: 11pt;width: 100%; text-align: center">
		<tr>
			<!-- <td style="width: 200px;text-align: center"><b>CONDICION</b></td> -->
			<td style="width: 50px;text-align: center"><b>LINEAS</b></td>
			<td style="width: 50px;text-align: center"><b>ITEMS</b></td>
			<td style="width: 120px;text-align: center"><b>SUBTOTAL</b></td>
			<!-- <td style="width: 100px;text-align: center"><b>DESCUENTO</b></td> -->
			<td style="width: 90px;text-align: center"><b>IVA</b></td>
			<td style="width: 120px;text-align: center"><b>TOTAL</b></td>
		</tr>
		<tr>
			<!-- <td style="text-align: center"><?php echo $termPago[0]["text"] ?></td> -->
			<td style="text-align: center"><?php echo count($detalles) ?></td>
			<td style="text-align: center"><?php echo $cantTotal;?></td>  
			<td style="text-align: center"><?php echo "$ ".number_format($subtotal, 0)?></td>
			<!-- <td style="text-align: center"><?php echo "$ ".number_format($descuentoTotal, 0)?></td> -->
			<td style="text-align: center"><?php echo "$ ".number_format($ivaTotal, 0)?></td>
			<td style="text-align: center"><?php echo "$ ".number_format($totalTotales, 0)?></td>
		</tr>
	</table>
</page_footer>
<page_header>
	<table border='0' style="font-size: 7pt;width: 100%;">
		<tr>
			<td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
			<td style="text-align: center; font-size: 13px; width: 300px; height: 120px">CALLE 15# 11 88 AV. SAN CARLOS<BR/> TELEFONO 2769068 - 2746796<BR/>SINCELEJO - SUCRE<BR/>REGIMEN SIMPLIFICADO</td>
			<td style="text-align: center; font-size: 13px;   width: 150px; height: 120px">AJUSTE DE INVENTARIO<BR/>No <b><?php echo $cabecera[0]["id"] ?></b></td>
		</tr>
		<tr align='center'>
			<td style="text-align: center; font-size: 13px;"><?php 
			echo "DISTRIBUIDORA MAS SALUD";
			?></td>
		</tr>
		<tr align='center'>
			<td style="text-align: center; font-size: 13px;"><?php 
			echo "NIT 64.701.076-0";
			?></td>                                
		</tr>
	</table>
</page_header>
	
<div>
	
	<table style="font-size: 9pt; width:100%;"  >
		<tr>
			<td style='width: 200px;'><b>DESCRIPCION</b></td>            
			<td style='width: 100px;'><b>COMERCIAL</b></td>            
			<td style='width: 100px;'><b>LABORATORIO</b></td>
			<td style='width: 50px;'><b>TIPO</b></td>
			<td style='width: 40px;'><b>CANT</b></td>
			<td style='width: 50px;'><b>PRECIO</b></td>
			<td style='width: 30px;'><b>IVA</b></td>            
			<td style='width: 100px;'><b>TOTAL</b></td>
		</tr>
	<?php 
	for($i=0;$i<count($detalles);$i++)
	{
		$datospro[0]="*";
		$sql="SELECT * FROM general_products_services WHERE idunico='".$detalles[$i]['id_producto']."'";
		$product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql)); 
		$sql = "SELECT * FROM general_tax WHERE id='".$product[0]['idIva']."'";
		$iva = consulta::convertir_a_array(consulta::ejecutar_consulta($sql))[0]['porc_impu'];
	?>
		<tr>
			<td><?php echo $product[0]["nombre"] ?></td>            
			<td><?php echo $product[0]["nombre_comercial"] ?></td>
			<?php
				$sql="SELECT text as nombre FROM general_params WHERE value='".$product[0]["laboratorio"]."' AND grupo='laboratorios'";
				$laboratorio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
			?>
			<td><?php echo $laboratorio[0]["nombre"] ?></td>            
			<td><?php echo $detalles[$i]['tipo']?></td>
			<td><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
			<td><?php echo number_format(($detalles[$i]['precio_costo']),0) ?></td>
			<td><?php echo $iva ?></td>
			<?php 
			if($detalles[$i]['tipo']=="salida")
			{
			 ?>
			
				<td><?php echo number_format($detalles[$i]['valor_total']*-1,0) ?></td>
			<?php } ?>
			<?php 
			if($detalles[$i]['tipo']=="entrada")
			{
			 ?>
			
				<td><?php echo number_format($detalles[$i]['valor_total'],0) ?></td>
			<?php } ?>
		</tr>
	<?php    
		}
	?>
	</table>
</div>
</page>     