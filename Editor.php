<?php
session_start();

if (empty($_SESSION['permm'])) {
    die("Nedostatečná oprávnění");
} else if ($_SESSION['permm'] == 0) {
    die("Nedostatečná oprávnění");
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>[Editor] Drsná Stránka</title>
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
    require('Db.php');
    Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');

    $clanek = array(
        'clanky_id' => '',
        'titulek' => '',
        'obsah' => '',
        'popisek' => '',
        'klicova_slova' => '',

    );

    $jmenooo = $_SESSION['jmenoo'];
    $datum = date("d" . "." . "m" . "." . "Y");

    if ($_POST) {
        if (!$_POST['clanky_id']) {
            Db::query('
            INSERT INTO clanky (titulek, obsah, popisek, klicova_slova, autor, datum)
            VALUES (?, ?, ?, ?, ?, ?)
        ', $_POST['titulek'], $_POST['obsah'], $_POST['popisek'], $_POST['klicova_slova'], $jmenooo, $datum);
        } else {
            Db::query('
            UPDATE clanky
            SET titulek=?, obsah=?, url=?, popisek=?, klicova_slova=?
            WHERE clanky_id=?
        ', $_POST['titulek'], $_POST['obsah'], $_POST['popisek'], $_POST['klicova_slova'], $_POST['clanky_id']);
        }
        /* header("Tady bylo to URL co jsi smazal. Pokud je toto zbytečné, mrdni to do piče");
        exit();
    } else if (isset($_GET['url'])) {
        $nactenyClanek = Db::queryOne('
        SELECT *
        FROM clanky
        WHERE url=?
    ', $_GET['url']);
        if ($nactenyClanek)
            $clanek = $nactenyClanek;
        else
            $zprava = '�l�nek nebyl nalezen'; */
    }

    ?>
    <section class="main">

        <header>
            <p class="zacatek">
                <b>Velice drsná stránka</b>
            </p>
            <p class="podnadpis">
                Místo pro ty nejdrsnější články
            </p>

            <p class="reg">
                <b>Editor článků</b>
            </p>

        </header>

        <article>
            <?php
            if (isset($zprava))
                echo ('<p>' . $zprava . '</p>');
            ?>

            <form method="post">
                <input class="form" type="hidden" name="clanky_id" value="<?= htmlspecialchars($clanek['clanky_id']) ?>" /><br />
                Titulek<br />
                <input class="form" type="text" name="titulek" value="<?= htmlspecialchars($clanek['titulek']) ?>" /><br />
                Popisek<br />
                <input class="form" type="text" name="popisek" value="<?= htmlspecialchars($clanek['popisek']) ?>" /><br />
                Tagy<br />
                <input class="form" type="text" name="klicova_slova" value="<?= htmlspecialchars($clanek['klicova_slova']) ?>" /><br />

                <br>

                <section cass="tiny">
                    <textarea name="obsah"><?= htmlspecialchars($clanek['obsah']) ?></textarea>
                </section>

                <input class="submit2" type="submit" value="Odeslat" />
            </form>
        </article>
    </section>

    <section class="login">

        <p class="loginp"><input class="loginbutton" type="submit" name="Login" value="Vrátit se na účet" onclick="location.href='/Logged.php'" />
        <input class="loginbutton" type="submit" name="Login" value="Ukázat články" onclick="location.href='/Homepage.php'" />
    </p>

    </section>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <footer>
        <p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
    </footer>

    <section class="tiny">
        <script type="text/javascript" src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: "textarea[name=obsah]",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                entities: "160,nbsp",
                entity_encoding: "named",
                entity_encoding: "raw",
                height: "450",
                width: "900",
            });
        </script>
    </section>



</body>