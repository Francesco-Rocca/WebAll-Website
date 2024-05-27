 <?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "weball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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
$stm->execute();

$sql = "INSERT INTO Individuals (id_customer, first_name, last_name) VALUES (LAST_INSERT_ID(), ?, ?)";
$stm = $conn->prepare($sql);

$stm->bind_param("ss", $nome, $cognome);
$stm->execute();

$conn->close();
?> 