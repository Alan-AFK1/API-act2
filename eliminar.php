<?php

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    die("Acceso no permitido.");
}

if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    die("Error: ID de registro no válido.");
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM registros WHERE id = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        $titulo = "Registro eliminado correctamente";
        $mensaje = "El registro seleccionado fue eliminado.";
        $tipo = "exito";
    } else {
        $titulo = "Registro no encontrado";
        $mensaje = "No existe un registro con el ID seleccionado.";
        $tipo = "error";
    }

} else {

    $titulo = "Error";
    $mensaje = "No fue posible eliminar el registro.";
    $tipo = "error";
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
                    <a href="listar.php" class="boton">Volver a los registros</a>
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