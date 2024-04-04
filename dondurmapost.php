<?php
require_once("includes/config.php");
require_once("getproductforms.php");
require_once("orderfuncs.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
  header("Location: login.php");
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  dondurmaSend();
  header("Refresh:3; order.php");
  exit();
} else {
  echo "Sipariş bilgileri alınamadı";
  header("Refresh:3; order.php");
  exit();
}


?>