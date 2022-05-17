<?php
session_start();
if ($_POST) {

    if (($_POST['correo']=="lupitarios@hotmail.com") &&($_POST['contrasenia']=="lupita123")){
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="Lupita Rios";
        header("Location: inicio.php");
    }else {
        $mensaje = "Error el usuario o contraseña son incorrectos";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Bienvenido a la magia</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <br><br><br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                    <?php if(isset($mensaje)){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                        <?php }?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Ingresa tu usuario">
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Ingresa tu contraseña">
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>