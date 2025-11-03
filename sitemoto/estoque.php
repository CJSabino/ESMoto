<?php
include("conexao.php");

$sql = "SELECT * FROM motos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Estoque - Renatinho Motos</title>
  <style>
    /* ===== Page layout ===== */
    header {
      background: linear-gradient(90deg,
          rgba(15, 23, 42, 1),
          rgba(6, 11, 34, 1));
      color: white;
      padding: 18px 24px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo {
      width: 56px;
      height: 56px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--accent), #ff7ab6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 18px;
      box-shadow: 0 6px 18px rgba(14, 18, 40, 0.6);
    }

    nav ul {
      display: flex;
      gap: 18px;
      list-style: none;
    }

    nav a {
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-weight: 600;
    }

    .cta {
      background: var(--accent);
      padding: 10px 14px;
      border-radius: 8px;
      color: white;
      font-weight: 700;
      text-decoration: none;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 15px;
      width: 250px;
      text-align: center;
    }

    .card img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .card h3 {
      margin: 10px 0 5px;
    }

    .card p {
      margin: 5px 0;
    }

    .price {
      font-size: 18px;
      font-weight: bold;
      color: green;
    }
  </style>
</head>

<body>
  <header>
    <div class="container topbar">
      <div class="brand">
        <img
          src="logorenato.jpg"
          width="56"
          height="56"
          style="border-radius: 8px; object-fit: cover"
          alt="Logo Renatinho Motos" />
        <div>
          <div style="font-weight: 800; font-size: 18px">Renatinho Motos</div>
          <div
            style="
                font-size: 12px;
                color: rgba(255, 255, 255, 0.6);
                margin-top: 2px;
              ">
            Ourinhos · Compra e venda de motos
          </div>
        </div>
      </div>
      <nav>
        <ul>
          <li><a href="home.html">Inicio</a></li>
          <li><a href="#empresa">Empresa</a></li>
        </ul>
      </nav>
      <a
        href="https://wa.me/5514988199761?text=Olá! Gostaria de mais informações."
        class="cta">Fale conosco</a>
    </div>
  </header>
  <h1>Estoque - Renatinho Motos</h1>
  <div class="container">
    <?php
    if ($result->num_rows > 0) {
      while ($moto = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<img src='" . $moto['imagem'] . "' alt='Imagem da moto'>";
        echo "<h3>" . $moto['marca'] . " " . $moto['modelo'] . "</h3>";
        echo "<p>Ano: " . $moto['ano'] . "</p>";
        echo "<p>KM: " . $moto['km'] . "</p>";
        echo "<p class='price'>R$ " . number_format($moto['preco'], 2, ',', '.') . "</p>";
        echo "</div>";
      }
    } else {
      echo "<p style='text-align:center;'>Nenhuma moto cadastrada no estoque.</p>";
    }
    ?>
  </div>
  <footer class="container">
    <div
      style="
          display: flex;
          justify-content: space-between;
          align-items: center;
          flex-wrap: wrap;
          gap: 12px;
        ">
      <small>© 2025 Renatinho Motos — Todos os direitos reservados</small>
      <div style="display: flex; gap: 12px">
        <a href="#">Política de privacidade</a>
        <a href="#">Termos</a>
      </div>
    </div>
  </footer>
</body>

</html>