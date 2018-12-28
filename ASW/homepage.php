<!DOCTYPE html>
<html>
    <?php
    include('headers.php');
    include('functions.php');
    ?>
    <body>
        <header>
            <a href="index.php"><img id="logo" src="fundo.jpg"/></a>
            <h1 id="title">PANDEMIC</h1>
        </header>
        <?php if (verificaLoginUser()) {
            ?>
            <div id="logs">
                <a href="user_dash.php"><img class="icone" src="img_avatar2.png" style="width: 100px height: 100px" alt="Avatar"></a>
                <button id="botao_logout" href="index.php">Logout</button>
            </div>

            <div class="container">
                <div class="col-lg-12">
                    <button type="button" style="width: 500px; margin-left: 175px; margin-top: 50px;" class="btn btn-primary btn-lg" onclick="location.href = 'criar_jogo.php'">Criar jogo</button>
                    <button type="button" style="width: 500px; margin-left: 175px;" class="btn btn-primary btn-lg" onclick="location.href = 'lista_jogos.php'">Juntar-me a jogo</button>
                    <button type="button" style="width: 500px; margin-left: 175px;" class="btn btn-primary btn-lg" onclick="location.href = 'meus_jogos.php'">Os meus jogos</button>
                </div>
            </div>
            <?php
        } else {
            header('Location: index.php');
        }
        ?>

        <script type="text/javascript">
            $('#botao_logout').click(function () {
                window.location.replace("log_out.php");
            })

        </script>

    </body>
</html>
