<?php
$servername = "localhost";
$username = "root";  
$password = "";    
$dbname = "motos_es";

//Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

//Verifica
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
