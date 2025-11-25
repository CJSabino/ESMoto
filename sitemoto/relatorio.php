<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include_once("conexao.php"); 

$total_vendas = 0;
$valor_total_vendido = 0;
$lucro_total = 0;
$detalhes_vendas = [];
$erro_relatorio = null;

try {
    $sql_detalhes = "SELECT 
                        id, 
                        data_venda, 
                        modelo, 
                        marca, 
                        preco_venda, 
                        custo_compra, 
                        lucro, 
                        comprador, 
                        cpf_comprador, 
                        vendedor 
                     FROM vendas 
                     ORDER BY data_venda DESC";
    
    $stmt_detalhes = $conn->query($sql_detalhes);
    $detalhes_vendas = $stmt_detalhes->fetchAll(PDO::FETCH_ASSOC);

    $total_vendas = count($detalhes_vendas);
    foreach ($detalhes_vendas as $venda) {

        $valor_total_vendido += (float)$venda['preco_venda'];
        $lucro_total += (float)$venda['lucro'];
    }

} catch (PDOException $e) {
    $erro_relatorio = "Erro ao carregar relatório: " . $e->getMessage();
}


function formatar_moeda($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas</title>

    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php include 'includes/header_admin.php';?>
    <div class="admin-container">
        <h2>📊 Relatório de Vendas</h2>
        
        <?php if ($erro_relatorio): ?>
            <p style='color:red; background: #ffe6e6; padding: 10px; border-radius: 5px;'><?php echo $erro_relatorio; ?></p>
        <?php endif; ?>

        <div class="resumo-vendas">
            <div class="resumo-item">
                <h3><?php echo $total_vendas; ?></h3>
                <p>Motos Vendidas</p>
            </div>
            <div class="resumo-item">
                <h3><?php echo formatar_moeda($valor_total_vendido); ?></h3>
                <p>Valor Total Vendido</p>
            </div>
            <div class="resumo-item">
                <h3><?php echo formatar_moeda($lucro_total); ?></h3>
                <p>Lucro Total</p>
            </div>
            <div class="resumo-item">
                <button class="btn-filter-admin">Filtrar</button>
            </div>
        </div>
        
        <h3>Detalhes das Vendas</h3>
        
        <table>
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Data da Venda</th>
                    <th>Moto</th>
                    <th>Marca</th>
                    <th>Valor Venda</th> 
                    <th>Custo Compra</th> 
                    <th>Lucro</th>
                    <th>Comprador</th>
                    <th>CPF</th>
                    <th>Vendedor</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($total_vendas > 0): ?>
                    <?php foreach ($detalhes_vendas as $venda): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($venda['id']); ?></td>
                            <td><?php echo (new DateTime($venda['data_venda']))->format('d/m/Y H:i'); ?></td>
                            <td><?php echo htmlspecialchars($venda['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($venda['marca']); ?></td>
                            <td><?php echo formatar_moeda($venda['preco_venda']); ?></td>
                            <td><?php echo formatar_moeda($venda['custo_compra']); ?></td>
                            <td><?php echo formatar_moeda($venda['lucro']); ?></td>
                            <td><?php echo htmlspecialchars($venda['comprador']); ?></td>
                            <td><?php echo htmlspecialchars($venda['cpf_comprador']); ?></td>
                            <td><?php echo htmlspecialchars($venda['vendedor']); ?></td> 
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">Nenhuma venda registrada ainda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include 'includes/footer.php';?>
</body>
</html>