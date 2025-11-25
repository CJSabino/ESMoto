<?php
include("conexao.php"); // Conexão PDO/Supabase

try {
    // 1. Consulta Base
    $sql = "SELECT * FROM motos WHERE 1=1";
    $params = [];

    // 2. Busca Simples (Barra de pesquisa do estoque)
    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        // ILIKE no Postgres é case-insensitive (melhor para busca)
        $sql .= " AND (marca ILIKE ? OR modelo ILIKE ?)";
        $busca = "%" . $_GET['busca'] . "%";
        $params[] = $busca;
        $params[] = $busca;
    }

    // 3. Execução PDO
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $motos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no estoque: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title class="titulo-centro">Estoque</title>
  <link rel='stylesheet' type='text/css' href='./estilo.css'>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  
  <h1 class="titulo-centro" style="padding: 10px">Estoque - CRJ Bikers</h1>
  
  <form action="estoque.php" method="GET" class="search-bar">
    <input type="text" name="busca" placeholder="Buscar por marca ou modelo...">
    <button type="submit">Buscar</button>
  </form>

  <main class="container">
    <section id="estoque" class="section">
      <div class="grid">
        <?php
        // Verifica se tem resultados
        if (count($motos) > 0) {
          // Loop foreach (PDO)
          foreach ($motos as $moto) {

            $moto_id = $moto['id'];
            $cilindrada_show = isset($moto['cilindrada']) ? $moto['cilindrada'] . "cc" : "";

            echo "<article class='card'>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "<h3>" . $moto['marca'] . " " . $moto['modelo'] . "</h3>";
            if ($cilindrada_show) echo "<p style='font-size: 14px; color: #666; margin-top:-5px; margin-bottom:5px;'>" . $cilindrada_show . "</p>";
            echo "<p class='preco'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";
            echo "<a class='btn-buy' href='javascript:void(0);' data-target='modal-" . $moto_id . "'>Ver anúncio</a>";

            // MODAL DA MOTO (O HTML do modal é idêntico ao home.php)
            echo "<div id='modal-" . $moto_id . "' class='modal'>";
            echo "<div class='modal-content'>";
            echo "<span class='close'>&times;</span>";
            echo "<div class='modal-grid-layout'>";
            echo "<div class='modal-col-left'><img src='" . $moto['imagem'] . "' alt='Imagem da moto'></div>";
            echo "<div class='modal-col-right'>";
            echo "<h2 class='modal-title'>" . $moto['marca'] . " " . $moto['modelo'] . " <small>" . $moto['ano'] . "</small></h2>";
            echo "<div class='specs-grid'>";
            echo "<div class='spec-item'><span class='label'>Ano</span><span class='value'>" . $moto['ano'] . "</span></div>";
            if ($cilindrada_show) echo "<div class='spec-item'><span class='label'>Cilindrada</span><span class='value'>" . $cilindrada_show . "</span></div>";
            echo "<div class='spec-item'><span class='label'>Quilometragem</span><span class='value'>" . $moto['km'] . " km</span></div>";
            echo "</div>"; 
            echo "<div class='modal-footer-info'>";
            echo "<div class='modal-price-container'><span class='label'>Preço à vista</span><p class='modal-price'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p></div>";
            echo "<a href='https://wa.me/5514998920284?text=Tenho interesse na " . $moto['marca'] . "' class='btn-whatsapp btn-modal-full' target='_blank'>Chamar no WhatsApp</a>";
            echo "</div></div></div></div></div>";
            echo "</article>";
          }
        } else {
          echo "<p style='text-align:center; width:100%;'>Nenhuma moto encontrada.</p>";
        }
        ?>
      </div>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script>
    // Seu JavaScript original dos modais
    document.addEventListener("DOMContentLoaded", function() {
      const openButtons = document.querySelectorAll(".btn-buy");
      const closeButtons = document.querySelectorAll(".modal .close");
      
      openButtons.forEach(btn => btn.onclick = () => {
          const m = document.getElementById(btn.getAttribute("data-target"));
          if(m) m.style.display = "block";
      });
      closeButtons.forEach(btn => btn.onclick = () => btn.closest(".modal").style.display = "none");
      window.onclick = (e) => { if(e.target.classList.contains("modal")) e.target.style.display = "none"; }
    });
  </script>
</body>
</html>