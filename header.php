<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Starmovie</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/logo.jpeg">


    <style>
        body {
            margin: 0;
            background-color: #000;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            background-color: #111;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 60px; 
            border-radius: 8px;
        }

        nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 40px; 
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffcc00;
        }

        .search-login {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-login {
            background-color: #c00;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #ff0000;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="img/logo.png" alt="Starmovie Logo">
        <h1 style="color: #ffcc00; margin:0;">Starmovie</h1>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="inserir.php">Inserir</a></li>
            <li><a href="listar.php">Listar</a></li>
        </ul>
    </nav>

    <div class="search-login">
        <?php if (isset($_SESSION['usuario'])): ?>
            <span>Olá, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span>
            <a href="logout.php" class="btn-login">Sair</a>
        <?php else: ?>
            <a href="cadastro.php" class="btn-login">Fazer cadastro</a>
        <?php endif; ?>
    </div>
</header>
