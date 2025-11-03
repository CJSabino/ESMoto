<?php
$servername = "localhost";
$username = "root";  // padrão do XAMPP
$password = "";      // padrão do XAMPP (sem senha)
$dbname = "renatinho_motos"; // o nome do seu banco

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
