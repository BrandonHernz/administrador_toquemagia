<?php

//Configuración de conexión BD (Backend)

define('HOST', 'localhost');
define('USER', 'root'); //Nombre de usuario de la BD
define('PASSWORD', ''); //Contraseña de la base de datos
define('DBNAME', 'tiendita'); //Nombre de la base de datos

$conexion = new mysqli(HOST, USER, PASSWORD, DBNAME);