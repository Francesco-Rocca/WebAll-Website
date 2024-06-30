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

try {
    $sql = "UPDATE Customers SET email = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $_POST["email"]);

    $r = $stm->execute();

    if (!$r) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    $sql = "UPDATE Customers SET billing_address = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $_POST["billing_address"]);

    $r = $stm->execute();

    if (!$r) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    $sql = "UPDATE Customers SET phone = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $_POST["phone"]);

    $r = $stm->execute();

    if (!$r) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    if ($customer["c_type"] == 'I') {
        $sql = "UPDATE Individuals SET first_name = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $_POST["first_name"]);

        $r = $stm->execute();

        if (!$r) {
            header("location: ../area_personale/area_personale.php?error=true");
        }

        $sql = "UPDATE Individuals SET last_name = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $_POST["last_name"]);

        $r = $stm->execute();

        if (!$r) {
            header("location: ../area_personale/area_personale.php?error=true");
        }
    } else {
        $sql = "UPDATE Organizations SET name = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $_POST["name"]);

        $r = $stm->execute();

        if (!$r) {
            header("location: ../area_personale/area_personale.php?error=true");
        }

        $sql = "UPDATE Organizations SET hq_address = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("s", $_POST["hq_address"]);

        $r = $stm->execute();

        if (!$r) {
            header("location: ../area_personale/area_personale.php?error=true");
        }
    }
} catch (Exception $e) {
    header("location: ../area_personale/area_personale.php?error=true");
}

header("location: ../area_personale/area_personale.php?success=true");