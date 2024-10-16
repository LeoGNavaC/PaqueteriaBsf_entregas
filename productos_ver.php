<!--En esta pagina podemos visualizar las caracteristicas del dato, pero sin poder modificar algo-->
<?php 
	include("conexion.php");
	include("productos_tabla.php");
	$pagina = $_GET['pag'];
	$id = $_GET['id'];
//****************+se realizo modificacion en la consulta */
	$querybuscar = mysqli_query($conn, "SELECT pro.id,pro.nombre,pro.numeroguia,pro.fecha,pro.nombresocio,pro.direccion,pro.orientacion,pro.foto_nombre,pro.foto,pro.comentarios,cat.nombre as categoria 
	FROM productos pro, categoria_productos cat where pro.categoria_id=cat.id and pro.id = '$id'");
	
	while($mostrar = mysqli_fetch_array($querybuscar)){
		$proid 	= $mostrar['id'];
		$pronom	= $mostrar['nombre'];
		$prodes	= $mostrar['numeroguia'];
		$propre	= $mostrar['fecha'];
		$procat	= $mostrar['categoria'];//***************se realizo modificacion */
		$pronomso=$mostrar['direccion'];
		$prodir = $mostrar['nombresocio'];
		$proori	= $mostrar['orientacion'];
		$profotN = $mostrar['foto_nombre'];
		$profot	= $mostrar['foto'];
		$procom	= $mostrar['comentarios'];
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style2.css">
    <title>Ver datos</title>
</head>
<body>
<div class="caja_popup2" id="popup" onmousedown="dragElement(this)">
        <form class="contenedor_popup" method="POST">
            <table>
                <tr>
                    <th colspan="2">Ver datos</th>
                </tr>
                <tr> 
                    <td data-label="Id"><b>Id:</b></td>
                    <td><?php echo $proid;?></td>
                </tr>		
                <tr> 
                    <td data-label="Nombre del repartidor"><b>Nombre del repartidor:</b></td>
                    <td><?php echo $pronom;?></td>
                </tr>
                <tr> 
                    <td data-label="N°Guía"><b>N°Guía:</b></td>
                    <td><?php echo $prodes;?></td>
                </tr>
                <tr> 
                    <td data-label="Fecha"><b>Fecha:</b></td>
                    <td><?php echo $propre;?></td>
                </tr>
                <tr> 
                    <td data-label="Paqueteria"><b>Paqueteria:</b></td>
                    <td><?php echo $procat;?></td>
                </tr>
                <tr>
                    <td data-label="Nombre del residente"><b>Nombre del residente:</b></td>
                    <td><?php echo $pronomso;?></td>
                </tr>
                <tr>
                    <td data-label="Direccion"><b>Direccion:</b></td>
                    <td><?php echo $prodir;?></td>
                </tr>
                <tr>
                    <td data-label="Orientacion"><b>Orientacion:</b></td>
                    <td><?php echo $proori;?></td>
                </tr>
                <tr>
                    <td data-label="Foto"><b>Foto:</b></td>
                    <td>
                        <img id="imagenP" src="data:image/*;base64,<?php echo base64_encode($profot);?>" alt="Foto">
                        <p id="nombreP"><?php echo $profotN; ?></p>
                    </td>
                </tr>
                <tr>
                    <td data-label="Comentarios"><b>Comentarios</b></td>
                    <td><?php echo $procom;?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a class='BotonesTeam' href="productos_tabla.php?pag=<?php echo $pagina; ?>">Regresar</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

