<?php
include("conexao.php");

// Pesquisa
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
  $termo_busca = $_GET['busca'];
  $termo_like = "%" . $termo_busca . "%";
  $sql = "SELECT * FROM motos WHERE marca LIKE ? OR modelo LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $termo_like, $termo_like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  // Caso não buscar nada
  $sql = "SELECT * FROM motos";
  $result = $conn->query($sql);
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
  <!-- Busca -->
  <form action="estoque.php" method="GET" class="search-bar">
    <input type="text" name="busca" placeholder="Buscar por marca ou modelo...">
    <button type="submit">Buscar</button>
  </form>

  <main class="container">
    <section id="estoque" class="section">

      <div class="grid">

        <?php
        if ($result->num_rows > 0) {
          while ($moto = $result->fetch_assoc()) {

            // Pega o ID único da moto. 
            $moto_id = $moto['id'];
            echo "<article class='card'>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "<h3>" . $moto['marca'] . " " . $moto['modelo'] . "</h3>";
            echo "<p class='preco'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";

            echo "<a class='btn-buy' href='javascript:void(0);' data-target='modal-" . $moto_id . "'>Ver anúncio</a>";
            echo "<div id='modal-" . $moto_id . "' class='modal'>";
            echo "<div class='modal-content'>";
            echo "<span class='close'>&times;</span>";
            echo "<h2>" . $moto['marca'] . " " . $moto['modelo'] . " - " . $moto['ano'] . "</h2>";
            echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
            echo "<p class='janela'>Ano: " . $moto['ano'] . "</p>";
            echo "<p class='janela'>Quilometragem: " . $moto['km'] . " km" . "</p>";
            echo "<p class='janela'>R$: " . number_format($moto['preco'], 2, ',', '.') . "</p>";
            echo "<a href='https://wa.me/5514998920284?text=Olá! Tenho interesse na " . $moto['marca'] . " " . $moto['modelo'] . "' class='btn-whatsapp' target='_blank'>Chamar no WhatsApp</a>";
            echo "</div>";
            echo "</div>";
            echo "</article>";
          }
        } else {
          echo "<p style='text-align:center;'>Nenhuma moto cadastrada no estoque.</p>";
        }
        ?>

      </div>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const openButtons = document.querySelectorAll(".btn-buy");
      const closeButtons = document.querySelectorAll(".modal .close");
      openButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          const targetModalId = button.getAttribute("data-target");
          const modal = document.getElementById(targetModalId);
          if (modal) {
            modal.style.display = "block";
          }
        });
      });
      closeButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          const modal = button.closest(".modal");
          if (modal) {
            modal.style.display = "none";
          }
        });
      });
      window.addEventListener("click", function(event) {
        if (event.target.classList.contains("modal")) {
          event.target.style.display = "none";
        }
      });

    });
  </script>
</body>

</html>