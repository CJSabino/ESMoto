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
            background: #d4d4d4ff;
        }

        select {
            font-weight: 500;
            font-size: 15px;
            border-radius: 5px;
            margin-top: 0px;
            width: 100%;
            height: 40px;
            box-sizing: border-box;
        }

        .add-img {
            font-weight: 500;
            font-size: 15px;
            border-radius: 5px;
            margin-top: 0px;
            width: 100%;
            height: 40px;
            box-sizing: border-box;
        }

        .input {
            font-weight: 500;
            font-size: 15px;
            border-radius: 5px;
        }

        .btn-adicionar {
            display: inline-block;
            padding: 12px 20px;
            background-color: #060b22;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include 'includes/header_admin.php'; ?>
    <div class="admin-container">

        <div class="admin-form">
            <h2>Adicionar Nova Moto ao Estoque</h2>
            <form action="cadastrar_moto.php" method="POST" enctype="multipart/form-data">
                <div class="grid ">
                    <div>
                        <label for="marca">Marca:</label>
                        <select type="select" id="marca" name="marca" required>
                            <option>Insira a marca da moto.</option>
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
                        <label for="preco">Combustivel:</label>
                        <select type="select" id="combustivel" name="combustivel" required>
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
                        <label for="preco">Preço (R$):</label>
                        <input class="input" type="text" id="preco" name="preco" placeholder="0" required>
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
            //Busca todas as motos
            $sql = "SELECT id, marca, modelo, imagem, km, preco FROM motos ORDER BY id DESC";
            $result_motos = $conn->query($sql);

            if ($result_motos->num_rows > 0) {
                while ($moto = $result_motos->fetch_assoc()) {
            ?>
                    <article class="card">

                        <img src="<?php echo htmlspecialchars($moto['imagem']); ?>" alt="Moto">

                        <h3><?php echo htmlspecialchars($moto['marca']); ?> <?php echo htmlspecialchars($moto['modelo']); ?>
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