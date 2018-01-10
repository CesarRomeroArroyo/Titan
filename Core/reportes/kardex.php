<style type="text/css">
table {border-collapse:collapse}
td {border:1px solid black}
</style>
<?php require_once 'includes/includes.php'; 
$sql="SELECT * FROM general_products_services WHERE id='".$_GET["id"]."'";
$producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
$sql="SELECT * FROM general_movimientos WHERE id_producto='".$producto[0]["idunico"]."'";
$stock= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

?>
<page orientation="portrait" backtop="5mm" backbottom="5mm" backleft="1mm" backright="5mm" format="LETTER" > 
	<table class="tableborder" style="width: 700px; border: 1px solid black; padding-left: 10px;font-weight: bold; ">            
	    <tr>
	        <td style="width: 450px">Producto: <?php echo $producto[0]["nombre"]?></td>
	        <td style="width: 250px">Codigo Barras: <?php echo $producto[0]["codigo_barras"]?></td>
	    </tr>
	    <tr>
	        <td style="width: 450px">Ultimo Costo: <?php echo number_format($producto[0]["p_costo_pro"])?></td>
	        <td style="width: 250px">Ultimo Descuento 1: <?php echo $producto[0]["desc1"]?></td>
	    </tr>
	    <tr>
	        <td style="width: 450px"></td>
	        <td style="width: 250px">Ultimo Descuento 2: <?php echo $producto[0]["desc2"]?></td>
	    </tr>
	</table>
<br/>
	<table style="border-width: 2px; border-style: solid;">  
		<tr style="font-weight: bold;">
			<td>Tipo</td>
			<td>Fecha</td>
			<td>Detalle</td>
			<td>Origen</td>
			<td>Destino</td>
			<td>Doc Ref.</td>
			<td>Cant</td>
			<td>Costo</td>
			<td>Precio</td>
			<td>Total</td>
		</tr>
		<?php 
		for ($i=0; $i < count($stock); $i++) { 
		?>	
			<tr>
				<td style="width: 50px; font-size: 5px overflow: hidden;"><?php 
				$tipo =$stock[$i]["tipo"];
				if($stock[$i]["tipo"]=="entrada_traspaso")
				{
					$tipo ="entrada";
				}
				if($stock[$i]["tipo"]=="salida_traspaso")
				{
					$tipo ="salida";
				}
				echo $tipo ?></td>
				<td style="width: 70px; overflow: hidden;"><?php echo Utils::formato_fecha_sql_a_normal($stock[$i]["fecha"]) ?></td>
				<td style="width: 100px; overflow: hidden;"><?php echo $stock[$i]["detalle"] ?></td>
				<td style="width: 90px; overflow: hidden;"><?php echo $stock[$i]["nombre_origen"] ?></td>
				<td style="width: 90px; overflow: hidden;"><?php echo $stock[$i]["nombre_destino"] ?></td>				
				<td style="width: 70px; overflow: hidden;"><?php echo $stock[$i]["n_fact"] ?></td>
				<td style="width: 30px; overflow: hidden;text-align: center"><?php echo $stock[$i]["cantidad"] ?></td>
				<td style="width: 70px; overflow: hidden;"><?php echo number_format($stock[$i]["precio_costo"])?></td>
				<td style="width: 70px; overflow: hidden;"><?php echo number_format($stock[$i]["precio_venta"])?></td>
				<td style="width: 70px; overflow: hidden;"><?php echo number_format($stock[$i]["valor_total"])?></td>
			</tr>
		<?php 
		}
		 ?>
	</table>

</page>