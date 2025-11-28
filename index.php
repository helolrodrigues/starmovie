<?php session_start(); ?>
<?php include("header.php"); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<main>

  <h2>Filmes em destaque</h2>

  <div class="filmes">
    <div class="card" data-bs-toggle="modal" data-bs-target="#modal1">
      <img src="img/divertidamente.jpeg" alt="Divertidamente">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal2">
      <img src="img/coraline.jpg" alt="Coraline">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal3">
      <img src="img/caramelo.jpg" alt="Caramelo">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal4">
      <img src="img/chocolate.webp" alt="A fantástica fábrica de chocolate">
      <h5 class="card-title">Saiba mais</h5>
    </div>


    <div class="card" data-bs-toggle="modal" data-bs-target="#modal5">
      <img src="img/elaeoscaras.webp" alt="Ela e os caras">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal6">
      <img src="img/invocacao.webp" alt="Invocação do mal 4">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal7">
      <img src="img/donzela.jpg" alt="Donzela">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal8">
      <img src="img/titanic.jpg" alt="Titanic">
      <h5 class="card-title">Saiba mais</h5>
    </div>
  </div>

  
  <h2 class="mt-5">Séries em destaque</h2>

  <div class="series">
  
    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal1">
      <img src="img/round6.webp" alt="Round 6">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal2">
      <img src="img/sintonia.jpg" alt="Sintonia">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal3">
      <img src="img/obx.jpg" alt="Outer Banks">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal4">
      <img src="img/b99.jpg" alt="Brooklyn Nine-Nine">
      <h5 class="card-title">Saiba mais</h5>
    </div>


    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal5">
      <img src="img/ga.jpg" alt="Grey's Anatomy">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal6">
      <img src="img/st.jpg" alt="Stranger Things">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal7">
      <img src="img/gg.jpg" alt="Gossip Girl">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#smodal8">
      <img src="img/friends.jpg" alt="Friends">
      <h5 class="card-title">Saiba mais</h5>
    </div>
  </div>

  <!-- botao para inserir novo titulo -->
  <div class="text-center mt-4">
    <a href="inserir.php" class="btn btn-warning btn-lg">Inserir novo título</a>
  </div>

  <!-- caixa com informações dos filmes -->
  <?php
  $filmes = [
      ['id'=>'modal1','titulo'=>'Divertidamente','img'=>'divertidamente.jpeg','desc'=>"Ano: 2024<br>Gênero: Infantil, Comédia<br>Descrição:Com um salto temporal, Riley se encontra mais velha, passando pela tão temida adolescência. Junto com o amadurecimento, a sala de controle também está passando por uma adaptação para dar lugar a algo totalmente inesperado: novas emoções. As já conhecidas, Alegria, Raiva, Medo, Nojinho e Tristeza não têm certeza de como se sentir quando novos inquilinos chegam ao local."],
      ['id'=>'modal2','titulo'=>'Coraline','img'=>'coraline.jpg','desc'=>"Ano: 2009<br>Gênero: Animação, Fantasia<br>Descrição: Coraline descobre uma porta secreta que a leva para um mundo alternativo."],
      ['id'=>'modal3','titulo'=>'Caramelo','img'=>'caramelo.jpg','desc'=>"Ano: 2025<br>Gênero: Drama, Comédia<br>Descrição: Conta a história de Pedro, um chef prestes a realizar seu sonho, que enfrenta um diagnóstico inesperado e precisa reavaliar sua vida. Ele encontra apoio em um vira-lata caramelo chamado Amendoim, e juntos enfrentam desafios, construindo uma amizade inspiradora. Gravado em São Paulo e dirigido por Diego Freitas, o filme celebra a superação, o afeto e o companheirismo."],
      ['id'=>'modal4','titulo'=>'A Fantástica fábrica de chocolate','img'=>'chocolate.webp','desc'=>"Ano: 2005<br>Gênero: Família, Fantasia<br>Descrição: Charlie ganha um bilhete dourado para visitar a fábrica de chocolate de Willy Wonka."],
      ['id'=>'modal5','titulo'=>'Ela e os caras','img'=>'elaeoscaras.webp','desc'=>"Ano: 2020<br>Gênero: Comédia<br>Descrição: Uma mulher decide se envolver com um grupo de homens para ganhar confiança."],
      ['id'=>'modal6','titulo'=>'Invocação do mal 4','img'=>'invocacao.webp','desc'=>"Ano: 2023<br>Gênero: Terror, Suspense<br>Descrição: Os investigadores Ed e Lorraine enfrentam uma nova ameaça demoníaca."],
      ['id'=>'modal7','titulo'=>'Donzela','img'=>'donzela.jpg','desc'=>"Ano: 2018<br>Gênero: Drama, Romance<br>Descrição: Uma jovem enfrenta desafios para encontrar seu verdadeiro amor."],
      ['id'=>'modal8','titulo'=>'Titanic','img'=>'titanic.jpg','desc'=>"Ano: 1997<br>Gênero: Romance, Drama<br>Descrição: A história de Jack e Rose a bordo do Titanic."],
  ];

  foreach($filmes as $filme): ?>
    <div class="modal fade" id="<?= $filme['id'] ?>" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?= $filme['titulo'] ?></h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img src="img/<?= $filme['img'] ?>" class="img-fluid" alt="<?= $filme['titulo'] ?>">
            <p><?= $filme['desc'] ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- caixa com informações das series -->
  <?php
  $series = [
      ['id'=>'smodal1','titulo'=>'Round 6','img'=>'round6.webp','desc'=>"Ano: 2021<br>Gênero: Drama, Suspense<br>Descrição: Participantes competem em jogos mortais por um prêmio em dinheiro."],
      ['id'=>'smodal2','titulo'=>'Sintonia','img'=>'sintonia.jpg','desc'=>"Ano: 2019<br>Gênero: Drama, Música<br>Descrição: A vida de três jovens em diferentes caminhos dentro da favela."],
      ['id'=>'smodal3','titulo'=>'Outer Banks','img'=>'obx.jpg','desc'=>"Ano: 2020<br>Gênero: Aventura, Drama<br>Descrição: Adolescente e amigos descobrem um tesouro escondido e enfrentam rivais."],
      ['id'=>'smodal4','titulo'=>'Brooklyn Nine-Nine','img'=>'b99.jpg','desc'=>"Ano: 2013<br>Gênero: Comédia, Policial<br>Descrição: Um grupo de detetives enfrenta casos e confusões na delegacia de Brooklyn."],
      ['id'=>'smodal5','titulo'=>'Grey\'s Anatomy','img'=>'ga.jpg','desc'=>"Ano: 2005<br>Gênero: Drama, Médico<br>Descrição: Médicos do Grey Sloan Memorial Hospital lidam com vida pessoal e casos clínicos."],
      ['id'=>'smodal6','titulo'=>'Stranger Things','img'=>'st.jpg','desc'=>"Ano: 2016<br>Gênero: Ficção, Mistério<br>Descrição: Crianças enfrentam eventos sobrenaturais em sua cidade."],
      ['id'=>'smodal7','titulo'=>'Lucifer','img'=>'lucifer.jpg','desc'=>"Ano: 2016<br>Gênero: Drama, Policial, Fantasia<br>Descrição: Lúcifer Morningstar ajuda a polícia de Los Angeles a resolver crimes."],
      ['id'=>'smodal8','titulo'=>'Friends','img'=>'friends.jpg','desc'=>"Ano: 1994<br>Gênero: Comédia, Romance<br>Descrição: A vida de seis amigos em Nova York e suas aventuras pessoais e profissionais."],
  ];
// conecta as imagens dos modais e cards 
  foreach($series as $serie): ?>
    <div class="modal fade" id="<?= $serie['id'] ?>" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?= $serie['titulo'] ?></h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img src="img/<?= $serie['img'] ?>" class="img-fluid" alt="<?= $serie['titulo'] ?>">
            <p><?= $serie['desc'] ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</main>

<?php include("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
  body { 
    background: #000; 
    color: #fff; 
    font-family: Arial, sans-serif; 
    margin: 0; 
    padding: 20px; 
  }

  h2 { 
    text-align: center; 
    color: #ffcc00; 
    margin-bottom: 30px; 
  }

  .filmes, .series {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto 50px auto;
  }

  .card {
    text-align: center;
    cursor: pointer;
  }

  .card img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .card img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(255,204,0,0.5);
  }

  .card-title {
    margin-top: 8px;
    font-size: 1rem;
    color: #ffcc00;
  }

  .modal-content {
    background: #111;
    color: #fff;
    border-radius: 12px;
  }

  .modal-body img {
    border-radius: 10px;
    margin-bottom: 15px;
  }

  .btn-close-white {
    filter: invert(1);
  }

  .btn-warning {
    background-color: #ffcc00;
    border-color: #ffcc00;
    color: #000;
    font-weight: bold;
    padding: 10px 25px;
    transition: transform 0.2s;
  }

  .btn-warning:hover {
    transform: scale(1.05);
    color: #000;
  }
</style>
