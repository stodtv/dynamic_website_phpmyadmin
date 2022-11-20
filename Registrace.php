<?php
session_start();
require('Db.php');
Db::connect('127.0.0.1', 'N�zev datab�ze', 'root', '');

if ($_POST)
{
    if ($_POST['rok'] != date('Y'))
        $zprava = 'Chybn� vypln�n� antispam.';
    else if ($_POST['heslo'] != $_POST['heslo_znovu'])
        $zprava = 'Hesla nesouhlas�';
    else
    {
        $existuje = Db::querySingle('
            SELECT COUNT(*)
            FROM uzivatele
            WHERE jmeno=?
            LIMIT 1
        ', $_POST['jmeno']);
        if ($existuje)
            $zprava = 'U�ivatel s touto p�ezd�vkou je ji� v datab�zi obsa�en.';
        else
        {
            $heslo = password_hash($_POST['heslo'], PASSWORD_DEFAULT);
            Db::query('
                INSERT INTO uzivatele (jmeno, heslo)
                VALUES (?, ?)
            ', $_POST['jmeno'], $heslo);
            $_SESSION['uzivatel_id'] = Db::getLastId();
            $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];
            $_SESSION['uzivatel_admin'] = 0;
            header('Location: administrace.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang='cs'>
  <head>
    <title>Registrace u�ivatele</title>
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
                    Heslo znovu<br />
                    <input type="password" name="heslo_znovu" /><br />
                    Zadejte aktu�ln� rok (antispam)<br />
                    <input type="text" name="rok" /><br />
                    <input type="submit" value="Registrovat" />
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
     
  </body>
</html>

