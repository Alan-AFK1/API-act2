<?php

require_once "conexion.php";

if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    die("ID de registro no válido.");
}

$id = (int) $_GET["id"];

$sql = "SELECT id, name, email, age, country FROM registros WHERE id = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("El registro no existe.");
}

$registro = $resultado->fetch_assoc();

$stmt->close();
$conexion->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar registro</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Editar registro</h1>

        <nav>
            <a href="index.php">Registrar</a>
            <a href="listar.php">Ver registros</a>
        </nav>
    </header>

    <main>
        <section>
            <article>
                <h2>Modificar usuario</h2>

                <form class="registro-form" action="actualizar.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= htmlspecialchars($registro["id"]) ?>"
                    >

                    <div>
                        <label for="name">Nombre:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= htmlspecialchars($registro["name"]) ?>"
                            required
                        >
                    </div>

                    <div>
                        <label for="email">Correo electrónico:</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($registro["email"]) ?>"
                            required
                        >
                    </div>

                    <div>
                        <label for="age">Edad:</label>
                        <input
                            type="number"
                            id="age"
                            name="age"
                            min="1"
                            max="120"
                            value="<?= htmlspecialchars($registro["age"]) ?>"
                            required
                        >
                    </div>

                    <div>
                        <label for="country">País:</label>
                        <select id="country" name="country" required>
                            <option value="">Selecciona un país</option>
                            <option value="México" <?= $registro["country"] === "México" ? "selected" : "" ?>>México</option>
                            <option value="España" <?= $registro["country"] === "España" ? "selected" : "" ?>>España</option>
                            <option value="Estados Unidos" <?= $registro["country"] === "Estados Unidos" ? "selected" : "" ?>>Estados Unidos</option>
                            <option value="Canadá" <?= $registro["country"] === "Canadá" ? "selected" : "" ?>>Canadá</option>
                            <option value="Argentina" <?= $registro["country"] === "Argentina" ? "selected" : "" ?>>Argentina</option>
                            <option value="Colombia" <?= $registro["country"] === "Colombia" ? "selected" : "" ?>>Colombia</option>
                            <option value="Chile" <?= $registro["country"] === "Chile" ? "selected" : "" ?>>Chile</option>
                        </select>
                    </div>

                    <button type="submit">Actualizar registro</button>

                </form>
            </article>
        </section>
    </main>

    <footer>
        <p>Actividad 2 - Aplicaciones Interactivas</p>
    </footer>

</body>
</html>