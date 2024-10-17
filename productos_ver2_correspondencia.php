<!--En esta pagina podemos visualizar las caracteristicas del dato, pero sin poder modificar algo-->
<?php 
	include("conexion.php");
	include("datos_bsf_correspondencia.php");
	$pagina = $_GET['pag'];
	$id = $_GET['id'];
//**************se realizo modificacion en la consulta */
	$querybuscar = mysqli_query($conn, "SELECT id,nombre,numeroguia,fecha,paque,nombresocio,direccion,orientacion,comentarios,estatus,fecha_entrega FROM productos_correspondencia WHERE id = '$id'");
	
	while($mostrar = mysqli_fetch_array($querybuscar)){
		$proid 	= $mostrar['id'];
		$prodes	= $mostrar['numeroguia'];
		$propre	= $mostrar['fecha'];
		$procat	= $mostrar['paque'];
		$pronomso=$mostrar['nombresocio'];
		$prodir = $mostrar['direccion'];
		$proori	= $mostrar['orientacion'];
        $procom=  $mostrar['comentarios'];
		$proest=  $mostrar['estatus'];
		$proent=  $mostrar['fecha_entrega'];
	}
?>

<html>
	<body>
		<div class="caja_popup3">
			<form class="contenedor_popup1" method="POST">
				<table>

					<tr>
						<th colspan="2">Ver datos</th>
					</tr>
					
					<tr> 
						<td><b>Id:</b></td>
						<td><?php echo $proid;?></td>
					</tr>		
					
					<tr> 
						<td><b>N°Guía: </b></td>
						<td><?php echo $prodes;?></td>
					</tr>
					
					<tr> 
						<td><b>Fecha: </b></td>
						<td><?php echo $propre;?></td>
					</tr>
					
					<tr> 
						<td><b><Param>Paqueteria</Param>: </b></td>
						<td><?php echo $procat;?></td>
					</tr>
					
					<tr>
						<td><b>Nombre del residente: </b></td>
						<td><?php echo $pronomso;?></td>
					</tr>
					
					<tr>
						<td><b>Direccion: </b></td><!--La etiqueta b nos ayuda a que se vea mas negrita la letra-->
						<td><?php echo $prodir;?></td>
					</tr>

					<tr>
						<td><b>Orientacion: </b></td>
						<td><?php echo $proori;?></td>
					</tr>

					<tr>
                    	<td><b>Comentarios:</b></td>
						<td><?php echo $procom;?></td>
                    </tr>

                    <tr>
                    	<td><b>Estatus:</b></td>
						<td><?php echo $proest;?></td>
					</tr>

					<tr> 
						<td><b>Fecha-entrega:</b></td>
						<td><?php echo $proent;?></td>
					</tr>

					<tr> 
						<td colspan="2">
							<?php echo "<a class='BotonesTeam' href=\"datos_bsf_correspondencia.php?pag=$pagina\">Regresar</a>";?><!--***************se realizo modificacion**************-->
						</td>
					</tr>

				</table>
			</form>
		</div>
	</body>
</html>

