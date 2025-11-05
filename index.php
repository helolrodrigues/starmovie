<?php include("header.php"); ?>
<link rel="stylesheet" href="">

<main>
    <h2>Filmes em Destaque</h2>

    <div class="filmes-container">
        <?php
        include("conexao.php");

        $sql = "SELECT * FROM filmes ORDER BY id DESC LIMIT 6";
        $resultado = mysqli_query($conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            while ($filme = mysqli_fetch_assoc($resultado)) {
                echo "
                <div class='card'>
                    <img src='{$filme['imagem']}' alt='{$filme['titulo']}'>
                    <div class='card-content'>
                        <h3>{$filme['titulo']}</h3>
                        <p>{$filme['descricao']}</p>
                    </div>
                </div>";
            }
        } else {
            echo "<p>Nenhum filme cadastrado ainda 😢</p>";
        }
        ?>
    </div>
</main>

<?php include("footer.php"); ?>
