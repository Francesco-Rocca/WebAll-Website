<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebAll</title>
    <link rel="stylesheet" href="../style.css">
    <script src="http://52.47.171.54:8080/service/init.js"></script>

    <style>
        .error {
            width: 500px;
            margin-bottom: 24px;
            margin-left: 0px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo"><img src="../weball_logo.png" alt="Logo" /></a>
            <div class="nav-links">
                <a href="../index.php">Home</a>
                <a href="../documentazione.php">Documentazione</a>
                <a href="../siamo.php">Chi siamo</a>
                <a href="../accedi.php">Accedi</a>
            </div>
            <button class="join-button"disabled>Utilizza anche tu WebAll</button>
        </div>
    </nav>
    
    <div class="login-container3">
        <h1 class="login-title3">Registrazione Azienda</h1>
        <form action="../backend/reg_aziende.php" method="POST">
            <?php if (isset($_GET["error"])) { ?>
                <div class="error">
                    <p>Ops... Si è verificato un errore, controlla i dati</p>
                </div>
            <?php } ?>

            <input type="email" class="textcontainer" name="email" placeholder="Email utente" required><br><br>
            <input type="password"  class="textcontainer" name="password" placeholder="Password" required><br><br>
            <input type="password"  class="textcontainer" name="password-conf" placeholder="Conferma password" required><br><br>
            <input type="tel" pattern="+[0-9]{1,3} [0-9]{3} [0-9]{3} [0-9]{4}" class="textcontainer" name="num-tel" placeholder="Numero felefono" required><br><br>
            <input type="text"  class="textcontainer" name="indirizzo" placeholder="Indirizzo fatturazione" required><br><br>
            <input type="text"  class="textcontainer" name="ragionesoc" placeholder="Ragione sociale" required><br><br>
            <input type="text"  class="textcontainer" name="indirizzo-sede" placeholder="Indirizzo sede" required><br><br>
            <button id="submitButton" type="submit">Registrati</button>
        </form>
    </div>
    <div class="immagelogo2">
        <img src="../logo_bianco.png" alt="Logo" />
    </div>
    
</body>
</html>