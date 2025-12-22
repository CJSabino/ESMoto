<?php

date_default_timezone_set('America/Sao_Paulo');

$host = "HOST";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "SENHA";

try {

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {
    die("Erro na conexão com Supabase: " . $e->getMessage());
}
?>