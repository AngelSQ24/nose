<?php
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "mi_base_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $telefono = $_POST['telefono'];

    if (preg_match("/^[0-9]{10}$/", $telefono)) {
        $sql = "INSERT INTO usuarios (nombre_completo, telefono) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nombre_completo, $telefono);

        if ($stmt->execute()) {
            echo "<div class='success'>Datos guardados exitosamente</div>";
        } else {
            echo "<div class='error'>Error al guardar los datos: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='error'>Por favor, ingresa un número de teléfono válido de 10 dígitos.</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        .form-container {
            background-color: #ffffff;
            padding: 2em;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-top: 10px;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #0078d4;
            box-shadow: 0 0 5px rgba(0, 120, 212, 0.3);
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #0078d4;
            color: #fff;
            font-weight: bold;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005bb5;
        }

        .success {
            margin-top: 15px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 8px;
        }

        .error {
            margin-top: 15px;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registro de Usuario</h2>
        <form method="POST" action="">
            <label for="nombre_completo">Nombre Completo:</label>
            <input type="text" id="nombre_completo" name="nombre_completo" required><br>
            
            <label for="telefono">Teléfono (10 dígitos):</label>
            <input type="text" id="telefono" name="telefono" maxlength="10" required><br>
            
            <input type="submit" value="Guardar">
        </form>
    </div>
</body>
</html>
