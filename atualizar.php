<?php
session_start();
require 'conexao.php';

// Confere login
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para acessar esta página.");
}

$usuarioLogado = $_SESSION['usuario_id'];

// Confere ID
if (!isset($_GET['id'])) {
    die("Erro: Nenhum ID informado.");
}

$id = (int) $_GET['id'];

/* ================================
   BUSCA DADOS DO TÍTULO
================================ */
$sql = $pdo->prepare("SELECT * FROM titulos WHERE id_titulos = ?");
$sql->execute([$id]);
$titulo = $sql->fetch(PDO::FETCH_ASSOC);

if (!$titulo) {
    die("Erro: Título não encontrado.");
}

/* ================================
   BUSCA GÊNEROS
================================ */
$generos = $pdo->query("SELECT * FROM generos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// gênero atual
$sqlGen = $pdo->prepare("SELECT fk_generos_id_generos FROM titulo_genero WHERE fk_titulos_id_titulos = ?");
$sqlGen->execute([$id]);
$generoAtual = $sqlGen->fetchColumn();

/* ================================
   PROCESSA FORMULÁRIO
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_filmes = trim($_POST['nome_filmes'] ?? '');
    $nome_serie = trim($_POST['nome_serie'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $sinopse = trim($_POST['sinopse'] ?? '');
    $generoNovo = $_POST['fk_generos_id_generos'] ?? null;

    if ($tipo === 'Filme') $nome_serie = '';
    if ($tipo === 'Série') $nome_filmes = '';

    /* Apagar imagem atual */
    $imagem = $titulo['imagem'];
    if (isset($_POST['apagar_imagem']) && $_POST['apagar_imagem'] == '1') {
        if (!empty($imagem) && file_exists("img/" . $imagem)) {
            unlink("img/" . $imagem);
        }
        $imagem = "";
    }

    /* Upload nova imagem */
    if (!empty($_FILES['nova_imagem']['name'])) {
        $nomeArq = time() . "_" . basename($_FILES['nova_imagem']['name']);
        move_uploaded_file($_FILES['nova_imagem']['tmp_name'], "img/" . $nomeArq);
        $imagem = $nomeArq;
    }

    /* Atualiza tabela titulos */
    $update = $pdo->prepare("
        UPDATE titulos 
        SET nome_filmes=?, nome_serie=?, tipo=?, sinopse=?, imagem=?
        WHERE id_titulos=?
    ");
    $update->execute([$nome_filmes, $nome_serie, $tipo, $sinopse, $imagem, $id]);

    /* Atualiza gênero */
    if ($generoNovo != null) {
        $check = $pdo->prepare("SELECT COUNT(*) FROM titulo_genero WHERE fk_titulos_id_titulos=?");
        $check->execute([$id]);

        if ($check->fetchColumn()) {
            $updateGen = $pdo->prepare("UPDATE titulo_genero SET fk_generos_id_generos=? WHERE fk_titulos_id_titulos=?");
            $updateGen->execute([$generoNovo, $id]);
        } else {
            $insertGen = $pdo->prepare("INSERT INTO titulo_genero VALUES (?, ?)");
            $insertGen->execute([$id, $generoNovo]);
        }
    }

    header("Location: listar.php?msg=atualizado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Título</title>
<style>
body {
    background: #000;
    color: #fff;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
    padding-top: 40px;
}

form {
    background: #111;
    width: 450px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 25px rgba(255, 204, 0, 0.4);
    animation: fade 0.3s ease;
}

@keyframes fade {
    from { opacity: 0; transform: translateY(-15px); }
    to   { opacity: 1; transform: translateY(0); }
}

h2 {
    text-align: center;
    color: #ffcc00;
    margin-bottom: 10px;
}

label {
    font-weight: bold;
    color: #ffcc00;
    margin-top: 10px;
    display: block;
}

input, textarea, select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 8px;
    border: 1px solid #444;
    background: #000;
    color: #fff;
    font-size: 14px;
}

button {
    background: #ffcc00;
    color: #000;
    border: none;
    padding: 12px;
    margin-top: 15px;
    width: 100%;
    border-radius: 8px;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
}

.imagem-atual {
    margin-top: 10px;
    padding: 10px;
    background: #222;
    border-radius: 8px;
    text-align: center;
}

.btn-voltar {
    position: fixed;
    top: 20px;
    left: 20px;
    border: 2px solid #ffcc00;
    background: transparent;
    color: #ffcc00;
    padding: 8px 14px;
    text-decoration: none;
    border-radius: 10px;
}

/* Campos dinâmicos de Filme/Série */
#campo-filme, #campo-serie { display:none; }
</style>
</head>
<body>

<a href="listar.php" class="btn-voltar">⬅ Voltar</a>

<form method="POST" enctype="multipart/form-data">
<h2>Editar Título</h2>

<label>Tipo:</label>
<select name="tipo" id="tipo" required>
    <option value="">Selecione...</option>
    <option value="Filme" <?= $titulo['tipo']=='Filme'?'selected':'' ?>>Filme</option>
    <option value="Série" <?= $titulo['tipo']=='Série'?'selected':'' ?>>Série</option>
</select>

<!-- CAMPO FILME -->
<div id="campo-filme">
    <label>Nome do Filme:</label>
    <input type="text" name="nome_filmes" id="nome_filmes" value="<?= htmlspecialchars($titulo['nome_filmes']) ?>">
</div>

<!-- CAMPO SÉRIE -->
<div id="campo-serie">
    <label>Nome da Série:</label>
    <input type="text" name="nome_serie" id="nome_serie" value="<?= htmlspecialchars($titulo['nome_serie']) ?>">
</div>

<label>Gênero:</label>
<select name="fk_generos_id_generos">
    <option value="">Selecione...</option>
    <?php foreach($generos as $g): ?>
        <option value="<?= $g['id_generos'] ?>" <?= $g['id_generos']==$generoAtual?'selected':'' ?>>
            <?= htmlspecialchars($g['nome']) ?>
        </option>
    <?php endforeach; ?>
</select>

<label>Sinopse:</label>
<textarea name="sinopse" rows="4"><?= htmlspecialchars($titulo['sinopse']) ?></textarea>

<label>Nova imagem (opcional):</label>
<input type="file" name="nova_imagem">

<button type="submit">Salvar alterações</button>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tipo = document.getElementById("tipo");
    const campoFilme = document.getElementById("campo-filme");
    const campoSerie = document.getElementById("campo-serie");
    const inputFilme = document.getElementById("nome_filmes");
    const inputSerie = document.getElementById("nome_serie");

    function atualizarCampos() {
        if (tipo.value === "Filme") {
            campoFilme.style.display = "block";
            campoSerie.style.display = "none";
            inputFilme.required = true;
            inputSerie.required = false;
            inputSerie.value = "";
        } else if (tipo.value === "Série") {
            campoFilme.style.display = "none";
            campoSerie.style.display = "block";
            inputSerie.required = true;
            inputFilme.required = false;
            inputFilme.value = "";
        } else {
            campoFilme.style.display = "none";
            campoSerie.style.display = "none";
            inputFilme.required = false;
            inputSerie.required = false;
        }
    }

    // Atualiza campos ao carregar a página (preenchimento existente)
    atualizarCampos();

    // Atualiza campos ao alterar o select
    tipo.addEventListener("change", atualizarCampos);
});
</script>

</body>
</html>
