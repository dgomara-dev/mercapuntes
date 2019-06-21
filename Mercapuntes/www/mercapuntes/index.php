<!--
    INDEX.PHP
    Página de inicio. 
-->


<?php
    // Recibir datos
    $texto = "";
    if (isset($_POST["texto"])) {
        $texto = strip_tags(trim($_POST["texto"]));
    }
    
    $curso = "";
    if (isset($_POST["curso"])) {
        $curso = strip_tags(trim($_POST["curso"]));
    }
    
    $tematica = "";
    if (isset($_POST["tematica"])) {
        $tematica = strip_tags(trim($_POST["tematica"]));
    }
    
    $precio = "";
    if (isset($_POST["precio"])) {
        $precio = strip_tags(trim($_POST["precio"]));
    }
    
    $zona = "";
    if (isset($_POST["zona"])) {
        $zona = strip_tags(trim($_POST["zona"]));
    }

    $campos = array($texto, $curso, $tematica, $precio, $zona);

    // Para las funciones que realizan consultas con la BD
    require "./../../seguridad/mercapuntes/datosBD.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mercapuntes - Vende tus apuntes al mejor precio</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/all.css" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <link rel="icon" type="image/png" href="./img/favicon.png">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/funciones.js"></script>
</head>

<body>
    <!-- Barra de navegación -->
    <header class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container">
                <a class="navbar-brand" href="./index.php">
                    <img src="./img/logo2.png" alt="Mercapuntes" height="65px" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="./index.php"><i class="fas fa-home"></i>&nbsp;Inicio</a>
                        </li>
                        <?php
                            // Dependiendo de si hemos iniciado sesión o no, mostramos unas cosas u otras
                            require "./../../seguridad/mercapuntes/funciones.php";
                            iniciarSesion();
                            $usuario = "";
                            if (validarSesion($usuario)) {
                                echo "<li class='nav-item'>
                                            <a class='nav-link' href='./perfil.php'><i class='fas fa-user'></i>&nbsp;Perfil</a>
                                        </li>
                                        <li class='nav-item'>
                                            <a class='nav-link' href='./subir.php'><i class='fas fa-check'></i>&nbsp;Subir anuncio</a>
                                        </li>
                                        <li class='nav-item'>
                                            <a class='nav-link' href='./src/sesionCerrar.php'><i class='fas fa-sign-out-alt'></i>&nbsp;Cerrar sesión</a>
                                        </li>";
                            }
                            else {
                                echo "<li class='nav-item'>
                                            <a class='nav-link' href='./iniciarSesion.php'><i class='fas fa-sign-in-alt'></i>&nbsp;Entrar</a>
                                        </li>
                                        <li class='nav-item'>
                                            <a class='nav-link' href='./registro.php'><i class='fas fa-user-plus'></i>&nbsp;Registrarse</a>
                                        </li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Parte principal -->
    <main class="container">
        <?php
            // Dependiendo de si hemos iniciado sesión o no, mostramos unas cosas u otras
            if (!validarSesion($usuario)) {
                echo "<div class='row'>
                        <div class='col-md-12'>
                            <div class='card'>
                                <div id='carousel' class='carousel slide' data-ride='carousel'>
                                    <div class='carousel-inner rounded mx-auto'>
                                        <div class='carousel-item active'>
                                            <img class='img-fluid rounded mx-auto d-block w-100' src='./img/carousel1.png' alt='Bienvenido a MERCAPUNTES'>
                                        </div>
                                        <div class='carousel-item'>
                                            <img class='img-fluid rounded mx-auto d-block w-100' src='./img/carousel2.png' alt='Usa la web sin coste'>
                                        </div>
                                        <div class='carousel-item'>
                                            <a href='./registro.php'><img class='img-fluid rounded mx-auto d-block w-100' src='./img/carousel3.png' alt='Regístrate ya'></a>
                                        </div>
                                    </div>
                                    <a class='carousel-control-prev' href='#carousel' data-slide='prev'>
                                        <span class='carousel-control-prev-icon'></span>
                                    </a>
                                    <a class='carousel-control-next' href='#carousel' data-slide='next'>
                                        <span class='carousel-control-next-icon'></span>
                                    </a>
                                </div>
                            </div>
                        </div>  
                    </div>";
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin:0">
                    <div class="card-header">
                        <h5 class="card-title text-center">¿Qué es lo que buscas?</h5>
                    </div>
                    <div class="card-body">
                        <form id="formulario" method="post" action="./index.php">
                            <div class="form-row">
                                <div class="form-label-group col-md-12">
                                    <label for="curso">Búsqueda</label>
                                    <input type="text" name="texto" id="texto" class="form-control" minlenght="4" maxlength="90" size="20" autofocus="autofocus" placeholder="Apuntes de matemáticas..." value="<?=$texto?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label-group col-md-3">
                                    <label for="curso">Curso</label>
                                    <select class="form-control" name="curso" id="curso" form="formulario">
                                        <?php
                                            mostrarSelect("cursos", "id_curso", $curso, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-label-group col-md-3">
                                    <label for="tematica">Temática</label>
                                    <select class="form-control" name="tematica" id="tematica" form="formulario">
                                        <?php
                                            mostrarSelect("tematicas", "id_tematica", $tematica, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-label-group col-md-3">
                                    <label for="zona">Zona</label>
                                    <select class="form-control" name="zona" id="zona" form="formulario">
                                        <?php
                                            mostrarSelect("zonas", "id_zona", $zona, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-label-group col-md-3">
                                    <label for="precio">Precio máximo (€)</label>
                                    <input type="number" name="precio" id="precio" class="form-control currency" min="0" max="9999" step="0.01" placeholder="0,00" value="<?=$precio?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label-group col-md-12">
                                    <button class="btn btn-lg btn-warning btn-block text-uppercase" name="submit" type="submit">¡Buscar apuntes!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php
                // Parte principal de la consulta
                $sql = "SELECT id_anuncio, titulo, descripcion, precio, imagen FROM anuncios";

                // Dependiendo de los campos que se envíen en el formulario, se escribirá una sentencia u otra
                $cambio = false;    // Bandera que nos dice si ya se ha producido una concatenación en la sentencia
                $parametros = array();  // Array que nos guarda los valores de los parámetros
                $parametros_tipos = "";    // String que nos guarda el tipo de cada parámetro que queramos buscar
                if (!empty($texto)) {
                    $sql .= " WHERE titulo LIKE ?";
                    array_push($parametros, "%".$texto."%");
                    $parametros_tipos .= "s";
                    $cambio = true;
                }

                for ($i=1; $i<sizeof($campos); $i++) {
                    if (!empty($campos[$i])) {
                        if ($cambio == false) {
                            $sql .= " WHERE";
                            $cambio = true;
                        }
                        else {
                            $sql .= " AND";  
                        }
                        if ($i == 1) {
                            $sql .= " curso = ?";
                            array_push($parametros, $curso);
                            $parametros_tipos .= "s";
                        }
                        else if ($i == 2) {
                            $sql .= " tematica = ?";
                            array_push($parametros, $tematica);
                            $parametros_tipos .= "s";
                        }
                        else if ($i == 3) {
                            $sql .= " precio <= ?";
                            array_push($parametros, $precio);
                            $parametros_tipos .= "d";
                        } 
                        else if ($i == 4) {
                            $sql .= " zona = ?";
                            array_push($parametros, $zona);
                            $parametros_tipos .= "s";
                        }
                    }
                }

                // Independientemente de los valores, la sentencia terminará así siempre
                $sql .= " ORDER BY fecha DESC";

                // Creamos el canal y la consulta
                $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
                if (!$canal) {
                    exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
                }
                mysqli_set_charset($canal, "utf8");
                
                $consulta = mysqli_prepare($canal, $sql);        
                if (!$consulta) {
                    exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
                }

                // Hacemos esto sólo si hay que pasar parámetros
                if (!empty($parametros)) {
                    $contenido_bind_param[] = $parametros_tipos; // Guardamos los tipos en la primera posición del array
                    for ($i=0; $i<count($parametros); $i++) {
                        $nombre_bind = "bind".$i; // Creamos un nombre de variable
                        $$nombre_bind = $parametros[$i];  // Doble dólar porque es una variable "variable", le añadimos el parámetro
                        $contenido_bind_param[] = &$$nombre_bind; // Pasamos por referencia la varaible "variable" dentro del array
                    }
                 
                // Llamamos a la función de forma dinámica
                    call_user_func_array(array($consulta, "bind_param"), $contenido_bind_param);
                }

                mysqli_stmt_execute($consulta);
                mysqli_stmt_bind_result($consulta, $id_anuncio_, $titulo_, $descripcion_, $precio_, $imagen_);
                
                // Mostramos los resultados de la consulta
                $cont = 0;
                while (mysqli_stmt_fetch($consulta)) {
                    if (empty($imagen_)) {
                        $imagen_ = "./img/imagen.png";
                    }
                    else {
                        $imagen_ = "./src/imagenMostrar.php?id=".$imagen_;
                    }
                    if ($cont%3==0) {
                       echo "</div>"; 
                    }
                    if ($cont==0 || $cont%3==0) {
                       echo "<div class='row'>"; 
                    }
                    echo "<div class='col-md-4' style='margin-top:30px'>
                            <div class='card h-100'>
                                <a href='./anuncio.php?id=".$id_anuncio_."'><img class='card-img-top img-thumbnail rounded mx-auto' src='".$imagen_."' alt='".$titulo_."'></a>
                                <div class='card-body'>
                                    <h4 class='card-title titulo-anuncio text-uppercase'><a href='./anuncio.php?id=".$id_anuncio_."'>".$titulo_."</a></h4>
                                    <h5 class='font-weight-bold'>".$precio_."€</h5>
                                    <p class='card-text'>".$descripcion_."</p>
                                </div>
                            </div>
                        </div>";
                    $cont++;
                }
                if ($cont == 0) {
                    echo "<p style='text-align:center;margin-top:50px;font-size:20px;color:white;'>No se han encontrado resultados. Prueba a ampliar la búsqueda.</p";
                }
                mysqli_stmt_close($consulta);
                unset($consulta);
                mysqli_close($canal);
            ?>
        </div>
        <!-- Aviso legal -->
        <div id="avisoLegal" class="modal">
            <div id="avisoLegal-content" class="modal-content">
                <div id="avisoLegal-header" class="modal-header">
                    <h2 class="text-uppercase" style="padding: 10px">Aviso legal</h2>
                    <span id="cerrarAvisoLegal" class="close"><i class="fas fa-window-close"></i></span>
                </div>
                <div id="avisoLegal-body" class="modal-body" style="margin-top: 10px">
                    <h5>POLÍTICA DE PRIVACIDAD</h5>
                    <p class="small">En cumplimiento de lo dispuesto en la Ley Orgánica 15/1999, de 13 de Diciembre, de Protección de Datos de Carácter Personal (LOPD) se informa al usuario que todos los datos que nos proporcione serán incorporados a un fichero, creado y mantenido bajo la responsabilidad de Mercapuntes.</p>
                    <p class="small">Siempre se va a respetar la confidencialidad de sus datos personales que sólo serán utilizados con la finalidad de gestionar los servicios ofrecidos, atender a las solicitudes que nos plantee, realizar tareas administrativas, así como remitir información técnica, comercial o publicitaria por vía ordinaria o electrónica.</p><br />
                    <h5>POLÍTICA DE COOKIES</h5>
                    <p class="small">Mercapuntes por su propia cuenta o la de un tercero contratado para prestación de servicios de medición, pueden utilizar cookies cuando el usuario navega por el sitio web. Las cookies son ficheros enviados al navegador por medio de un servicio web con la finalidad de registrar las actividades del usuario durante su tiempo de navegación.</p>
                    <p class="small">Las cookies utilizadas se asocian únicamente con un usuario anónimo y su ordenador, y no proporcionan por sí mismas los datos personales del usuario.</p>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="text-center font-weight-bold">
                        <span id="abrirAvisoLegal" style="color:white">AVISO LEGAL</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="small text-center">Copyright &copy; 2019 - Mercapuntes</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center">
                        <a href="https://twitter.com/mercapuntes/" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://www.facebook.com/Mercapuntes-2108176312628206/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://www.instagram.com/mercapuntes/" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
