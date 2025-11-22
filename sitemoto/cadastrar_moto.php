<?php
// 1. Segurança: Verificar se o admin está logado
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado. Faça o login."); // Encerra o script se não for admin
}

include("conexao.php");

// 2. Receber dados do formulário (via $_POST)
$marca = $_POST['marca'];
$combustivel = $_POST['combustivel'];
$modelo = $_POST['modelo'];
$cilindrada = $_POST['cilindrada'];
$ano = $_POST['ano'];
$km = $_POST['km'];
$preco = $_POST['preco'];

// 3. Lidar com o Upload da Imagem (via $_FILES)
$target_dir = "uploads/"; // A pasta que você criou
$target_file = $target_dir . basename($_FILES["imagem"]["name"]); // Caminho final: "uploads/nome-da-imagem.jpg"
$uploadOk = 1;

// Tentar mover o arquivo enviado (da pasta temporária do XAMPP para sua pasta 'uploads')
if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
    // Se o upload deu certo, $target_file é o caminho que salvamos no banco
    $caminho_imagem_db = $target_file;
    
    // 4. Preparar e Executar o SQL (INSERT)
    $stmt = $conn->prepare("INSERT INTO motos (marca, modelo, cilindrada, ano, km, preco, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiids", $marca, $modelo, $cilindrada, $ano, $km, $preco, $caminho_imagem_db);

    if ($stmt->execute()) {
        // Sucesso! Redireciona de volta para o painel
        header("Location: admin_painel.php?sucesso=1");
    } else {
        // Erro no SQL
        echo "Erro ao salvar no banco de dados: " . $stmt->error;
    }
    
    $stmt->close();
    
} else {
    // Erro no Upload
    echo "Desculpe, houve um erro ao fazer o upload da sua imagem.";
}

$conn->close();
?>