<?php

  //DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Veritabanı ile bağlantı kurulamadı: " . $conn->connect_error);
}

?>