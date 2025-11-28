<?php
session_start();
require 'conexao.php';

// mostra todas as informações dos titulos
try {
    $sql = "
        SELECT 
            t.id_titulos,
            t.nome_filmes,
            t.nome_serie,
            t.tipo,
            t.sinopse,
            t.imagem,
            GROUP_CONCAT(g.nome SEPARATOR ', ') AS generos
        FROM titulos t
        LEFT JOIN titulo_genero tg ON tg.fk_titulos_id_titulos = t.id_titulos
        LEFT JOIN generos g ON g.id_generos = tg.fk_generos_id_generos
        GROUP BY t.id_titulos
        ORDER BY t.id_titulos DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar títulos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Catálogo - Starmovie</title>
<link rel="stylesheet" href="css/style.css">
<?php include("header.php"); ?>
<style>
body { 
    background:#000; 
    color:#fff; 
    font-family:Arial, Helvetica, sans-serif; 
    margin:0; 
    padding:0; 
}

.catalogo-container { 
    width:90%; 
    max-width:1200px; 
    margin:40px auto; 
}


.catalogo-titulo { 
    text-align:center; 
    color:#ffcc00; 
    font-size:2rem; 
    margin-bottom:30px; 
}


.catalogo-grid { 
    display:grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap:25px; 
}

@media (max-width: 1024px) { .catalogo-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .catalogo-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .catalogo-grid { grid-template-columns: 1fr; } }


.card { 
    background:#111; 
    border-radius:10px; 
    overflow:hidden; 
    padding-bottom:15px; 
    transition:transform 0.3s, box-shadow 0.3s; 
}
.card:hover { 
    transform:scale(1.05); 
    box-shadow:0 0 20px rgba(255,204,0,0.5); 
}


.card img { 
    width:100%; 
    height:320px; 
    object-fit:cover; 
}


.card-content { 
    padding:15px; 
}
.card-content h3 { 
    margin:0; 
    font-size:1.2rem; 
    color:#fff; 
}
.card-content p { 
    margin-top:8px; 
    color:#aaa; 
    font-size:0.9rem; 
}
.card-content strong { 
    color:#ffcc00; 
}

.card-actions { 
    margin-top:10px; 
}
.card-actions a { 
    color:#ffcc00; 
    text-decoration:none; 
    margin-right:10px; 
    font-size:0.9rem; 
    transition:color 0.3s; 
}
.card-actions a:hover { 
    color:#fff; 
}
</style>
</head>
<body>

<div class="catalogo-container">
    <h1 class="catalogo-titulo">Catálogo de Filmes e Séries</h1>

    <div class="catalogo-grid">
        <?php if(!empty($filmes)): ?>
            <?php foreach($filmes as $filme): ?>
                <?php $id = $filme['id_titulos']; ?>
                <div class="card"> 
                    <?php $img = !empty($filme['imagem']) ? $filme['imagem'] : 'img/default_poster.jpg'; ?>
                    <img src="<?= htmlspecialchars($img) ?>" alt="Capa do título">
                    
                    <div class="card-content">
                        <h3><?= htmlspecialchars($filme['nome_filmes'] ?: $filme['nome_serie']) ?></h3>
                        <p><strong>Tipo:</strong> <?= htmlspecialchars($filme['tipo']) ?></p>
                        <p><strong>Gênero:</strong> <?= htmlspecialchars($filme['generos'] ?? '—') ?></p>
                        <p><strong>Sinopse:</strong> <?= htmlspecialchars($filme['sinopse']) ?></p>

                        <?php if(isset($_SESSION['usuario'])): ?>
                            <div class="card-actions">
                                <a href="atualizar.php?id=<?= $id ?>">Editar</a>
                                <a href="excluir.php?id=<?= $id ?>" onclick="return confirm('Tem certeza que deseja excluir este título?');">Excluir</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#ffcc00; text-align:center;">Nenhum título encontrado.</p>
        <?php endif; ?>
    </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>
