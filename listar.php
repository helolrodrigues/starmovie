<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require 'conexao.php';

$sql = "SELECT * FROM titulos";
$stmt = $pdo->query($sql);

echo "<h1>Lista de Títulos</h1>";

while ($filme = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div style='margin-bottom:15px; border-bottom:1px solid #ccc;'>";
    echo "<strong>Série:</strong> " . $filme['nome_serie'] . "<br>";
    echo "<strong>Filme:</strong> " . $filme['nome_filmes'] . "<br>";
    echo "<strong>Tipo:</strong> " . $filme['tipo'] . "<br>";
    echo "</div>";
}
?>
