<?php include("../template/cabecera.php"); ?>
<?php

include('../config/config.php');
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


switch ($accion) {
    case 'Agregar':


        $consulta = "INSERT INTO categoria (nombre, descripcion) VALUES('" . $txtNombre . "','" . $txtDescripcion . "')";

        $query = $conexion->query($consulta);

        header("Location: categorias.php");
        break;

    case 'Modificar':
        $consulta = "UPDATE categoria SET nombre = '" . $txtNombre . "', descripcion = '" . $txtDescripcion ."'  WHERE idcaategoria=" . $txtID;
        $query = $conexion->query($consulta);

        header("Location: categorias.php");
        //echo "Presionado botón modificar";
        break;

    case 'Cancelar':
        header("Location: categorias.php");
        //echo "Presionado botón cancelar";
        break;

    case 'Seleccionar':
        $consulta = "SELECT * FROM categoria WHERE idcaategoria=" . $txtID;
        $query = $conexion->query($consulta);
        $categoria = $query->fetch_assoc(); //Seleción asociativa a mi consulta

        //Atributos recuperados
        $txtNombre = $categoria['nombre'];
        $txtDescripcion = $categoria['descripcion'];
        //echo "Presionado botón seleccionar";
        break;

    case 'Borrar':

        $consulta = "DELETE FROM categoria WHERE idcaategoria=" . $txtID;
        $query = $conexion->query($consulta);
        header("Location: categorias.php");
        break;

    default:
        # code...
        break;
}


?>

<div class="col-md-4">

    <div class="card">
        <div class="card-header">
            Datos de la categoría
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" value="<?php echo $txtID; ?>" required readonly class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre de la categoría:</label>
                    <input type="text" value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre" required placeholder="Nombre de la categoría">
                </div>

                <div class="form-group">
                    <label for="txtDescripcion">Descripción de la categoría:</label>
                    <textarea name="txtDescripcion" id="txtDescripcion" required placeholder="Ingrese aquí la descripción de la categoría" rows="5" cols="30"><?php echo $txtDescripcion; ?></textarea>
                </div>

                    <br>
                    <br>
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
                <th>Nombre de la categoría</th>
                <th>Descripción de la categoría</th>
                <th>Número de productos en la categoría</th>
                <th>Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $query = $conexion->query("SELECT * FROM categoria");
            foreach ($query as $fila) { ?>
                <tr>
                    <td><?php echo $fila['idcaategoria'] ?></td>
                    <td><?php echo $fila['nombre'] ?></td>
                    <td><?php echo $fila['descripcion'] ?></td>
<td></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $fila['idcaategoria']; ?>">
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