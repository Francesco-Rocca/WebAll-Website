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

$sql = "SELECT a.*, b.name, b.max_hits, b.max_yearly_hits FROM Subscriptions a INNER JOIN Plans b ON a.id_plan = b.id_plan WHERE a.id_customer = ?";
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

    <script>
        function deldom(d) {
            const result = confirm("Want to delete?");
            if (result) {
                window.location = '../backend/del_dominio.php?id=' + d;
            }
        }
    </script>
    
    <style>
        .center {
            margin: auto;
            width: max-content;
            margin-top: 64px;
        }

        table {
            min-width: 70vw;
            width: 70vw;
        }

        th, td {
            min-width: 10vw;
        }

        table.alternate tr:nth-child(even) {
            background-color: #150039;
        }
        
        table.alternate tr:nth-child(odd) {
            background-color: #240046;
        }

        .button-3 {
            filter: brightness(140%);
            width: 100px;
            max-width: 9.5vw;
            appearance: none;
            background-color: #2ea44f;
            border: 1px solid rgba(27, 31, 35, .15);
            border-radius: 6px;
            box-shadow: rgba(27, 31, 35, .1) 0 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system,system-ui,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            padding: 6px 16px;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
        }

        .button-3:focus:not(:focus-visible):not(.focus-visible) {
            box-shadow: none;
            outline: none;
        }

        .button-3:hover {
            background-color: #2c974b;
        }

        .button-3:focus {
            box-shadow: rgba(46, 164, 79, .4) 0 0 0 3px;
            outline: none;
        }

        .button-3:disabled {
            background-color: #94d3a2;
            border-color: rgba(27, 31, 35, .1);
            color: rgba(255, 255, 255, .8);
            cursor: default;
        }

        .button-3:active {
            background-color: #298e46;
            box-shadow: rgba(20, 70, 32, .2) 0 1px 0 inset;
        }

        .delete {
            filter: brightness(110%);
            width: 100px;
            max-width: 9.5vw;
            appearance: none;
            background-color: #EE4B2B;
            border: 1px solid rgba(27, 31, 35, .15);
            border-radius: 6px;
            box-shadow: rgba(27, 31, 35, .1) 0 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system,system-ui,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            padding: 6px 16px;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
        }

        .delete:focus:not(:focus-visible):not(.focus-visible) {
            box-shadow: none;
            outline: none;
        }

        .delete:hover {
            background-color: #f0582f;
        }

        .delete:focus {
            box-shadow: rgba(46, 164, 79, .4) 0 0 0 3px;
            outline: none;
        }
    </style>

    <script>
        function aggdom() {
            window.location = 'reg_dominio.php'
        }
    </script>
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

    <div class="center">
        <table class="alternate">
            <tr>
                <th>Dominio</th>
                <th>Piano</th>
                <th>Data di attivazione</th>
                <th>Hit</th>
                <th>Hit annuali</th>
                <th>Budget</th>
                <th>Azioni</th>
        </tr>

            <?php while ($row = $r->fetch_assoc()) { ?>
                <tr>
                    <td> <?php echo $row["domain"]; ?> </td>
                    <td> <?php echo $row["name"]; ?> </td>
                    <td> <?php echo $row["activation_date"]; ?> </td>
                    <td> <?php  echo $row["num_hits"]; ?> / <?php echo $row["max_hits"]; ?> </td>
                    <td> <?php echo $row["num_yearly_hits"]; ?> / <?php echo $row["max_yearly_hits"]; ?> </td>
                    <td> <?php echo number_format((float)$row["price_due"], 2, '.', ''); ?> € / <?php echo number_format((float)$row["price_ceiling"], 2, '.', ''); ?> € </td>
                    <td align="center">
                        <a class="button-3" href="reg_dominio.php?edit=<?php echo $row["id_subscription"]; ?>">Modifica</a>
                        <input type="button" class="delete" onclick="<?php echo "deldom(" . $row["id_subscription"] . ")"; ?>" value="Elimina">
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php if (isset($_GET["error"])) { ?>
            <div class="error">
                <p>Ops... Si è verificato un errore</p>
            </div>
        <?php } ?>

        <?php if (isset($_GET["success"])) { ?>
            <div class="success">
                <p>Fatto! Operazione completta con successo</p>
            </div>
        <?php } ?>

        <input type="button" href="reg_dominio.php" class="join-button2" value="Aggiungi dominio" onclick="aggdom()">
    </div>
</body>
</html>