<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuarios</title>
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
            <article>
                <h2>Registrar nuevo usuario</h2>

                <form class="registro-form" action="guardar.php" method="POST">

                    <div>
                        <label for="name">Nombre:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                        >
                    </div>

                    <div>
                        <label for="email">Correo electrónico:</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
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
                            required
                        >
                    </div>

                    <div>
                        <label for="country">País:</label>
                        <select id="country" name="country" required>
                            <option value="">Selecciona un país</option>
                            <option value="México">México</option>
                            <option value="España">España</option>
                            <option value="Estados Unidos">Estados Unidos</option>
                            <option value="Canadá">Canadá</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Chile">Chile</option>
                        </select>
                    </div>

                    <button type="submit">Guardar registro</button>

                </form>
            </article>
        </section>
    </main>

    <footer>
        <p>Actividad 2 - Aplicaciones Interactivas</p>
    </footer>

</body>
</html>