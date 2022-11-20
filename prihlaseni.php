<?php
session_start(); //
require('Db.php');
Db::connect('127.0.0.1', 'Název databáze', 'root', '');

if (isset($_SESSION['uzivatel_id']))
{
    header('Location: administrace.php');
    exit();
}

if ($_POST)
{
    $uzivatel = Db::queryOne('
        SELECT uzivatele_id, admin, heslo
        FROM uzivatele
        WHERE jmeno=?
    ', $_POST['jmeno']);
    if (!$uzivatel || !password_verify($_POST['heslo'], $uzivatel['heslo']))
        $zprava = 'Neplatné uživatelské jméno nebo heslo';
    else
    {
        $_SESSION['uzivatel_id'] = $uzivatel['uzivatele_id'];
        $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];
        $_SESSION['uzivatel_admin'] = $uzivatel['admin'];
        header('Location: administrace.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang='cs'>
  <head>
    <title>Pøihlášení do administrace</title>
    <meta charset='utf-8'>
    <meta name='description' content=''>
    <meta name='keywords' content=''>
    <meta name='author' content=''>
    <meta name='robots' content='all'>
    <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
    <link href='/favicon.png' rel='shortcut icon' type='image/png'>
  </head>
  <body>
     <header>
         Název stránky, logo a navigaèní struktura
         <nav>
            <ul>
                <li><a href="index.html">Domù</a></li>
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
                    Jméno<br />
                    <input type="text" name="jmeno" /><br />
                    Heslo<br />
                    <input type="password" name="heslo" /><br />
                    <input type="submit" value="Pøihlásit" />
                </form>

                <p>Pokud ještì nemáte úèet, <a href="registrace.php">zaregistrujte se</a>.</p>
            </article>
        </section>
        <aside>
            Postranní banner
        </aside>
    </div>
    <footer>
        Autoøi, datum aktualizace...
    </footer>
     
  </body>
</html>