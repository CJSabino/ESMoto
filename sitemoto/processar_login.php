<?php
// 1. Iniciar a Sessão
// A "sessão" é como o PHP "lembra" que o usuário está logado
session_start();

include("conexao.php");

// 2. Receber dados do formulário
$usuario_form = $_POST['usuario'];
$senha_form = $_POST['senha'];

// 3. Buscar o usuário no banco
$stmt = $conn->prepare("SELECT * FROM usuarios_admin WHERE usuario = ?");
$stmt->bind_param("s", $usuario_form);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // 4. Achei o usuário. Agora, verificar a senha.
    $admin = $result->fetch_assoc();
    
    // password_verify() compara a senha digitada com o HASH salvo no banco
    if (password_verify($senha_form, $admin['senha'])) {
        
        // 5. Sucesso! Senha correta.
        // Salvar na sessão que o usuário está logado
        $_SESSION['admin_id'] = $admin['id'];
        
        // Redirecionar para o painel de admin
        header("Location: admin_painel.php");
        exit;
        
    }
}

// 6. Falha: Se chegou aqui, ou o usuário não existe ou a senha está errada.
// Redireciona de volta para a página de login com uma mensagem de erro (opcional).
header("Location: login.php?erro=1");
exit;
?>