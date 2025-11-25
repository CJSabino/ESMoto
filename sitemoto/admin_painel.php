<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="estilo.css">

    <style>
        body {
            background: #d4d4d4ff;
        }

        select,
        .add-img,
        .input {
            font-weight: 500;
            font-size: 15px;
            border-radius: 5px;
            margin-top: 0px;
            width: 100%;
            height: 40px;
            box-sizing: border-box;
        }

        .input {
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>

<body>
    <?php include 'includes/header_admin.php'; ?>

    <div class="admin-container">

        <div class="admin-form">
            <h2>Adicionar Nova Moto ao Estoque</h2>

            <form action="cadastrar_moto.php" method="POST" enctype="multipart/form-data">
                <div class="grid">
                    <div>
                        <label for="marca">Marca:</label>
                        <select id="marca" name="marca" required>
                            <option value="" disabled selected>Selecione a marca</option>
                            <option>Yamaha</option>
                            <option>Kawasaki</option>
                            <option>Honda</option>
                            <option>BMW</option>
                            <option>Suzuki</option>
                            <option>Harley-Davidson</option>
                            <option>Triumph</option>
                            <option>KTM</option>
                            <option>Ducati</option>
                        </select>
                    </div>
                    <div>
                        <label for="combustivel">Combustivel:</label>
                        <select id="combustivel" name="combustivel" required>
                            <option>Gasolina</option>
                            <option>Flex</option>
                        </select>
                    </div>
                    <div>
                        <label for="modelo">Modelo:</label>
                        <input class="input" type="text" id="modelo" name="modelo" required>
                    </div>
                    <div>
                        <label for="ano">Ano:</label>
                        <input class="input" type="number" id="ano" name="ano" required>
                    </div>

                    <div>
                        <label for="km">Quilometragem (KM):</label>
                        <input class="input" type="number" id="km" name="km" required>
                    </div>
                    <div>
                        <label for="cilindrada">Cilindrada (cc):</label>
                        <input class="input" type="number" id="cilindrada" name="cilindrada" placeholder="Ex: 160"
                            required>
                    </div>
                    <div>
                        <label for="custo_compra">Preço de Compra (R$):</label>
                        <input class="input" type="text" id="custo_compra" name="custo_compra"
                            placeholder="Ex: 15000.00" required>
                    </div>
                    <div>
                        <label for="preco">Preço de venda(R$):</label>
                        <input class="input" type="text" id="preco" name="preco" placeholder="0.00" required>
                    </div>
                    <div>
                        <label for="imagem">Foto da Moto:</label>
                        <input class="add-img" type="file" id="imagem" name="imagem" accept="image/*" required>
                    </div>
                </div>
                <button type="submit" class="btn-adicionar">Adicionar Moto</button>
            </form>
        </div>

        <h2>Gerenciar Estoque (Remover)</h2>

        <div class="grid">
            <?php
            try {
                $sql = "SELECT id, marca, modelo, imagem, km, preco FROM motos ORDER BY id DESC";
                $stmt = $conn->query($sql);
                $motos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($motos) > 0) {

                    foreach ($motos as $moto) {
                        ?>
                        <article class="card">
                            <img src="<?php echo htmlspecialchars($moto['imagem']); ?>" alt="Moto">

                            <h3>
                                <?php echo htmlspecialchars($moto['marca']); ?>
                                <?php echo htmlspecialchars($moto['modelo']); ?>
                            </h3>

                            <p class="preco" style="position: relative; top: 10px; margin-top: 5px; font-size: 18px;">
                                R$ <?php echo number_format($moto['preco'], 2, ',', '.'); ?>
                            </p>

                            <div class="meta" style="margin-top: 15px;">

                                <a href="remover_moto.php?id=<?php echo $moto['id']; ?>" class="btn-remover"
                                    onclick="return confirm('Tem certeza que deseja remover esta moto? A ação não pode ser desfeita.');">
                                    Remover
                                </a>

                                <a href="vendida_moto.php?id=<?php echo $moto['id']; ?>" class="btn-vendida"
                                    onclick="return confirm('Tem certeza que deseja marcar esta moto como vendida?');">
                                    Vendida
                                </a>
                            </div>
                        </article>
                        <?php
                    }
                } else {
                    echo "<p>Nenhuma moto no estoque para gerenciar.</p>";
                }
            } catch (PDOException $e) {
                echo "<p style='color:red'>Erro ao carregar motos: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>