<div class="page-header">
    <h1>Askaremuistio - sisäänkirjautuminen</h1>
</div>
<body class = "container">
    <div class = "subsection">
        <form action = "tarkistus.php" method = "POST">
            Käyttäjänimi: <input type = "text" name = "username" value = "<?php echo $data->kayttaja; ?>"/>
            Salasana: <input type = "password" name = "password" />
            <button type = "submit">Kirjaudu</button>
        </form>
    </div>
</body>

