<?php
include('conexion.php');


function obtenerVehiculoPorMatricula($matricula) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vehiculos_icarplus WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function actualizarVehiculo($matricula, $marca, $modelo, $tipo, $ano, $clasificacion, $descripcion, $imagen) {
    global $conn;
    $stmt = $conn->prepare("UPDATE vehiculos_icarplus SET marca = ?, modelo = ?, tipo = ?, ano = ?, clasificacion = ?, descripcion = ?, imagen = ? WHERE matricula = ?");
    $stmt->bind_param("sssissss", $marca, $modelo, $tipo, $ano, $clasificacion, $descripcion, $imagen, $matricula);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["editar_vehiculo"])) {
    $matriculaEditar = $_GET["matricula"];
    $vehiculo = obtenerVehiculoPorMatricula($matriculaEditar);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_vehiculo"])) {
    $matricula = $_POST["matricula"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $tipo = $_POST["tipo"];
    $ano = $_POST["ano"];
    $clasificacion = $_POST["clasificacion"];
    $descripcion = $_POST["descripcion"];

  
    $vehiculoActual = obtenerVehiculoPorMatricula($matricula);
    $imagen = $vehiculoActual['imagen'];


    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $target_dir = "img_Vehi/";
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

    if (actualizarVehiculo($matricula, $marca, $modelo, $tipo, $ano, $clasificacion, $descripcion, $imagen)) {
        echo "Vehículo actualizado con éxito.";
        header("Location: vehiculos.php");
        exit();
    } else {
        echo "Error al actualizar el vehículo: " . $conn->error;
    }
}
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
    <div class="parallax"><img src="https://media.istockphoto.com/id/1478431022/es/foto/coches-en-venta-de-stock-mucha-fila.jpg?b=1&s=170667a&w=0&k=20&c=3znaMg2UP7DXxNQZ5cOObDzsJTjq4LztbBpU118sG5M="></div>
  </div>

<div class="container">
    <h3 class="center-align card-panel #004d40 teal darken-4 white-text">Editar Vehículo</h3>

    <div class="row">
        <div class="col l12 s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Editar Vehículo</span>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="input-field">
                            <input id="matricula" type="text" name="matricula" value="<?php echo $vehiculo['matricula']; ?>" readonly>
                            <label for="matricula">Matrícula (Solo lectura) </label>
                        </div>
                        <div class="input-field">
                            <input id="marca" type="text" name="marca" value="<?php echo $vehiculo['marca']; ?>" required>
                            <label for="marca">Marca</label>
                        </div>
                        <div class="input-field">
                            <input id="modelo" type="text" name="modelo" value="<?php echo $vehiculo['modelo']; ?>" required>
                            <label for="modelo">Modelo</label>
                        </div>
                        <div class="input-field">
                            <select id="tipo" name="tipo" required>
                                <option value="automatico" <?php echo ($vehiculo['tipo'] == 'automatico') ? 'selected' : ''; ?>>Automático</option>
                                <option value="sincronico" <?php echo ($vehiculo['tipo'] == 'sincronico') ? 'selected' : ''; ?>>Sincrónico</option>
                            </select>
                            <label for="tipo">Tipo</label>
                        </div>
                        <div class="input-field">
                            <input id="ano" type="number" name="ano" value="<?php echo $vehiculo['ano']; ?>" required>
                            <label for="ano">Año</label>
                        </div>
                        <div class="input-field">
                            <select id="clasificacion" name="clasificacion" required>
                                <option value="Segmento micro" <?php echo ($vehiculo['clasificacion'] == 'Segmento micro') ? 'selected' : ''; ?>>Segmento micro</option>
                                <option value="Segmento A" <?php echo ($vehiculo['clasificacion'] == 'Segmento A') ? 'selected' : ''; ?>>Segmento A</option>
                                <option value="Segmento B" <?php echo ($vehiculo['clasificacion'] == 'Segmento B') ? 'selected' : ''; ?>>Segmento B</option>
                                <option value="Segmento C" <?php echo ($vehiculo['clasificacion'] == 'Segmento C') ? 'selected' : ''; ?>>Segmento C</option>
                                <option value="Segmento D" <?php echo ($vehiculo['clasificacion'] == 'Segmento D') ? 'selected' : ''; ?>>Segmento D</option>
                                <option value="Segmento E" <?php echo ($vehiculo['clasificacion'] == 'Segmento E') ? 'selected' : ''; ?>>Segmento E</option>
                                <option value="Segmento F" <?php echo ($vehiculo['clasificacion'] == 'Segmento F') ? 'selected' : ''; ?>>Segmento F</option>
                                <option value="Segmento J" <?php echo ($vehiculo['clasificacion'] == 'Segmento J') ? 'selected' : ''; ?>>Segmento J</option>
                                <option value="Segmento M" <?php echo ($vehiculo['clasificacion'] == 'Segmento M') ? 'selected' : ''; ?>>Segmento M</option>
                                <option value="Segmento S" <?php echo ($vehiculo['clasificacion'] == 'Segmento S') ? 'selected' : ''; ?>>Segmento S</option>
                            </select>
                            <label for="clasificacion">Clasificación</label>
                        </div>
                        <div class="input-field">
                            <input id="descripcion" type="text" name="descripcion" value="<?php echo $vehiculo['descripcion']; ?>" required>
                            <label for="descripcion">Descripción</label>
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
                        <div class="input-field">
                            <input id="cedula_cliente" type="text" name="cedula_cliente" value="<?php echo $vehiculo['cedula_cliente']; ?>" readonly>
                            <label for="cedula_cliente">Cédula Cliente (Solo lectura)</label>
                        </div>
                        <div class="center">

                            <button class="btn waves-effect waves-light #004d40 teal darken-4" type="submit" name="actualizar_vehiculo">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="assets\js\init.js" ></script>
<script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems,);
  });

</script>
</body>
</html>
