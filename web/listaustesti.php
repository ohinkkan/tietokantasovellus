<?php
require_once 'libs/connection.php';
require_once 'libs/models/user.php';

$tasklist = user::getUsers();
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
            <?php foreach ($tasklist as $task) { ?>
                <li><?php echo $task->getUsername(); ?></li>
            <?php } ?>
        </ul>
    </body>


</body>
</html>
