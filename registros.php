<?php
include('conexion.php');


date_default_timezone_set('America/Caracas');


function obtenerRegistros() {
    global $conn;
    $result = $conn->query("SELECT * FROM registros_icarplus");
    return $result->fetch_all(MYSQLI_ASSOC);
}


function obtenerRegistroPorId($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM registros_icarplus WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function insertarRegistro($matricula_vehiculos, $cedula_mecanicos, $serial_repuestos, $cantidad_repuestos, $fecha_ingreso) {
    global $conn;
    
    
    $stmt = $conn->prepare("INSERT INTO registros_icarplus (matricula_vehiculos, cedula_mecanicos, serial_repuestos, cantidad_repuestos, fecha_ingreso) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $matricula_vehiculos, $cedula_mecanicos, $serial_repuestos, $cantidad_repuestos, $fecha_ingreso);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function actualizarRegistro($id, $matricula_vehiculos, $cedula_mecanicos, $serial_repuestos, $cantidad_repuestos) {
    global $conn;
    $stmt = $conn->prepare("UPDATE registros_icarplus SET matricula_vehiculos = ?, cedula_mecanicos = ?, serial_repuestos = ?, cantidad_repuestos = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $matricula_vehiculos, $cedula_mecanicos, $serial_repuestos, $cantidad_repuestos, $id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function eliminarRegistro($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM registros_icarplus WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar"])) {
    $matricula_vehiculos = $_POST["matricula_vehiculos"];
    $cedula_mecanicos = $_POST["cedula_mecanicos"];
    $serial_repuestos = $_POST["serial_repuestos"];
    $cantidad_repuestos = $_POST["cantidad_repuestos"];
    $fecha_ingreso = date('Y-m-d H:i:s');

    if (insertarRegistro($matricula_vehiculos, $cedula_mecanicos, $serial_repuestos, $cantidad_repuestos, $fecha_ingreso)) {
        echo "Registro insertado con éxito.";
    } else {
        echo "Error al insertar el registro: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_registro"])) {
    $idEditar = $_POST["id"];
    $matricula_vehiculosEditar = $_POST["matricula_vehiculos"];
    $cedula_mecanicosEditar = $_POST["cedula_mecanicos"];
    $serial_repuestosEditar = $_POST["serial_repuestos"];
    $cantidad_repuestosEditar = $_POST["cantidad_repuestos"];

    if (actualizarRegistro($idEditar, $matricula_vehiculosEditar, $cedula_mecanicosEditar, $serial_repuestosEditar, $cantidad_repuestosEditar)) {
        echo "Registro actualizado con éxito.";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_registro"])) {
    $idEliminar = $_POST["id_eliminar"];

    if (eliminarRegistro($idEliminar)) {
        echo "Registro eliminado con éxito.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

function getVerEnlace($id) {
    return "ver_registro.php?id=$id";
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

<nav class="#303f9f #004d40 teal darken-4">
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
    <div class="parallax"><img src="https://png.pngtree.com/thumb_back/fw800/background/20230610/pngtree-lamborghini-super-car-in-fire-wallpapers-hd-image_2904876.jpg"></div>
  </div>

<div class="container">
    <h3 class="center-align card-panel #303f9f #004d40 teal darken-4 white-text">Registros</h3>


    <div class="row">
        <div class="col l12 s12 m6">
            <div class="card">
                <div class="card-content center">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="input-field">
                            <input id="matricula_vehiculos" type="text" name="matricula_vehiculos" required>
                            <label for="matricula_vehiculos">Matrícula Vehículo</label>
                        </div>
                        <div class="input-field">
                            <input id="cedula_mecanicos" type="text" name="cedula_mecanicos" required>
                            <label for="cedula_mecanicos">Cédula Mecánico</label>
                        </div>
                        <div class="input-field">
                            <input id="serial_repuestos" type="text" name="serial_repuestos" required>
                            <label for="serial_repuestos">Serial Repuestos</label>
                        </div>
                        <div class="input-field">
                            <input id="cantidad_repuestos" type="number" name="cantidad_repuestos" required>
                            <label for="cantidad_repuestos">Cantidad Repuestos</label>
                        </div>
                        <button class="btn waves-effect waves-light #303f9f #004d40 teal darken-4" type="submit" name="registrar">Registrar</button>
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
                        <th>ID</th>
                        <th>Matrícula Vehículo</th>
                        <th>Cédula Mecánico</th>
                        <th>Serial Repuesto</th>
                        <th>Cantidad Repuesto</th>
                        <th>Fecha Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $registros = obtenerRegistros();
                    foreach ($registros as $registro) {
                        echo "<tr>";
                        echo "<td>{$registro['id']}</td>";
                        echo "<td>{$registro['matricula_vehiculos']}</td>";
                        echo "<td>{$registro['cedula_mecanicos']}</td>";
                        echo "<td>{$registro['serial_repuestos']}</td>";
                        echo "<td>{$registro['cantidad_repuestos']}</td>";
                        echo "<td>{$registro['fecha_ingreso']}</td>";
                        echo "<td>
                                <a class='waves-effect waves-light btn' href='" . getVerEnlace($registro['id']) . "'>Ver</a></td>";
                        echo "</tr>";
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
<script src="assets\js\init.js"></script>
<script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems,);
  });

</script>
</body>
</html>