<!DOCTYPE html>
<html lang="cs">

<head>
  <title>[Registrace] Drsná Stránka</title>
  <meta charset="windows-1260">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <meta name="robots" content="all">
  <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
  <link href="/favicon.ico" rel="shortcut icon" type="icon/ico">
  <link rel="stylesheet" href="styly.css" type="text/css">

</head>

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
      <b>Registrace</b>
    </p>

    <article>
      <p>

      <form method="post">
        Jméno (nickname)<br />
        <input class="form" type="text" name="jmeno" /><br />
        Heslo<br />
        <input class="form" type="password" name="heslo" /><br />
        Heslo znovu<br />
        <input class="form" type="password" name="heslo_znovu" /><br />
        Zadejte aktuální rok (antispam):<br />
        <input class="form" type="text" name="rok" /><br />
        <input class="button" type="submit" name="Registrovat" value="Zaregistrovat" />
      </form>

      <?php

      $zprava = "";     

      if ($_POST) {
        require_once('Db.php');
        Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
        $existuje = Db::querySingle('
            SELECT COUNT(*)
            FROM uzivatele
            WHERE jmeno=?
            LIMIT 1
        ', $_POST['jmeno']);

        if ($_POST['jmeno'] == "") {
          $zprava = 'Jméno nemůže být prázdné.';
      ?>
          <section class="reddiv">

            <?php echo $zprava; ?>

          </section>
        <?php
        } else if ($existuje) {
          $zprava = 'Uživatel s touto přezdívkou je již v databázi obsažen.';
        ?>
          <section class="reddiv">

            <?php echo $zprava; ?>

          </section>
        <?php
        } else if ($_POST['rok'] != date('Y')) {
          $zprava = 'Chybně vyplněný antispam.';
        ?>
          <section class="reddiv">

            <?php echo $zprava; ?>

          </section>
        <?php
        } else if ($_POST['heslo'] != $_POST['heslo_znovu']) {
          $zprava = 'Hesla nesouhlasí';
        ?>
          <section class="reddiv">

            <?php echo $zprava; ?>

          </section>
        <?php
        } else {
          require_once('Db.php');
          Db::connect('127.0.0.1', 'drsnadatabaze', 'root', '');
          $heslo = password_hash($_POST['heslo'], PASSWORD_DEFAULT);
          Db::query('INSERT INTO uzivatele (Jmeno, Heslo) VALUES (?, ?)', $_POST['jmeno'], $heslo);

          $zprava = 'Úspěšně zaregistrováno! Nyní se můžete přihlásit.';
        ?>
          <section class="greendiv">

            <?php echo $zprava; ?>

          </section>
      <?php
        }
      }


      ?>

      </p>
    </article>


  </section>
  <section class="login">

    <p class="loginp">Jste již zaregistrováni? <input class="loginbutton" type="submit" name="Login" value="Přihlásit se" onclick="location.href='/Login.php'"/></p>

  </section>

      <br><br><br><br><br><br><br><br><br><br><br><br>

  <footer>
    <p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
  </footer>
</body>

</html>