<?php
include("conexao.php");

// ATIVAR RELATÓRIO DE ERROS
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  // 1. Consulta Base
  $sql = "SELECT * FROM motos WHERE 1=1";
  $tipos = "";
  $params = [];

  // --- LÓGICA DOS FILTROS (Vindos do Modal) ---

  // Marca
  if (isset($_GET['filtro_marca']) && !empty($_GET['filtro_marca'])) {
    $sql .= " AND marca LIKE ?";
    $tipos .= "s";
    $params[] = "%" . $_GET['filtro_marca'] . "%";
  }

  // Modelo
  if (isset($_GET['filtro_modelo']) && !empty($_GET['filtro_modelo'])) {
    $sql .= " AND modelo LIKE ?";
    $tipos .= "s";
    $params[] = "%" . $_GET['filtro_modelo'] . "%";
  }

  // Cilindrada
  if (isset($_GET['filtro_cc']) && !empty($_GET['filtro_cc'])) {
    $sql .= " AND cilindrada >= ?";
    $tipos .= "i";
    $params[] = $_GET['filtro_cc'];
  }

  // Ano
  if (isset($_GET['filtro_ano']) && !empty($_GET['filtro_ano'])) {
    $sql .= " AND ano = ?";
    $tipos .= "i";
    $params[] = $_GET['filtro_ano'];
  }

  // 2. Preparar e Executar
  $stmt = $conn->prepare($sql);

  if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
  }

  $stmt->execute();
  $result = $stmt->get_result();

} catch (Exception $e) {
  die("Erro ao carregar motos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CRJ Bikers - Home</title>
  <link rel='stylesheet' type='text/css' href='./estilo.css'>

  <style>
    
  </style>
</head>

<body>

  <?php include 'includes/header.php'; ?>

  <main class="container">
    <section class="hero">
      <div>
        <h1>Encontre a sua próxima moto com quem entende.</h1>
        <p>
          CRJ Bikers — ofertas, financiamento e avaliação na hora.
          Estoque atualizado diariamente com as melhores opções para você
          rodar com confiança.
        </p>

        <div class="filter-button">
          <a href="javascript:void(0);" class="btn-filter" id="btn-abrir-filtro">Filtrar motos</a>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 18px; align-items: center;">
          <div style="padding: 10px; background: rgba(14, 20, 40, 0.04); border-radius: 10px;">
            <strong>Financiamento</strong><br /><small style="color: var(--muted)">Aprovação em 24h</small>
          </div>
          <div style="padding: 10px; background: rgba(14, 20, 40, 0.04); border-radius: 10px;">
            <strong>Avaliação</strong><br /><small style="color: var(--muted)">Valor justo pelo seu usado</small>
          </div>
        </div>
      </div>
    </section>
  </main>

  <main class="container">
    <section id="estoque" class="section">

      <?php if (!empty($_GET['filtro_marca']) || !empty($_GET['filtro_cc']) || !empty($_GET['filtro_ano'])) { ?>
        <p style="margin-bottom: 20px;">
          Resultados do filtro. <a href="home.php">Limpar</a>
        </p>
      <?php } ?>

      <div class="grid">

        <?php
        if ($result->num_rows > 0) {
          while ($moto = $result->fetch_assoc()) {

            $moto_id = $moto['id'];
            $cilindrada_show = isset($moto['cilindrada']) ? $moto['cilindrada'] . "cc" : "";

            echo "<article class='card'>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "<h3>" . $moto['marca'] . " " . $moto['modelo'] . "</h3>";

            if ($cilindrada_show)
              echo "<p style='font-size: 14px; color: #666; margin-top:-5px; margin-bottom:5px;'>" . $cilindrada_show . "</p>";

            echo "<p class='preco'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";

            echo "<a class='btn-buy' href='javascript:void(0);' data-target='modal-" . $moto_id . "'>Ver anúncio</a>";

            // MODAL DA MOTO
            echo "<div id='modal-" . $moto_id . "' class='modal'>";
            echo "<div class='modal-content'>";

            echo "<span class='close'>&times;</span>";
            echo "<div class='modal-grid-layout'>";

            //IMAGEM (Esquerda)
            echo "<div class='modal-col-left'>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "</div>";

            //INFORMAÇÕES (Direita)
            echo "<div class='modal-col-right'>";

            // Título
            echo "<h2 class='modal-title'>" . $moto['marca'] . " " . $moto['modelo'] . " <small>" . $moto['ano'] . "</small></h2>";

            // Grid de Especificações
            echo "<div class='specs-grid'>";
            echo "<div class='spec-item'><span class='label'>Ano</span><span class='value'>" . $moto['ano'] . "</span></div>";

            if ($cilindrada_show) {
              echo "<div class='spec-item'><span class='label'>Cilindrada</span><span class='value'>" . $cilindrada_show . "</span></div>";
            }

            echo "<div class='spec-item'><span class='label'>Quilometragem</span><span class='value'>" . $moto['km'] . " km</span></div>";
            echo "</div>";
            echo "<div class='modal-footer-info'>";
            echo "<div class='modal-price-container'>";
            echo "<span class='label'>Preço à vista</span>";
            echo "<p class='modal-price'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";
            echo "</div>";

            echo "<a href='https://wa.me/5514998920284?text=Tenho interesse na " . $moto['marca'] . "' class='btn-whatsapp btn-modal-full' target='_blank'>Chamar no WhatsApp</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</article>";
          }
        } else {
          echo "<p style='text-align:center; width:100%;'>Nenhuma moto encontrada com esses filtros.</p>";
        }
        ?>

      </div>
    </section>
  </main>

  <div id="modal-filtro" class="modal">
    <div class="modal-content" style="max-width: 400px;">
      <span class="close close-filtro">&times;</span>
      <h2>Filtrar Motos</h2>

      <form action="home.php" method="GET" class="form-filtro">

        <div>
          <label for="filtro_marca">Marca</label>
          <input type="text" name="filtro_marca" placeholder="Ex: Honda">
        </div>
        <div>
          <label for="filtro_modelo">Modelo</label>
          <input type="text" name="filtro_modelo" placeholder="Ex: CB 500">
        </div>
        <div>
          <label for="filtro_cc">Cilindrada (Mínima)</label>
          <input type="number" name="filtro_cc" placeholder="Ex: 300">
        </div>
        <div>
          <label for="filtro_ano">Ano</label>
          <input type="number" name="filtro_ano" placeholder="Ex: 2023">
        </div>

        <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
        <a href="home.php" class="btn-limpar">Limpar Filtros</a>
      </form>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script>
    document.addEventListener("DOMContentLoaded", function () {

      // === 1. Lógica do Modal de FILTRO ===
      const btnFiltro = document.getElementById("btn-abrir-filtro");
      const modalFiltro = document.getElementById("modal-filtro");
      const closeFiltro = document.querySelector(".close-filtro"); // X do filtro

      if (btnFiltro) {
        btnFiltro.addEventListener("click", function (e) {
          e.preventDefault(); // Impede o link de pular a página
          modalFiltro.style.display = "block";
        });
      }

      if (closeFiltro) {
        closeFiltro.addEventListener("click", function () {
          modalFiltro.style.display = "none";
        });
      }

      // === 2. Lógica dos Modais das MOTOS ===
      const openButtons = document.querySelectorAll(".btn-buy");
      // Importante: Pega os botões X que NÃO são do filtro
      const closeButtons = document.querySelectorAll(".modal:not(#modal-filtro) .close");

      openButtons.forEach(function (button) {
        button.addEventListener("click", function () {
          const targetModalId = button.getAttribute("data-target");
          const modal = document.getElementById(targetModalId);
          if (modal) modal.style.display = "block";
        });
      });

      closeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
          const modal = button.closest(".modal");
          if (modal) modal.style.display = "none";
        });
      });

      // === 3. Fechar qualquer modal clicando fora ===
      window.addEventListener("click", function (event) {
        if (event.target.classList.contains("modal")) {
          event.target.style.display = "none";
        }
      });

    });
  </script>

</body>

</html>