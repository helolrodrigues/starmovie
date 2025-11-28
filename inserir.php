<?php
session_start();
require 'conexao.php';

// bloqueia se nao estiver logado
if (!isset($_SESSION['usuario_id'])) {
//mensagem que nao é cadastrado
    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Acesso Negado</title>
        <style>
            body {
                background: #000;
                color: #fff;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: 100vh;
                margin: 0;
            }
            .mensagem-box {
                background: #111;
                border: 2px solid #ffcc00;
                padding: 30px 50px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 0 20px rgba(255,204,0,0.5);
            }
            h2 {
                color: #ffcc00;
                margin-bottom: 15px;
            }
            p {
                margin-bottom: 20px;
                color: #fff;
            }
            .btn-login {
                text-decoration: none;
                background: #ffcc00;
                color: #000;
                padding: 12px 25px;
                border-radius: 8px;
                font-weight: bold;
                transition: transform 0.2s;
            }
            .btn-login:hover {
                transform: scale(1.05);
                background: #fff200;
            }
        </style>
    </head>
    <body>
        <div class="mensagem-box">
            <h2>Acesso Negado</h2>
            <p>Você precisa estar cadastrado para acessar esta página.</p>
            <a href="cadastro.php" class="btn-login">Fazer cadastro</a>
        </div>
    </body>
    </html>
    ';
    exit;
}

$usuarioLogado = $_SESSION['usuario_id'];

// formulario 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipo         = trim($_POST['tipo'] ?? '');
    $nome_filmes  = trim($_POST['nome_filmes'] ?? '');
    $nome_serie   = trim($_POST['nome_serie'] ?? '');
    $sinopse      = trim($_POST['sinopse'] ?? '');
    $genero       = trim($_POST['genero'] ?? '');
    $imagem       = null;

    if ($tipo === 'Filme') $nome_serie = '';
    if ($tipo === 'Série') $nome_filmes = '';

    // upload da imagem
    if (!empty($_FILES['imagem']['name'])) {
        $pastaDestino = __DIR__ . '/img/';
        if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0777, true);

        $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $caminhoDestino = $pastaDestino . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
            $imagem = 'img/' . $nomeArquivo;
        } else {
            echo "<p style='color:red;text-align:center;'>Erro ao mover a imagem!</p>";
            exit;
        }
    }

    try {
        // insere titulo 
        $sql = "INSERT INTO titulos (nome_filmes, nome_serie, tipo, sinopse, imagem, id_usuario)
                VALUES (:nome_filmes, :nome_serie, :tipo, :sinopse, :imagem, :id_usuario)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_filmes', $nome_filmes);
        $stmt->bindParam(':nome_serie', $nome_serie);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':sinopse', $sinopse);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':id_usuario', $usuarioLogado);
        $stmt->execute();

        $id_titulo = $pdo->lastInsertId();

        // escolhe o genero
        if ($genero !== '') {
            $stmtGen = $pdo->prepare("SELECT id_generos FROM generos WHERE nome = :genero LIMIT 1");
            $stmtGen->bindParam(':genero', $genero);
            $stmtGen->execute();

            if ($stmtGen->rowCount() > 0) {
                $id_genero = $stmtGen->fetchColumn();
            } else {
                $insGen = $pdo->prepare("INSERT INTO generos (nome) VALUES (:genero)");
                $insGen->bindParam(':genero', $genero);
                $insGen->execute();
                $id_genero = $pdo->lastInsertId();
            }

            $rel = $pdo->prepare("INSERT INTO titulo_genero (fk_titulos_id_titulos, fk_generos_id_generos)
                                  VALUES (:id_titulos, :id_generos)");

            $rel->bindParam(':id_titulos', $id_titulo);
            $rel->bindParam(':id_generos', $id_genero);
            $rel->execute();
        }

        header("Location: listar.php?msg=inserido");
        exit;

    } catch (PDOException $e) {
        echo "<p style='color:red;text-align:center;'>Erro ao inserir título: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

//carrega as opcoes de genero
$generosExistentes = [];
try {
    $stmt = $pdo->query("SELECT nome FROM generos ORDER BY nome ASC");
    $generosExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo "<p style='color:red;text-align:center;'>Erro ao carregar gêneros!</p>";
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Adicione um novo título</title>

<style>
    body { 
        background:#000; 
        color:#fff; 
        font-family:Arial,sans-serif; 
        display:flex; 
        justify-content:center; 
        align-items:center; 
        min-height:100vh;
        margin:0;
        padding-top:40px;
    }

    form { 
        background:#111; 
        padding:35px; 
        border-radius:12px; 
        box-shadow:0 0 18px #ffcc00; 
        width:430px; 
    }

    h2 { 
        text-align:center; 
        color:#ffcc00; 
        margin-bottom:20px;
    }

    input, textarea, select { 
        width:100%; 
        padding:10px; 
        margin:10px 0; 
        border-radius:6px; 
        border:none; 
        background:#222;
        color:#fff;
    }

    button { 
        background:#ffcc00; 
        color:#000; 
        padding:12px; 
        border-radius:6px; 
        border:none; 
        cursor:pointer; 
        width:100%; 
        font-size:1rem;
        font-weight:bold;
        margin-top:10px;
    }
    
    button:hover { background:#fff200; }

    .btn-voltar { 
        position:absolute; 
        top:20px; 
        left:20px; 
        background:#111; 
        color:#ffcc00; 
        border:2px solid #ffcc00; 
        padding:8px 14px; 
        border-radius:8px; 
        text-decoration:none; 
        font-weight:bold;
    }

    .btn-voltar:hover { 
        background:#ffcc00; 
        color:#000; 
    }
</style>

</head>
<body>

<a href="index.php" class="btn-voltar">⬅ Voltar</a>

<form method="POST" enctype="multipart/form-data">
<h2>Insira um novo título!</h2>

<label>Tipo:</label>
<select name="tipo" id="tipo" required>
    <option value="">Selecione...</option>
    <option value="Filme">Filme</option>
    <option value="Série">Série</option>
</select>

<!-- nome do filme-->
<div id="campo-filme" style="display:none;">
    <label>Nome do Filme:</label>
    <input type="text" name="nome_filmes" id="nome_filmes" placeholder="Digite o nome do filme">
</div>

<!-- nome da serie  -->
<div id="campo-serie" style="display:none;">
    <label>Nome da Série:</label>
    <input type="text" name="nome_serie" id="nome_serie" placeholder="Digite o nome da série">
</div>

<label>Gênero:</label>
<select name="genero">
    <option value="">Selecione...</option>
    <?php foreach ($generosExistentes as $g): ?>
        <option value="<?= htmlspecialchars($g) ?>"><?= htmlspecialchars($g) ?></option>
    <?php endforeach; ?>
</select>

<label>Sinopse:</label>
<textarea name="sinopse" rows="4" placeholder="Digite aqui a sinopse..."></textarea>

<label>Imagem (capa):</label>
<input type="file" name="imagem" accept="image/*">

<button type="submit">Salvar</button>
</form>

<script> //se for filme aparecer somnete campo de filme
document.addEventListener("DOMContentLoaded", function() {
    const tipo = document.getElementById("tipo");
    const campoFilme = document.getElementById("campo-filme");
    const campoSerie = document.getElementById("campo-serie");
    const inputFilme = document.getElementById("nome_filmes");
    const inputSerie = document.getElementById("nome_serie");

    tipo.addEventListener("change", function() {
        if (this.value === "Filme") {
            campoFilme.style.display = "block";
            campoSerie.style.display = "none";

            inputFilme.required = true;
            inputSerie.required = false;
            inputSerie.value = "";
        } 
        else if (this.value === "Série") {
            campoFilme.style.display = "none";
            campoSerie.style.display = "block";

            inputSerie.required = true;
            inputFilme.required = false;
            inputFilme.value = "";
        } 
        else {
            campoFilme.style.display = "none";
            campoSerie.style.display = "none";

            inputFilme.required = false;
            inputSerie.required = false;
        }
    });
});
</script>

</body>
</html>
