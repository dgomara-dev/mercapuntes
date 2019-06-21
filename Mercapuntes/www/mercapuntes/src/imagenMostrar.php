<!-- 
    IMAGENMOSTRAR.PHP
    Muestra una imagen que recibe por GET
-->


<?php
    $imagen = "";
    if (isset($_GET["id"])) {
       $imagen = strip_tags(trim($_GET["id"]));
    }

    require "./../../../seguridad/mercapuntes/datosBD.php";
    header('Content-Type: image/jpeg');
    ob_get_clean();
    readfile("./..".__ALBUM__.$imagen);
    ob_end_flush();
?>
