<?php
session_start();

if (session_status() != PHP_SESSION_ACTIVE || !$_SESSION["email"]) {
    header("location: ../accedi.php");
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

if ($customer["password_hash"] !== hash("sha256", $_SESSION["password"])) {
    header("location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebAll</title>
    <link rel="stylesheet" href="../style.css">
    <script src="http://52.47.171.54:8080/service/init.js"></script>
    <style>
        form {
            margin: auto;
            width: max-content;
            margin-top: 64px;
        }

        th, td {
            min-width: 20vw;
        }

        table.alternate tr:nth-child(odd) {
            background-color: #150039;
        }
        
        table.alternate tr:nth-child(even) {
            background-color: #240046;
        }
    </style>

</head>
<body>
    <nav class="navbar">
        <div class="container">
        <a href="#" class="logo"><img src="../weball_logo.png" alt="Logo" /></a>
        <div class="nav-links">
          <a href="lista_dominii.php">Dominii</a>
          <a href="area_personale.php">Dashboard</a>
          <!-- <a href="../siamo.php">Chi siamo</a>
          <a href="../accedi.php">Accedi</a> -->
        </div>
        <button class="join-button" onclick="logout()">Logout</button>
      </div>
    </nav>

    <form action="../backend/agg_password.php" method="POST">
        <table class="alternate">
            <tr>
                <td>Vecchia password</td>
                <td> <input type="password" class="textcontainer" name="old" required> </td>
            </tr>

            <tr>
                <td>Nuova passowrd</td>
                <td> <input type="password" class="textcontainer" name="new" required> </td>
            </tr>

            <tr>
                <td>Conferma nuova password</td>
                <td><input type="password" class="textcontainer" name="conf" required></td>
            </tr>
        </table>

        <?php if (isset($_GET["error"])) { ?>
            <div class="error">
                <p>I dati inseriti non sono validi</p>
            </div>
        <?php } ?>

        <input type="submit" class="join-button2" value="Cambia">
    </form>
</body>
</html>