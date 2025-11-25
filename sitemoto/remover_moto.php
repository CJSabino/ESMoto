<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado. Faça o login.");
}
include("conexao.php");
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_painel.php?status=erro_id");
    exit;
}

$id_moto = $_GET['id'];

//APAGA O ARQUIVO DA IMAGEM DO SERVIDOR
//Para não deixar arquivos ocupando espaço

$stmt_img = $conn->prepare("SELECT imagem FROM motos WHERE id = ?");
$stmt_img->bind_param("i", $id_moto);
$stmt_img->execute();
$result_img = $stmt_img->get_result();

if ($result_img->num_rows === 1) {
    $moto = $result_img->fetch_assoc();
    $caminho_imagem = $moto['imagem'];
    if (!empty($caminho_imagem) && file_exists($caminho_imagem)) {
        // Apaga o arquivo do servidor
        unlink($caminho_imagem);
    }
}
$stmt_img->close();
//APAGA O REGISTRO DA MOTO NO BANCO DE DADOS
$stmt_delete = $conn->prepare("DELETE FROM motos WHERE id = ?");
$stmt_delete->bind_param("i", $id_moto); //i = inteiro

if ($stmt_delete->execute()) {
    //Volta para o painel de admin
    $stmt_delete->close();
    $conn->close();
    header("Location: admin_painel.php?status=removido_sucesso");
    exit;
} else {
    //Caso Erro
    $stmt_delete->close();
    $conn->close();
    header("Location: admin_painel.php?status=erro_remover");
    exit;
}
?>