<?php
if (isset($_POST['niveau'])) {
    $niveau = $_POST['niveau'];

    // Controleer of het geselecteerde niveau geldig is (1, 2 of 3)
    if ($niveau == 1 || $niveau == 2 || $niveau == 3) {
        // Toon de progress boxes en woorden
        echo '<div id="progressContainer">';
        for ($i = 0; $i < 10; $i++) {
            echo '<div class="progress-box" id="box_' . $i . '"></div>';
        }
        echo '</div>';
        echo '<div class="bulkMain2">';
        echo '<div id="wordContainer">';
        echo $nederlandseOptie . ' = <input type="text" id="fname" name="fname"><br><br><br>';
        echo '</div>';
        // Voeg hier je formulier voor het beantwoorden van vragen toe
        echo '<form id="answerForm" method="POST">';
        echo '<input type="submit" value="Submit Answer">';
        echo '</form>';
        echo '</div>';
    } else {
        echo 'Ongeldig niveau geselecteerd.';
    }
} else {
    echo 'Niveau is niet geselecteerd.';
}
?>
