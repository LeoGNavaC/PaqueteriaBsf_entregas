<!--Esta pagina muestra todo el contenido de la tabla-->
<?php
	include('conexion.php');
	include("barra_lateral.php");
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Paquetería BSF</title>
	<link rel="icon" type="image/x-icon" href="image/bosque.png">
	<body>
		<div class="ContenedorPrincipal">	
			<?php
	
				$filasmax = 10;//Este me ayuda a mostrar una cantidad de datos en la tabla, en este caso muestra hasta 10 *********** se realizo modificacion
	
				if (isset($_GET['pag'])){
					$pagina = $_GET['pag'];
				} else {
					$pagina = 1;
				}
	
				if(isset($_POST['btnbuscar'])){//*****************se realizo una modificacion */
					$buscar = $_POST['txtbuscar'];
					$sqlusu = mysqli_query($conn, "SELECT id,numeroguia,fecha,paque,nombresocio,direccion,orientacion,comentarios,estatus,fecha_entrega FROM productos_correspondencia WHERE numeroguia LIKE '%".$buscar."%' OR direccion LIKE '%".$buscar."%' ORDER BY id DESC LIMIT " . (($pagina - 1) * $filasmax) ."," . $filasmax);
				}
				else{
					$sqlusu = mysqli_query($conn, "SELECT id,numeroguia,paque,nombresocio,direccion,comentarios,estatus,fecha_entrega FROM productos_correspondencia ORDER BY id DESC LIMIT " . (($pagina - 1) * $filasmax)  . "," . $filasmax);
				}	
	
				$resultadoMaximo = mysqli_query($conn, "SELECT count(*) as num_productos FROM productos_correspondencia");
	
				$maxusutabla = mysqli_fetch_assoc($resultadoMaximo)['num_productos'];
		
			?>

			<div class="ContenedorTabla">
				<form method="POST">
					<h2>Tabla del repartidor</h2>
		
					<div class="ContBuscar">
						<div style="float: left;">
							<a href="datos_bsf_correspondencia.php" class="BotonesTeam">Inicio</a>
							<input class="BotonesTeam" type="submit" value="Buscar" name="btnbuscar">
							<input class="CajaTextoBuscar" type="text" name="txtbuscar"  placeholder="Ingresar n° de guía o nombre del socio" autocomplete="off" >
						</div>
						<div style="float:right;">
							
						</div>
					</div>
				</form>
					<table>
						<tr>
							<th>Acción</th>
							<th>N° Guía</th>
							<th>Paqueteria(empresa)</th>
							<th>Dirección</th>
							<th>Nombre del residente</th>
							<th>Comentarios</th>
							<th>Estatus</th>
							<th>Fecha/entrega</th>
						</tr>
		
						<?php
							while ($mostrar = mysqli_fetch_assoc($sqlusu)) {
								echo "<tr>";
									echo "<td style='width:25% height:25%'>
										<a class='BotonesTeam1' href=\"productos_ver2_correspondencia.php?id=$mostrar[id]&pag=$pagina\">&#x1F50D;</a> 
										<a class='BotonesTeam2' href=\"estatus_correspondencia.php?id=$mostrar[id]&pag=$pagina\">&#x2714;</a>
									</td>";  
									echo "<td>".$mostrar['numeroguia']."</td>";
									//echo "<td>".$mostrar['paque']."</td>";//Muestra el numero de la empresa, nos referimos a categoria_id, y pasa porque esta heredando lo de la llave foreana
									echo "<td>".$mostrar['paque']."</td>";
									echo "<td>".$mostrar['nombresocio']."</td>";
									echo "<td>".$mostrar['direccion']."</td>";
									//echo "<td style='width:30%'><img src='data:image/jpg;base64,".base64_encode($mostrar['foto']).";'></td>";// --- echo "<td>".$mostrar['foto']."</td>";
									echo "<td>".$mostrar['comentarios']."</td>";
									if ($mostrar["estatus"] == "Entregado") {
										//echo "Holaaaaaa!!!!!!";
										echo "<td style='width:50%'><font color='green'><b>".$mostrar['estatus']."</font></td>";
									} else {
										//echo "Holiiiiii!!!!!!";
										echo "<td style='width:50%'><font color='red'><b>".$mostrar['estatus']."</font></td>";
									}
									//echo "<td style='width:50%'>".$mostrar['estatus']."</td>";
									echo "<td>".$mostrar['fecha_entrega']."</td>";
								echo "</tr>";
							}
						?>
					</table>
					<div class="contador" style='text-align:right'>
						<br>
						<?php echo "Total de registros: ".$maxusutabla;?>
					</div>
				</div>
				<div style='text-align:right'>
					<br>
				</div>
				<div style="text-align:center">
					<?php
						if (isset($_GET['pag'])) {
						if ($_GET['pag'] > 1) {
					?>
					<a class="BotonesTeam4" href="datos_bsf_correspondencia.php?pag=<?php echo $_GET['pag'] - 1; ?>">Anterior</a>
					<?php
						} 
						else 
						{
						?>
					<a class="BotonesTeam4" href="#" style="pointer-events: none">Anterior</a>
					<?php
						}
					?>
	
				<?php
					} 
					else 
					{
				?>
				<a class="BotonesTeam4" href="#" style="pointer-events: none">Anterior</a>
				<?php
					}
					
					if (isset($_GET['pag'])) {
					if ((($pagina) * $filasmax) < $maxusutabla) {
				?>
				<a class="BotonesTeam4" href="datos_bsf_correspondencia.php?pag=<?php echo $_GET['pag'] + 1; ?>">Siguiente</a>
				<?php
					} else {
				?>
				<a class="BotonesTeam4" href="#" style="pointer-events: none">Siguiente</a>
				<?php
					}
				?>
				<?php
					} else {
				?>
				<a class="BotonesTeam4" href="datos_bsf_correspondencia.php?pag=2">Siguiente</a>
				<?php
					}
				?>
			</div>
		</div>
	</body>
</html>

