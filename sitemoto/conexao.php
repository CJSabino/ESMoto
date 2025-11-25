<?php
// Credenciais do Supabase
$host = "db.rfaeweinsjkcxjpnbyig.supabase.co"; // Pegue no painel do Supabase
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "CRJ2025";

try {
    // String de conexão (DSN)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    
    // Criando a conexão PDO
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mostra erros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Traz arrays associativos
    ]);

} catch (PDOException $e) {
    die("Erro na conexão com Supabase: " . $e->getMessage());
}
?>