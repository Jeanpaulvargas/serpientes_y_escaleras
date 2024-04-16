<?php
session_start();

// Si no se ha establecido el nombre del jugador o no ha llegado a la casilla 100, redireccionar al inicio
if (!isset($_SESSION['player_name']) || $_SESSION['player_position'] != 100) {
    header("Location: setup.php");
    exit();
}

// Reiniciar el juego
if (isset($_POST['restart'])) {
    $_SESSION['player_position'] = 1; // Reiniciar la posición del jugador
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Ganaste!</title>
</head>
<body>
    <h1>¡Felicidades, <?php echo htmlspecialchars($_SESSION['player_name']); ?> has ganado el juego!</h1>
    <form method="post">
        <button type="submit" name="restart">Reiniciar Juego</button>
    </form>
</body>
</html>
