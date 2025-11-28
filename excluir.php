<?php
session_start();

// verifica se a variavel criada existe
if (!isset($_SESSION['usuario'])) {
    // mensagem estilizada sobre acesso restrito
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

// carrega a conexão com o banco
require 'conexao.php';

// verifica se o id de usuario será exxcluido pela URL
if (!isset($_GET['id'])) {
    die("Erro: ID não informado!");
}

// converte o id para numero
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

    // exclui o titulo da tabela principal
    $del_titulo = $pdo->prepare("DELETE FROM titulos WHERE id_titulos = :id");
    $del_titulo->bindParam(':id', $id);
    $del_titulo->execute();

    // redireciona para o listar
    header("Location: listar.php?msg=excluido");
    exit;
// se acontecer algum erro, mostra uma mensagem em vez do sistema quebrar
} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}
?>
