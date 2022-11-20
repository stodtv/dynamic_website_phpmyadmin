<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>[Články] Drsná Stránka</title>
    <meta charset="windows-1260">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="all">
    <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
    <link href="/favicon.ico" rel="shortcut icon" type="icon/ico">
    <link rel="stylesheet" href="styly.css" type="text/css">

<body>
    <?php
    $anticringe = 0;
    ?>
    <section class="login">

        <form method="post" class="bottom">Kolik článků chcete zobrazit? (Základ 20) <input class="smolform" type="text" name="kolikclankui" size=3 /> <input class="loginbutton" type="submit" name="kolikclanku" value="Obnovit"></form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            if (isset($_POST['kolikclanku'])) {
                if ($_POST['kolikclankui'] < 1) {
                    $zprava = 'Číslo musí být větší než 0';
        ?>
                    <section class="reddivv">

                        <?php echo $zprava; ?>

                    </section>
        <?php
                } else {
                    $anticringe = 1;
                    $limit = $_POST['kolikclankui'];
                }
            }
        }

        ?>

    </section>

    <section class="mainn">

        <header>
            <p class="zacatek">
                <b>Velice drsná stránka</b>
            </p>
            <p class="podnadpis">
                Místo pro ty nejdrsnější články
            </p>

        </header>

        <p class="reg">
            <b>Všechny články</b>
        </p>

        <div class = "tabulec">
        <table>

            <tr>
                <th>ID</th>
                <th>Název</th>
                <th>Autor</th>
                <th>Datum</th>
            </tr>

            <?php


            $limit = 20;

            if ($anticringe == 1) {
                $limit = $_POST['kolikclankui'];
            }

            require_once('Db.php');
            Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
            $clanekarray = Db::queryAll('SELECT * from clanky ORDER BY id_clanku DESC LIMIT ?', $limit);
            foreach ($clanekarray as $zaznam) {
            ?> <tr>
                    <td> <?php echo (htmlspecialchars($zaznam['id_clanku'])); ?> </td> <?php
                                                                                        ?> <td> <?php echo (htmlspecialchars($zaznam['titulek'])); ?></a> </td> <?php
                                                                                                                                                                ?> <td> <?php echo (htmlspecialchars($zaznam['autor'])); ?> </td> <?php
                                                                                                                                                                                                                                    ?> <td> <?php echo (htmlspecialchars($zaznam['datum'])); ?> </td>
                </tr> <?php
                    }
                        ?>
        </table>
        </div>
    </section>

    <section class="login">

        <form method="post" class="bottom">Který článek chcete přečíst? (Zadejte ID) <input class="smolform" type="text" name="kteryclaneki" size=3 /> <input class="loginbutton" type="submit" name="kteryclanek" value="Přečíst"></form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['kteryclanek'])) {
                require_once('Db.php');
                Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
                $existujee = Db::querySingle('
                 SELECT COUNT(*)
                 FROM clanky
                 WHERE id_clanku=?
                 LIMIT 1
                 ', $_POST['kteryclaneki']);

                if ($existujee) {
                    $mezikrok = $_POST['kteryclaneki'];
                    $_SESSION['claneknumber'] = $mezikrok;
                    echo $_SESSION['claneknumber'];
                    header('Location: /Clanek.php');
                } else {
                    $zprava = 'Musíte zadat platné ID';
        ?>
                    <section class="reddivv">

                        <?php echo $zprava; ?>

                    </section>
        <?php
                }
            }
        }

        ?>

    </section>

    <section class="login">

        <p class="loginp">
        <input class="loginbutton" type="submit" name="Login" value="Napsat článek" onclick="location.href='/Editor.php'" />
        <input class="loginbutton" type="submit" name="Login" value="Vrátit se na účet" onclick="location.href='/Logged.php'" />
        <input class="loginbutton" type="submit" name="Login" value="Odhlásit se" onclick="location.href='/Login.php'" />
    </p>

    </section>

    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <footer>
        <p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
    </footer>

</body>