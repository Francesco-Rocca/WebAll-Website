<?php
ob_start();
unset($_SESSION["email"]);
unset($_SESSION["password"]);
header("location: ../index.html");
ob_end_clean();