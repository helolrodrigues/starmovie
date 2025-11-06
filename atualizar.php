<?php
require 'conexao.php';

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    die("Erro: Nenhum ID informado.");
}

$id = (int) $_GET['id'];

// Busca o título no banco
try {
    $sql = "SELECT * FROM titulos WHERE id_titulos = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $titulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$titulo) {
        die("Erro: Título não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar título: " . $e->getMessage());
}

// Atualiza quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_filmes = $_POST['nome_filmes'] ?? '';
    $nome_serie = $_POST['nome_serie'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $imagem = $titulo['imagem']; // mantém imagem antiga se não trocar

    // 🔥 Se o usuário marcou “Apagar imagem”
    if (isset($_POST['apagar_imagem']) && $_POST['apagar_imagem'] === '1') {
        if (!empty($titulo['imagem']) && file_exists('img/' . $titulo['imagem'])) {
            unlink('img/' . $titulo['imagem']); // apaga do servidor
        }
        $imagem = ''; // limpa o campo no banco
    }

    // 📸 Se enviou nova imagem
    if (!empty($_FILES['imagem']['name'])) {
        $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $caminhoDestino = 'img/' . $nomeArquivo;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
            // Se já tinha imagem antiga, apaga do servidor
            if (!empty($titulo['imagem']) && file_exists('img/' . $titulo['imagem'])) {
                unlink('img/' . $titulo['imagem']);
            }
            $imagem = $nomeArquivo;
        }
    }

    try {
        $sql = "UPDATE titulos 
                SET nome_filmes = :nome_filmes, 
                    nome_serie = :nome_serie, 
                    tipo = :tipo, 
                    sinopse = :sinopse, 
                    imagem = :imagem 
                WHERE id_titulos = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_filmes', $nome_filmes);
        $stmt->bindParam(':nome_serie', $nome_serie);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':sinopse', $sinopse);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: listar.php?msg=atualizado");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar título: " . $e->getMessage();
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
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #111;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px #ffcc00;
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #ffcc00;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 5px;
            border: none;
        }
        button {
            background-color: #ffcc00;
            color: #000;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #fff200;
        }
        .imagem-atual img {
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .imagem-atual label {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Atualizar título</h2>

        <label>Nome do Filme</label>
        <input type="text" name="nome_filmes" value="<?= htmlspecialchars($titulo['nome_filmes']) ?>">

        <label>Nome da Série</label>
        <input type="text" name="nome_serie" value="<?= htmlspecialchars($titulo['nome_serie']) ?>">

        <label>Tipo</label>
        <select name="tipo" required>
            <option value="">Selecione...</option>
            <option value="Filme" <?= $titulo['tipo'] === 'Filme' ? 'selected' : '' ?>>Filme</option>
            <option value="Série" <?= $titulo['tipo'] === 'Série' ? 'selected' : '' ?>>Série</option>
        </select>

        <label>Sinopse</label>
        <textarea name="sinopse" rows="4"><?= htmlspecialchars($titulo['sinopse']) ?></textarea>

<label>Imagem atual:</label>
<div class="imagem-atual">
    <?php if (!empty($titulo['imagem'])): ?>
        <img src="img/<?= htmlspecialchars($titulo['imagem']) ?>" width="120"><br>
        <label><input type="checkbox" name="apagar_imagem" value="1"> Apagar imagem atual</label>
    <?php else: ?>
        <p>Nenhuma imagem cadastrada.</p>
    <?php endif; ?>
</div>

        <label>Nova imagem (opcional):</label>
        <input type="file" name="imagem">

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
