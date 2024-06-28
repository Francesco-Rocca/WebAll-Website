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

if ($customer["password_hash"] !== $_SESSION["password"]) {
    header("location: ../index.html");
    exit();
}

$sql = "SELECT a.*, b.name FROM Subscriptions a INNER JOIN Plans b ON a.id_plan = b.id_plan WHERE a.id_customer = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $customer["id_customer"]);
$stm->execute();

$r = $stm->get_result();
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
        .center {
            margin: auto;
            width: 40vw;
            margin-top: 64px;
        }

        th, td {
            min-width: 8vw;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
        <a href="#" class="logo"><img src="../weball_logo.png" alt="Logo" /></a>
        <div class="nav-links">
          <a href="lista_dominii.php">Dominii</a>
          <a href="lista_pagamenti.php">Pagamenti</a>
          <!-- <a href="../siamo.html">Chi siamo</a>
          <a href="../accedi.php">Accedi</a> -->
        </div>
        <button class="join-button" onclick="logout()">Logout</button>
      </div>
    </nav>

    <div class="center">
        <table>
            <tr>
                <th>Dominio</th>
                <th>Piano</th>
                <th>Data di attivazione</th>
                <th>Modifica</th>
                <th>Elimina</t>
        </tr>

            <?php while ($row = $r->fetch_assoc()) { ?>
                <tr>
                    <td> <?php echo $row["domain"]; ?> </td>
                    <td> <?php echo $row["name"] ?> </td>
                    <td> <?php echo $row["activation_date"]; ?> </td>
                    <td><a href="../backend/updt_dominio.php?id=<?php echo $row["id_subscription"]; ?>">Modifica</a></td>
                    <td><a href="../backend/agg_dominio.php?id=<?php echo $row["id_subscription"]; ?>">Elimina</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>