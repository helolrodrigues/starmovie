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
        <a href='cadastro.php'>Fazer cadastro</a>
    </div>
    ";
    exit;
}

require 'conexao.php';

// verifica id pela URL
if (!isset($_GET['id'])) {
    die("Erro: ID não informado!");
}

$id = (int) $_GET['id']; 

try {
    // exclui as reviews
    $del_reviews = $pdo->prepare("DELETE FROM reviews WHERE fk_titulos_id_titulos = :id");
    $del_reviews->bindParam(':id', $id);
    $del_reviews->execute();

    // exclui as conexões com o genero
    $del_rel = $pdo->prepare("DELETE FROM titulo_genero WHERE fk_titulos_id_titulos = :id");
    $del_rel->bindParam(':id', $id);
    $del_rel->execute();

    // exclui o titulo
    $del_titulo = $pdo->prepare("DELETE FROM titulos WHERE id_titulos = :id");
    $del_titulo->bindParam(':id', $id);
    $del_titulo->execute();

    header("Location: listar.php?msg=excluido");
    exit;

} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}
?>
