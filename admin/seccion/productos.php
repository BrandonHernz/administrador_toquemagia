<?php include("../template/cabecera.php"); ?>
<?php

include('../config/config.php');
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$precioUnit = (isset($_POST['precioUnit'])) ? $_POST['precioUnit'] : "";
$existencia = (isset($_POST['existencia'])) ? $_POST['existencia'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$categoriaProduct = (isset($_POST['categoriaProduct'])) ? $_POST['categoriaProduct'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


switch ($accion) {
    case 'Agregar':

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : "principal.jpg";

        $consulta = "INSERT INTO articulo (nombre, descripción, precio_unitario, imagen, existencia, categoria_id) VALUES('" . $txtNombre . "','" . $txtDescripcion . "','" . $precioUnit . "', '" . $nombreArchivo . "', '" . $existencia . "', '" . $categoriaProduct . "')";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $query = $conexion->query($consulta);

        header("Location: productos.php");
        break;

    case 'Modificar':
        $consulta = "UPDATE articulo SET nombre = '" . $txtNombre . "', descripción = '" . $txtDescripcion . "', precio_unitario = '" . $precioUnit . "', existencia = '" . $existencia . "'  WHERE idarticulo=" . $txtID;
        $query = $conexion->query($consulta);

        if ($txtImagen != "") {

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES['txtImagen']['name'] : "principal.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $consulta = "SELECT imagen FROM articulo WHERE idarticulo=" . $txtID;
            $query = $conexion->query($consulta);
            $producto = $query->fetch_assoc(); //Seleción asociativa a mi consulta

            if (isset($producto['imagen']) && ($producto['imagen'] != "principal.jpg")) {
                if (file_exists("../../img/" . $producto['imagen'])) {
                    unlink("../../img/" . $producto['imagen']);
                }
            }

            $consulta = "UPDATE articulo SET imagen = '" . $nombreArchivo . "'  WHERE idarticulo=" . $txtID;
            $query = $conexion->query($consulta);
        }
        header("Location: productos.php");
        //echo "Presionado botón modificar";
        break;

    case 'Cancelar':
        header("Location: productos.php");
        //echo "Presionado botón cancelar";
        break;

    case 'Seleccionar':
        $consulta = "SELECT * FROM articulo WHERE idarticulo=" . $txtID;
        $query = $conexion->query($consulta);
        $producto = $query->fetch_assoc(); //Seleción asociativa a mi consulta

        //Atributos recuperados
        $txtNombre = $producto['nombre'];
        $txtDescripcion = $producto['descripción'];
        $precioUnit = $producto['precio_unitario'];
        $existencia = $producto['existencia'];
        //$categoriaProduct = $producto['categoria'];
        $txtImagen = $producto['imagen'];
        //echo "Presionado botón seleccionar";
        break;

    case 'Borrar':

        $consulta = "SELECT imagen FROM articulo WHERE idarticulo=" . $txtID;
        $query = $conexion->query($consulta);
        $producto = $query->fetch_assoc(); //Seleción asociativa a mi consulta

        if (isset($producto['imagen']) && ($producto['imagen'] != "principal.jpg")) {
            if (file_exists("../../img/" . $producto['imagen'])) {
                unlink("../../img/" . $producto['imagen']);
            }
        }

        $consulta = "DELETE FROM articulo WHERE idarticulo=" . $txtID;
        $query = $conexion->query($consulta);
        header("Location: productos.php");
        break;

    default:
        # code...
        break;
}


?>

<div class="col-md-4">

    <div class="card">
        <div class="card-header">
            Datos del producto
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" value="<?php echo $txtID; ?>" required readonly class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre del producto:</label>
                    <input type="text" value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" required placeholder="Nombre">
                </div>

                <div class="form-group">
                    <label for="precioUnit">Precio unitario:</label>
                    <br>
                    <input type="number" value="<?php echo $precioUnit; ?>" step="any" name="precioUnit" id="precioUnit" required placeholder="0"/>
                </div>

                <div class="form-group">
                    <label for="existencia">Existencias:</label>
                    <br>
                    <input type="number" value="<?php echo $existencia; ?>" name="existencia" id="existencia" required placeholder="0" />
                </div>

                <div class="form-group">
                    <label for="categoriaProduct">Categoria del producto:</label>
                    <select name="categoriaProduct">
                        <option value="0">Seleccione:</option>
                        <?php
                        $query = $conexion->query("SELECT * FROM categoria");
                        while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="' . $valores['idcaategoria'] . '">' . $valores['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtDescripcion">Descripción del producto:</label>
                    <textarea name="txtDescripcion" id="txtDescripcion" required placeholder="Ingrese aquí la descripción del producto" rows=" 5" cols="30"><?php echo $txtDescripcion; ?></textarea>
                </div>


                <div class="form-group">
                    <label for="txtImagen">Imagen del producto:</label>
                    <?php if ($txtImagen != "") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen ?>" width="70" alt="">
                    <?php } ?>
                    <br>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : "" ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : "" ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : "" ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>

    </div>
</div>
<br>
<div class="col-md-8">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio unitario</th>
                <th>Existencias</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = $conexion->query("SELECT * FROM articulo");
            foreach ($query as $fila) { ?>
                <tr>
                    <td><?php echo $fila['idarticulo'] ?></td>
                    <td><?php echo $fila['nombre'] ?></td>
                    <td><?php echo $fila['precio_unitario'] ?></td>
                    <td><?php echo $fila['existencia'] ?></td>
                    <td><?php echo $fila['categoria_id']?></td>
                    <td><?php echo $fila['descripción'] ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $fila['imagen'] ?>" width="70" alt="">
                    </td>

                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $fila['idarticulo']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- <td><a href='eliminar.php?id=".$fila['id_autor']."'>Eliminar</a></td>
                        <td><a href='modificar.php?id=".$fila['id_autor']."'>Modificar</a></td>  -->


<?php include("../template/pie.php"); ?>