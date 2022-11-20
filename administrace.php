<?php
session_start();
if (!isset($_SESSION['uzivatel_id']))
{
    header('Location: prihlaseni.php');
    exit();
}

if (isset($_GET['odhlasit']))
{
    session_destroy();
    header('Location: prihlaseni.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styl.css" type="text/css" />
    <title>Administrace</title>
</head>

<body>
<article>
    <div id="centrovac">
        <header>
            <h1>Administrace</h1>
        </header>
        <section>
            <p>V�tejte v administraci, jste p�ihl�eni jako <?= htmlspecialchars($_SESSION['uzivatel_jmeno']) ?></p>
            <?php
                if (!$_SESSION['uzivatel_admin'])
                    echo('Nem�te administr�torsk� opr�vn�n�, po��dejte administr�tora webu, aby v�m je p�id�lil.');
            ?>
            <h2><a href="editor.php">Editor �l�nk�</a></h2>
            <h2><a href="clanky.php">Seznam �l�nk�</a></h2>
            <h2><a href="administrace.php?odhlasit">Odhl�sit</a></h2>
        </section>
        
</article>
</body>
</html>