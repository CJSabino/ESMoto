<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    die("Acesso negado. Faça o login.");
}

include("conexao.php"); 

$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$cilindrada = $_POST['cilindrada'];
$ano = $_POST['ano'];
$km = $_POST['km'];
$preco = $_POST['preco'];
$custo_compra = $_POST['custo_compra'];
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);

if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
    $caminho_imagem_db = $target_file;

    try {
        $sql = "INSERT INTO motos (marca, modelo, cilindrada, ano, km, preco, custo_compra, imagem) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $marca, 
            $modelo, 
            $cilindrada, 
            $ano, 
            $km, 
            $preco, 
            $custo_compra,
            $caminho_imagem_db
        ]);


       header("Location: admin_painel.php?msg=cadastrado");
        exit;

    } catch (PDOException $e) {
        echo "Erro ao salvar no Supabase: " . $e->getMessage();
    }

} else {
    echo "Desculpe, houve um erro ao fazer o upload da imagem para a pasta.";
}
?>
