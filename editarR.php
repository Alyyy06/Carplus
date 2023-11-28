<?php
include('conexion.php');


function obtenerRepuestoPorSerial($serial) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM repuestos_icarplus WHERE serial = ?");
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function editarRepuesto($serial, $marca, $nombre, $cantidad, $imagen) {
    global $conn;
    $stmt = $conn->prepare("UPDATE repuestos_icarplus SET marca = ?, nombre = ?, cantidad = ?, imagen = ? WHERE serial = ?");
    $stmt->bind_param("ssiss", $marca, $nombre, $cantidad, $imagen, $serial);
    return $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_repuesto"])) {
    $serial = $_POST["serial"];
    $marca = isset($_POST["marca"]) ? $_POST["marca"] : '';
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : '';


    $repuestoActual = obtenerRepuestoPorSerial($serial);
    $imagenActual = $repuestoActual['imagen'];

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $target_dir = "img_Repu/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
       
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                $imagenNueva = $target_file;
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
            } else {
                echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            }
        } else {
            echo "El archivo no es una imagen válida.";
        }
    } else {
      
        $imagenNueva = $imagenActual;
    }


    if (editarRepuesto($serial, $marca, $nombre, $cantidad, $imagenNueva)) {
        echo "Repuesto editado con éxito.";
    } else {
        echo "Error al editar el repuesto.";
    }
}


if (isset($_GET['serial'])) {
    $serialEditar = $_GET['serial'];
    $repuestoEditar = obtenerRepuestoPorSerial($serialEditar);
} else {
 
    header("Location: repuestos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iCar Plus</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>

<nav class="#004d40 teal darken-4">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo left">iCar Plus</a>
      <ul id="nav-mobile" class="right">
        <li><a href="pagina_principal.php">Inicio</a></li>
        <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </nav>

<div id="index-banner" class="parallax-container" >
    <div class="section no-pad-bot" id="inicio">
      <div class="container">
        <br><br><br><br><br><br>
        <h3 class="white-text center"></h3>
        <div class="row center">
          <h5 class="header col s12 light4"></h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="https://p4.wallpaperbetter.com/wallpaper/295/790/337/volkswagen-volkswagen-golf-assembly-disassembled-parts-hd-wallpaper-preview.jpg"></div>
  </div>
<div class="container">
    <h3 class="center-align card-panel #004d40 teal darken-4 white-text">Editar Repuesto</h3>

    <div class="row">
        <div class="col l8 s12 m6 offset-l2">
            <div class="card">
                <div class="card-content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="serial" value="<?php echo $repuestoEditar['serial']; ?>">
                        <div class="input-field">
                            <input id="marca" type="text" name="marca" value="<?php echo $repuestoEditar['marca']; ?>" required>
                            <label for="marca">Marca</label>
                        </div>
                        <div class="input-field">
                            <input id="nombre" type="text" name="nombre" value="<?php echo $repuestoEditar['nombre']; ?>" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field">
                            <input id="cantidad" type="number" name="cantidad" value="<?php echo $repuestoEditar['cantidad']; ?>" required>
                            <label for="cantidad">Cantidad</label>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn #004d40 teal darken-4">
                                <span>Imagen</span>
                                <input type="file" name="imagen">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="center">

                            <button class="btn waves-effect waves-light #004d40 teal darken-4" type="submit" name="editar_repuesto">Editar Repuesto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="left">
         <a href="repuestos.php"><i class="material-icons left">arrow_back</i>Regresar</a><hr>
     </div>
</div>
<br> <br>
<div class="center">

    <footer class="page-footer #303f9f #004d40 teal darken-4">
        <div class="footer-copyright">
            <div class="container">
                <p> Alidsabeth Jimenez <br>
                    Todos los derechos son reservados <br>
                    Copyright © 2023</p>
            </div>
            <div></div>
        </div>
    </footer>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems,);
  });

</script>
</body>
</html>
