<?php
ob_start();
session_start();
unset($_SESSION["email"]);
unset($_SESSION["password"]);
session_unset();
header("location: ../index.html");
ob_end_clean();