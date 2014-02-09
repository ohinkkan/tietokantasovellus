
<!DOCTYPE html>
<html>
    <head>

        <link href = "css/bootstrap.css" rel = "stylesheet">
        <link href = "css/bootstrap-theme.css" rel = "stylesheet">
        <link href = "css/main.css" rel = "stylesheet">
        <script type="text/javascript" src='js/jquery.js'></script>
        <script type="text/javascript" src='js/bootstrap.js'></script>
        <title>Askaremuistio <?php echo $nimi; ?></title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
    </head>

    <div class="page-header">
        <h1>Askaremuistio</h1>
    </div>
    <body class="container">
        <?php if (!empty($data->virhe)): ?>
            <div class="alert alert-danger"><?php echo $data->virhe; ?></div>
        <?php endif; ?>
        <?php if (!empty($data->note)): ?>
            <div class="alert alert-success"><?php echo $data->note; ?></div>
        <?php endif; ?>

        <?php require $sivu; ?>
    </body>
    <div style="float:right"><a href="rasite.php?logout=1">Kirjaudu ulos</a></div>
</html>

