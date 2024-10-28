<?php
	session_start();
	include('conexion.php');
	if(isset($_SESSION['usuarioingresando'])){
		$usuarioingresado = $_SESSION['usuarioingresando'];
		$buscandousu = mysqli_query($conn,"SELECT * FROM usuarios WHERE correo = '".$usuarioingresado."'");
		$mostrar=mysqli_fetch_array($buscandousu);	
	} else {
		header('location: index.php');
	}
?>

<html>
	<head>
		<title>Paqueteria BFS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="preload" href="normalize.css" as="style">
        <link rel="stylesheet" href="normalize.css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="BarraLateral">
			<ul><!--Se encuentran los links a las demas paginas-->
			<li><a href="productos_tabla.php">• Datos Generales</a></li><!--************se realizo modificacion-->
				<li><a href="datos_bsf.php">• Datos de entrega</a></li>

				<li><a href="productos_tabla_correspondencia.php">• Datos Generales (correspondencia)</a></li>		
				<li><a href="datos_bsf_correpondencia.php">• Datos de Entrega (correspondencia)</a></li>		

				
				<li><a href="cerrar_sesion.php" >• Cerrar sesión</a></li>
			</ul>
			<hr>
		</div>
	</body>
</html>