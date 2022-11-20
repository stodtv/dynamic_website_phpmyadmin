<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>[Přihlášení] Drsná Stránka</title>
    <meta charset="windows-1260">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="all">
    <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
    <link href="/favicon.ico" rel="shortcut icon" type="icon/ico">
    <link rel="stylesheet" href="styly.css" type="text/css">

<body>

    <section class="main">

        <header>
            <p class="zacatek">
                <b>Velice drsná stránka</b>
            </p>
            <p class="podnadpis">
                Místo pro ty nejdrsnější články
            </p>

        </header>

        <p class="reg">
            <b>Přihlášení</b>
        </p>

        <article>
            <p>

            <form method="post">
                Jméno (nickname)<br />
                <input class="form" type="text" name="jmeno" /><br />
                Heslo<br />
                <input class="form" type="password" name="heslo" /><br />
                <input class="button" type="submit" name="Registrovat" value="Přihlásit se" />
            </form>

            <?php

            $hesloo = null;
            if ($_POST) {
                if ($_POST['jmeno'] == "") {
                    $zprava = 'Jméno nemůže být prázdné.';
            ?>
                    <section class="reddiv">

                        <?php echo $zprava; ?>

                    </section>
                    <?php

                } else {
                    require_once('Db.php');
                    Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
                    $jmenoo = 0;
                    $jmeno = Db::queryAll('
                    SELECT jmeno
                    FROM uzivatele
                    WHERE jmeno=?
                    LIMIT 1
                ', $_POST['jmeno']);
                    foreach ($jmeno as $j) {
                        $jmenoo = htmlspecialchars($j['jmeno']);
                    }
                    /* echo $jmenoo; */

                    if ($_POST['heslo'] == null) {
                        $zprava = 'Musíte zadat heslo.';
                    ?>
                        <section class="reddiv">

                            <?php echo $zprava; ?>

                        </section>
                        <?php
                    } else {

                        $heslo = Db::queryAll('
                    SELECT heslo
                    FROM uzivatele
                    WHERE jmeno=?
                    LIMIT 1
                ', $_POST['jmeno']);
                        foreach ($heslo as $h) {
                            $hesloo = htmlspecialchars($h['heslo']);
                        }
                        /* echo $hesloo; */

                        $hashcheck = password_verify($_POST['heslo'], $hesloo);
                        if ($hashcheck == 1) {

                            /*$zprava = 'Úspěšně přihlášeno!';
                        ?>
                            <section class="greendiv">

                                <?php echo $zprava; ?> <input class="loginbutton" type="submit" name="Login" value="Přejít na účet" onclick="location.href='/Logged.php'" />

                            </section>
                        <?php*/

                            header('Location: /Logged.php');

                            $_SESSION['jmenoo'] = $jmenoo;

                        /*    require_once('Db.php');
        Db::connect('127.0.0.1', 'drsnadatabaze', 'root', ''); */
        $perm = Db::queryAll('
        SELECT perms
        FROM uzivatele
        WHERE jmeno=?
        LIMIT 1
        ', $_POST['jmeno']);
        foreach ($perm as $p) {
            $permm = htmlspecialchars($p['perms']);
        }
        $_SESSION['permm'] = $permm;

                        } else {
                            $zprava = 'Špatné heslo.';
                        ?>
                            <section class="reddiv">

                                <?php echo $zprava; ?>

                            </section>
            <?php
                        }
                    }
                }
            }

            ?>

        </article>

        <?php

       /* require_once('Db.php');
        Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
        $perm = Db::queryAll('
        SELECT perms
        FROM uzivatele
        WHERE jmeno=?
        LIMIT 1
        ', $_POST['jmeno']);
        foreach ($perm as $p) {
            $permm = htmlspecialchars($p['perm']);
        }
        $_SESSION['permm'] = $permm;
        echo $permm; */

        ?>

    </section>

    <section class="login">

        <p class="loginp">Ještě nemáte účet? <input class="loginbutton" type="submit" name="Login" value="Vytvořit účet" onclick="location.href='/DrsnaStranka.php'" /></p>

    </section>

    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <footer>
        <p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
    </footer>

</body>

</html>