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

    <style>
        /* ===== Estilos gerais ===== */
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
            padding: 15px 60px;
        }

        main {
           display: flex;
           flex-direction: column;
           align-items: center;
           justify-content: center;
           text-align: center;
           padding: 40px 20px;
           font-size: 1.2rem;
}
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
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

        .search-login input[type="text"] {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
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
        .carousel-item img { 
        max-height: 350px ;
        width: 100%;
        }

    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="img/logo.png" alt="Starmovie Logo">
        <h1 style="color: #ffcc00;">Starmovie</h1>
    </div>

        <nav class="menu">
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
        <a href="cadastro.php" class="btn-login">Fazer login</a>
    <?php endif; ?>
</div>
</header>
     <main>
    <h2>Sobre o Starmovie</h2>
    <p>O Starmovie nasceu com a proposta de oferecer um ambiente moderno e fácil de usar para amantes do cinema.  
       Aqui você encontra avaliações, notas e informações sobre filmes de diversos gêneros.  
       Nosso objetivo é ajudar você a decidir o que assistir e compartilhar suas impressões com outros usuários.
    <p>Este site também faz parte de um projeto desenvolvido na matéria de SW  
      da Escola Maria Cristina Medeiros, onde buscamos aplicar nossos  
      conhecimentos em desenvolvimento web criando uma plataforma prática,  
      intuitiva e voltada para os fãs de cinema.
    </p>
    </p>
    <div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/etecc.jpeg" class="d-block w-100" alt="ETEC Maria Cristina Medeiros">
      <div class="carousel-caption d-none d-md-block">
        <h5>ETEC Maria Cristina Medeiros</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>

    </div>
  </div>
</div>
     </main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> STARMOVIE - Desenvolvido pela Equipe Etecflix🎬</p>
</footer>