<?php
if (!isset($_COOKIE['admin'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

    <?php include('consts.php'); ?>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-1 col-md-1">
                </div>

                <div class="col-lg-1 col-md-1">
                    <div class="user">Bem vindo, <?php echo $_COOKIE['admin'] ?>!</div>

                </div>
            </div>
        </div>

        <div class="container conteudo">
            <div class="row>">
                <div class="col-lg-2 col-md-2" >
                    <div class="row">
                        <a href="list_users.php"><button class="botaoMenu">Listar Utilizadores</button></a>
                    </div>
                    <div class="row">
                        <a href="list_jogos.php"><button class="botaoMenu">Listar Jogos</button></a>
                    </div>

                </div>

            </div>

        </div>
    </body>

</html>

