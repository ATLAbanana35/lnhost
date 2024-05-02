<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liste des Applications</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header>
        <h1>Liste des Applications</h1>
    </header>
    <main>
        <section class="app">
            <h2>LNHost panel</h2>
            <p>Gérer vos apps</p>
            <a href="lnhost">Accéder à LNhost</a>
        </section>
        <?php
if (is_dir("nextcloud")) {
  echo '      <section class="app">
  <img src="lnhost/assets/nc.png" alt="NextCloud Icon" />
  <h2>NextCloud</h2>
  <p>Un cloud multifonctionnel</p>
  <a href="nextcloud">Accéder à NextCloud</a>
</section>';
}
if (is_dir("kchat")) {
  echo '      <section class="app">
  <img src="lnhost/assets/kchat.svg" alt="KChat Icon" />
  <h2>KChat</h2>
  <p>Un chat fonctionnel, avec plusieurs bonnes fonctionnalités</p>
  <a href="kchat">Accéder à KChat</a>
</section>';
}
if (is_dir("wordpress")) {
  echo '      <section class="app">
  <img src="lnhost/assets/wp.png" alt="WordPress Icon" />
  <h2>WordPress</h2>
  <p>Un CMS pour site webs</p>
  <a href="wordpress">Accéder à WordPress</a>
</section>';
}
if (is_dir("serendipity")) {
  echo '      <section class="app">
  <img src="lnhost/assets/serendipity.png" alt="Serendipity Icon" />
  <h2>Serendipity</h2>
  <p>Un CMS pour blog</p>
  <a href="serendipity">Accéder à Serendipity</a>
</section>';
}
?>

        <!-- Ajoutez d'autres sections pour chaque application -->
    </main>
    <footer>
        <p>Created by Loines</p>
    </footer>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    header,
    footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 1rem;
    }

    main {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
    }

    .app {
        width: 300px;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        text-align: center;
    }

    .app img {
        max-width: 100px;
        max-height: 100px;
    }

    a {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #333;
        background-color: #eee;
        padding: 8px;
        border-radius: 4px;
    }

    a:hover {
        background-color: #ddd;
    }
    </style>
</body>

</html>