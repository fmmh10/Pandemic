<?php
include ('functions.php');
if (verificaLoginUser()) {
    header('Location: homepage.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pandemic</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="styles/style.css"/>
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="script.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <a href="index.php  "><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>
        <div id="logs">
            <button id="botao_login" onclick="document.getElementById('id01').style.display = 'block'">Login</button>
            <button onclick="location.href = 'register.php'">Register</button>
        </div>

        <?php include('login.php'); ?>


    </body>
</html>
