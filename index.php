<?php
session_start();

if (!isset($_SESSION['player_name']) || !isset($_SESSION['player_position'])) {
    header("Location: setup.php");
    exit();
}

// Definir serpientes y escaleras
$escaleras = [3 => 11, 15 => 35, 22 => 42];
$serpientes = [98 => 78, 95 => 75, 47 => 26];

$message = '';

// Mover al jugador
if (isset($_POST['move'])) {
    $diceRoll = rand(1, 12); // Tira un dado de 12 caras
    $_SESSION['last_dice_roll'] = $diceRoll;
    $newPosition = $_SESSION['player_position'] + $diceRoll;
    $newPosition = min($newPosition, 100); // El máximo es 100

    // Comprobar escaleras y serpientes
    if (array_key_exists($newPosition, $escaleras)) {
        $message = "¡Subiste por una escalera de $newPosition a " . $escaleras[$newPosition] . "!";
        $newPosition = $escaleras[$newPosition];
    } elseif (array_key_exists($newPosition, $serpientes)) {
        $message = "¡Bajaste por una serpiente de $newPosition a " . $serpientes[$newPosition] . "!";
        $newPosition = $serpientes[$newPosition];
    }

    $_SESSION['player_position'] = $newPosition;

    // Comprobar si el jugador ha ganado
    if ($_SESSION['player_position'] == 100) {
        header("Location: win.php");
        exit();
    }
}

// Reiniciar el juego
if (isset($_POST['reset'])) {
    $_SESSION['player_position'] = 1;
    unset($_SESSION['last_dice_roll']);
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tablero de Escaleras y Serpientes</title>
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(10, 50px);
            /* crea un grid de 10x10 */
            grid-gap: 5px;
        }

        .cell {
            width: 60px;
            /* Ajustado para dar más espacio a las imágenes */
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            background-color: #f0f0f0;
            background-size: cover;
            /* Cubre toda la casilla con la imagen */
            background-position: center;
            /* Centra la imagen en la casilla */
        }

        .escalera {
            background-image: url('./images/esc.jpeg');
        }

        .serpiente {
            background-image: url('./images/ser.png');
        }

        .player {
            background-color: blue;
            color: white;
            font-weight: bold;
            position: relative;
            z-index: 1;
            /* Asegura que el texto del jugador se muestra encima de la imagen de fondo */
        }


        .escalera,
        .escalera-fin {
            background-color: lightgreen;
        }

        .escalera-fin {
            background-color: darkgreen;
        }

        .serpiente,
        .serpiente-fin {
            background-color: salmon;
        }

        .serpiente-fin {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <h1>Tablero de Escaleras y Serpientes</h1>
    <p>Jugador: <?php echo htmlspecialchars($_SESSION['player_name']); ?></p>
    <p>Posición actual: <?php echo $_SESSION['player_position']; ?></p>
    <p>Último lanzamiento: <?php echo $_SESSION['last_dice_roll'] ?? 'Aún no has lanzado'; ?></p>
    <?php if (!empty($message)) : ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>
    <form method="post">
        <button name="move">Lanzar Dado</button>
        <button name="reset">Reiniciar Juego</button>
    </form>

    <div class="board">
        <?php
        for ($row = 9; $row >= 0; $row--) {
            if ($row % 2 == 1) {
                // Filas impares
                for ($col = 10; $col >= 1; $col--) {
                    $cellNumber = ($row * 10) + $col;
                    $cellStyle = '';
                    if ($cellNumber == $_SESSION['player_position']) {
                        $cellStyle = 'player';
                    }
                    foreach ($escaleras as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'escalera';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'escalera-fin';
                        }
                    }
                    foreach ($serpientes as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'serpiente';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'serpiente-fin';
                        }
                    }
                    echo "<div class='cell $cellStyle'>$cellNumber</div>";
                }
            } else {
                // Filas pares
                for ($col = 1; $col <= 10; $col++) {
                    $cellNumber = ($row * 10) + $col;
                    $cellStyle = '';
                    if ($cellNumber == $_SESSION['player_position']) {
                        $cellStyle = 'player';
                    }
                    foreach ($escaleras as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'escalera';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'escalera-fin';
                        }
                    }
                    foreach ($serpientes as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'serpiente';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'serpiente-fin';
                        }
                    }
                    echo "<div class='cell $cellStyle'>$cellNumber</div>";
                }
            }
        }
        ?>
    </div>
</body>

</html>