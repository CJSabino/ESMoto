<?php
// 1. Iniciar a Sessão
session_start();

// Inclui a conexão PDO com Supabase
include("conexao.php");

// 2. Receber dados do formulário
$usuario_form = $_POST['usuario'];
$senha_form = $_POST['senha'];

try {
    // 3. Buscar o usuário no banco (Sintaxe PDO)
    // Não usamos bind_param, passamos direto no execute
    $sql = "SELECT * FROM usuarios_admin WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario_form]);

    // Pega o resultado (apenas 1 linha)
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se $admin não for falso (ou seja, encontrou alguém)
    if ($admin) {

        // 4. Verificar a senha (Igual ao anterior)
        if (password_verify($senha_form, $admin['senha'])) {

            // 5. Sucesso!
            $_SESSION['admin_id'] = $admin['id'];

            header("Location: admin_painel.php");
            exit;
        }
    }

    // 6. Falha (Usuário não achado OU senha errada)
    header("Location: login.php?erro=1");
    exit;

} catch (PDOException $e) {
    die("Erro no login: " . $e->getMessage());
}
?>