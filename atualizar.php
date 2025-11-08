<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .msg {
            background-color: #111;
            border: 2px solid #ffcc00;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px #ffcc00;
            width: 350px;
        }
        a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: #fff200;
        }
    </style>
    <div class='msg'>
        <h2>⚠️ Acesso restrito!</h2>
        <p>Você precisa se conectar para acessar esta página.</p>
        <a href='cadastro.php'>Fazer login</a>
    </div>
    ";
    exit;
}

require 'conexao.php';

if (!isset($_GET['id'])) die("Erro: Nenhum ID informado!");
$id = (int)$_GET['id'];

// Busca o título
try {
    $stmt = $pdo->prepare("SELECT * FROM titulos WHERE id_titulos = :id");
    $stmt->execute([':id' => $id]);
    $titulo = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$titulo) die("Erro: Título não encontrado.");

    // Pega o gênero atual
    $stmtGenero = $pdo->prepare("SELECT fk_generos_id_generos FROM titulo_genero WHERE fk_titulos_id_titulos = :id LIMIT 1");
    $stmtGenero->execute([':id' => $id]);
    $generoAtual = $stmtGenero->fetchColumn();
    $generoAtual = ($generoAtual !== false) ? (int)$generoAtual : null;

    // Todos os gêneros
    $generos = $pdo->query("SELECT id_generos, nome FROM generos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar dados: " . htmlspecialchars($e->getMessage()));
}

// Atualiza quando envia o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_filmes = trim($_POST['nome_filmes'] ?? '');
    $nome_serie = trim($_POST['nome_serie'] ?? '');
    $tipo = $_POST['tipo'] ?? '';
    $sinopse = trim($_POST['sinopse'] ?? '');
    $imagem = $titulo['imagem'] ?? '';
    $generoSelecionado = !empty($_POST['fk_generos_id_generos']) ? (int)$_POST['fk_generos_id_generos'] : null;

    if ($tipo === 'Filme') $nome_serie = '';
    if ($tipo === 'Série') $nome_filmes = '';

    // Apagar imagem
    if (isset($_POST['apagar_imagem']) && $_POST['apagar_imagem'] === '1') {
        if (!empty($titulo['imagem']) && file_exists('img/' . $titulo['imagem'])) {
            @unlink('img/' . $titulo['imagem']);
        }
        $imagem = '';
    }

    try {
        // Atualiza título
        $stmt = $pdo->prepare("UPDATE titulos 
                               SET nome_filmes = :nome_filmes, 
                                   nome_serie = :nome_serie, 
                                   tipo = :tipo, 
                                   sinopse = :sinopse, 
                                   imagem = :imagem 
                               WHERE id_titulos = :id");
        $stmt->execute([
            ':nome_filmes' => $nome_filmes,
            ':nome_serie' => $nome_serie,
            ':tipo' => $tipo,
            ':sinopse' => $sinopse,
            ':imagem' => $imagem,
            ':id' => $id
        ]);

        // Atualiza ou insere gênero
        if ($generoSelecionado !== null) {
            $existe = $pdo->prepare("SELECT COUNT(*) FROM titulo_genero WHERE fk_titulos_id_titulos = :id");
            $existe->execute([':id'=>$id]);
            if ($existe->fetchColumn()) {
                $stmt = $pdo->prepare("UPDATE titulo_genero SET fk_generos_id_generos = :genero WHERE fk_titulos_id_titulos = :id");
                $stmt->execute([':genero'=>$generoSelecionado, ':id'=>$id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO titulo_genero (fk_titulos_id_titulos, fk_generos_id_generos) VALUES (:id, :genero)");
                $stmt->execute([':id'=>$id, ':genero'=>$generoSelecionado]);
            }
        }

        header("Location: inserir.php?msg=atualizado"); // volta para inserir.php
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar título: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Atualizar título</title>
<style>
body {
    background-color:#000;
    color:#fff;
    font-family:Arial,sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
form {
    background-color:#111;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 15px #ffcc00;
    width:400px;
}
h2 {text-align:center;color:#ffcc00;}
input, textarea, select {width:100%;padding:8px;margin:8px 0;border-radius:5px;border:none;}
button {background-color:#ffcc00;color:#000;border:none;padding:10px;border-radius:5px;cursor:pointer;width:100%;}
button:hover {background-color:#fff200;}
.imagem-atual img {border-radius:5px;margin-bottom:5px;display:block;}
.imagem-atual label {font-size:0.9em;}
.btn-voltar {
    position:fixed;
    top:15px;
    left:15px;
    background:#111;
    color:#ffcc00;
    border:2px solid #ffcc00;
    padding:6px 12px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}
.btn-voltar:hover {background:#ffcc00;color:#000;}
</style>
</head>
<body>

<a href="index.php" class="btn-voltar">⬅ Voltar</a>

<form method="POST" enctype="multipart/form-data">
<h2>Atualizar título</h2>

<label>Nome do Filme</label>
<input type="text" name="nome_filmes" value="<?= htmlspecialchars($titulo['nome_filmes'] ?? '') ?>">

<label>Nome da Série</label>
<input type="text" name="nome_serie" value="<?= htmlspecialchars($titulo['nome_serie'] ?? '') ?>">

<label>Tipo</label>
<select name="tipo" required>
    <option value="">Selecione...</option>
    <option value="Filme" <?= ($titulo['tipo']==='Filme')?'selected':'' ?>>Filme</option>
    <option value="Série" <?= ($titulo['tipo']==='Série')?'selected':'' ?>>Série</option>
</select>

<label>Gênero</label>
<select name="fk_generos_id_generos" required>
    <option value="">Selecione um gênero...</option>
    <?php foreach($generos as $g){
        $selected = ($generoAtual==$g['id_generos'])?'selected':'';
        echo '<option value="'.$g['id_generos'].'" '.$selected.'>'.$g['nome'].'</option>';
    } ?>
</select>

<label>Sinopse</label>
<textarea name="sinopse" rows="4"><?= htmlspecialchars($titulo['sinopse'] ?? '') ?></textarea>

<label>Imagem atual:</label>
<div class="imagem-atual">
    <?php
    $caminhoImagem = !empty($titulo['imagem']) ? 'img/' . $titulo['imagem'] : '';
    if (!empty($titulo['imagem']) && file_exists($caminhoImagem)): ?>
        <img src="<?= htmlspecialchars($caminhoImagem) ?>" width="120">
        <label><input type="checkbox" name="apagar_imagem" value="1"> Apagar imagem atual</label>
    <?php else: ?>
        <p>Nenhuma imagem cadastrada.</p>
    <?php endif; ?>
</div>

<button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
