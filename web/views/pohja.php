<!DOCTYPE html>
<html>
    <head>
        <link href = "css/bootstrap.css" rel = "stylesheet">
        <link href = "css/bootstrap-theme.css" rel = "stylesheet">
        <link href = "css/main.css" rel = "stylesheet">
        <title>Askaremuistio <?php echo $nimi; ?></title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
    </head>

    <div class="page-header">
        <h1>Askaremuistio</h1>
    </div>

    <?php if (!empty($data->virhe)): ?>
        <div class="alert alert-danger"><?php echo $data->virhe; ?></div>
    <?php endif; ?>

    <?php require $sivu; ?>
</html>

