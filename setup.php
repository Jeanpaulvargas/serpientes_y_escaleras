<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['player_name'] = $_POST['player_name'];
    $_SESSION['player_position'] = 1; 
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración del Juego</title>
</head>
<body>
    <h1>Ingrese su nombre para comenzar el juego</h1>
    <form method="post">
        Nombre del Jugador: <input type="text" name="player_name" required>
        <button type="submit">Comenzar Juego
            
        </button>
    </form>
</body>
</html>
