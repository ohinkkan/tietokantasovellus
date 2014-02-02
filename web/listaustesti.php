<?php
require_once 'libs/connection.php';
require_once 'libs/models/user.php';

$lista = user::getUsers();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <head><title>Otsikko</title></head>
    <body>
        <h1>Listaelementtitesti</h1>
        <ul>
            <?php foreach ($lista as $asia) { ?>
                <li><?php echo $asia->getUsername(); ?></li>
            <?php } ?>
        </ul>
    </body>


</body>
</html>
