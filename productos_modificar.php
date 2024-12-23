<?php 
	include("conexion.php");
	include("productos_tabla.php");

	$pagina = $_GET['pag'];
	$id = $_GET['id'];

	$querybuscar = mysqli_query($conn, "SELECT pro.id,pro.nombre,numeroguia,fecha,pro.paque,pro.nombresocio,pro.direccion,pro.orientacion,foto_nombre,foto,comentarios,pro.categoria_id,cat.nombre as categoria 
	FROM productos pro, categoria_productos cat where pro.categoria_id=cat.id and pro.id = '$id'");
	
	while($mostrar = mysqli_fetch_array($querybuscar))
	{	
		$proid 		= $mostrar['id'];
		$pronom 	= $mostrar['nombre'];
		$prodes 	= $mostrar['numeroguia'];
		$propre 	= $mostrar['fecha'];//fecha
		$propaquete	= $mostrar['paque'];//paquete
		$pronomso	= $mostrar['nombresocio'];
		$prodir		= $mostrar['direccion'];
		$proori		= $mostrar['orientacion'];
		$procat 	= $mostrar['categoria_id'];
		$profotN	= $mostrar['foto_nombre'];
		$profot		= $mostrar['foto'];
		$procom		= $mostrar['comentarios'];
		
	}
?>

<html>
	<body>
		<div class="caja_popup2">
			<form id="Form" class="contenedor_popup" method="POST" enctype="multipart/form-data">
				<table>
					<tr><th colspan="2">Modificar datos</th></tr>	
					<tr> 
						<td><b>Id: </b></td>
						<td><input class="CajaTexto" type="number" name="txtid" value="<?php echo $proid;?>" readonly></td>
					</tr>

					<tr> 
						<td><b>Nombre del repartidor: </b></td>
						<td><input class="CajaTexto" type="text" name="txtnom" value="<?php echo $pronom;?>" required></td>
					</tr>

					<tr> 
						<td><b>N° Guía: </b></td>
						<td><input class="CajaTexto" type="text" name="txtdes" value="<?php echo $prodes;?>" required></td>
					</tr>

					<tr> 
						<td><b>Fecha: </b></td>
						<td><input class="CajaTexto" type="datetime-local" step="any" name="txtpre" value="<?php echo $propre;?>" required ></td>
					</tr>

					<tr> 
						<td><b>	Empresa: </b></td>
						<td>
							<select name="txtcat" class='CajaTexto' required>
								<?php	
									$qrproductos = mysqli_query($conn, "SELECT * FROM categoria_productos ");
									while($mostrarcat = mysqli_fetch_array($qrproductos)) { 
										if($mostrarcat['id']==$procat){
											echo '<option selected="selected" value="'.$mostrarcat['id'].'">' .$mostrarcat['nombre']. '</option>';
										} else {
											echo '<option value="'.$mostrarcat['id'].'">' .$mostrarcat['nombre']. '</option>';
										}
									}	
								?> 
							</select>
						</td>
					</tr>

					<tr> 
						<td><b>Nombre del residente: </b></td>
						<td>
							<input class="CajaTexto" type="text" name="txtnomso" value="<?php echo $pronomso;?>" readonly>
							<input list="residentesN" id="inputN" name="txtnomso" class="CajaTexto">
							<datalist id="residentesN">
								<?php
									$qrcategoria = mysqli_query($conn, "SELECT * FROM residentes");
									while($mostrarresi = mysqli_fetch_array($qrcategoria)) {
										if($mostrarresi['name'] == $pronomso){
											echo '<option value="' . $pronomso . '">';
										} else {
											echo '<option value="' . $mostrarresi['name'] . '">' . $mostrarresi['idresidentes'] .'</option>';
										}
									}
								?>
							</datalist>
						</td>
					</tr>

					<tr>
						<td><b>Direccion: </b></td>
						<td>
							<input class="CajaTexto" type="text" name="txtdirec" value="<?php echo $prodir;?>" readonly>
							<input list="residentesD" id="inputD" name="txtdirec" class="CajaTexto">
							<datalist id="residentesD">
							
							</datalist>
							<script>
								document.getElementById('inputN').addEventListener('change',function () {
									var seleccionNombre = this.value;//obtenemos aqui  el nombre del primer datalist, se guarda aqui
									var residentesD		= document.getElementById('residentesD');

									residentesD.innerHTML	= '';//limpiamos el datalist2

									var xhr	= new XMLHttpRequest();//obtenemos las opciones del segundo datalist
									xhr.onreadystatechange = function() {
										if(this.readyState == 4 && this.status == 200) {
											var opcion = JSON.parse(this.responseText);
											opcion.forEach(function(option) {
												residentesD.innerHTML += '<option value="' + option + '">';
											});
										}
									};
									xhr.open("GET", "get_options.php?name=" + seleccionNombre, true);
									xhr.send();
								});
							</script>
						</td>
					</tr>
					
					<tr>
						<td><b>Orientación: </b></td>
						<td>
							<select name="txtori" class="CajaTexto" required>
								<?php 
									if($proori == 'Oriente'){
										echo '<option>' . $proori . '</option>';
										echo '<option>Poniente</option>';
									} else {
										echo '<option>' . $proori . '</option>';
										echo '<option>Oriente</option>';
									}
								?>
							</select>
						</td>
					</tr>

					<tr> 
						<td><b>Desea modificar la foto: </b></td>
						<td>

							<select id="opcion" name="opcion" class="CajaTexto" onchange="mostrarB()">
								<option value="No">No</option>
								<option value="Si">Si</option>	
							</select>

							<script>
								function mostrarB(){
									var opcionS = document.getElementById("opcion").value;
									var miVid = document.getElementById("Video");//Con esto traigo el elemento
									var miCan = document.getElementById("Canvas");
									var miBot = document.getElementById("BotonesVideo");
										
									/*Sirve esta condicion para mostrar o dejar de mostrar el boton */
									if(opcionS === "Si"){
										miVid.style.display = "block";//con esto lo muestro
										miCan.style.display = "block";
										miBot.style.display = "block";
										//alert('Holaaaaaaaa siiii');
									} else {
										miVid.style.display = "none";//con esto lo muestro
										miCan.style.display = "none";
										miBot.style.display = "none";
										//alert('holaaaaaaaa nooooo');
									}
								}
							</script>

							<br><br>

							<!--En esta seccion va toda la camara y tomar la foto-->
							<div id="Video" style="display:none">
                            	<video muted id="video" width="640" height="480" autoplay></video>
							</div>
							<div id="Canvas">
								<canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
							</div>
							<div id="BotonesVideo" style="display:none">
								<button type="button" id="capture">
									<i class="zmdi zmdi-camera-party-mode" style="color: #333;"></i> 
									Tomar Foto
								</button>
								<input type="hidden" id="photoInput" name="photo">
							</div>

							<br><br><br>

							<!--Sirve para verificar si los datos estan ahi-->
							<img id="imagenP" src="data:image/*;base64,<?php echo base64_encode($profot);?>" width="300" height="300" alt="Foto">
							<p id="nombreP"><?php echo $profotN; ?></p>	
						</td>
					</tr>

					<tr>
						<td><b>Comentarios </b></td>
						<td>
							<select name="txtcom" class="CajaTexto" required>
								<?php 
									if($procom == 'El paquete esta en buen estado'){
										echo '<option>' . $procom . '</option>';
										echo '<option>El empaque se encuentra dañado</option>';
									} else {
										echo '<option>' . $procom . '</option>';
										echo '<option>El paquete esta en buen estado</option>';
									}
								
								?>
							</select>
						</td>
					</tr>

						<td colspan="2" >
							<?php echo "<a class='BotonesTeam' href=\"productos_tabla.php?pag=$pagina\">Cancelar</a>";?>&nbsp;
							<input class='BotonesTeam' type="submit" name="btnregistrar" value="Modificar" onClick="javascript: return confirm('¿Deseas modificar este producto');">
						</td>
					</tr>
				</table>
			</form>
			
		</div>

		<script >
			// Accedemos a la cámara
			const video = document.getElementById('video');//guardamos esa variable
			navigator.mediaDevices.getUserMedia({ video: true })//Verificamos si esta abierta o no
			.then(stream => {
				video.srcObject = stream;
				})
				.catch(err => {
					console.error('Error al acceder a la cámara: ', err);
				});

			// Capturamos la foto
			const captureButton = document.getElementById('capture');
			const canvas = document.getElementById('canvas');
			const photoInput = document.getElementById('photoInput');

			captureButton.addEventListener('click', () => {//tomamos la foto del canvas
				const context = canvas.getContext('2d');//La dejamos en 2D la imagen del canvas
				context.drawImage(video, 0, 0, canvas.width, canvas.height);//tomamos las memidas del canvas
				const photoData = canvas.toDataURL('image/png');//lo volvemos imagen
				photoInput.value = photoData;//tomamos el valor de la imagen
				canvas.style.display = 'block';//lo mostramos en un canvas aparte
			});

			// Enviamos el formulario
			const photoForm = document.getElementById('photoForm');//Enviamos el formulario
			photoForm.addEventListener('submit', (event) => {
				const formData = new FormData(photoForm);
				fetch('save_photo.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.text())
				.then(data => {
					console.log(data);
					alert('Foto guardada exitosamente.');
				})
				.catch(err => {
					console.error('Error al guardar la foto: ', err);
				});
			});
		</script>
	</body>
</html>

<?php
		
	if(isset($_POST['btnregistrar'])){    
		
		if($_POST['opcion'] == 'No') {

			$proid1 	= $_POST['txtid'];
			$pronom1 	= $_POST['txtnom'];
			$prodes1	= $_POST['txtdes'];
			$propre1 	= $_POST['txtpre'];//fecha
			$propaquete1= $_POST['txtcat'];//paquete
			if(empty($_POST['txtnomso'])){
				$pronomso1 = $pronomso;
			} else {
				$pronomso1	= $_POST['txtnomso'];
			}
			if(empty($_POST['txtdirec'])){
				$prodir1 = $prodir;
			} else {
				$prodir1 = $_POST['txtdirec'];
			}
			$proori1	= $_POST['txtori'];
			$procat1 	= $_POST['txtcat'];
			$procom		= $_POST['txtcom'];

			//echo "<script>alert('holaaaaaa mundoooooo esto es para no actualizar la imagen');</script>";
			$querymodificar = mysqli_query($conn, "UPDATE productos SET nombre='$pronom1',numeroguia='$prodes1',fecha='$propre1',paque='$propaquete1',nombresocio='$pronomso1',direccion='$prodir1',orientacion='$proori1',comentarios='$procom',categoria_id='$procat1' WHERE id = '$proid1'");
			echo "<script>window.location= 'productos_tabla.php?pag=$pagina' </script>";

			mysqli_query( $conn, "UPDATE productos AS p JOIN categoria_productos AS cp ON p.categoria_id = cp.id SET p.paque = cp.nombre");			

		
		

		} else {

			//$querymodificar = mysqli_query($conn, "DELETE FROM productos WHERE  foto = $profot"); 

			$proid1 	= $_POST['txtid'];
			$pronom1 	= $_POST['txtnom'];
			$prodes1	= $_POST['txtdes'];
			$propre1 	= $_POST['txtpre'];//fecha
			$propaquete1= $_POST['txtcat'];//paquete
			if(empty($_POST['txtnomso'])){
				$pronomso1 = $pronomso;
			} else {
				$pronomso1	= $_POST['txtnomso'];
			}
			if(empty($_POST['txtdirec'])){
				$prodir1 = $prodir;
			} else {
				$prodir1 = $_POST['txtdirec'];
			}
			$proori1	= $_POST['txtori'];
			$procat1 	= $_POST['txtcat'];
			
			$profotN1 = 'foto_' . date('d-m-y', time()) . '.png';
			$profot1 = $_POST['photo'];
			list($type, $data) = explode(';', $profot1);
			list(, $data) = explode(',', $data);
			$data = base64_decode($data);

			

			$procom		= $_POST['txtcom'];

			//echo "<script>alert('holaaaaaa mundoooooo esto es para actualizar imagen');</script>";
			//$querymodificar = mysqli_query($conn, "UPDATE productos SET nombre='$pronom1',numeroguia='$prodes1',fecha='$propre1',paque='$propaquete1',nombresocio='$pronomso1',direccion='$prodir1',orientacion='$proori1',foto_nombre='$profotN1',foto='$data',comentarios='$procom',categoria_id='$procat1' WHERE id = '$proid1'");
			$stmt = $conn->prepare("UPDATE productos SET nombre=?,numeroguia=?,fecha=,paque=,nombresocio=,direccion=,orientacion=,foto_nombre=,foto=,comentarios=,categoria_id= WHERE id=?");
    		$stmt->bind_param("sssiisssssi", $pronom1, $prodes1, $propre1, $propaquete1, $pronomso1, $prodir1, $proori1, $profotN1, $data, $procom, $procat1, $proid1);

			
			echo "<script>window.location= 'productos_tabla.php?pag=$pagina' </script>";

			mysqli_query( $conn, "UPDATE productos AS p JOIN categoria_productos AS cp ON p.categoria_id = cp.id SET p.paque = cp.nombre");	
		}

	}
?>