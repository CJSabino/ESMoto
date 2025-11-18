<?php
// Inicia a sessão
session_start();
// Se o usuário NÃO ESTÁ logado
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
            background: #f4f4f4;
        }

        .logout {
            display: inline-block;
            background: #060b22;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            float: right;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<?php include 'includes/header_admin.php'; ?>
    <div class="admin-container">

        <h1>Painel Administrativo</h1>

        <div class="admin-form">
            <h2>Adicionar Nova Moto ao Estoque</h2>
            <form action="cadastrar_moto.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
                <div>
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" required>
                </div>
                <div>
                    <label for="ano">Ano:</label>
                    <input type="number" id="ano" name="ano" required>
                </div>

                <div>
                    <label for="km">Quilometragem (KM):</label>
                    <input type="number" id="km" name="km" required>
                </div>

                <div>
                    <label for="preco">Preço (R$):</label>
                    <input type="text" id="preco" name="preco" placeholder="25000.00" required>
                </div>

                <div>
                    <label for="imagem">Foto da Moto:</label>
                    <input type="file" id="imagem" name="imagem" accept="image/*" required>
                </div>

                <button type="submit" class="btn-adicionar">Adicionar Moto</button>
            </form>
        </div>

        <h2>Gerenciar Estoque (Remover)</h2>

        <div class="grid">

            <?php
            //Busca todas as motos
            $sql = "SELECT id, marca, modelo, imagem, km, preco FROM motos ORDER BY id DESC";
            $result_motos = $conn->query($sql);

            if ($result_motos->num_rows > 0) {
                while ($moto = $result_motos->fetch_assoc()) {
                    ?>
                    <article class="card">

                        <img src="<?php echo htmlspecialchars($moto['imagem']); ?>" alt="Moto">

                        <h3><?php echo htmlspecialchars($moto['marca']); ?>         <?php echo htmlspecialchars($moto['modelo']); ?>
                        </h3>

                        <div class="meta" style="justify-content: flex-start; margin-top: 5px;">
                            <small>KM: <?php echo htmlspecialchars($moto['km']); ?></small>
                        </div>

                        <p class="preco" style="position: relative; top: 0; margin-top: 5px; font-size: 18px;">
                            R$ <?php echo number_format($moto['preco'], 2, ',', '.'); ?>
                        </p>

                        <div class="meta" style="margin-top: 10px;"> <small>ID: <?php echo $moto['id']; ?></small>

                            <a href="remover_moto.php?id=<?php echo $moto['id']; ?>" class="btn-filter"
                                onclick="return confirm('Tem certeza que deseja remover esta moto? A ação não pode ser desfeita.');">
                                Remover
                            </a>
                        </div>
                    </article>
                    <?php
                } // Fim do while
            } else {
                echo "<p>Nenhuma moto no estoque para gerenciar.</p>";
            }
            $conn->close(); // Fechando a conexão
            ?>
        </div>
    </div>
</body>

</html>