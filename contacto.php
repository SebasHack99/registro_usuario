<?php
include 'connection.php';

// Obtener los valores de tipo_documento
$query_tipo_documento = "SELECT id, nombre FROM tipo_documento";
$resultado_tipo_documento = mysqli_query($enlace, $query_tipo_documento);

$tipo_documentos = [];
if ($resultado_tipo_documento) {
    while ($row = mysqli_fetch_assoc($resultado_tipo_documento)) {
        $tipo_documentos[] = $row;
    }
}

// Obtener los valores de rol_usuarios
$query_rol_usuarios = "SELECT ID, TIPO_USUARIO FROM rol_usuarios";
$resultado_rol_usuarios = mysqli_query($enlace, $query_rol_usuarios);

$rol_usuarios = [];
if ($resultado_rol_usuarios) {
    while ($row = mysqli_fetch_assoc($resultado_rol_usuarios)) {
        $rol_usuarios[] = $row;
    }
}

// Obtener los valores de estado
$query_estado = "SELECT ID, ESTADO_ACTIVIDAD FROM estado";
$resultado_estado = mysqli_query($enlace, $query_estado);

$estados = [];
if ($resultado_estado) {
    while ($row = mysqli_fetch_assoc($resultado_estado)) {
        $estados[] = $row;
    }
}

// Obtener los valores de habitaciones
$query_habitaciones = "SELECT ID, NUMERO FROM habitaciones";
$resultado_habitaciones = mysqli_query($enlace, $query_habitaciones);

$habitaciones = [];
if ($resultado_habitaciones) {
    while ($row = mysqli_fetch_assoc($resultado_habitaciones)) {
        $habitaciones[] = $row;
    }
}

// Obtener los valores de vehiculo
$query_vehiculo = "SELECT id, tipo_vehiculo FROM vehiculo";
$resultado_vehiculo = mysqli_query($enlace, $query_vehiculo);

$vehiculos = [];
if ($resultado_vehiculo) {
    while ($row = mysqli_fetch_assoc($resultado_vehiculo)) {
        $vehiculos[] = $row;
    }
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_documento_id = $_POST['tipo_documento_id'];
    $numero_identificacion = $_POST['numero_identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];
    $contrasena = $_POST['contrasena'];
    $habitacion = $_POST['habitacion'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $vehiculo = $_POST['vehiculo'];
    $placa_vehiculo = $_POST['placa_vehiculo'];

    // Verificar si el número de identificación ya existe
    $check_query = "SELECT * FROM usuarios WHERE NUMERO_IDENTIFICACION = ?";
    $stmt_check = mysqli_prepare($enlace, $check_query);
    mysqli_stmt_bind_param($stmt_check, "i", $numero_identificacion);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<div class='alert alert-danger'>El número de identificación ya está registrado.</div>";
    } else {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (tipo_documento_id, NUMERO_IDENTIFICACION, NOMBRE, APELLIDO, CORREO, ROL, TELEFONO, ESTADO, CONTRASENA, HABITACION, FECHA_CHECKIN, FECHA_CHECKOUT, vehiculo, placa_vehiculo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($enlace, $sql);
        mysqli_stmt_bind_param($stmt, "iisssiisssssss", $tipo_documento_id, $numero_identificacion, $nombre, $apellido, $correo, $rol, $telefono, $estado, $contrasena, $habitacion, $fecha_checkin, $fecha_checkout, $vehiculo, $placa_vehiculo);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Nuevo registro creado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . mysqli_error($enlace) . "</div>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($stmt_check);
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Registro de Usuario</h5>
                    <form action="#" method="post" class="row g-3">
                        <div class="col-md-4">
                            <label for="tipo_documento_id" class="form-label">Tipo de Documento</label>
                            <select id="tipo_documento_id" name="tipo_documento_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione el tipo de documento</option>
                                <?php foreach ($tipo_documentos as $tipo_documento): ?>
                                    <option value="<?php echo $tipo_documento['id']; ?>"><?php echo $tipo_documento['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="numero_identificacion" class="form-label">Número de Identificación</label>
                            <input type="number" id="numero_identificacion" name="numero_identificacion" class="form-control" placeholder="Número de Identificación" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" required>
                        </div>
                        <div class="col-md-4">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo" required>
                        </div>
                        <div class="col-md-4">
                            <label for="rol" class="form-label">Rol de Usuario</label>
                            <select id="rol" name="rol" class="form-select" required>
                                <option value="" disabled selected>Seleccione el rol de usuario</option>
                                <?php foreach ($rol_usuarios as $rol_usuario): ?>
                                    <option value="<?php echo $rol_usuario['ID']; ?>"><?php echo $rol_usuario['TIPO_USUARIO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select" required>
                                <option value="" disabled selected>Seleccione el estado</option>
                                <?php foreach ($estados as $estado): ?>
                                    <option value="<?php echo $estado['ID']; ?>"><?php echo $estado['ESTADO_ACTIVIDAD']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <div class="col-md-4">
                            <label for="habitacion" class="form-label">Habitación</label>
                            <select id="habitacion" name="habitacion" class="form-select" required>
                                <option value="" disabled selected>Seleccione la habitación</option>
                                <?php foreach ($habitaciones as $habitacion): ?>
                                    <option value="<?php echo $habitacion['ID']; ?>"><?php echo $habitacion['NUMERO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_checkin" class="form-label">Fecha de Check-In</label>
                            <input type="date" id="fecha_checkin" name="fecha_checkin" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_checkout" class="form-label">Fecha de Check-Out</label>
                            <input type="date" id="fecha_checkout" name="fecha_checkout" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <select id="vehiculo" name="vehiculo" class="form-select" required>
                                <option value="" disabled selected>Seleccione el tipo de vehículo</option>
                                <?php foreach ($vehiculos as $vehiculo): ?>
                                    <option value="<?php echo $vehiculo['id']; ?>"><?php echo $vehiculo['tipo_vehiculo']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="placa_vehiculo" class="form-label">Placa del Vehículo</label>
                            <input type="text" id="placa_vehiculo" name="placa_vehiculo" class="form-control" placeholder="Placa del Vehículo" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
