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
                $sqlusu = mysqli_query($conn, "SELECT pro.id,pro.numeroguia,pro.fecha,pro.nombresocio,pro.direccion,pro.orientacion,cat.nombre AS categoria FROM productos pro INNER JOIN categoria_productos cat ON pro.categoria_id=cat.id WHERE pro.numeroguia LIKE '".$buscar."%' OR pro.direccion LIKE '%".$buscar."%'");
            } else {//******************se realizo modificacion */
                $sqlusu = mysqli_query($conn, "SELECT pro.id,pro.numeroguia,pro.fecha,pro.nombresocio,pro.direccion,pro.orientacion,cat.nombre AS categoria FROM productos pro, categoria_productos cat WHERE pro.categoria_id=cat.id ORDER BY pro.id DESC LIMIT " . (($pagina - 1) * $filasmax)  . "," . $filasmax);
            }

            $resultadoMaximo = mysqli_query($conn, "SELECT count(*) as num_productos FROM productos");
            $maxusutabla = mysqli_fetch_assoc($resultadoMaximo)['num_productos'];
        ?>
        <div class="ContenedorTabla">
            <form method="POST">
                <h2>Busqueda de Paquetes</h2>
                <div class="ContBuscar">
                    <div style="float: left;">
                        <input class="BotonesTeam" type="submit" value="Buscar" name="btnbuscar">
                        <input class="CajaTextoBuscar" type="text" name="txtbuscar" placeholder="Ingresar datos de busqueda" autocomplete="off">
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
                        <th>Paqueteria(empresa)</th>
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
                            <td data-label="Paqueteria(empresa)"><?= $mostrar['categoria'] ?></td>
                            <td data-label="Nombre del residente"><?= $mostrar['nombresocio'] ?></td>
                            <td data-label="Dirección"><?= $mostrar['direccion'] ?></td>
                            <td data-label="Orientación"><?= $mostrar['orientacion'] ?></td><!--*************se realizo cambio*************-->
                            
                            <td data-label="Acciones">

                                <a class="BotonesTeam1" href="productos_ver.php?id=<?= $mostrar['id'] ?>&pag=<?= $pagina ?>">&#x1F50D;</a> 
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
                <a class="BotonesTeam4" href="productos_tabla.php?pag=<?= $pagina - 1; ?>">Anterior</a><!--Se realizo modificacion***********************+-->
            <?php else : ?>
                <a class="BotonesTeam4" href="#" style="pointer-events: none">Anterior</a>
            <?php endif; ?>

            <?php if ((($pagina) * $filasmax) < $maxusutabla) : ?>
                <a class="BotonesTeam4" href="productos_tabla.php?pag=<?= $pagina + 1; ?>">Siguiente</a><!--Se realizo modificacion***********************+-->
            <?php else : ?>
                <a class="BotonesTeam4" href="#" style="pointer-events: none">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

