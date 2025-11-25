<?php
include("conexao.php");

try {
    $sql = "SELECT * FROM motos WHERE 1=1";
    $params = [];


    if (isset($_GET['filtro_marca']) && !empty($_GET['filtro_marca'])) {
        $sql .= " AND marca ILIKE ?"; 
        $params[] = "%" . $_GET['filtro_marca'] . "%";
    }

    if (isset($_GET['filtro_modelo']) && !empty($_GET['filtro_modelo'])) {
        $sql .= " AND modelo ILIKE ?";
        $params[] = "%" . $_GET['filtro_modelo'] . "%";
    }

    if (isset($_GET['filtro_cc']) && !empty($_GET['filtro_cc'])) {
        $sql .= " AND cilindrada >= ?";
        $params[] = $_GET['filtro_cc'];
    }

    if (isset($_GET['filtro_ano']) && !empty($_GET['filtro_ano'])) {
        $sql .= " AND ano = ?";
        $params[] = $_GET['filtro_ano'];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params); 
    $motos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar motos do Supabase: " . $e->getMessage());
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
    .form-filtro { display: flex; flex-direction: column; gap: 15px; }
    .form-filtro label { font-weight: bold; margin-bottom: 5px; display: block; }
    .form-filtro input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
    .btn-aplicar { background-color: var(--accent, #e11d48); color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    .btn-limpar { display: block; text-align: center; margin-top: 10px; color: #666; text-decoration: underline; font-size: 14px; }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <section class="hero">
      <div>
        <h1>Encontre a sua próxima moto com quem entende.</h1>
        <p>CRJ Bikers — ofertas, financiamento e avaliação na hora.</p>
        <div class="filter-button">
          <a href="javascript:void(0);" class="btn-filter" id="btn-abrir-filtro">Filtrar motos</a>
        </div>
        </div>
    </section>
  </main>

  <main class="container">
    <section id="estoque" class="section">
      
      <?php if (!empty($_GET['filtro_marca']) || !empty($_GET['filtro_cc']) || !empty($_GET['filtro_ano'])) { ?>
            <p style="margin-bottom: 20px;">Resultados do filtro. <a href="home.php">Limpar</a></p>
      <?php } ?>

      <div class="grid">
        <?php
        if (count($motos) > 0) {
          foreach ($motos as $moto) {

            $moto_id = $moto['id'];
            $cilindrada_show = isset($moto['cilindrada']) ? $moto['cilindrada'] . "cc" : "";

            echo "<article class='card'>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "<h3>" . $moto['marca'] . " " . $moto['modelo'] . "</h3>";
            if($cilindrada_show) echo "<p style='font-size: 14px; color: #666; margin-top:-5px; margin-bottom:5px;'>" . $cilindrada_show . "</p>";
            echo "<p class='preco'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";
            echo "<a class='btn-buy' href='javascript:void(0);' data-target='modal-" . $moto_id . "'>Ver anúncio</a>";
            echo "<div id='modal-" . $moto_id . "' class='modal'>";
            echo "<div class='modal-content'>";
            echo "<span class='close'>&times;</span>";
            echo "<div class='modal-grid-layout'>";
            echo "<div class='modal-col-left'><img src='" . $moto['imagem'] . "' alt='Imagem da moto'></div>";
            echo "<div class='modal-col-right'>";
            echo "<h2 class='modal-title'>" . $moto['marca'] . " " . $moto['modelo'] . " <small>" . $moto['ano'] . "</small></h2>";
            echo "<div class='specs-grid'>";
            echo "<div class='spec-item'><span class='label'>Ano</span><span class='value'>" . $moto['ano'] . "</span></div>";
            if($cilindrada_show) echo "<div class='spec-item'><span class='label'>Cilindrada</span><span class='value'>" . $cilindrada_show . "</span></div>";
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

  <div id="modal-filtro" class="modal">
    <div class="modal-content" style="max-width: 400px;">
        <span class="close close-filtro">&times;</span>
        <h2>Filtrar Motos</h2>
        <form action="home.php" method="GET" class="form-filtro">
            <div><label>Marca</label><input type="text" name="filtro_marca" placeholder="Ex: Honda"></div>
            <div><label>Modelo</label><input type="text" name="filtro_modelo" placeholder="Ex: CB 500"></div>
            <div><label>Cilindrada (Mínima)</label><input type="number" name="filtro_cc" placeholder="Ex: 300"></div>
            <div><label>Ano</label><input type="number" name="filtro_ano" placeholder="Ex: 2023"></div>
            <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
            <a href="home.php" class="btn-limpar">Limpar Filtros</a>
        </form>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const openButtons = document.querySelectorAll(".btn-buy");
        const closeButtons = document.querySelectorAll(".modal:not(#modal-filtro) .close");
        const btnFiltro = document.getElementById("btn-abrir-filtro");
        const modalFiltro = document.getElementById("modal-filtro");
        const closeFiltro = document.querySelector(".close-filtro");
        if(btnFiltro) btnFiltro.onclick = (e) => { e.preventDefault(); modalFiltro.style.display = "block"; }
        if(closeFiltro) closeFiltro.onclick = () => modalFiltro.style.display = "none";
        
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

