<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso no permitido.");
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$age = $_POST["age"] ?? "";
$country = trim($_POST["country"] ?? "");

if ($name === "" || $email === "" || $age === "" || $country === "") {
    die("Error: todos los campos son obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: el correo electrónico no tiene un formato válido.");
}

if (!filter_var($age, FILTER_VALIDATE_INT) || $age < 1 || $age > 120) {
    die("Error: la edad debe ser un número entre 1 y 120.");
}

// los "?" son parametros que se rellenaran después 
$sql = "INSERT INTO registros (name, email, age, country) VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// "ssis" se refiere a string, string, integer, string, en orden. El "Prepared Statement"
$stmt->bind_param("ssis", $name, $email, $age, $country);

if ($stmt->execute()) {

    $titulo = "Registro guardado correctamente";
    $mensaje = "El usuario fue registrado exitosamente.";
    $tipo = "exito";

} else {

    if ($conexion->errno === 1062) {
        $titulo = "Correo ya registrado";
        $mensaje = "El correo electrónico ya está registrado.";
        $tipo = "error";
    } else {
        $titulo = "Error";
        $mensaje = "No fue posible guardar el registro.";
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
                    <a href="index.php" class="boton">Volver al formulario</a>
                    <a href="listar.php" class="boton">Ver registros</a>
                </div>
            </article>
        </section>
    </main>

    <footer>
        <p>Actividad 2 - Aplicaciones Interactivas</p>
    </footer>

</body>
</html>
