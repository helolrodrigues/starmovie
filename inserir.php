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
        <a href='login.php'>Fazer login</a>
    </div>
    ";
    exit;
}

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_serie = $_POST['nome_serie'] ?? '';
    $nome_filmes = $_POST['nome_filmes'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $imagem = '';

    // Faz o upload se o arquivo foi enviado
    if (!empty($_FILES['imagem']['name'])) {
        $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $caminhoDestino = 'img/' . $nomeArquivo;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
            $imagem = $nomeArquivo;
        } else {
            echo "<p style='color:red;text-align:center;'>Erro ao enviar imagem!</p>";
        }
    }

    if (!empty($tipo) && (!empty($nome_filmes) || !empty($nome_serie))) {
        try {
            $sql = "INSERT INTO titulos (nome_serie, nome_filmes, tipo, sinopse, imagem)
                    VALUES (:nome_serie, :nome_filmes, :tipo, :sinopse, :imagem)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome_serie', $nome_serie);
            $stmt->bindParam(':nome_filmes', $nome_filmes);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':sinopse', $sinopse);
            $stmt->bindParam(':imagem', $imagem);
            $stmt->execute();

            header("Location: listar.php?msg=inserido");
            exit;
        } catch (PDOException $e) {
            echo "<p style='color:red;text-align:center;'>Erro ao inserir título: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;text-align:center;'>Por favor, preencha o nome e selecione o tipo!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar novo título</title>
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
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Adicionar novo título</h2>

        <label>Nome do Filme:</label>
        <input type="text" name="nome_filmes" placeholder="Digite o nome do filme">

        <label>Nome da Série:</label>
        <input type="text" name="nome_serie" placeholder="Digite o nome da série">

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="">Selecione...</option>
            <option value="Filme">Filme</option>
            <option value="Série">Série</option>
        </select>

        <label>Sinopse:</label>
        <textarea name="sinopse" rows="4" placeholder="Digite aqui a sinopse..."></textarea>

        <label>Imagem (capa):</label>
        <input type="file" name="imagem">

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
