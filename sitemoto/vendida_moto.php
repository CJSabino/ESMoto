<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include_once("conexao.php"); 

$moto_id = $_GET['id'] ?? null;

if (!$moto_id || !is_numeric($moto_id)) {
    $_SESSION['mensagem'] = "Erro: ID da moto inválido.";
    header("Location: admin_painel.php");
    exit;
}

try {

    $stmt_moto = $conn->prepare("SELECT id, marca, modelo, preco, custo_compra FROM motos WHERE id = :id");
    $stmt_moto->bindParam(':id', $moto_id, PDO::PARAM_INT);
    $stmt_moto->execute();
    $moto = $stmt_moto->fetch(PDO::FETCH_ASSOC);

    if (!$moto) {
        $_SESSION['mensagem'] = "Erro: Moto não encontrada no estoque.";
        header("Location: admin_painel.php");
        exit;
    }
    
    $_SESSION['moto_venda'] = $moto;
    
    header("Location: formulario_venda.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao buscar moto para venda: " . $e->getMessage();
    header("Location: admin_painel.php");
    exit;
}
?>