 <?php
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "weball";

print_r($_POST);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "<br>";
print_r($conn->query("SELECT * FROM Customers")->fetch_assoc());

$sql = "INSERT INTO Customers (c_type, email, password_hash, billing_address, registration_date, phone) VALUES ('I', ?, ?, ?, CURDATE(), ?)";
$stm = $conn->prepare($sql);

$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$numtel = $_POST["num-tel"];
$email = $_POST["email"];
$password = $_POST["password"];
$password_conf = $_POST["password-conf"];
$indirizzo = $_POST["indirizzo"];


$stm->bind_param("ssss", $email, $password, $indirizzo, $numtel);
$s = $stm->execute();
if (!$s) {
    die($stm->error);
}

$sql = "INSERT INTO Individuals (id_customer, first_name, last_name) VALUES (LAST_INSERT_ID(), ?, ?)";
$stm = $conn->prepare($sql);

$stm->bind_param("ss", $nome, $cognome);
$s = $stm->execute();
if (!$s) {
    die($stm->error);
}
$conn->close();
?> 