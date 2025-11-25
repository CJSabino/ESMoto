<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado.");
}

include("conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT imagem FROM motos WHERE id = ?");
        $stmt->execute([$id]);
        $moto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($moto && !empty($moto['imagem']) && file_exists($moto['imagem'])) {
            unlink($moto['imagem']);
        }

        $stmt_del = $conn->prepare("DELETE FROM motos WHERE id = ?");
        $stmt_del->execute([$id]);

        header("Location: admin_painel.php?msg=removido");

    } catch (PDOException $e) {
        echo "Erro ao remover: " . $e->getMessage();
    }
}
?>