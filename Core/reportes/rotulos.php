<?php require_once 'includes/includes.php';   
$sql="SELECT * FROM invoice_head WHERE numfactura='".$_POST["numfactura"]."'";   
$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM invoice_details WHERE idunico='".$cabecera[0]["idunico"]."'";   
$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idcliente"]."'";
$cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM general_municipios WHERE cod_mun='".$cliente[0]["ciu_sede_pri"]."'";
$ciudad = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
 ?>

 <page format="220x129" orientation="L" backtop="1mm" backbottom="1mm" backleft="1mm" backright="2mm"  > 
 
    <table border='0' style="font-size: 7pt;width: 100px">
        <tr>
            <td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
            
            <td style="text-align: right;   width: 450px; height: 120px"><b style="font-size: 23px; ">GUIA DE TRANSPORTE</b><br>
			<br>
			<label style="font-size: 18px">
				<?php echo $_POST["numfactura"] ?>
			</label>
            </td>
        
        </tr>                     
    </table>
    <table border="0">
    	<tr>
    		<td style="width: 220px">FECHA</td>
    		<td style="width: 520px"><?php echo date("d/m/Y"); ?></td>
    	</tr>
    	<tr>
    		<td style="width: 220px">DESTINATARIO</td>
    		<td style="width: 520px"><?php echo $cliente[0]["nom_rep_leg"]." ".$cliente[0]["ape_rep_leg"] ?></td>
    	</tr>
    	<tr>
    		<td style="width: 220px">NEGOCIO</td>
    		<td style="width: 520px"><?php echo $cliente[0]["raz_soc"] ?></td>
    	</tr>
    	<tr>
    		<td style="width: 220px">DIRECCION</td>
    		<td style="width: 520px"><?php echo $cliente[0]["dir_sede_pri"] ?></td>
    	</tr>
    	<tr>
    		<td style="width: 220px">CIUDAD</td>
    		<td style="width: 520px"><?php echo $ciudad [0]["nom_mun"]?></td>
    	</tr>
    	<tr>
    		<td style="width: 220px">ANEXOS</td>
    		<td style="width: 520px"><?php echo $_POST["anexos"] ?></td>
    	</tr>
    </table>
    <table>
    	<tr>
    		<td style="width: 740px; text-align: justify;">
    			<p >Estamos remitiendo con el señor__________________________________________________ Identificado con la cedula
N°______________________de_______________en el vehiculo______________________de
color____________________ placas________________________y telefono N°______________________
    		</p></td>
    	</tr>
    </table>
    <table border="1" style="border-collapse: collapse;">
    	<tr>
    		<td style="width: 370px">
    			<table>
    				<tr>
    					<td style="width: 185px">
    						# Cajas: 
    					</td>
    					<td style="width: 185px">
    						<?php echo $_POST["numcaja"] ?>
    					</td>
    				</tr>
    				<tr>
    					<td style="width: 185px">
    						# Paquetes: 
    					</td>
    					<td style="width: 185px">
    						
    					</td>
    				</tr>
    				<tr>
    					<td style="width: 185px">
    						Valor Flete: 
    					</td>
    					<td style="width: 185px">
    						$__________________
    					</td>
    				</tr>
    			</table>
    		</td> 
    		<td style="width: 370px; font-size: 11px">
    			Recibi de conformidad las cajas detalladas en la presente guia de transporte
				<br/>
				<br/><br/>
    			______________________________________________________
    			Firma,CC y Sello.
    		</td>    		
    	</tr>
    	<tr>
    		<td colspan="2" style="text-align:center; font-size: 11px">
    			Señor cliente al recibir la mercancia por favor revisela en presencia del transportador, si observa roturas, magulladuras o cualquier tipo de daño escriba en la
guia las observaciones.
    		</td>
    	</tr>
    </table>
    <br/>
    <b style="font-size: 10px">Pagina [[page_cu]] de [[page_nb]], Impreso el <?php echo date("d/m/Y") ?>, <?php echo date("G:H:s"); ?></b>
 </page>


<?php 
$numcaja=1;
for ($i=0; $i < $_POST["numcaja"]; $i++) { 
?>
<page format="220x129" orientation="L" backtop="1mm" backbottom="1mm" backleft="1mm" backright="2mm"  > 
 
	

    <table border='0' style="font-size: 9pt;width: 100px">
        <tr>
            <td style="width: 640px;text-align: center"><img src="images/mustralogo.png" style="width: 300px; height: 90px ;" alt=""/>
            </td>
            <td style="width: 220px" rowspan="3">
    			<img style="width: 130px;height: 400px" src="<?php echo STR_DIR_IMAGE_DEFAULTH ?>rotulos.png">
    		</td>
        </tr>                        
    	<tr>
    		<td style="width: 640px">
    			<p style="font-size: 20px">!!! PRODUCTOS FARMACEUTICOS TRATAR CON CUIDADO ¡¡¡</p>
    		</td>    		
    	</tr>
    	<tr>
    		<td style="width: 640px">
    			<table>
    				<tr>
    					<td style="width: 120px">
    						FACTURA 
    					</td>
    					<td style="width: 520px">
    						<?php echo $_POST["numfactura"] ?>
    					</td>
    				</tr>
    				<tr>
    					<td style="width: 120px">
    						FECHA 
    					</td>
    					<td style="width: 520px">
    						<?php echo Utils::formato_fecha_sql_a_normal($cabecera[0]["fecha"]) ?>
    					</td>
    				</tr>
    				<tr>
			    		<td style="width: 120px">DESTINATARIO</td>
			    		<td style="width: 520px"><?php echo $cliente[0]["nom_rep_leg"]." ".$cliente[0]["ape_rep_leg"] ?></td>
			    	</tr>
			    	<tr>
			    		<td style="width: 120px">NEGOCIO</td>
			    		<td style="width: 520px"><?php echo $cliente[0]["raz_soc"] ?></td>
			    	</tr>
			    	<tr>
			    		<td style="width: 120px">DIRECCION</td>
			    		<td style="width: 520px"><?php echo $cliente[0]["dir_sede_pri"] ?></td>
			    	</tr>
			    	<tr>
			    		<td style="width: 120px">CIUDAD</td>
			    		<td style="width: 520px"><?php echo $ciudad [0]["nom_mun"]?></td>
			    	</tr>
			    	<tr>
			    		<td style="width: 120px"># CAJAS</td>
			    		<td style="width: 520px"><?php echo $_POST["numcaja"];?></td>
			    	</tr>			    	
			    	<tr>			    		
			    		<td style="border: black 1px solid;font-size: 15px; width: 640px; text-align: center" colspan="2">
			    			FLETES PAGADOS POR LA COMPAÑIA
			    		</td>
			    	</tr>
			    	<tr>			    		
			    		<td style="width: 640px; text-align: center" colspan="2">
			    			Señor cliente al recibir la mercancia por favor revisela en presencia del transportador, si observa roturas,
magulladuras o cualquier tipo de daño escriba en la guia las observaciones.
			    		</td>
			    	</tr>
    				
    			</table>
    		</td>    		
    	</tr>
   		
    </table>
   
    <b style="font-size: 10px">Pagina [[page_cu]] de [[page_nb]], Impreso el <?php echo date("d/m/Y") ?>, <?php echo date("G:H:s"); ?></b>
    <b style="font-size: 48px"><?php echo $numcaja." de ".$_POST["numcaja"];?></b>
 </page>
<?php	
$numcaja=$numcaja+1;
}
 ?>

