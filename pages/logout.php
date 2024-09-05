<?php
session_start();
if(!isset($_SESSION["ID"])&& $_SESSION["STATUS"]!="ACTIEF") {
    echo "<script>
    alert('U heeft geen toegang tot deze pagina.');
    location.href='../index.php';
    </script>";
}
unset($_SESSION["ID"]);
unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_NAAM"]);
unset($_SESSION["E-MAIL"]);
unset($_SESSION["STATUS"]);
unset($_SESSION["ROL"]);
// Session beëindigen
session_destroy();
// Databaseverbinding sluiten
$verbinding = null;
header("location: ../index.php");
?>