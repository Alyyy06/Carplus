<?php
include('conexion.php');


function agregarRepuesto($serial, $marca, $nombre, $cantidad, $imagen) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO repuestos_icarplus (serial, marca, nombre, cantidad, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $serial, $marca, $nombre, $cantidad, $imagen);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function obtenerRepuestos() {
    global $conn;
    $result = $conn->query("SELECT * FROM repuestos_icarplus");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function eliminarRepuesto($serial) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM repuestos_icarplus WHERE serial = ?");
    $stmt->bind_param("i", $serial);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_repuesto"])) {
    $serial = $_POST["serial"];
    $marca = $_POST["marca"];
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];

    $imagen = "img/default.jpg"; 

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
    
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                $imagen = $target_file;
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
            } else {
                echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            }
        } else {
            echo "El archivo no es una imagen válida.";
        }
    }

    if (agregarRepuesto($serial, $marca, $nombre, $cantidad, $imagen)) {
        echo "Repuesto agregado con éxito.";
    } else {
        echo "Error al agregar el repuesto: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_repuesto"])) {
    $serialEliminar = $_POST["serial"];

    if (eliminarRepuesto($serialEliminar)) {
        echo "Repuesto eliminado con éxito.";
    } else {
        echo "Error al eliminar el repuesto: " . $conn->error;
    }
}


$repuestos = obtenerRepuestos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iCar Plus</title>
 
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
    <div class="parallax"><img src="https://images.unsplash.com/photo-1494905998402-395d579af36f?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8OXx8fGVufDB8fHx8fA%3D%3D"></div>
  </div>
<div class="container">
    <h3 class="center-align card-panel #004d40 teal darken-4 white-text">Repuestos</h3>

    <div class="row">
        <div class="col l8 s12 m6 offset-l2">
            <div class="card">
                <div class="card-content center">
                    <span class="card-title">Agregar Repuesto</span>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <input id="serial" type="text" name="serial" required>
                            <label for="serial">Serial</label>
                        </div>
                        <div class="input-field">
                            <input id="marca" type="text" name="marca" required>
                            <label for="marca">Marca</label>
                        </div>
                        <div class="input-field">
                            <input id="nombre" type="text" name="nombre" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field">
                            <input id="cantidad" type="number" name="cantidad" required>
                            <label for="cantidad">Cantidad</label>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn #004d40 teal darken-4">
                                <span>Imagen</span>
                                <input type="file" name="imagen" accept="image/*">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light #004d40 teal darken-4" type="submit" name="agregar_repuesto">Agregar Repuesto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row #1de9b6 teal accent-3">
        <div class="col s12">
            <table class="striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Serial</th>
                    <th>Marca</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $N_contador = 1;
                foreach ($repuestos as $repuesto) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $N_contador . "</td>";
                    echo "<td class='text-center'>" . $repuesto['serial'] . "</td>";
                    echo "<td class='text-center'>" . $repuesto['marca'] . "</td>";
                    echo "<td class='text-center'>" . $repuesto['nombre'] . "</td>";
                    echo "<td class='text-center'>" . $repuesto['cantidad'] . "</td>";
                    echo "<td class='text-center'><img class='materialboxed' src='" . $repuesto['imagen'] . "' alt='Imagen de repuesto' style='max-width: 100px; max-height: 100px;'></td>";
                    echo "<td class='text-center'>
                            <form action='editarR.php' method='get'>
                                <input type='hidden' name='serial' value='" . $repuesto['serial'] . "'>
                                <button class='btn waves-effect waves-light' type='submit' name='editar_repuesto'>Editar</button>
                            </form>

                        </td>";
                    echo "<td class='text-center'>
                        <form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
                            <input type='hidden' name='serial' value='" . $repuesto['serial'] . "'>
                            <button class='btn red waves-effect waves-light' type='submit' name='eliminar_repuesto'>Eliminar</button>
                        </form>
                    </td>";
                    echo "</tr>";

                    $N_contador++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="center">

    <footer class="page-footer #303f9f #004d40 teal darken-4
">
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
