<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>[<?php
        echo $_SESSION['jmenoo'];
    ?>] Drsná Stránka</title>
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
    <b>Váš účet</b>
</p>


<p class = "vasejmeno">Vaše jméno: <b><?php
        echo $_SESSION['jmenoo'];
    ?></b> </p>


<p class="loginp"><input class="loginbutton" type="submit" name="Login" value="Zobrazit Články" onclick="location.href='/Homepage.php'" /><input class="loginbutton" type="submit" name="Login" value="Napsat Článek" onclick="location.href='/Editor.php'" /></p>

</section>

<section class="login">

<p class="loginp"><input class="loginbutton" type="submit" name="Login" value="Odhlásit" onclick="location.href='/Login.php'" /></p>

</section>

<br><br><br><br><br><br><br><br><br><br><br><br><br>

<footer>
<p class="footertxt">Vytvořili V. Štodt a J. Rusek</p>
</footer>

</body>