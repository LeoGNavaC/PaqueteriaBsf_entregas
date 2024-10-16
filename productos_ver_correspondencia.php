<!--En esta pagina podemos visualizar las caracteristicas del dato, pero sin poder modificar algo-->
<?php 
	include("conexion.php");
	include("productos_tabla_correspondencia.php");
	$pagina = $_GET['pag'];
	$id = $_GET['id'];
//****************+se realizo modificacion en la consulta */
	$querybuscar = mysqli_query($conn, "SELECT id,nombre,numeroguia,fecha,paque,nombresocio,direccion,orientacion,comentarios FROM productos_correspondencia WHERE id = '$id'");
	
	while($mostrar = mysqli_fetch_array($querybuscar)){
		$proid 	= $mostrar['id'];
		$pronom	= $mostrar['nombre'];
		$prodes	= $mostrar['numeroguia'];
		$propre	= $mostrar['fecha'];
		$propaquete= $mostrar['paque'];
        $pronomso=$mostrar['nombresocio'];
        $prodir = $mostrar['direccion'];
        $proori = $mostrar['orientacion'];
        $procom = $mostrar['comentarios'];
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
                    <td><?php echo $propaquete;?></td>
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
                    <td data-label="Comentarios"><b>Comentarios</b></td>
                    <td><?php echo $procom;?></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <a class='BotonesTeam' href="productos_tabla_Correspondencia.php?pag=<?php echo $pagina; ?>">Regresar</a>
                    </td>
                </tr>

            </table>
        </form>
    </div>
</body>
</html>

