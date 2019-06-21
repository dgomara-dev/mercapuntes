<!-- 
    USUARIOACTUALIZAR.PHP
    Se manda actualizar determinados datos del usuario, fuera en la carpeta de seguridad.
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si *NO* hay una sesión iniciada, no podemos permitir que se pueda entrar aquí.
        En tal caso, echamos al usuario a iniciarSesion.php.
     */
    require "./../../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (!validarSesion($usuario)) {
        header("Location: ./../iniciarSesion.php");
        exit;
    }

   require "./../../../seguridad/mercapuntes/usuarioActualizar-s.php";
?>
