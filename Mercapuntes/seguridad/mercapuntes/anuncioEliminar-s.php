<!-- 
    ANUNCIOELIMINAR-S.PHP
    Eliminar un anuncio enlazado con una cuenta de usuario.
-->

<?php
    require "./../../../seguridad/mercapuntes/datosBD.php";

    // Recepción y validación de los datos
    $id_anuncio = $_SESSION["aux"];
    $_SESSION["aux"] = "";  // Vaciamos por si acaso, ya que ya ha cumplido su función de trasporte


    // Eliminamos la imagen del album
    $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
    if (!$canal) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
    }
    mysqli_set_charset($canal, "utf8");
    
    $sql = "SELECT imagen FROM anuncios WHERE id_anuncio = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $id_anuncio);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $imagenAntigua);
    mysqli_stmt_fetch($consulta);
    mysqli_stmt_close($consulta);
    unset($consulta);
    unlink("./../".__ALBUM__.$imagenAntigua);


    // Eliminamos el anuncio de la base de datos
    $sql = "DELETE FROM anuncios WHERE id_anuncio = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "i", $id_anuncio);
    mysqli_stmt_execute($consulta);    
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    header("Location: ./../subir.php?mensaje=".urlencode("Anuncio eliminado con éxito."));
?>
