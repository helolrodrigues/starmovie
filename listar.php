<?php
session_start(); // 🔥 Adiciona isso para ativar a sessão
require 'conexao.php';

$sql = "SELECT * FROM titulos";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - Starmovie</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("header.php"); // menu ?> 
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .catalogo-container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .catalogo-titulo {
            text-align: center;
            color: #ffcc00;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .catalogo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .card {
            background-color: #111;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.5);
        }

        .card img {
            width: 100%;
            height: 320px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-content h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #fff;
        }

        .card-content p {
            margin-top: 8px;
            color: #aaa;
            font-size: 0.9rem;
        }

        .card-actions {
            margin-top: 10px;
        }

        .card-actions a {
            color: #ffcc00;
            text-decoration: none;
            margin-right: 10px;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .card-actions a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<div class="catalogo-container">
    <h1 class="catalogo-titulo">Catálogo de Filmes e Séries</h1>

    <div class="catalogo-grid">
        <?php
        while ($filme = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $filme['id_titulos']; // ✅ Nome certo da coluna

            echo "<div class='card'>";
            $img = !empty($filme['imagem']) ? 'img/' . $filme['imagem'] : 'img/default_poster.jpg';
            echo "<img src='$img' alt='Capa do título'>";

            echo "<div class='card-content'>";
            echo "<h3>" . htmlspecialchars($filme['nome_filmes'] ?: $filme['nome_serie']) . "</h3>";
            echo "<p><strong>Tipo:</strong> " . htmlspecialchars($filme['tipo']) . "</p>";
            echo "<p><strong>Sinopse:</strong> " . htmlspecialchars($filme['sinopse']) . "</p>";

            // 🔒 Só mostra botões se estiver logado
            if (isset($_SESSION['usuario'])) {
                echo "<div class='card-actions'>";
                echo "<a href='atualizar.php?id=$id' class='btn-editar'>Editar</a>";
                echo "<a href='excluir.php?id=$id' class='btn-excluir' onclick=\"return confirm('Tem certeza que deseja excluir este título?');\">Excluir</a>";
                echo "</div>";
            }

            echo "</div></div>";
        }
        ?>
    </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>
