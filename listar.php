<?php
require 'conexao.php'; 

$sql = "SELECT * FROM starmovie";
$stmt = $pdo->query($sql);

while ($filme = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<strong>ID:</strong> " . $filme['id'] . "<br>";
    echo "<strong>Título:</strong> " . $filme['titulo'] . "<br>";
    echo "<strong>Gênero:</strong> " . $filme['genero'] . "<br>";
    echo "<strong>Ano:</strong> " . $filme['ano'] . "<br>";
    echo "<strong>Sinopse:</strong> " . $filme['sinopse'] . "<br>";
    echo "<strong>Nota:</strong> " . $filme['nota'] . "<br><br>";
}
?>
