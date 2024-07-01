<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebAll</title>
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
          <a href="siamo.php"disabled>Chi siamo</a>
          <a href="accedi.php">Accedi</a>
        </div>
        <button class="join-button" onclick="openPage()">Utilizza anche tu WebAll</button>
      </div>
    </nav>

    <div class="content">
        <h1>Chi Siamo</h1>
        <p>Benvenuto nella sezione chi siamo</p>
    </div>
    <script>
      function openPage() {
            window.location.href = 'registrazione.php';
        }
    </script>
</body>
</html>