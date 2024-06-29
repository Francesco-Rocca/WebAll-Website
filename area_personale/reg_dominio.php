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

$sql = "SELECT * FROM Plans";
$stm = $conn->prepare($sql);
$stm->execute();

$plans = $stm->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>area personale</title>
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
          <a href="lista_pagamenti.php">Pagamenti</a>
          <!-- <a href="../siamo.html">Chi siamo</a>
          <a href="../accedi.php">Accedi</a> -->
        </div>
        <button class="join-button" onclick="logout()">Logout</button>
      </div>
    </nav>

    <form action="../backend/reg_dominio.php" method="POST">
        <table class="alternate">
            <tr>
                <td>Nome di dominio</td>
                <td> <input type="text" class="textcontainer" name="domain"> </td>
            </tr>

            <tr>
                <td>Piano</td>
                <td>
                    <select name="plan">
                    <?php while ($row = $plans->fetch_assoc()) { ?>
                        <option value="<?php echo $row["id_plan"]; ?>">
                            <?php echo $row["name"]; ?> (max <?php echo $row["max_hits"]; ?> HIT/<?php echo $row["duration"]; ?>M, max <?php echo $row["max_yearly_hits"] ?> HIT/anno, <?php echo $row["price"]; ?> €/<?php echo $row["duration"]; ?>M, extra <?php echo $row["price_per_req"]; ?> €/HIT)
                        </option>
                    <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Tetto del costo (€ EUR)</td>
                <td><input type="number" class="textcontainer" name="domain"></td>
            </tr>
        </table>

        <br>
        <input type="submit" class="join-button2" value="Aggiungi">
    </form>
</body>
</html>