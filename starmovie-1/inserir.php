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
require 'conexao.php'; // $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Captura os campos do formulário
    $tipo = trim($_POST['tipo'] ?? '');
    $nome_filmes = trim($_POST['nome_filmes'] ?? '');
    $nome_serie = trim($_POST['nome_serie'] ?? '');
    $sinopse = trim($_POST['sinopse'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $imagem = null;

    // Validação mínima
    if ($tipo === '') {
        echo "<p style='color:red;text-align:center;'>Por favor, selecione o tipo (Filme ou Série)!</p>";
        exit;
    }

    // Limpa o campo que não vai usar
    if ($tipo === 'Filme') $nome_serie = '';
    if ($tipo === 'Série') $nome_filmes = '';

    // Upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $pastaDestino = __DIR__ . '/img/';
        if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0777, true);

        $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $caminhoDestino = $pastaDestino . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
            $imagem = 'img/' . $nomeArquivo; // caminho relativo para usar no HTML
        } else {
            echo "<p style='color:red;text-align:center;'>Erro ao mover a imagem!</p>";
            exit;
        }
    }

    try {
        // Insere o título no banco
        $sql = "INSERT INTO titulos (nome_filmes, nome_serie, tipo, sinopse, imagem)
                VALUES (:nome_filmes, :nome_serie, :tipo, :sinopse, :imagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_filmes', $nome_filmes);
        $stmt->bindParam(':nome_serie', $nome_serie);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':sinopse', $sinopse);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->execute();

        $id_titulo = $pdo->lastInsertId();

        // Inserir/associar gênero
        if ($genero !== '') {
            // verifica se já existe
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

        // Redireciona para a listagem
        header("Location: listar.php?msg=inserido");
        exit;

    } catch (PDOException $e) {
        echo "<p style='color:red;text-align:center;'>Erro ao inserir título: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// ======= BUSCAR GÊNEROS EXISTENTES =======
$generosExistentes = [];
try {
    $stmt = $pdo->query("SELECT nome FROM generos ORDER BY nome ASC");
    $generosExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo "<p style='color:red;text-align:center;'>Erro ao carregar gêneros: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Adicionar novo título</title>
<style>
body { background-color:#000; color:#fff; font-family:Arial,sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
form { background-color:#111; padding:25px; border-radius:10px; box-shadow:0 0 15px #ffcc00; width:400px; }
h2 { text-align:center; color:#ffcc00; }
input, textarea, select { width:100%; padding:8px; margin:8px 0; border-radius:5px; border:none; }
button { background:#ffcc00; color:#000; padding:10px; border-radius:5px; border:none; cursor:pointer; width:100%; }
button:hover { background:#fff200; }
.btn-voltar { position:absolute; top:20px; left:20px; background:#111; color:#ffcc00; border:2px solid #ffcc00; padding:8px 14px; border-radius:8px; text-decoration:none; font-weight:bold;}
.btn-voltar:hover{ background:#ffcc00; color:#000; }
</style>
</head>
<body>

<a href="index.php" class="btn-voltar">⬅ Voltar</a>

<form method="POST" enctype="multipart/form-data">
<h2>Adicionar título</h2>

<label>Tipo:</label>
<select name="tipo" required>
    <option value="">Selecione...</option>
    <option value="Filme">Filme</option>
    <option value="Série">Série</option>
</select>

<label>Nome do Filme:</label>
<input type="text" name="nome_filmes" placeholder="Digite o nome do filme">

<label>Nome da Série:</label>
<input type="text" name="nome_serie" placeholder="Digite o nome da série">

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

</body>
</html>
