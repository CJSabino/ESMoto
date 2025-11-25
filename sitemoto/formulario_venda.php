<?php
session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['moto_venda'])) {
    header("Location: admin_painel.php");
    exit;
}

include_once("conexao.php");
$moto = $_SESSION['moto_venda'];
$preco_sugerido = number_format($moto['preco'], 2, '.', ''); 
$erro = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moto_id = $moto['id'];
    $marca = $moto['marca'];
    $modelo = $moto['modelo'];
    $preco_venda = filter_input(INPUT_POST, 'preco_venda', FILTER_VALIDATE_FLOAT);
    $custo_compra = $moto['custo_compra'];
    $comprador = filter_input(INPUT_POST, 'comprador', FILTER_SANITIZE_STRING);
    $cpf_comprador = filter_input(INPUT_POST, 'cpf_comprador', FILTER_SANITIZE_STRING);
    $vendedor = filter_input(INPUT_POST, 'vendedor', FILTER_SANITIZE_STRING);
    
    if ($preco_venda === false || $custo_compra === false || $preco_venda <= 0) {
        $erro = "Preço de Venda ou Custo de Compra são inválidos.";
    } else {
        
        $data_venda = date('Y-m-d H:i:s');
        
        $conn->beginTransaction();

        try {
            $sql_insert = "INSERT INTO vendas (moto_id, marca, modelo, preco_venda, custo_compra, comprador, cpf_comprador, vendedor, data_venda) 
                           VALUES (:moto_id, :marca, :modelo, :preco_venda, :custo_compra, :comprador, :cpf_comprador, :vendedor, :data_venda)";
            $stmt_insert = $conn->prepare($sql_insert);

            $stmt_insert->bindParam(':moto_id', $moto_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(':marca', $marca);
            $stmt_insert->bindParam(':modelo', $modelo);
            $stmt_insert->bindParam(':preco_venda', $preco_venda);
            $stmt_insert->bindParam(':custo_compra', $custo_compra);
            $stmt_insert->bindParam(':comprador', $comprador);
            $stmt_insert->bindParam(':cpf_comprador', $cpf_comprador);
            $stmt_insert->bindParam(':vendedor', $vendedor);
            $stmt_insert->bindParam(':data_venda', $data_venda);
            $stmt_insert->execute();
            $sql_delete = "DELETE FROM motos WHERE id = :moto_id";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':moto_id', $moto_id, PDO::PARAM_INT);
            $stmt_delete->execute();
            $conn->commit();
            unset($_SESSION['moto_venda']);
            $_SESSION['mensagem'] = "Venda da $marca $modelo registrada com sucesso!";
            header("Location: admin_painel.php");
            exit;

        } catch (PDOException $e) {
            $conn->rollBack();
            $erro = "Erro ao registrar a venda: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venda</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php include 'includes/header_admin.php';?>
    <div class="admin-container">
        <h2>Venda de 🏍️ <?php echo htmlspecialchars($moto['marca'] . " " . $moto['modelo']); ?></h2>
        <p>Preencha os dados da venda para remover do estoque e registrar no relatório.</p>
        
        <?php if ($erro): ?>
            <p style='color:red; background: #ffe6e6; padding: 10px; border-radius: 5px;'><?php echo $erro; ?></p>
        <?php endif; ?>

        <form action="formulario_venda.php" method="POST">
            <div class="grid">
                <div>
                    <label for="preco_venda">Preço de Venda (R$):</label>
                    <input class="input" type="text" id="preco_venda" name="preco_venda" value="<?php echo $preco_sugerido; ?>" required>
                </div>
                <div>
                    <label for="comprador">Comprador:</label>
                    <input class="input" type="text" id="comprador" name="comprador" required>
                </div>
                <div>
                    <label for="cpf_comprador">CPF do Comprador:</label>
                    <input class="input" type="text" id="cpf_comprador" name="cpf_comprador" required>
                </div>
                <div>
                    <label for="vendedor">Vendedor:</label>
                    <input class="input" type="text" id="vendedor" name="vendedor" value="<?php echo $_SESSION['admin_nome'] ?? 'Admin'; ?>" required>
                </div>
            </div>
            <button type="submit" class="btn-adicionar">Confirmar Venda e Remover do Estoque</button>
        </form>
    </div>
</body>
</html>