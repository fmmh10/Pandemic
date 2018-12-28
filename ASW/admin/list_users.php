<?php
include('../db_config.php');

if (!isset($_COOKIE['admin'])) {
    exit();
}


$query_lista = "SELECT * FROM user";


foreach ($_POST as $pesquisar => $dados) {
    if ($pesquisar == 'procurar') {
        $coluna_a_procurar = $dados;
    }
    $query_lista = "SELECT * FROM user WHERE `$coluna_a_procurar`='$dados'";
}

$result_lista = mysqli_query($conn, $query_lista) or die();
?>
<html>
    <?php include 'consts.php'; ?>
    <?php include './headers.php'; ?>
    <body>
        <table>
            <tr>
                <th>Nº Utilizador</th><th>Nome</th><th>Apelido</th><th>Nickname</th><th>E-mail</th><th>Sexo</th><th>Data de Nascimento</th><th>País</th><th>Distrito</th><th>Concelho<th>Password</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result_lista)) { ?>
                <tr>
                    <?php
                    foreach ($row as $campo => $dados) {
                        echo "<td>" . $dados . "</td>";
                    }
                    ?>
                </tr>
                <?php
            }
            ?>


        </table>
        <form action="" method="POST">
            <label for="procurar">Procurar por:</label>
            <select name="procurar">
                <option value="nome">Nome</option>
                <option value="pais">País</option>
            </select>
            <input type="text" name="a_procurar" />
            <button type="submit">Procurar</button>
        </form>
    </body>
</html>
