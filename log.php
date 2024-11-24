<?php
$servername = "db4free.net"; // Dirección del servidor
$username = "marlonk"; // Nombre de usuario de tu cuenta de db4free
$password = "12345678"; // Contraseña de tu cuenta de db4free
$dbname = "prueba01"; // Nombre de la base de datos


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $identificacion = trim($_POST['identificacion']);

    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($apellido) && !empty($identificacion)) {
        // Preparar la consulta para insertar los datos
        $sql = "INSERT INTO clientes (nombre, apellido, identificacion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $apellido, $identificacion);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
            echo "<p>Registro exitoso. Ahora puedes regresar y comentar.</p>";
            echo '<a href="index.html">Volver a la página principal</a>';
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Por favor, completa todos los campos.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Registro de Clientes</h1>
    <form method="POST" action="log.php">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="identificacion" placeholder="Identificación" required>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
