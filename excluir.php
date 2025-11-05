
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
require 'conexao.php';

if (isset($_GET['id_titulo'])) {
    $id = $_GET['id_titulo'];

    $sql = "DELETE FROM titulos WHERE id_titulo = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Título excluído com sucesso!'); window.location='listar.php';</script>";
    } else {
        echo "<p>Erro ao excluir título.</p>";
    }
} else {
    echo "<p>ID não informado.</p>";
}
?>
