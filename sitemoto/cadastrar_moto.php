<?php
// 1. Segurança
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado. Faça o login.");
}

// IMPORTANTE: Este arquivo deve conter a conexão PDO com o Supabase
include("conexao.php"); 

// 2. Receber dados
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$cilindrada = $_POST['cilindrada']; // Garante que a coluna existe no Supabase!
$ano = $_POST['ano'];
$km = $_POST['km'];
$preco = $_POST['preco'];

// 3. Upload da Imagem (Isso continua salvando na pasta do seu site)
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);

if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
    $caminho_imagem_db = $target_file;

    try {
        // 4. SQL (O comando é igual, mas a execução muda)
        $sql = "INSERT INTO motos (marca, modelo, cilindrada, ano, km, preco, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        // 5. EXECUÇÃO PDO (O jeito simples!)
        // O PDO descobre automaticamente se é texto ou número.
        // Basta passar as variáveis na ordem correta dentro dos colchetes [].
        $stmt->execute([
            $marca, 
            $modelo, 
            $cilindrada, 
            $ano, 
            $km, 
            $preco, 
            $caminho_imagem_db
        ]);

        // Sucesso!
        header("Location: admin_painel.php?sucesso=1");

    } catch (PDOException $e) {
        // Erro do Supabase/Postgres
        echo "Erro ao salvar no Supabase: " . $e->getMessage();
    }

} else {
    echo "Desculpe, houve um erro ao fazer o upload da imagem para a pasta.";
}

// No PDO não é obrigatório fechar a conexão manualmente, o PHP faz isso.
?>