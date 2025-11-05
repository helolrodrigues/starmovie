<?php
require 'conexao.php';

// Verifica se veio o ID pela URL
if (isset($_GET['id_titulo'])) {
    $id = $_GET['id_titulo'];

    // Busca o título no banco
    $sql = "SELECT * FROM titulos WHERE id_titulo = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $filme = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se não encontrou o registro, exibe mensagem
    if (!$filme) {
        echo "<p><b>Erro:</b> Nenhum título encontrado com esse ID.</p>";
        exit;
    }
} else {
    echo "<p><b>Erro:</b> Nenhum ID informado.</p>";
    exit;
}

// Atualização quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id_titulo'];
    $nome_serie = $_POST['nome_serie'];
    $nome_filmes = $_POST['nome_filmes'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE titulos 
            SET nome_serie = :nome_serie, nome_filmes = :nome_filmes, tipo = :tipo 
            WHERE id_titulo = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_serie', $nome_serie);
    $stmt->bindParam(':nome_filmes', $nome_filmes);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Título atualizado com sucesso!'); window.location='listar.php';</script>";
        exit;
    } else {
        echo "<p>Erro ao atualizar título.</p>";
    }
}
?>

<h2>Editar Título</h2>
<form method="POST">
    <input type="hidden" name="id_titulo" value="<?= htmlspecialchars($filmes['id_titulo']) ?>">

    <label>Série:</label><br>
    <input type="text" name="nome_serie" value="<?= htmlspecialchars($filmes['nome_serie']) ?>"><br><br>

    <label>Filme:</label><br>
    <input type="text" name="nome_filmes" value="<?= htmlspecialchars($filmes['nome_filmes']) ?>"><br><br>

    <label>Tipo:</label><br>
    <input type="text" name="tipo" value="<?= htmlspecialchars($filmes['tipo']) ?>"><br><br>

    <button type="submit">Salvar alterações</button>
</form>
