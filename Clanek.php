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
    require_once('Db.php');
    Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
    $velkaarray = Db::queryAll('SELECT * from clanky where id_clanku = ?', $_SESSION['claneknumber']);
    foreach ($velkaarray as $output) {
        $id_clanku = htmlspecialchars($output['id_clanku']);
        $titulek = htmlspecialchars($output['titulek']);
        $obsah = htmlspecialchars_decode($output['obsah']);
        $popisek = htmlspecialchars($output['popisek']);
        $klicova_slova = htmlspecialchars($output['klicova_slova']);
        $autor = htmlspecialchars($output['autor']);
        $datum = htmlspecialchars($output['datum']);
    }

    ?>

    <section class="main">
        <b>
            <p class="titulek"> <?php echo $titulek; ?> </p>
        </b>
        <p class="popisek"> <?php echo $popisek; ?> </p>
    </section>
    <section class="claneksection">
        <div class="hornidiv">
            <p class="autor"> ID: <b> <?php echo $id_clanku; ?> </b></p>
            <p class="autor"> Autor: <b> <?php echo $autor; ?> </b></p>
            <p class="datum"> Napsáno: <b> <?php echo $datum; ?> </b></p>
        </div>
        <br>
        <div class="obsahdiv">
            <p class="obsah"> <?php echo $obsah; ?> </p>
        </div>
        <p class="tagy">
        <h6> Tagy: <?php echo $klicova_slova; ?> </h6>
        </p>
    </section>

    <section class="login">

        <p class="loginp"><input class="loginbutton" type="submit" name="Login" value="Vrátit se na účet" onclick="location.href='/Logged.php'" />
        <input class="loginbutton" type="submit" name="Login" value="Vrátit se na články" onclick="location.href='/Homepage.php'" />
        </p>

    </section>

    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <footer>
        <p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
    </footer>

</body>