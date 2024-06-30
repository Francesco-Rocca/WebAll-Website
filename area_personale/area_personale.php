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
    header("location: ../index.html");
    exit();
}

function generaValori() {
    $id = $GLOBALS["customer"]["id_customer"];
    $conn = $GLOBALS["conn"];

    if ($GLOBALS["customer"]["c_type"] === 'O') {
        $sql = "SELECT * FROM InstitutionalCustomers WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("i", $id);
        $stm->execute();
        $stm->execute();

        $r = $stm->get_result()->fetch_assoc();
        generaAzienda($r);

        return;
    }

    $sql = "SELECT * FROM IndividualCustomers WHERE id_customer = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $id);
    $stm->execute();
    $stm->execute();

    $r = $stm->get_result()->fetch_assoc();
    generaUtente($r);
}
?>

<html>
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
          <a href="area_personale.php">Dashboard</a>
          <!-- <a href="../siamo.html">Chi siamo</a>
          <a href="../accedi.php">Accedi</a> -->
        </div>
        <button class="join-button" onclick="logout()">Logout</button>
      </div>
    </nav>


    <form action="../backend/agg_info.php" method="POST">
        <?php generaValori(); ?>

        <?php function generaAzienda($r) { ?>
            <table class="alternate">
                <tr>
                    <td>Ragione sociale</td>
                    <td> <input type="text" class="textcontainer" name="name" value=<?php echo "\"" . $r["name"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Indirizzo E-Mail</td>
                    <td> <input type="text" class="textcontainer" name="email" value=<?php echo "\"" . $r["email"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Indirizzo di fatturazione</td>
                    <td> <input type="text" class="textcontainer" name="billing_address" value=<?php echo "\"" . $r["billing_address"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Sede legale</td>
                    <td> <input type="text" class="textcontainer" name="hq_address" value=<?php echo "\"" . $r["billing_address"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Numero di telefono</td>
                    <td> <input type="tel" pattern="[0-9]{3} [0-9]{3} [0-9]{4}"class="textcontainer" name="phone" value=<?php echo "\"" . $r["phone"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Data di registrazione</td>
                    <td> <?php echo $r["registration_date"]; ?> </td>
                </tr>
                <tr>
                    <td>Codice utente</td>
                    <td> <?php echo $r["id_customer"]; ?> </td>
                </tr>
            </table>
        <?php } ?>

        <?php function generaUtente($r) { ?>
            <table class="alternate">
                <tr>
                    <td>Nome</td>
                    <td> <input type="text" class="textcontainer" name="first_name" value=<?php echo "\"" . $r["first_name"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Cognome</td>
                    <td> <input type="text" class="textcontainer" name="last_name" value=<?php echo "\"" . $r["last_name"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Indirizzo E-Mail</td>
                    <td> <input type="text" class="textcontainer" name="email" value=<?php echo "\"" . $r["email"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Indirizzo di fatturazione</td>
                    <td> <input type="text" class="textcontainer" name="billing_address" value=<?php echo "\"" . $r["billing_address"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Numero di telefono</td>
                    <td> <input type="tel" pattern="[0-9]{3} [0-9]{3} [0-9]{4}"class="textcontainer" name="phone" value=<?php echo "\"" . $r["phone"] . "\""; ?>> </td>
                </tr>
                <tr>
                    <td>Data di registrazione</td>
                    <td> <?php echo $r["registration_date"]; ?> </td>
                </tr>
                <tr>
                    <td>Codice utente</td>
                    <td> <?php echo $r["id_customer"]; ?> </td>
                </tr>
            </table>
        <?php } ?>

        <br>
        <input type="submit" class="join-button2" value="Aggiorna">
        <input type="button" href="agg_password.php" class="join-button2" value="Cambia password">
    </form>

    <script>
        function logout() {
            window.location = "../backend/logout.php";
        }
    </script>
</body>
</html>