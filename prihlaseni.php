<?php
session_start(); //
require('Db.php');
Db::connect('127.0.0.1', 'N�zev datab�ze', 'root', '');

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
        $zprava = 'Neplatn� u�ivatelsk� jm�no nebo heslo';
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
    <title>P�ihl�en� do administrace</title>
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
                    Jm�no<br />
                    <input type="text" name="jmeno" /><br />
                    Heslo<br />
                    <input type="password" name="heslo" /><br />
                    <input type="submit" value="P�ihl�sit" />
                </form>

                <p>Pokud je�t� nem�te ��et, <a href="registrace.php">zaregistrujte se</a>.</p>
            </article>
        </section>
        <aside>
            Postrann� banner
        </aside>
    </div>
    <footer>
        Auto�i, datum aktualizace...
    </footer>
     
  </body>
</html>