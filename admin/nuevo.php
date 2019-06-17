<?php  session_start();

require 'config.php';
require '../functions.php';

comprobarSession();
$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ../error.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titulo = limpiarDatos($_POST['titulo']);
    $descripcion = limpiarDatos($_POST['descripcion']);
    $texto = $_POST['texto'];
    $imagen = $_FILES['imagen']['tmp_name'];

    $archivo_subido = '../' . $blog_config['carpeta_imagenes'] . $_FILES['imagen']['name'];
    move_uploaded_file($imagen,$archivo_subido);
    $statement = $conexion->prepare('INSERT INTO posts (id,titulo,descripcion,texto,imagen) VALUES (null,:titulo,:descripcion,:texto,:imagen)');
    $statement->execute(array(':titulo' => $titulo, ':descripcion' => $descripcion, ':texto' => $texto, ':imagen' => $_FILES['imagen']['name']));
    header('Location: ' .  RUTA . 'admin/');
}


require '../views/nuevo.view.php';



?>