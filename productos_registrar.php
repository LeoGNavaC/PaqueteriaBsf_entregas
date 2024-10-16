<!--Esta pagina contiene todo lo relacionado para agregar un nuevo dato (Boton: "Agregar Datos")-->
<?php 
	//aqui se encuentar el boton de agregar datos y su formulario para agreagr los datos.
	include("conexion.php");//Sirve para conectar la base de datos
	include("productos_tabla.php");//Sirve para conectarse a la pagina principal(Por asi decirlo)
	$pagina = $_GET['pag'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Datos</title>
    <link type="text/css" rel="shortcut icon" href="assets/images/favicon.ico"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script defer src="foto.js"></script>
</head>
<body>
    <div class="caja_popup">
        <form id="photoForm" class="contenedor_popup" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <th colspan="2">Agregar datos</th>
                </tr>
                <tr>
                    <td><b>Nombre del repartidor: </b></td>
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
                        <select name="txtcat" class="CajaTexto" required>
                            <?php
                            $qrcategoria = mysqli_query($conn, "SELECT * FROM categoria_productos");
                            while ($mostrarcat = mysqli_fetch_array($qrcategoria)) {
                                echo '<option value="' . $mostrarcat['id'] . '">' . $mostrarcat['nombre'] . '</option>';
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
                            $qrcategoria = mysqli_query($conn, "SELECT name FROM residentes");
                            while ($mostrarresi = mysqli_fetch_array($qrcategoria)) {
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
                        <datalist id="residentesD"></datalist>
                        <script>
                            document.getElementById('inputN').addEventListener('change', function() {
                                var seleccionNombre = this.value;
                                var residentesD = document.getElementById('residentesD');
                                residentesD.innerHTML = '';

                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
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
                        <div id="Video">
                            <video muted id="video" width="640" height="480" autoplay></video>
                        </div>
                        <div id="Canvas">
                            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                        </div>
                        <div id="BotonesVideo">
                            <button type="button" id="capture">
                                <i class="zmdi zmdi-camera-party-mode" style="color: #333;"></i> 
                                Tomar Foto
                            </button>
                            <input type="hidden" id="photoInput" name="photo">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Comentarios</b></td>
                    <td>
                        <select name="txtcom" class="CajaTexto" required>
                            <option></option>
                            <option>El paquete esta buen estado</option>
                            <option>El empaque se encuentra dañado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        echo "<a class='BotonesTeam' href=\"productos_tabla.php?pag=$pagina\">Cancelar</a>";
                        ?>
                        <input class='BotonesTeam' type="submit" name="btnregistrar" value="Registrar" onClick="return confirm('¿Deseas registrar estos datos?');">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        // Accedemos a la cámara
        const video = document.getElementById('video');//Tomamos el elemento del video
        navigator.mediaDevices.getUserMedia({ video: true })//Verificamos si podemos conectarnos
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error('Error al acceder a la cámara: ', err);
            });

        // Capturamos la foto
        const captureButton = document.getElementById('capture');//Tomamos el elemento del boton
        const canvas = document.getElementById('canvas');//Tomamos el elemento del canvas
        const photoInput = document.getElementById('photoInput');//Tomamos el elemento del input

        captureButton.addEventListener('click', () => {//Le agregamos un evento click
            const context = canvas.getContext('2d');//Convertimos la foto en 2D
            context.drawImage(video, 0, 0, canvas.width, canvas.height);//Tomamos las medidas de la imagen
            const photoData = canvas.toDataURL('image/png');//La convertimos
            photoInput.value = photoData;//Tomamos el valor
            canvas.style.display = 'block';//Mostramos la foto tomada por eso el block
        });

        // Enviamos el formulario
        const photoForm = document.getElementById('photoForm');//Tomamos el elemento de la foto
        photoForm.addEventListener('submit', (event) => {//subimos el elemento
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
    if (isset($_POST['btnregistrar'])) {
        $pronom = $_POST['txtnom'];
        $prodes = $_POST['txtdes'];
        $propre = $_POST['txtpre'];
        $propaq = $_POST['txtcat'];
        $pronomso = $_POST['txtnomso'];
        $prodir = $_POST['txtdirec'];
        $proori = $_POST['txtori'];
        $procat = $_POST['txtcat'];
        $procom = $_POST['txtcom'];

        $profotN = 'foto_' . date('d-m-y', time()) . '.png';
        $profot = $_POST['photo'];
        list($type, $data) = explode(';', $profot);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        $stmt = $conn->prepare("INSERT INTO productos (nombre, numeroguia, fecha, paque, nombresocio, direccion, orientacion, foto_nombre, foto, comentarios, categoria_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");//Se cambio para no caer en inyeccion de informacion con SQL
        $stmt->bind_param("ssssssssssi", $pronom, $prodes, $propre, $propaq, $pronomso, $prodir, $proori, $profotN, $data, $procom, $procat);//Incertamos los parametros

        if ($stmt->execute()) {
            echo "<script> alert('Producto registrado con exito: $pronom'); window.location='productos_tabla.php'  </script>";
        } else {
            echo "<script> alert('Error al registrar el producto'); window.location='productos_tabla.php'  </script>";
        }

        $stmt->close();

        $conn->query("UPDATE productos AS p JOIN categoria_productos AS cp ON p.categoria_id = cp.id SET p.paque = cp.nombre");
        $conn->query("UPDATE productos AS p JOIN residentes AS r ON p.id_residentes = r.idresidentes SET p.nombresocio = r.name");
    }
?>
