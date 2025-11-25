<?php
session_start();

include("conexao.php");

$usuario_form = $_POST['usuario'];
$senha_form = $_POST['senha'];

try {
    $sql = "SELECT * FROM usuarios_admin WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario_form]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {

        if (password_verify($senha_form, $admin['senha'])) {

            $_SESSION['admin_id'] = $admin['id'];

            header("Location: admin_painel.php");
            exit;
        }
    }

    header("Location: login.php?erro=1");
    exit;

} catch (PDOException $e) {
    die("Erro no login: " . $e->getMessage());
}
?>