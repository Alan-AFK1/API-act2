<?php

require_once "conexion.php";

$sql = "SELECT id, name, email, age, country FROM registros ORDER BY id DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al consultar los registros: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de registros</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Registros almacenados</h1>

        <nav>
            <a href="index.php">Registrar</a>
            <a href="listar.php">Ver registros</a>
        </nav>
    </header>

    <main>
        <section>
            <article>
                <h2>Lista de usuarios</h2>

                <?php if ($resultado->num_rows > 0): ?>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo electrónico</th>
                                <th>Edad</th>
                                <th>País</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($registro = $resultado->fetch_assoc()): ?>

                                <tr>
                                    <!-- convertir caractereres especiales de html antes de mostrar datos, para evitar Cross-Site Scripting.
                                     Por ejemplo, mostrar literalmente texto y limitar ejecución de código  -->
                                    <td><?= htmlspecialchars($registro["id"]) ?></td>
                                    <td><?= htmlspecialchars($registro["name"]) ?></td>
                                    <td><?= htmlspecialchars($registro["email"]) ?></td>
                                    <td><?= htmlspecialchars($registro["age"]) ?></td>
                                    <td><?= htmlspecialchars($registro["country"]) ?></td>

                                    <td>
                                        <a href="editar.php?id=<?= $registro["id"] ?>" class="boton">
                                            Editar
                                        </a>

                                        <a href="eliminar.php?id=<?= $registro["id"] ?>"
                                        class="boton"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>
                    </table>

                <?php else: ?>

                    <p>No hay registros almacenados.</p>

                <?php endif; ?>

                <p>
                    <a href="index.php">Registrar un nuevo usuario</a>
                </p>

            </article>
        </section>
    </main>

    <footer>
        <p>Actividad 2 - Aplicaciones Interactivas</p>
    </footer>

</body>
</html>

<?php
$conexion->close();
?>