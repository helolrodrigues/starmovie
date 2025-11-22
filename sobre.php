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
           align-items: flex-start;
           justify-content: center;
           padding: 40px 20px;
           font-size: 1.2rem;
           text-align: left;
           max-width: 1300px;
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
        .center-img {
            align-self: center;
            max-width: 40%;
            height: auto;
            display: block;
            margin: 30px 0; 
        }
    /* Estiliza o título */
        .h2 {
            color: #ddb71fff;         
            position: relative;      /* Permite posicionar o ::after em relação ao título */
            display: inline-block;   /* Faz o título ocupar apenas a largura do texto */
            padding-bottom: 10px;    /* Espaço entre o texto e a linha vermelha */
            text-align: left;
            display: block; /* isso força o h2 a ocupar a largura toda */
}


/* Cria a linha vermelha decorativa embaixo do título */
        .h2::after {
           content: "";             /* Cria um elemento vazio para se transformar na linha */
           position: absolute;      /* Permite posicionar a linha livremente */
           bottom: 0;               /* Coloca a linha exatamente na parte inferior do título */
           left: 50%;               /* Posiciona o centro da linha no meio do título */
           transform: translateX(-50%); /* Ajusta a linha para ficar centralizada */
           width: 60%;              /* Tamanho da linha (60% da largura do texto) */
           height: 3px;             /* Espessura da linha */
           background: red;   
     
        }
        .footer{
            text-align: center;

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
    <h2 class="h2">Sobre o Starmovie</h2>
    <p>O Starmovie nasceu com a proposta de oferecer um ambiente moderno e fácil de usar para amantes do cinema.  
       Aqui você encontra avaliações, notas e informações sobre filmes de diversos gêneros.  
       Nosso objetivo é ajudar você a decidir o que assistir e compartilhar suas impressões com outros usuários.
    
    </p>
       </p>
    <h2 class="h2">Nossa missão</h2>
    <p>Nossa missão é transformar a forma como você descobre novos filmes, oferecendo um ambiente moderno, rápido e intuitivo. Queremos que
        cada usuário tenha uma experiência simples e agradável ao explorar o universo do cinema.
    </p>
    <h2 class="h2">Propósito do Starmovie</h2>
    <p>Acreditamos que o cinema aproxima pessoas, inspira histórias e desperta emoções. Por isso, nosso propósito é oferecer
        um espaço onde todos possam expressar seu amor pelo cinema de forma simples e divertida.
    </p>


        <h2 class="h2">Nosso projeto e equipe</h2>
    <p>Este site também faz parte de um projeto desenvolvido na matéria de SW  
      da Escola Maria Cristina Medeiros, onde buscamos aplicar nossos  
      conhecimentos em desenvolvimento web criando uma plataforma prática,  
      intuitiva e voltada para os fãs de cinema.
    </p>
    <img src="img/nos.jpeg" class="img-fluid center-img" alt="...">
    
</div>
     </main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> STARMOVIE - Desenvolvido pela Equipe Etecflix🎬</p>
</footer>