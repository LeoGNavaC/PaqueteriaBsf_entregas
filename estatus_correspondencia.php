<?php 
    include("conexion.php");
    include("datos_bsf_correspondencia.php");

    $pagina = $_GET['pag'];
    $id = $_GET['id'];

    $querybuscar = mysqli_query($conn, "SELECT id,paque,direccion,numeroguia,estatus FROM productos_correspondencia WHERE id = '$id'"); //*******se realizo modificacion */
    
    while($mostrar = mysqli_fetch_array($querybuscar)){    
        $proid      = $mostrar['id'];
        $procat     = $mostrar['paque'];
        $pronomso   = $mostrar['direccion'];
        $prodes     = $mostrar['numeroguia'];
        $proest     = $mostrar['estatus'];
    }
?>

<html>
<meta charset='UTF-8'>
    <body>
        <div class="caja_popup4">
            <form class="contenedor_popup3" method="POST">
                <table>
                    <tr><th colspan="2">Estatus del Paquete</th></tr>  
                    
                    <tr style="display: none">     
                        <td><b>Id: </b></td>
                        <td><input class="CajaTexto" type="number" name="id" value="<?php echo $proid;?>" readonly></td>
                    </tr>

                    <tr> 
                        <td><b>N°Guía: </b></td>
                        <td><input class="CajaTexto" type="text" name="gia" value="<?php echo $prodes;?>" readonly></td>
                    </tr>

                    <tr> 
                        <td><b>Paqueteria: </b></td>
                        <td><?php echo $procat;?></td>
                    </tr>

                    <tr>
                        <td><b>Fue: </b></td>
                        <td>
                            <select name="fue" class="CajaTexto">
                                <option value="Entregado">Entregado</option>
                            </select>
                        </td>    
                    </tr>     
                    
                    <!-- ***********************se realizo modificacion
                    <tr> 
                        <td><b>Fecha/Entrega: </b></td>
                        <td><input class="CajaTexto" type="datetime-local" step="any" name="fecha" value="<?php //echo $proent; ?>" required ></td>
                    </tr>
                    -->

                    <tr>
                        <td colspan="2" >
                            <?php echo "<a class='BotonesTeam' href=\"datos_bsf_correspondencia.php?pag=$pagina\">Cancelar</a>";?>&nbsp;<!--**********Se realizo modificacion****-->
                            <input class='BotonesTeam' type="submit" name="btnregistrar" value="Aceptar">
                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </body>
</html>

<?php
    if(isset($_POST['btnregistrar'])){

        /* Tome la fecha de la region */
        date_default_timezone_set('America/Mexico_City');//*****************se realizo modificacion */

        $proid1     = $_POST['id'];    
        $proest1    = $_POST['fue'];
        $proent1    = date("Y-m-d H:i:s");//*******************Se realizo una modificacion

        // Actualización en la base de datos
        $querymodificar = mysqli_query($conn, "UPDATE productos_correspondencia SET estatus='$proest1', fecha_entrega='$proent1' WHERE id = '$proid1'");
        echo "<script>window.location= 'datos_bsf_correspondencia.php?pag=$pagina' </script>";//************se realizo modificacion */
    }
?>
