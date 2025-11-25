<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas</title>

    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php include 'includes/header_admin.php'; ?>
    <div class="admin-container">
        <h2>📊 Relatório de Vendas</h2>
        
        <div class="resumo-vendas">
            <div class="resumo-item">
                <h3>6</h3>
                <p>Motos Vendidas</p>
            </div>
            <div class="resumo-item">
                <h3>R$ 45.980,00</h3>
                <p>Valor total Vendido</p>
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
                    <th>Vendida por</th>
                    <th>comprada por</th>
                    <th>Lucro</th>
                    <th>Comprador</th>
                    <th>CPF do comprador</th>
                    <th>Vendedor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>24/11/2025 10:30</td>
                    <td>XRE 300 Adventure</td>
                    <td>Honda</td>
                    <td>R$ 22.500,00</td>
                    <td>R$ 19.000,00</td>
                    <td>R$ 3.000,00</td>
                    <td>Jacquicele Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td> 
                </tr>
                <tr>
                    <td>2</td>
                    <td>24/11/2025 10:30</td>
                    <td>CBR650F</td>
                    <td>Honda</td>
                    <td>R$ 41.000,00</td>
                    <td>R$ 35.000,00</td>
                    <td>R$ 6.000,00</td>
                    <td>João Pedro Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>24/11/2025 10:30</td>
                    <td>pcx</td>
                    <td>Honda</td>
                    <td>R$ 18.000,00</td>
                    <td>R$ 12.000,00</td>
                    <td>R$ 6.000,00</td>
                    <td>Newton Campos Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>24/11/2025 10:30</td>
                    <td>XRE 300 Adventure</td>
                    <td>Honda</td>
                    <td>R$ 22.500,00</td>
                    <td>R$ 19.000,00</td>
                    <td>R$ 3.000,00</td>
                    <td>Jacquicele Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td> 
                </tr>
                <tr>
                    <td>5</td>
                    <td>24/11/2025 10:30</td>
                    <td>CBR650F</td>
                    <td>Honda</td>
                    <td>R$ 41.000,00</td>
                    <td>R$ 35.000,00</td>
                    <td>R$ 6.000,00</td>
                    <td>João Pedro Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>24/11/2025 10:30</td>
                    <td>pcx</td>
                    <td>Honda</td>
                    <td>R$ 18.000,00</td>
                    <td>R$ 12.000,00</td>
                    <td>R$ 6.000,00</td>
                    <td>Newton Campos Nicolau</td>
                    <td>12345678910</td>
                    <td>Renan</td>
                </tr>
                </tbody>
        </table>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>