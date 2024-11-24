<?php
// Conexión a la base de datos
$servername = "db4free.net"; // Cambia si es necesario
$username = "tu_usuario"; // Usuario de db4free
$password = "tu_contraseña"; // Contraseña de db4free
$dbname = "prueba01"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_apellido = trim($_POST['nombre_apellido']);
    $comentario = trim($_POST['comentario']);

    if (!empty($nombre_apellido) && !empty($comentario)) {
        // Verificar si el cliente existe
        $sql_cliente = "SELECT identificacion FROM clientes WHERE nombre_apellido = ?";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("s", $nombre_apellido);
        $stmt_cliente->execute();
        $result_cliente = $stmt_cliente->get_result();

        if ($result_cliente->num_rows > 0) {
            // El cliente existe
            $sql_comentario = "INSERT INTO comentarios (nombre_apellido, comentario) VALUES (?, ?)";
            $stmt_comentario = $conn->prepare($sql_comentario);
            $stmt_comentario->bind_param("ss", $nombre_apellido, $comentario);

            if ($stmt_comentario->execute()) {
                echo "<p>Comentario publicado exitosamente.</p>";
            } else {
                echo "<p>Error al publicar el comentario: " . $stmt_comentario->error . "</p>";
            }

            $stmt_comentario->close();
        } else {
            // El cliente no existe
            echo "<p>El cliente no está registrado. Por favor, <a href='log.php'>regístrate aquí</a>.</p>";
        }

        $stmt_cliente->close();
    } else {
        echo "<p>Por favor, completa todos los campos.</p>";
    }
}

$conn->close();
?>
