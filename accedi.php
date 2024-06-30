<?php
session_start();

if (session_status() == PHP_SESSION_ACTIVE && $_SESSION["email"]) {
    header("location: backend/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentazione</title>
    <link rel="stylesheet" href="style.css">
    <script src="http://52.47.171.54:8080/service/init.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
        <a href="#" class="logo"><img src="weball_logo.png" alt="Logo" /></a>
        <div class="nav-links">
          <a href="index.php">Home</a>
          <a href="documentazione.php">Documentazione</a>
          <a href="siamo.php">Chi siamo</a>
          <a href="accedi.php"disabled>Accedi</a>
        </div>
        <button class="join-button" onclick="openPage()">Utilizza anche tu WebAll</button>
      </div>
    </nav>
    
    <div class="login-container">
        <h1 class="login-title">WebAll Login</h1>
        <form action="/backend/login.php" method="post">
            <input type="email" class="textcontainer" name="email" placeholder="Email utente" required><br><br>
            <input type="password"  class="textcontainer" name="password" placeholder="Password" required><br><br>
            <button id="submitButton" type="submit">Accedi</button>
        </form>
    </div>
    <div class="immagelogo">
        <img src="logo_bianco.png" alt="Logo" />
    </div>
    <script> //funzione per aprire nuova pagina per la registrazione di un'utente
        function openPage() {
            window.location.href = 'registrazione.php';
        }
    </script>
</body>
</html>