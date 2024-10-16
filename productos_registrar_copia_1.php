<!--Esta pagina contiene todo lo relacionado para agregar un nuevo dato (Boton: "Agregar Datos")-->
<?php 
	//aqui se encuentar el boton de agregar datos y su formulario para agreagr los datos.
	include("conexion.php");//Sirve para conectar la base de datos
	include("productos_tabla.php");//Sirve para conectarse a la pagina principal(Por asi decirlo)
	$pagina = $_GET['pag'];

	
?>

<html>
	<body>
		<div class="caja_popup2">
			<form class="contenedor_popup" method="POST" enctype="multipart/form-data">
				<table>
					<tr>
						<th colspan="2">Agregar datos</th>
					</tr>	
					
					<tr> 
						<td><b>Nombre del repartidor: </b></td><!--Se modifico-->
						<td><input type="text" name="txtnom" autocomplete="off" class="CajaTexto" required></td>
					</tr>
					
					<tr> 
						<td><b>N° de Gía: </b></td>
						<td><input type="text" name="txtdes" autocomplete="off" class="CajaTexto" required></td>
					</tr>

					<tr> 
						<td><b>Fecha: </b></td>
						<td><input type="datetime-local" name="txtpre" autocomplete="off" class="CajaTexto" step="any" required></td>
					</tr>

					<tr> 
						<td><b>Empresa:</b></td>
						<td>	
							<select name="txtcat" type="text" class='CajaTexto' required>
								<?php		
									$qrcategoria = mysqli_query($conn, "SELECT * FROM categoria_productos ");
									while($mostrarcat = mysqli_fetch_array($qrcategoria)) { 
									echo '<option value="'.$mostrarcat['id'].'">' .$mostrarcat['nombre']. '</option>';
									}
								?>  
							</select>
						</td>
					</tr>

					<tr> 
						<td><b>Nombre del residente: </b></td>
						<td>
							<input list="residentesN" id="inputN" name="txtnomso" class="CajaTexto" required>
							<datalist id="residentesN">
								<?php        
									$qrcategoria = mysqli_query($conn, "SELECT name FROM residentes ");
									while($mostrarresi = mysqli_fetch_array($qrcategoria)) { 
										echo '<option value="' . $mostrarresi['name'] . '">';
									}
								?>  
							</datalist>
						</td>

						
					</tr>

					<tr>
						<td><b>Direccion: </b></td>
						<td>
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
						<td><b>Orientacion</b></td>
						<td>
							<select name="txtori" class="CajaTexto" required>
								<option></option>
								<option>Oriente</option>
								<option>Poniente</option>
							</select>
						</td>
					</tr>

					<tr> 
					<td><b>Foto</b></td>
<td>
    <video id="video" width="320" height="240" autoplay></video>
    <button class="BotonesTeam5" onclick="capturarFoto()">Tomar Foto</button>
</td>
<input type="hidden" id="foto_N" name="foto_N">

						<!--Todo este codigo hace el proceso de tomar el nombre del documento-->
				<script>
    const video = document.getElementById('video');

    function capturarFoto() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.error('Error al acceder a la cámara', err);
                });
        }
    }

    // Esta función debería manejar la captura de la imagen y enviarla al campo oculto foto_N
    function handleCapture() {
        var canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        var base64data = canvas.toDataURL('image/png'); // Convertir a base64

        // Establecer el valor del campo oculto foto_N con el nombre de la imagen
        var extension = 'png'; // O cualquier extensión que desees usar
        var nombreImagen = 'Imagen_' + Date.now() + '.' + extension;
        document.getElementById('foto_N').value = nombreImagen;

        // También podrías enviar base64data a través de AJAX si necesitas almacenar la imagen como datos base64
    }
</script>
						
					</tr>
					
					
					<tr>
						<td><b>Comentarios</b></td>
						<td>
							<select name="txtcom" class="CajaTexto" required>
								<option></option>
								<option>El paquete esta buen estado</option>
								<option>El empaque se encuentra dañado</option>
								<!--<option>otra</option>-->
							</select>
						</td>
					</tr>

					<tr>
						<td colspan="2" >
							<?php 
								echo "<a class='BotonesTeam' href=\"productos_tabla.php?pag=$pagina\">Cancelar</a>";
							?>&nbsp;

							<input class='BotonesTeam' type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm('¿Deseas registrar estos datos?');">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>


<?php
						
	if(isset($_POST['btnregistrar'])){   
					
		$pronom 	= $_POST['txtnom'];
		$prodes 	= $_POST['txtdes'];
		$propre 	= $_POST['txtpre'];//fecha
		$propaq 	= $_POST['txtcat'];//paquete
		$pronomso	= $_POST['txtnomso'];
		$prodir		= $_POST['txtdirec'];
		$proori		= $_POST['txtori'];
		$procat 	= $_POST['txtcat'];
		$profotN    = $_POST['foto_N'];
		$profot 	= addslashes(file_get_contents($_FILES['foto']['tmp_name']));//$_POST['foto'] -- addslashes(file_get_contents($_FILES['foto']['tmp_name']))
		$procom 	= $_POST['txtcom'];
					
		mysqli_query($conn, "INSERT INTO productos(nombre,numeroguia,fecha,paque,nombresocio,direccion,orientacion,foto_nombre,foto,comentarios,categoria_id) VALUES('$pronom','$prodes','$propre','$propaq','$pronomso','$prodir','$proori','$profotN','$profot','$procom','$procat')");			
		echo "<script> alert('Producto registrado con exito: $pronom'); window.location='productos_tabla.php'  </script>";
		//echo "<script> alert('Nombre de la imagen: $profotN'); window.location='productos_tabla.php'  </script>";

		//mysqli_query( $conn, "UPDATE productos AS p JOIN categoria_productos AS cp ON p.categoria_id = cp.id JOIN residentes AS sp ON p.id_residentes = sp.idresidentes SET p.nombresocio = sp.name, p.paque = cp.nombre");
		mysqli_query($conn,"UPDATE productos AS p JOIN categoria_productos AS cp ON p.categoria_id = cp.id SET p.paque = cp.nombre");
		mysqli_query($conn,"UPDATE productos AS p JOIN residentes AS r ON p.id_residentes = r.idresidentes SET p.nombresocio = r.name");
	}
?>