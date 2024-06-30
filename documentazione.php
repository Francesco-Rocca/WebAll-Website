<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrazione</title>
    <link rel="stylesheet" href="style.css">
    <script src="http://52.47.171.54:8080/service/init.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
        <a href="#" class="logo"><img src="weball_logo.png" alt="Logo" /></a>
        <div class="nav-links">
          <a href="index.php">Home</a>
          <a href="documentazione.php" disabled>Documentazione</a>
          <a href="siamo.php">Chi siamo</a>
          <a href="accedi.php">Accedi</a>
        </div>
        <button class="join-button"onclick="openPage()">Utilizza anche tu WebAll</button>
      </div>
    </nav>
    
    <div class="registration-container">
        <h1 class="registration-title">Benvenuto nella documentazione</h1>
        <p>Se sei interessato al nostro progetto scaricalo dal pulsante qui sotto!<br><br>Oppure visualizza il nostro github</p>
        <button class="join-button2" onclick="openLink2()">Download</button>
        <button class="join-button2" onclick="openLink3()">Link github</button>       
    </div>
    <div>
        <img src="github-mark-white.png" alt="github"">
    </div>
    <script> //funzione per aprire nuova pagina per la registrazione di un'utente
        function openPage() {
            window.location.href = 'registrazione.php';
        }

        function openLink2() {
            window.location.href = 'registrazione/utenti.php';
        }
        function openLink3() {
            window.location.href = 'https://github.com/WebAll-Accessibility';
        }
    </script>
</body>
</html>