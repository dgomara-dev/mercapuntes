<!-- 
    USUARIOCREAR.PHP
    Se manda a crear un nuevo usuario, fuera en la carpeta de seguridad.
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si ya hay una sesión iniciada, no podemos permitir que se pueda entrar aquí.
        En tal caso, echamos al usuario a index.php.
    */
    require "./../../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (validarSesion($usuario)) {
        header("Location: ./../index.php");
        exit;
    }

    require "./../../../seguridad/mercapuntes/usuarioCrear-s.php";
?>
