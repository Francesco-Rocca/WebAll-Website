<?php
session_start();

if (session_status() != PHP_SESSION_ACTIVE || !$_SESSION["email"]) {
    header("location: ../accedi.php");
    ob_end_clean();
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "weball";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT password_hash, c_type, id_customer FROM Customers WHERE email = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("s", $_SESSION["email"]);
$stm->execute();

$customer = $stm->get_result()->fetch_assoc();

if ($customer["password_hash"] !== $_SESSION["password"]) {
    header("location: ../index.html");
    exit();
}

function generaContenuto() {
    $id = $GLOBALS["customer"]["id_customer"];
    $conn = $GLOBALS["conn"];

    if ($GLOBALS["customer"]["c_type"] === 'O') {
        $sql = "SELECT * FROM InstitutionalCustomers WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("i", $id);
        $stm->execute();
        $stm->execute();

        $r = $stm->get_result()->fetch_assoc();
        echo "Ragione sociale: " . $r["name"];

        return;
    }

    $sql = "SELECT * FROM IndividualCustomers WHERE id_customer = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $id);
    $stm->execute();
    $stm->execute();

    $r = $stm->get_result()->fetch_assoc();
    echo "Nome: " . $r["first_name"] . " <br>";
    echo "Cognome: " . $r["last_name"];
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>area personale</title>
    <link rel="stylesheet" href="../style.css">
    <script src="http://52.47.171.54:8080/service/init.js"></script>
</head>
<>
    <nav class="navbar">
        <div class="container">
        <a href="#" class="logo"><img src="weball_logo.png" alt="Logo" /></a>
        <div class="nav-links">
          <a href="agg_dominio.php">Dominii</a>
          <a href="pagamenti.php">Pagamenti</a>
          <!-- <a href="../siamo.html">Chi siamo</a>
          <a href="../accedi.php">Accedi</a> -->
        </div>
        <button class="join-button" onclick="logout()">Logout</button>
      </div>
    </nav>

    <?php generaContenuto(); ?>

    <script>
        function logout() {
            window.location = "../backend/logout.php";
        }
    </script>
</body>
</html>