<!-- 
    ANUNCIOMODIFICAR-S.PHP
    Modificar un anuncio enlazado con una cuenta de usuario.
-->

<?php
    require "./../../../seguridad/mercapuntes/datosBD.php";

    // Recepción y validación de los datos
    $usuario = $_SESSION["usuario"];
    $id_anuncio = $_SESSION["aux"];
    $_SESSION["aux"] = "";  // Vaciamos por si acaso, ya que ya ha cumplido su función de trasporte

    $titulo = "";
    if (!isset($_POST["titulo"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir el título.");
    }
    $titulo = strip_tags(trim($_POST["titulo"]));

    $descripcion = "";
    if (!isset($_POST["descripcion"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la descripcion.");
    }
    $descripcion = strip_tags(trim($_POST["descripcion"]));

    $curso = "";
    if (!isset($_POST["curso"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir el curso.");
    }
    $curso = strip_tags(trim($_POST["curso"]));

    $tematica = "";
    if (!isset($_POST["tematica"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la tematica.");
    }
    $tematica = strip_tags(trim($_POST["tematica"]));

    $precio = "";
    if (!isset($_POST["precio"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir el precio.");
    }
    $precio = strip_tags(trim($_POST["precio"]));

    $zona = "";
    if (!isset($_POST["zona"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la zona.");
    }
    $zona = strip_tags(trim($_POST["zona"]));

    $telefono = "";
    if (!isset($_POST["telefono"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir el telefono.");
    }
    $telefono = strip_tags(trim($_POST["telefono"]));
    $telefono = str_replace(" ", "", $telefono);
    $telefono = str_replace("-", "", $telefono);

    if (empty($titulo) || strlen($titulo)<4 || strlen($titulo)>45) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode("")."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode($zona)."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca un título válido."));
        exit;
    }

    if (empty($descripcion) || strlen($descripcion)<20 || strlen($descripcion)>250) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode("")."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode($zona)."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca una descripción válida."));
        exit;
    }

    if (empty($precio) || !is_numeric($precio) || $precio<0 || $precio>9999) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode("")."&zona=".urlencode($zona)."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca un precio válido."));
        exit;
    }

    if (!empty($telefono) && (!is_numeric($telefono) || $telefono<100000000 || $telefono>999999999)) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode($zona)."&telefono=".urlencode("")."&mensaje2=".urlencode("Introduzca un teléfono válido."));
        exit;
    }


    // Los desplegables deben comprobarse con los datos existentes en la BD
    $resultado = comprobarSelect("cursos", $curso);
    if ($resultado == 0) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode("")."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode($zona)."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca un curso válido."));
        exit;
    }

    $resultado = comprobarSelect("tematicas", $tematica);
    if ($resultado == 0) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode("")."&precio=".urlencode($precio)."&zona=".urlencode($zona)."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca una temática válida."));
        exit;
    }

    $resultado = comprobarSelect("zonas", $zona);
    if ($resultado == 0) {
        header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje2=".urlencode("Introduzca una zona válida."));
        exit;
    }


    /*
        Validación de la imagen, en el caso de que se quiera subir una
    */
    $id_imagen = "";
    if ($_FILES["imagen"]["error"] != 4) {
        // 1. Restringir la extensión de la imagen
        $extension = explode(".", $_FILES["imagen"]["name"]);
        $extension = end($extension);
        $extension = strtolower($extension);
        if (strcmp($extension, "jpg")!=0 && strcmp($extension, "jpeg")!=0) {
            header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje=".urlencode("Introduzca una imagen válida (JPG, JPEG)."));
            exit;
        }
        // 2. Comprobar el tamaño de la imagen
        if ($_FILES["imagen"]["size"] > 5242880) {
            header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje=".urlencode("La imagen es demasiado grande (máximo permitido 5 MB)."));
            exit;
        }
        // 3. Comprobar cualquier otro tipo de error que se pueda dar y si no, subimos la imagen
        switch ($_FILES["imagen"]["error"]) {
            case UPLOAD_ERR_OK:         
                $id_imagen = uniqid("", true).".".$extension;
                $ruta_imagen = "./..".__ALBUM__.$id_imagen;
                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
                    header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje=".urlencode("La subida de imagen produce un error desconocido."));
                    exit;
                }    
                break;
            case UPLOAD_ERR_INI_SIZE: case UPLOAD_ERR_FORM_SIZE:
                header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje=".urlencode("La imagen es demasiado grande (máximo permitido 5 MB)."));
                exit;
                break;
            default:
                header("Location: ./../modificar.php?id=".$id_anuncio."&titulo=".urlencode($titulo)."&descripcion=".urlencode($descripcion)."&curso=".urlencode($curso)."&tematica=".urlencode($tematica)."&precio=".urlencode($precio)."&zona=".urlencode("")."&telefono=".urlencode($telefono)."&mensaje=".urlencode("La subida de imagen produce un error desconocido."));
                exit;
                break;
        }
    }


    // Necesitamos el ID del usuario
    $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
    if (!$canal) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
    }
    mysqli_set_charset($canal, "utf8");

    $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $usuario);

    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $id_usuario);
    mysqli_stmt_fetch($consulta);

    mysqli_stmt_close($consulta);
    unset($consulta);


    // Necesitamos la fecha actual
    date_default_timezone_set("Europe/Madrid");
    $fecha = date("Y-m-d H:i:s", time());

 
    // Dependiendo de si hemos subido una imagen o no, la sustituimos en la BD y borramos el archivo de la antigua
    if (empty($id_imagen)) {
        $sql = "UPDATE anuncios SET titulo=?, descripcion=?, curso=?, tematica=?, precio=?, zona=?, telefono=?, fecha=? WHERE id_anuncio=?";
        $consulta = mysqli_prepare($canal, $sql);
        if (!$consulta) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
        }
        mysqli_stmt_bind_param($consulta, "ssssdsssi", $titulo, $descripcion, $curso, $tematica, $precio, $zona, $telefono, $fecha, $id_anuncio);
    }
    else {
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
        $sql = "UPDATE anuncios SET titulo=?, descripcion=?, curso=?, tematica=?, precio=?, zona=?, telefono=?, fecha=?, imagen=? WHERE id_anuncio=?";
        $consulta = mysqli_prepare($canal, $sql);
        if (!$consulta) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
        }
        mysqli_stmt_bind_param($consulta, "ssssdssssi", $titulo, $descripcion, $curso, $tematica, $precio, $zona, $telefono, $fecha, $id_imagen, $id_anuncio);
    }


    // Actualizamos el anuncio en la base de datos
    mysqli_stmt_execute($consulta);    
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    header("Location: ./../anuncio.php?id=".urlencode($id_anuncio)."&mensaje=".urlencode("Anuncio modificado con éxito."));
?>
