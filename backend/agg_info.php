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

try {
    $sql = "UPDATE Customers SET email = ? WHERE id_customer = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("si", $_POST["email"], $customer["id_customer"]);

    $r = $stm->execute();
    $_SESSION["email"] = $_POST["email"];

    if (!$r || sizeof($stm->error_list) != 0) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    $sql = "UPDATE Customers SET billing_address = ? WHERE id_customer = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("si", $_POST["billing_address"], $customer["id_customer"]);

    $r = $stm->execute();

    if (!$r || sizeof($stm->error_list) != 0) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    $sql = "UPDATE Customers SET phone = ? WHERE id_customer = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("si", $_POST["phone"], $customer["id_customer"]);

    $r = $stm->execute();

    if (!$r || sizeof($stm->error_list) != 0) {
        header("location: ../area_personale/area_personale.php?error=true");
    }

    if ($customer["c_type"] === "I") {
        $sql = "UPDATE Individuals SET first_name = ? WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $_POST["first_name"], $customer["id_customer"]);

        $r = $stm->execute();

        if (!$r || sizeof($stm->error_list) != 0) {
            header("location: ../area_personale/area_personale.php?error=true");
        }

        $sql = "UPDATE Individuals SET last_name = ? WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $_POST["last_name"], $customer["id_customer"]);

        $r = $stm->execute();

        if (!$r || sizeof($stm->error_list) != 0) {
            header("location: ../area_personale/area_personale.php?error=true");
        }
    } else {
        $sql = "UPDATE Organizations SET name = ? WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $_POST["name"], $customer["id_customer"]);

        $r = $stm->execute();

        if (!$r || sizeof($stm->error_list) != 0) {
            header("location: ../area_personale/area_personale.php?error=true");
        }

        $sql = "UPDATE Organizations SET hq_address = ? WHERE id_customer = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param("si", $_POST["hq_address"], $customer["id_customer"]);

        $r = $stm->execute();

        if (!$r || sizeof($stm->error_list) != 0) {
            header("location: ../area_personale/area_personale.php?error=true");
        }
    }
} catch (Exception $e) {
    header("location: ../area_personale/area_personale.php?error=true");
    exit();
}

header("location: ../area_personale/area_personale.php?success=true");