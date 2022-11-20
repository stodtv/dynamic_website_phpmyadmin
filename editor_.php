<?php
session_start();
if (empty($_SESSION['permm']))
    die('Nedostatecna opravneni');

require('Db.php');
Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');

$clanek = array(
    'clanky_id' => '',
    'titulek' => '',
    'obsah' => '',
    'url' => '',
    'popisek' => '',
    'klicova_slova' => '',
);
if ($_POST)
{
    if (!$_POST['clanky_id'])
    {
        Db::query('
            INSERT INTO clanky (titulek, obsah, url, popisek, klicova_slova)
            VALUES (?, ?, ?, ?, ?)
        ', $_POST['titulek'], $_POST['obsah'], $_POST['url'], $_POST['popisek'], $_POST['klicova_slova']);
    }
    else
    {
        Db::query('
            UPDATE clanky
            SET titulek=?, obsah=?, url=?, popisek=?, klicova_slova=?
            WHERE clanky_id=?
        ', $_POST['titulek'], $_POST['obsah'], $_POST['url'], $_POST['popisek'], $_POST['klicova_slova'], $_POST['clanky_id']);
    }
    header('Location: index.php?clanek=' . $_POST['url']);
    exit();
}
else if (isset($_GET['url']))
{
    $nactenyClanek = Db::queryOne('
        SELECT *
        FROM clanky
        WHERE url=?
    ', $_GET['url']);
    if ($nactenyClanek)
        $clanek = $nactenyClanek;
    else
        $zprava = '�l�nek nebyl nalezen';
}

?>

<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styl.css" type="text/css" />
    <title>Editor �l�nk�</title>
</head>

<body>
    <<header>
         N�zev str�nky, logo a naviga�n� struktura
         <nav>
            <ul>
                <li><a href="index.html">Dom�</a></li>
                <li></li>  
            </ul>
         </nav>
     </header>
     <div class="container">
        <section class="hlavni">
            <article>
                <?php
                if (isset($zprava))
                    echo('<p>' . $zprava . '</p>');
                ?>

                <form method="post">
                    <input type="hidden" name="clanky_id" value="<?= htmlspecialchars($clanek['clanky_id']) ?>" /><br />
                    Titulek<br />
                    <input type="text" name="titulek" value="<?= htmlspecialchars($clanek['titulek']) ?>" /><br />
                    URL<br />
                    <input type="text" name="url" value="<?= htmlspecialchars($clanek['url']) ?>" /><br />
                    Popisek<br />
                    <input type="text" name="popisek" value="<?= htmlspecialchars($clanek['popisek']) ?>" /><br />
                    Kl��ov� slova<br />
                    <input type="text" name="klicova_slova" value="<?= htmlspecialchars($clanek['klicova_slova']) ?>" /><br />
                    <textarea name="obsah"><?= htmlspecialchars($clanek['obsah']) ?></textarea>
                    <input type="submit" value="Odeslat" />
                </form>
            </article>
        </section>
        <aside>
            Postrann� banner
        </aside>
    </div>
    <footer>
        Auto�i, datum aktualizace...
    </footer>
    <script type="text/javascript" src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
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
            entity_encoding: "raw"
        });
    </script>
</body>
</html>