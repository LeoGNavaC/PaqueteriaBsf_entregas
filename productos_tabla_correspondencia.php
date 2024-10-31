<!--Esta pagina muestra todo el contenido de la tabla-->
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style2.css">
    <link rel="preload" href="normalize.css" as="style">
    <link rel="stylesheet" href="normalize.css">
    <title>Paquetería BSF</title>
    <link rel="icon" type="image/x-icon" href="image/bosque.png">
</head>
<body>
    <div class="ContenedorPrincipal">    
        <?php
            include('conexion.php');
            include("barra_lateral.php");

            $filasmax = 10;//**************+se realizo modificacion */
            $pagina = isset($_GET['pag']) ? $_GET['pag'] : 1;

            if (isset($_POST['btnbuscar'])) {//************************se realizo modificacion */
                $buscar = $_POST['txtbuscar'];
                $sqlusu = mysqli_query($conn, "SELECT id,numeroguia,fecha,paque,nombresocio,direccion,orientacion FROM productos_correspondencia WHERE numeroguia LIKE '%".$buscar."%' OR direccion LIKE '%".$buscar."%' ORDER BY id DESC LIMIT " . (($pagina - 1) * $filasmax) . "," . $filasmax);
            } else {//******************se realizo modificacion */
                $sqlusu = mysqli_query($conn, "SELECT id,numeroguia,fecha,paque,nombresocio,direccion,orientacion FROM productos_correspondencia ORDER BY id DESC LIMIT " . (($pagina - 1) * $filasmax)  . "," . $filasmax);
            }

            $resultadoMaximo = mysqli_query($conn, "SELECT count(*) as num_productos FROM productos_correspondencia");
            $maxusutabla = mysqli_fetch_assoc($resultadoMaximo)['num_productos'];
        ?>
        <div class="ContenedorTabla">
            <form method="POST">
                <h2>Busqueda de Paquetes</h2>
                <div class="ContBuscar">
                    <div style="float: left;">
                    <a href="datos_bsf.php" class="BotonesTeam">Inicio</a>
                        <input class="BotonesTeam" type="submit" value="Buscar" name="btnbuscar">
                        <input class="CajaTextoBuscar" type="text" name="txtbuscar" placeholder="Ingresar n° de guía o nombre del socio" autocomplete="off">
                    </div>
                    <div style="float:right;"></div>
                </div>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>N° Guía</th>
                        <th>Fecha/recepción</th>
                        <th>Empresa</th>
                        <th>Dirección</th>
                        <th>Nombre del residente</th>
                        <th>Orientación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php while ($mostrar = mysqli_fetch_assoc($sqlusu)) : ?>
                        <tr>
                            <td data-label="Id"><?= $mostrar['id'] ?></td>
                            <td data-label="N° Guía"><?= $mostrar['numeroguia'] ?></td>
                            <td data-label="Fecha/recepción"><?= $mostrar['fecha'] ?></td>
                            <td data-label="Paqueteria(empresa)"><?= $mostrar['paque'] ?></td>
                            <td data-label="Nombre del residente"><?= $mostrar['nombresocio'] ?></td>
                            <td data-label="Dirección"><?= $mostrar['direccion'] ?></td>
                            <td data-label="Orientación"><?= $mostrar['orientacion'] ?></td><!--*************se realizo cambio*************-->
                            
                            <td data-label="Acciones">

                                <a class="BotonesTeam1" href="productos_ver_correspondencia.php?id=<?= $mostrar['id'] ?>&pag=<?= $pagina ?>">&#x1F50D;</a> 
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="contador" style='text-align:right'>
                <br>
                <?= "Total de registros: ".$maxusutabla; ?>
            </div>
        </div>
        <div style='text-align:right'><br></div>
        <div style="text-align:center">
            <?php if ($pagina > 1) : ?>
                <a class="BotonesTeam4" href="productos_tabla_correspondencia.php?pag=<?= $pagina - 1; ?>">Anterior</a><!--Se realizo modificacion***********************+-->
            <?php else : ?>
                <a class="BotonesTeam4" href="#" style="pointer-events: none">Anterior</a>
            <?php endif; ?>

            <?php if ((($pagina) * $filasmax) < $maxusutabla) : ?>
                <a class="BotonesTeam4" href="productos_tabla_correspondencia.php?pag=<?= $pagina + 1; ?>">Siguiente</a><!--Se realizo modificacion***********************+-->
            <?php else : ?>
                <a class="BotonesTeam4" href="#" style="pointer-events: none">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

