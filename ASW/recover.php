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
            <a href="index.php"><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>
        <div class="registo">
            <h2>Recover</h2>
            <form action="send_recover.php" method="post" id="registar">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" required>
                    <br>
                    <button type="submit" onclick="" class="btn btn-default">Enviar</button>
                </div>
            </form>
        </div>

    </body>
</html>
