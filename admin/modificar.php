<?php  session_start();

require 'config.php';
require '../functions.php';

comprobarSession();
$conexion = conexion($bd_config);
if (!$conexion) {
    header('Location: ../error.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = limpiarDatos($_POST['titulo']);
    $descripcion = limpiarDatos($_POST['descripcion']);
    $texto = $_POST['texto'];
    $id = limpiarDatos($_POST['id']);
    $imagen_guardada = $_POST['imagen-guardada'];
    $imagen = $_FILES['imagen'];

    if (empty($imagen['name'])){
        $imagen = $imagen_guardada;
    }else {
        $archivo_subido = '../' . $blog_config['carpeta_imagenes'] . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'],$archivo_subido);
        $imagen = $_FILES['imagen']['name'];
    }

    $statement = $conexion->prepare('UPDATE posts SET titulo = :titulo, descripcion = :descripcion, texto = :texto, imagen = :imagen WHERE id = :id');
    $statement->execute(array(':titulo' => $titulo, ':descripcion' => $descripcion, ':texto' => $texto, ':imagen' => $imagen, ':id' => $id));
    header('Location: ' . RUTA . 'admin/');

}else {
    $id_articulo = id_articulo($_GET['id']);
    if (empty($id_articulo)){
        header('Location: ' . RUTA . 'admin/');
    }

    $post = obtener_post_por_id($conexion,$id_articulo);
    if (!$post){
        header('Location: ' . RUTA . 'admin/');
    }

    $post = $post[0];
}


require '../views/modificar.view.php';

?>