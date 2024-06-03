<?php
ob_start();
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

$sql = "INSERT INTO Customers (c_type, email, password_hash, billing_address, registration_date, phone) VALUES ('I', ?, ?, ?, CURDATE(), ?)";
$stm = $conn->prepare($sql);

if (!isset($_POST["nome"])
      || !isset($_POST["cognome"])
      || !isset($_POST["num-tel"])
      || !isset($_POST["email"])
      || !isset($_POST["password"])
      || !isset($_POST["password-conf"])
      || !isset($_POST["indirizzo"])) {

    header("location: ../registrazione/utenti.html");
}

$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$numtel = $_POST["num-tel"];
$email = $_POST["email"];
$password = $_POST["password"];
$password_conf = $_POST["password-conf"];
$indirizzo = $_POST["indirizzo"];


$stm->bind_param("ssss", $email, $password, $indirizzo, $numtel);
$s = $stm->execute();

$sql = "INSERT INTO Individuals (id_customer, first_name, last_name) VALUES (LAST_INSERT_ID(), ?, ?)";
$stm = $conn->prepare($sql);

$stm->bind_param("ss", $nome, $cognome);
$s = $stm->execute();

session_start();
$_SESSION["mail"] = $mail;
$_SESSION["password"] = $password;

session_start();
$_SESSION["mail"] = $mail;
$_SESSION["password"] = $password;

header("location: ../area_personale/area_personale.php");
ob_get_clean();