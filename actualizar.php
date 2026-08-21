<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso no permitido.");
}

$id = $_POST["id"] ?? "";
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$age = $_POST["age"] ?? "";
$country = trim($_POST["country"] ?? "");

if (!filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
    die("Error: ID de registro no válido.");
}

if ($name === "" || $email === "" || $age === "" || $country === "") {
    die("Error: todos los campos son obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: el correo electrónico no tiene un formato válido.");
}

if (!filter_var($age, FILTER_VALIDATE_INT) || $age < 1 || $age > 120) {
    die("Error: la edad debe ser un número entre 1 y 120.");
}

$sql = "UPDATE registros
        SET name = ?, email = ?, age = ?, country = ?
        WHERE id = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("ssisi", $name, $email, $age, $country, $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        $titulo = "Registro actualizado correctamente";
        $mensaje = "Los datos del usuario fueron modificados exitosamente.";
        $tipo = "exito";
    } else {
        $titulo = "Registro procesado";
        $mensaje = "No se realizaron cambios en los datos.";
        $tipo = "exito";
    }

} else {

    if ($conexion->errno === 1062) {
        $titulo = "Correo ya registrado";
        $mensaje = "El correo electrónico ya está registrado.";
        $tipo = "error";
    } else {
        $titulo = "Error";
        $mensaje = "No fue posible actualizar el registro.";
        $tipo = "error";
    }
}

$stmt->close();
$conexion->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Registro de usuarios</h1>

        <nav>
            <a href="index.php">Registrar</a>
            <a href="listar.php">Ver registros</a>
        </nav>
    </header>

    <main>
        <section>
            <article class="mensaje <?= $tipo ?>">
                <h2><?= htmlspecialchars($titulo) ?></h2>

                <p><?= htmlspecialchars($mensaje) ?></p>

                <div class="acciones">
                    <a href="listar.php" class="boton">Ver registros</a>
                    <a href="index.php" class="boton">Registrar nuevo usuario</a>
                </div>
            </article>
        </section>
    </main>

    <footer>
        <p>Actividad 2 - Aplicaciones Interactivas</p>
    </footer>

</body>
</html>